<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

     protected $fillable = [
        'name',
        'job_title',
        'profile_picture',
        'cover_image',
        'youtube_link',
        'testimony',
        'ratings',
        'media_type',
    ];

    // Optional: link to the user who created the testimonial
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     /**
     * Get YouTube embed URL from regular YouTube URL
     */
    public function getYoutubeEmbedUrl()
    {
        $url = $this->youtube_link;
        
        // Handle various YouTube URL formats
        if (str_contains($url, 'youtube.com')) {
            // Regular YouTube URL: https://www.youtube.com/watch?v=VIDEO_ID
            parse_str(parse_url($url, PHP_URL_QUERY), $params);
            $videoId = $params['v'] ?? null;
        } elseif (str_contains($url, 'youtu.be')) {
            // Short YouTube URL: https://youtu.be/VIDEO_ID
            $path = parse_url($url, PHP_URL_PATH);
            $videoId = ltrim($path, '/');
        } else {
            // Already an embed URL or invalid
            return $url;
        }

        if ($videoId) {
            return "https://www.youtube.com/embed/{$videoId}";
        }

        return $url;
    }
}
