<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkedAccount extends Model
{
    protected $fillable = [
        'tiktok_url',
        'instagram_url',
        'twitter_url',
        'youtube_url',
        'other_url',
        'tiktok_connected',
        'tiktok_access_token',
        'tiktok_refresh_token',
        'tiktok_open_id',
        'tiktok_token_expires_at',
    ];

    protected $casts = [
        'tiktok_token_expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper method to check if TikTok is connected
    public function getTiktokConnectedAttribute()
    {
        return !empty($this->tiktok_access_token);
    }

    // Check if token is expired
    public function getTiktokTokenExpiredAttribute()
    {
        return $this->tiktok_token_expires_at && $this->tiktok_token_expires_at->isPast();
    }
}
