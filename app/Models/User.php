<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'failed_login_attempts',
        'blocked_until',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'blocked_until' => 'datetime',
    ];

    /**
     * Kullanıcının notları
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Kullanıcının bloke olup olmadığını kontrol et
     */
    public function isBlocked()
    {
        return $this->blocked_until && now()->lt($this->blocked_until);
    }
    
    /**
     * Bloke olma süresini hesapla
     */
    public function getBlockedUntilFormatted()
    {
        if ($this->blocked_until) {
            return now()->diffForHumans($this->blocked_until, true) . ' süre kaldı';
        }
        return null;
    }
}