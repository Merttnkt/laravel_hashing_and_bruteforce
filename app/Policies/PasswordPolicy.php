<?php

namespace App\Policies;

use Illuminate\Support\Facades\Hash;

class PasswordPolicy
{
    /**
     * Şifre karmaşıklığını doğrula
     *
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        // En az 8 karakter
        if (strlen($password) < 8) {
            return false;
        }

        // En az 1 büyük harf
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        // En az 1 küçük harf
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }

        // En az 1 rakam
        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }

        // En az 1 özel karakter
        if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $password)) {
            return false;
        }

        // Aynı karakterin en fazla 3 kez tekrar etmesini kontrol et
        if (preg_match('/(.)\1{3,}/', $password)) {
            return false;
        }

        return true;
    }

    /**
     * Şifreyi hashle
     *
     * @param string $password
     * @return string
     */
    public function hashPassword(string $password): string
    {
        return Hash::make($password);
    }

    /**
     * Şifre karmaşıklığı hakkında hata mesajı
     *
     * @return string
     */
    public function getPasswordRequirementsMessage(): string
    {
        return 'Şifre en az 8 karakter, 1 büyük harf, 1 küçük harf, 1 rakam ve 1 özel karakter içermeli, aynı karakter en fazla 3 kez tekrar etmelidir.';
    }
} 