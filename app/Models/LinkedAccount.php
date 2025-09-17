<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkedAccount extends Model
{
    protected $fillable = [
        'instagram_url',
        'twitter_url',
        'youtube_url',
        'other_url',
        'tiktok_connected',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
