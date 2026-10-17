<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkedAccount extends Model
{
    protected $fillable = [
        'facebook_url',
        'instagram_url',
        'tiktok_url',
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

    /**
     * The public social profiles that have been filled in, ready to render.
     * Keys match the form field names.
     */
    public function publicLinks(): array
    {
        $links = [
            'facebook_url'  => ['icon' => 'bi-facebook',  'label' => 'Facebook'],
            'instagram_url' => ['icon' => 'bi-instagram', 'label' => 'Instagram'],
            'tiktok_url'    => ['icon' => 'bi-tiktok',    'label' => 'TikTok'],
            'twitter_url'   => ['icon' => 'bi-twitter-x', 'label' => 'Twitter'],
            'youtube_url'   => ['icon' => 'bi-youtube',   'label' => 'YouTube'],
            'other_url'     => ['icon' => 'bi-globe',     'label' => 'Website'],
        ];

        $filled = [];

        foreach ($links as $field => $meta) {
            if (! empty($this->{$field})) {
                $filled[] = $meta + ['url' => $this->{$field}];
            }
        }

        return $filled;
    }

    // Helper method to check if TikTok is connected
    public function hasTikTokConnection(): bool
    {
        return !empty($this->tiktok_access_token);
    }

    public function getTiktokConnectedAttribute($value): bool
    {
        return !empty($this->tiktok_access_token) || (bool) $value;
    }

    // Check if token is expired
    public function getTiktokTokenExpiredAttribute()
    {
        return $this->tiktok_token_expires_at && $this->tiktok_token_expires_at->isPast();
    }
}
