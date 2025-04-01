<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Policies\PasswordPolicy;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/home';

    // Şifre reset validasyon kurallarını özelleştir
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed'],
        ];
    }
    
    // Şifre politikası ile validasyon
    protected function validatePasswordWithPolicy($password)
    {
        $policy = new PasswordPolicy();
        if (!$policy->validatePassword($password)) {
            throw ValidationException::withMessages([
                'password' => [$policy->getPasswordRequirementsMessage()],
            ]);
        }
    }
    
    // Şifre validasyonu override et
    protected function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->validationErrorMessages());
        
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        
        // Özel şifre politikası kontrolü
        $this->validatePasswordWithPolicy($request->input('password'));
    }

    // Şifre sıfırlandıktan sonra bloke durumunu kaldır
    protected function resetPassword($user, $password)
    {
        // Şifreyi hashle ve kaydet
        $policy = new PasswordPolicy();
        $user->password = $policy->hashPassword($password);
        
        // Bloke durumunu temizle
        $user->failed_login_attempts = 0;
        $user->blocked_until = null;
        $user->save();
        
        // Kullanıcıyı otomatik giriş yap
        $this->guard()->login($user);
    }
}