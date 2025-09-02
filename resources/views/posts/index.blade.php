<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Community Feed') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">

        <!-- Форма створення поста -->
        <div class="bg-white p-6 rounded shadow mb-6">
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @csrf
                <div>
                    <label class="block font-medium text-sm text-gray-700">Title</label>
                    <input type="text" name="title" class="block w-full border rounded p-2" required>
                </div>

                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700">Content</label>
                    <textarea name="content" rows="3" class="block w-full border rounded p-2" required></textarea>
                </div>

                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700">Image (optional)</label>
                    <input type="file" name="image" class="block w-full">
                </div>

                <div class="mt-4 text-right">
                    <x-primary-button>
                        {{ __('Post') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- Стрічка постів -->
        <div class="space-y-4">
            @foreach ($posts as $post)
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="text-lg font-bold">{{ $post->title }}</h3>
                    <p class="text-gray-700 mt-2">{{ $post->content }}</p>

                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="mt-2 max-h-64 w-full object-cover rounded">
                    @endif

                    <div class="text-sm text-gray-500 mt-3">
                        By {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                    </div>

                    <form action="{{ route('posts.like', $post) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="text-blue-600 hover:underline">
                            Like ({{ $post->likes->count() }})
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
