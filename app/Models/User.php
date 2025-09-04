<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Атрибути, які можна масово заповнювати.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'city',
        'about',
        'avatar',
    ];

    /**
     * Атрибути, які слід приховувати при серіалізації.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Атрибути, які треба приводити до потрібних типів.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Посты користувача
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Коментарі користувача
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Лайки користувача
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
