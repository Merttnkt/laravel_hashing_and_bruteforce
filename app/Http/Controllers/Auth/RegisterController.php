<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Policies\PasswordPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    protected $redirectTo = '/home';
    
    /**
     * Kullanıcı kayıt işlemi
     */
    public function register(Request $request)
    {
        // Gelen verilerin doğrulanması
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Şifre politikası kontrolü
        $passwordPolicy = new PasswordPolicy();
        if (!$passwordPolicy->validatePassword($request->password)) {
            throw ValidationException::withMessages([
                'password' => [$passwordPolicy->getPasswordRequirementsMessage()],
            ]);
        }

        // Kullanıcı oluşturma
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $passwordPolicy->hashPassword($request->password),
            'failed_login_attempts' => 0,
            'blocked_until' => null,
        ]);

        // Otomatik giriş
        auth()->login($user);

        return redirect()->route('home')->with('success', 'Hesabınız başarıyla oluşturuldu!');
    }

    /**
     * Kayıt form sayfasını gösterme
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
}