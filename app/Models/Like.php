<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
    ];

    /**
     * Користувач, який поставив лайк
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Пост, який лайкнули
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
