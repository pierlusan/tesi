<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function isMember($userId)
    {
        return $this->users()->where('user_id', $userId)->exists();
    }

}
