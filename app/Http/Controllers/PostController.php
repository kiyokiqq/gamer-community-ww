<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // Доступ тільки для авторизованих користувачів
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Показ усіх постів на дашборді
    public function index()
    {
        $posts = Post::with('user', 'likes')->latest()->get();
        return view('dashboard', compact('posts'));
    }

    // Створення нового поста
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $request->user()->posts()->create($data);

        return redirect()->back()->with('success', 'Post created successfully!');
    }

    // Форма редагування поста
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    // Оновлення поста
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('dashboard')->with('success', 'Post updated successfully!');
    }

    // Видалення поста
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->back()->with('success', 'Post deleted successfully!');
    }

    // Лайк/дизлайк поста
    public function like(Post $post)
    {
        $user = auth()->user();

        if ($post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->where('user_id', $user->id)->delete();
        } else {
            $post->likes()->create(['user_id' => $user->id]);
        }

        return redirect()->back();
    }

   public function myPosts(Request $request)
{
    $query = auth()->user()->posts(); // Всі пости користувача

    // Фільтр по назві
    if ($request->filled('title')) {
        $query->where('title', 'like', '%' . $request->title . '%');
    }

    // Фільтр по даті (точна)
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    // Фільтр по періоду
    if ($request->filled('from') && $request->filled('to')) {
        $query->whereBetween('created_at', [$request->from, $request->to]);
    }

    $posts = $query->orderBy('created_at', 'desc')->get();

    return view('posts.myposts', compact('posts'));
}


public function create()
{
    // Для створення поста використовуємо ту ж view, що і редагування,
    // але передаємо порожній об'єкт Post
    $post = new \App\Models\Post();
    return view('posts.edit', compact('post'));
}

}
