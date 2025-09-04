<x-app-layout>  
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-400 to-blue-400 drop-shadow-2xl">
                Edit Comment
            </h2>

            <a href="{{ route('dashboard') }}" class="btn-custom btn-gray">
                &#8592; Dashboard
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-8 p-6 relative">
        {{-- Плаваючий банер успіху --}}
        @if(session('success'))
            <div id="success-banner" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 p-4 bg-green-600 bg-opacity-80 text-white rounded-xl shadow-xl transition-all duration-500">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-gray-800 bg-opacity-60 backdrop-blur-md p-6 rounded-xl shadow-xl">
            <form action="{{ route('comments.update', $comment) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="content" class="block text-gray-200 font-semibold mb-2">Comment</label>
                    <textarea name="content" id="content" rows="3"
                              class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-purple-500"
                              required>{{ old('content', $comment->content) }}</textarea>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="btn-custom btn-purple">Update</button>
                    <a href="{{ route('dashboard') }}" class="btn-custom btn-gray">Cancel</a>
                </div>
            </form>
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

        .btn-purple { background: linear-gradient(135deg, #7e22ce, #5b21b6); }
        .btn-gray { background: linear-gradient(135deg, #6b7280, #4b5563); }

        @media (max-width: 768px) { .btn-custom { padding: 0.7rem 1.6rem; font-size: 0.95rem; } }
        @media (max-width: 480px) { .btn-custom { padding: 0.6rem 1.2rem; font-size: 0.9rem; } }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const banner = document.getElementById('success-banner');
            if(banner) {
                setTimeout(() => {
                    banner.style.opacity = '0';
                    banner.style.transform = 'translateX(-50%) translateY(-20px)';
                    setTimeout(() => banner.remove(), 500);
                }, 3000);
            }
        });
    </script>
</x-app-layout>
