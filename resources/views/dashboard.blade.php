<x-app-layout>         
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-400 to-blue-400 drop-shadow-2xl">
                {{ __('Dashboard') }}
            </h2>

            <!-- Гамбургер меню -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="p-2 rounded bg-gray-700 text-white focus:outline-none">
                    &#9776;
                </button>

                <div x-show="open" @click.away="open = false"
                     class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-xl shadow-lg z-50 space-y-1 p-2">
                    <a href="{{ route('posts.create') }}" class="btn-custom btn-purple">Create Post</a>
                    <a href="#feed" class="btn-custom btn-purple">View Feed</a>
                    <a href="{{ route('posts.my') }}" class="btn-custom btn-purple">My Posts</a>
                    <a href="{{ route('profile.show') }}" class="btn-custom btn-purple">Profile</a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 max-w-5xl mx-auto space-y-8 px-4">

        <!-- Стрічка постів -->
        <div id="feed" class="space-y-6">
            @forelse ($posts as $post)
                <div class="bg-gray-800 bg-opacity-60 backdrop-blur-md p-6 rounded-xl shadow-lg">
                    <h3 class="text-2xl font-extrabold mb-2 text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-400 to-blue-400">
                        {{ $post->title }}
                    </h3>
                    <p class="text-gray-200 mb-4">{{ $post->content }}</p>

                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" 
                             alt="Post image" 
                             class="w-full max-h-96 object-contain rounded shadow-inner border border-gray-700 mb-4">
                    @endif

                    <div class="text-sm text-gray-400 mb-3">
                        By {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                    </div>

                    <div class="flex flex-wrap gap-3 items-center mb-4">
                        <!-- Лайк кнопка AJAX -->
                        <button 
                            class="like-btn btn-custom btn-green"
                            data-url="{{ route('posts.like', $post) }}">
                            👍 Like (<span id="likes-count-{{ $post->id }}">{{ $post->likes->count() }}</span>)
                        </button>

                        @can('update', $post)
                            <a href="{{ route('posts.edit', $post) }}" class="btn-custom btn-blue">Edit</a>
                        @endcan

                        @can('delete', $post)
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
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
                                
                                @can('update', $comment)
                                    <div class="flex gap-2">
                                        <a href="{{ route('comments.edit', $comment) }}" class="btn-custom btn-blue text-xs">Edit</a>
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-custom btn-red text-xs">Delete</button>
                                        </form>
                                    </div>
                                @endcan
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

                </div>
            @empty
                <div class="bg-gray-700 p-6 rounded-xl text-gray-200 text-center">
                    No posts yet.
                </div>
            @endforelse
        </div>

    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const url = btn.dataset.url;

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
                if (countEl) countEl.textContent = data.likes_count;

                btn.innerHTML = data.liked 
                    ? `❤️ Liked (<span>${data.likes_count}</span>)`
                    : `👍 Like (<span>${data.likes_count}</span>)`;
            }
        });
    });
});
    </script>
</x-app-layout>
