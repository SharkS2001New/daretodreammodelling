<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'file_path'];
    
    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }

    // Likes on photo
    public function likes()
    {
        return $this->hasMany(PhotoLike::class);
    }

    // Views on photo
    public function views()
    {
        return $this->hasMany(PhotoView::class);
    }

    public function scopeLatestPerUser($query, ?array $userIds = null)
    {
        $latestIds = static::query()
            ->selectRaw('MAX(id) as id')
            ->groupBy('user_id');

        if ($userIds !== null) {
            $latestIds->whereIn('user_id', $userIds);
        }

        return $query->whereIn('photos.id', $latestIds);
    }

    public function scopeOrderByUserLikes($query)
    {
        return $query->orderByDesc(
            PhotoLike::query()
                ->selectRaw('count(*)')
                ->join('photos as liked_photos', 'liked_photos.id', '=', 'photo_likes.photo_id')
                ->whereColumn('liked_photos.user_id', 'photos.user_id')
        );
    }
}
