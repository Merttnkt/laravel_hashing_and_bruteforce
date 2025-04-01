<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        // recaptcha middleware'ini geçici olarak kaldırdık
        // $this->middleware('recaptcha')->only('login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Başarısız giriş denemesi kontrolü yapalım
        $user = User::where($this->username(), $request->input($this->username()))->first();
        
        // Kullanıcı varsa ve bloke edilmişse engelle
        if ($user && $user->blocked_until && now()->lt($user->blocked_until)) {
            $blocked_until = Carbon::parse($user->blocked_until)->diffForHumans();
            return redirect()->route('login')
                ->withInput(['email' => $request->email])
                ->withErrors(['email' => "Hesabınız güvenlik nedeniyle geçici olarak bloke edilmiştir. $blocked_until tekrar deneyebilirsiniz veya şifrenizi sıfırlayabilirsiniz."]);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // Başarısız giriş denemesi sayısını artır
        if ($user) {
            $user->failed_login_attempts += 1;
            
            // Şifre bloklaması için kontrol
            if ($user->failed_login_attempts >= 3) {
                $user->blocked_until = now()->addMinutes(30);
                $user->failed_login_attempts = 0; // Sayacı sıfırla
                $user->save();
                
                return redirect()->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors([$this->username() => 'Hesabınız güvenlik nedeniyle 30 dakika süreyle bloke edilmiştir. Şifrenizi sıfırlayabilir veya daha sonra tekrar deneyebilirsiniz.']);
            } else if ($user->failed_login_attempts == 2) {
                $user->save();
                return redirect()->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors([$this->username() => 'Dikkat: Bir sonraki başarısız denemede hesabınız 30 dakika bloke edilecektir.']);
            }
            
            $user->save();
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    // Giriş yapmadan önce hesabın bloke olup olmadığını kontrol et
    protected function attemptLogin(Request $request)
    {
        $user = User::where($this->username(), $request->input($this->username()))->first();
        
        $result = $this->guard()->attempt(
            $this->credentials($request), $request->boolean('remember')
        );
        
        // Giriş başarılı olduysa
        if ($result && $user) {
            // Başarılı girişte hatalı giriş sayacını sıfırla
            $user->failed_login_attempts = 0;
            $user->blocked_until = null;
            $user->save();
        }
        
        return $result;
    }

    // Kullanıcı çıkış yaptığında
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}