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
}
