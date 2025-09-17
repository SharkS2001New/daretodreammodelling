<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPublicInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_picture',
        'display_name',
        'age',
        'gender',
        'ethnicity',
        'hair',
        'eye',
        'height',
        'shoes',
        'waist',
        'hips',
        'location',
        'nationality',
        'languages',
        'about_me',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

