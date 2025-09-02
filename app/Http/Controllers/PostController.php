<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Показуємо стрічку постів
    public function index()
    {
        $posts = Post::with('user', 'likes')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    // Створення поста
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'user_id'    => Auth::id(),
            'category_id'=> null, // можна додати вибір категорії пізніше
            'title'      => $request->title,
            'content'    => $request->content,
            'image'      => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Post created successfully!');
    }

    // Лайкнути пост
    public function like(Post $post)
    {
        $user = Auth::user();

        if (!$post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->create(['user_id' => $user->id]);
        }

        return redirect()->back();
    }
}
