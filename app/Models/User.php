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
        'approved',
        'is_admin',
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
        'approved' => 'boolean',
        'is_admin' => 'boolean',
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function singleEvents()
    {
        return $this->hasMany(SingleEvent::class, 'client_id');
    }

    public function isAdmin(): bool
    {
        return $this->is_admin == true;
    }

    public function isMember(Group $group)
    {
        return $this->groups()->where('group_id', $group->id)->exists();
    }

    public function isAuthor(Post $post)
    {
        return $this->id === $post->user->id;
    }

    public static function pendingUsers()
    {
        return static::where('approved', false)->orderBy('created_at', 'desc')->get();
    }



}
