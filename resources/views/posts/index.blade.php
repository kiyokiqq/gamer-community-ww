<x-app-layout> 
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-400 to-blue-400 leading-tight drop-shadow-lg">
            {{ __('Community Feed') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-5xl mx-auto space-y-8 px-4">

        <!-- Форма створення поста -->
        <div class="bg-gray-800 bg-opacity-50 backdrop-blur-md p-6 rounded-xl shadow-lg">
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block font-semibold text-gray-200">Title</label>
                    <input type="text" name="title" class="block w-full border rounded p-2 bg-gray-900 text-white border-gray-700 focus:ring-2 focus:ring-purple-500" required>
                </div>

                <div>
                    <label class="block font-semibold text-gray-200">Content</label>
                    <textarea name="content" rows="3" class="block w-full border rounded p-2 bg-gray-900 text-white border-gray-700 focus:ring-2 focus:ring-purple-500" required></textarea>
                </div>

                <div>
                    <label class="block font-semibold text-gray-200">Image (optional)</label>
                    <input type="file" name="image" class="block w-full text-gray-200">
                </div>

                <div class="text-right">
                    <button type="submit" class="btn-custom btn-purple">Post</button>
                </div>
            </form>
        </div>

        <!-- Стрічка постів -->
        <div class="space-y-6">
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

                    <form action="{{ route('posts.like', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-custom btn-green">Like ({{ $post->likes->count() }})</button>
                    </form>
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
        .btn-purple { background: linear-gradient(135deg, #7e22ce, #5b21b6); }

        @media (max-width: 768px) { .btn-custom { padding: 0.7rem 1.6rem; font-size: 0.95rem; } }
        @media (max-width: 480px) { .btn-custom { padding: 0.6rem 1.2rem; font-size: 0.9rem; } }
    </style>
</x-app-layout>
