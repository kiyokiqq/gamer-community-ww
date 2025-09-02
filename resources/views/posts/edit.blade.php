<x-app-layout>  
    <x-slot name="header">
        <div class="flex items-center justify-between space-x-4">
            <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-400 to-blue-400 drop-shadow-2xl">
                {{ $post->exists ? __('Edit Post') : __('Create Post') }}
            </h2>

            <div class="flex gap-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-white bg-gray-700 px-4 py-2 rounded-xl hover:bg-gray-600 transition">
                    &#8592; Dashboard
                </a>
                <a href="{{ route('posts.my') }}" class="flex items-center gap-2 text-white bg-gray-700 px-4 py-2 rounded-xl hover:bg-gray-600 transition">
                    &#8592; My Posts
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 max-w-5xl mx-auto">
        <div class="bg-gray-800 bg-opacity-50 backdrop-blur-md p-6 rounded-xl shadow-lg">
            <form 
                action="{{ $post->exists ? route('posts.update', $post) : route('posts.store') }}" 
                method="POST" 
                enctype="multipart/form-data" 
                class="space-y-4"
            >
                @csrf
                @if($post->exists)
                    @method('PUT')
                @endif

                <div>
                    <label class="block font-semibold text-gray-200">Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        value="{{ old('title', $post->title) }}" 
                        class="block w-full border rounded p-2 bg-gray-900 text-white border-gray-700 focus:ring-2 focus:ring-purple-500" 
                        required
                    >
                </div>

                <div>
                    <label class="block font-semibold text-gray-200">Content</label>
                    <textarea 
                        name="content" 
                        rows="3" 
                        class="block w-full border rounded p-2 bg-gray-900 text-white border-gray-700 focus:ring-2 focus:ring-purple-500" 
                        required
                    >{{ old('content', $post->content) }}</textarea>
                </div>

                <div>
                    <label class="block font-semibold text-gray-200">Image (optional)</label>
                    <input type="file" name="image" class="block w-full text-gray-200">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="mt-2 max-h-48 w-full object-cover rounded">
                    @endif
                </div>

                <div class="text-right">
                    <button type="submit" class="btn-custom btn-purple">
                        {{ $post->exists ? __('Update Post') : __('Create Post') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Кнопки */
        .btn-custom {
            position: relative;
            display: inline-block;
            padding: 0.8rem 2rem;
            font-weight: 700;
            color: #fff;
            border-radius: 2rem;
            text-decoration: none;
            overflow: hidden;
            transition: box-shadow 0.3s ease, background 0.3s ease;
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
            box-shadow: 0 8px 25px rgba(0,0,0,0.4), 0 0 15px rgba(255,255,255,0.08);
        }

        .btn-purple { background: linear-gradient(135deg, #7e22ce, #5b21b6); }

        /* Адаптивність */
        @media (max-width: 768px) { .btn-custom { padding: 0.7rem 1.6rem; font-size: 0.95rem; } }
        @media (max-width: 480px) { .btn-custom { padding: 0.6rem 1.2rem; font-size: 0.9rem; } }
    </style>
</x-app-layout>
