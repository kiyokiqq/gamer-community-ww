<x-app-layout>    
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-400 to-blue-400 drop-shadow-2xl">
                {{ __('My Posts') }}
            </h2>

            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-white bg-gray-700 px-4 py-2 rounded-xl hover:bg-gray-600 transition">
                &#8592; Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12 max-w-5xl mx-auto space-y-8 px-4">

        <!-- Форма пошуку -->
        <div class="bg-gray-800 bg-opacity-50 backdrop-blur-md p-6 rounded-xl shadow-lg">
            <form method="GET" action="{{ route('posts.my') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="flex flex-col">
                    <label class="text-gray-200 font-semibold mb-1">Search by Title</label>
                    <input type="text" name="title" value="{{ request('title') }}" placeholder="Enter title" class="p-2 rounded bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-purple-500">
                </div>

                <div class="flex flex-col">
                    <label class="text-gray-200 font-semibold mb-1">Exact Date</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="p-2 rounded bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-purple-500">
                </div>

                <div class="flex flex-col">
                    <label class="text-gray-200 font-semibold mb-1">From</label>
                    <input type="date" name="from" value="{{ request('from') }}" class="p-2 rounded bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="flex flex-col">
                    <label class="text-gray-200 font-semibold mb-1">To</label>
                    <input type="date" name="to" value="{{ request('to') }}" class="p-2 rounded bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-purple-500">
                </div>

                <button type="submit" class="btn-custom btn-purple col-span-full md:col-span-1 mt-2">Search</button>
            </form>
        </div>

        <!-- Стрічка моїх постів -->
        <div id="feed" class="space-y-6">
            @forelse ($posts as $post)
                <div class="bg-gray-800 bg-opacity-60 backdrop-blur-md p-6 rounded-xl shadow-lg">
                    <h3 class="text-2xl font-extrabold mb-2 text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-400 to-blue-400">{{ $post->title }}</h3>
                    <p class="text-gray-200 mb-4">{{ $post->content }}</p>

                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" 
                             alt="Post image" 
                             class="w-full max-w-full max-h-96 object-contain rounded shadow-inner border border-gray-700 mb-4">
                    @endif

                    <div class="text-sm text-gray-400 mb-3">
                        By {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                    </div>

                    <div class="flex flex-wrap gap-3 items-center mb-4">
                        <!-- Лайк кнопка AJAX -->
                        <button 
    class="like-btn btn-custom btn-green"
    data-url="{{ route('posts.like', $post) }}">
    👍 Like (<span>{{ $post->likes->count() }}</span>)
</button>

                        @can('update', $post)
                            <a href="{{ route('posts.edit', $post) }}" class="btn-custom btn-blue">Edit</a>
                        @endcan

                        @can('delete', $post)
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-custom btn-red">Delete</button>
                            </form>
                        @endcan
                    </div>

<!-- Коментарі -->
<div class="mt-4 border-t border-gray-700 pt-4">
    <h4 class="text-gray-200 font-semibold mb-2">Comments ({{ $post->comments->count() }})</h4>

    @foreach ($post->comments as $comment)
        <div class="bg-gray-700 p-2 rounded mb-2 flex justify-between items-start">
            <div>
                <span class="font-semibold text-gray-100">{{ $comment->user->name }}:</span>
                <span class="text-gray-200">{{ $comment->content }}</span>
                <div class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</div>
            </div>
            <div class="flex gap-2">
                @can('update', $comment)
                    <a href="{{ route('comments.edit', $comment) }}" class="btn-custom btn-blue text-sm">Edit</a>
                @endcan
                @can('delete', $comment)
                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-custom btn-red text-sm">Delete</button>
                    </form>
                @endcan
            </div>
        </div>
    @endforeach

    @auth
        <form action="{{ route('posts.comments.store', $post) }}" method="POST" class="mt-2">
            @csrf
            <input type="text" name="content" placeholder="Add a comment..." 
                   class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-purple-500" required>
            <button type="submit" class="btn-custom btn-purple mt-2">Comment</button>
        </form>
    @endauth
</div>

    @empty
        <div class="bg-gray-700 p-6 rounded-xl text-gray-200 text-center">
            No posts found for your search criteria.
        </div>
    @endforelse
</div> <!-- #feed -->

</div> <!-- .py-12 .max-w-5xl -->

<style>
    .btn-custom {
        position: relative;
        display: inline-block;
        padding: 0.8rem 2rem;
        font-weight: 700;
        color: #fff;
        border-radius: 2rem;
        text-decoration: none;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
    }
    .btn-custom::before {
        content: "";
        position: absolute;
        top: 0;
        left: -75%;
        width: 50%;
        height: 100%;
        background: linear-gradient(120deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0.1) 50%, transparent 100%);
        transform: skewX(-20deg);
        transition: all 0.5s ease;
    }
    .btn-custom:hover::before { left: 125%; }
    .btn-custom:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 8px 25px rgba(0,0,0,0.4), 0 0 15px rgba(255,255,255,0.08);
    }

    .btn-green { background: linear-gradient(135deg, #34d399, #059669); }
    .btn-blue { background: linear-gradient(135deg, #6366f1, #4338ca); }
    .btn-red { background: linear-gradient(135deg, #ef4444, #b91c1c); }
    .btn-purple { background: linear-gradient(135deg, #7e22ce, #5b21b6); }

    @media (max-width: 768px) { .btn-custom { padding: 0.7rem 1.6rem; font-size: 0.95rem; } }
    @media (max-width: 480px) { .btn-custom { padding: 0.6rem 1.2rem; font-size: 0.9rem; } }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const url = btn.dataset.url;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    const countEl = btn.querySelector('span');

                    // Оновлюємо лічильник лайків
                    if (countEl) countEl.textContent = data.likes_count;

                    // Оновлюємо текст кнопки
                    btn.innerHTML = data.liked 
                        ? `❤️ Liked (<span>${data.likes_count}</span>)`
                        : `👍 Like (<span>${data.likes_count}</span>)`;
                } else {
                    console.error('Помилка при лайку:', response.status);
                }
            } catch (error) {
                console.error('Помилка запиту лайку:', error);
            }
        });
    });
});
</script>


</x-app-layout>
