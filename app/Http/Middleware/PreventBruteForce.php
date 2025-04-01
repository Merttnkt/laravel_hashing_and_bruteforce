<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class PreventBruteForce
{
    public function handle($request, Closure $next)
    {
        // Eğer giriş isteği ise ve kullanıcı henüz oturum açmadıysa
        if ($request->is('login') && $request->isMethod('post') && !Auth::check()) {
            // Email ile kullanıcıyı bul
            $user = User::where('email', $request->email)->first();
            
            // Kullanıcı varsa ve bloke edilmişse engelle
            if ($user && $user->blocked_until && now()->lt($user->blocked_until)) {
                $blocked_until = Carbon::parse($user->blocked_until)->diffForHumans();
                return redirect()->route('login')
                    ->withInput(['email' => $request->email])
                    ->withErrors(['email' => "Hesabınız güvenlik nedeniyle geçici olarak bloke edilmiştir. $blocked_until tekrar deneyebilirsiniz veya şifrenizi sıfırlayabilirsiniz."]);
            }

            // Şifre kontrolü (ileride Auth yapacak)
            $response = $next($request);
            
            // Eğer giriş başarısız olduysa (yönlendirme varsa)
            if ($response->isRedirection() && $user) {
                // Başarısız giriş denemesi sayısını artır
                $user->failed_login_attempts += 1;
                
                // 3 başarısız denemeden sonra hesabı bloke et (30 dakika)
                if ($user->failed_login_attempts >= 3) {
                    $user->blocked_until = now()->addMinutes(30);
                    $user->failed_login_attempts = 0; // Reset counter
                }
                
                $user->save();
            }
            
            return $response;
        }
        
        // Başarılı giriş sonrası failed_login_attempts sıfırla
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->failed_login_attempts > 0) {
                $user->failed_login_attempts = 0;
                $user->save();
            }
        }
        
        return $next($request);
    }
}