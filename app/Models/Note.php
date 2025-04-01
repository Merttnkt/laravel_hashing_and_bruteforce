<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'content', 
        'is_private',
        'user_id'
    ];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    /**
     * This note belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Scope for user's notes
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}