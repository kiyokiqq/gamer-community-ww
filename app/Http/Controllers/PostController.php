<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Показ усіх постів на дашборді
    public function index()
    {
        $posts = Post::with('user', 'likes', 'comments.user')->latest()->get();
        return view('dashboard', compact('posts'));
    }

    // Форма створення поста
    public function create()
    {
        $post = new Post();
        return view('posts.edit', compact('post'));
    }

    // Створення нового поста
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $data['image'] = $path;
        }

        $post = $request->user()->posts()->create($data);

        // Редірект на редагування створеного поста з банером
        return redirect()->route('posts.edit', $post)
                         ->with('success', 'Post created successfully!');
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }

            $path = $request->file('image')->store('posts', 'public');
            $data['image'] = $path;
        }

        $post->update($data);

        // Редірект на сторінку редагування з повідомленням
        return redirect()->route('posts.edit', $post)
                         ->with('success', 'Post updated successfully!');
    }

    // Видалення поста
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->back()->with('success', 'Post deleted successfully!');
    }

    // Лайк/дизлайк поста (AJAX)
public function like(Post $post)
{
    $user = auth()->user();

    if ($post->likes()->where('user_id', $user->id)->exists()) {
        $post->likes()->where('user_id', $user->id)->delete();
        $liked = false;
    } else {
        $post->likes()->create(['user_id' => $user->id]);
        $liked = true;
    }

    return response()->json([
        'liked' => $liked,
        'likes_count' => $post->likes()->count(),
    ]);
}

    // Показ власних постів з фільтрами
    public function myPosts(Request $request)
    {
        $query = auth()->user()->posts();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        $posts = $query->orderBy('created_at', 'desc')->get();

        return view('posts.myposts', compact('posts'));
    }

    // Додавання коментаря до поста
    public function storeComment(Request $request, Post $post)
    {
        $data = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $post->comments()->create([
            'user_id' => $request->user()->id,
            'content' => $data['content'],
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    // Форма редагування коментаря
    public function editComment(Comment $comment)
    {
        $this->authorize('update', $comment);
        return view('comments.edit', compact('comment'));
    }

    // Оновлення коментаря
    public function updateComment(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $data = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment->update($data);

        return redirect()->back()->with('success', 'Comment updated successfully!');
    }

    // Видалення коментаря
    public function destroyComment(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }
}
