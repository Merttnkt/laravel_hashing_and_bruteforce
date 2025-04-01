<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class VerifyReCaptcha
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // reCAPTCHA kontrolünü ancak env'de yapılandırılmışsa yap
        if (config('services.recaptcha.enabled', false)) {
            $recaptchaResponse = $request->input('g-recaptcha-response');
            
            // Cevap yoksa
            if (!$recaptchaResponse) {
                throw ValidationException::withMessages([
                    'captcha' => ['Lütfen reCAPTCHA doğrulamasını tamamlayın.']
                ]);
            }
            
            // Google reCAPTCHA API'ye doğrula
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $recaptchaResponse,
                'remoteip' => $request->ip()
            ]);
            
            // Doğrulama başarısızsa
            if (!$response->json('success')) {
                throw ValidationException::withMessages([
                    'captcha' => ['reCAPTCHA doğrulaması başarısız oldu. Lütfen tekrar deneyin.']
                ]);
            }
        }
        
        return $next($request);
    }
} 