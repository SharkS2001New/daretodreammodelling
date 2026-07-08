<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

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
        'is_admin',
        'user_type',
        'must_change_password',
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
        'is_admin' => 'boolean',
        'must_change_password' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->slug = static::uniqueSlug($user->name);
        });

        static::updating(function ($user) {
            if ($user->isDirty('name')) {
                $user->slug = static::uniqueSlug($user->name, $user->id);
            }
        });
    }

    public static function uniqueSlug(string $name, ?int $exceptId = null): string
    {
        $base = Str::slug($name) ?: 'model';
        $slug = $base;
        $counter = 1;

        while (
            static::where('slug', $slug)
                ->when($exceptId, fn ($query) => $query->where('id', '!=', $exceptId))
                ->exists()
        ) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }

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

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'recipient_id');
    }

    public function bookingsAsModel()
    {
        return $this->hasMany(Booking::class, 'model_id');
    }

    public function bookingsAsClient()
    {
        return $this->hasMany(Booking::class, 'client_id');
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'model_id');
    }

    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function displayName(): string
    {
        return $this->publicInfo?->display_name ?? $this->name;
    }

    public function avatarUrl(int $size = 150): string
    {
        if ($this->publicInfo?->profile_picture) {
            return asset('storage/' . $this->publicInfo->profile_picture);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&size=' . $size;
    }

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }
}
