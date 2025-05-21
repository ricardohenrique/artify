<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'bio',
        'location',
        'profile_image',
        'website_url',
        'user_type_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function paintings()
    {
        return $this->hasMany(Painting::class);
    }

    // Users followed by this user
    public function following() {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id')->withTimestamps();
    }

    // Followers of this user
    public function followers() {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id')->withTimestamps();
    }

    public function favorites() {
        return $this->belongsToMany(Painting::class, 'favorites')->withTimestamps();
    }

    public function conversationsAsBuyer()
    {
        return $this->hasMany(Conversation::class, 'buyer_id');
    }

    public function conversationsAsSeller()
    {
        return $this->hasMany(Conversation::class, 'seller_id');
    }

    public function allConversations()
    {
        return Conversation::where('buyer_id', $this->id)
            ->orWhere('seller_id', $this->id);
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

    public function isArtist()
    {
        return $this->user_type_id === 3;
    }

        public function isAdmin()
    {
        return $this->user_type_id === 1;
    }
}
