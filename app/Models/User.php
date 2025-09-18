<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login' => 'datetime',

    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function publicInfo()
    {
        return $this->hasOne(UserPublicInfo::class);
    }

    public function linkedAccount()
    {
        return $this->hasOne(LinkedAccount::class);
    }

    public function photos() {
        return $this->hasMany(Photo::class);
    }

    public function videos() {
        return $this->hasMany(Video::class);
    }

    public function followers() {
        return $this->hasMany(Follower::class, 'model_id');
    }

    public function following() {
        return $this->hasMany(Follower::class, 'user_id');
    }
}
