<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Дозволені для масового заповнення поля
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'content',
        'image',
    ];

    /**
     * Автор поста (зв’язок з User)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Категорія поста (зв’язок з Category)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Коментарі до поста
     */
    public function comments()
{
    return $this->hasMany(Comment::class);
}

    /**
     * Лайки до поста
     */
    public function likes()
{
    return $this->hasMany(\App\Models\Like::class);
}
}
