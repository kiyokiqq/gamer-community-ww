<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-400 to-blue-400 drop-shadow-2xl">
                {{ $user->name }}'s Profile
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('dashboard') }}" class="btn-custom btn-gray">Back to Dashboard</a>
                @auth
                    @if(auth()->id() === $user->id)
                        <a href="{{ route('profile.edit') }}" class="btn-custom btn-purple">Edit Profile</a>
                    @endif
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-8 p-6 relative">

        {{-- Плаваючий банер успіху --}}
        @if(session('success'))
            <div id="success-banner" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 p-4 bg-green-600 bg-opacity-80 text-white rounded-xl shadow-xl text-center font-semibold transition-all duration-500">
                {{ session('success') }}
            </div>
        @endif

        {{-- Профіль користувача --}}
        <div class="bg-gray-800 bg-opacity-60 backdrop-blur-md p-6 rounded-xl shadow-md text-gray-200 space-y-4">

            {{-- Порожня аватарка --}}
            <div class="flex items-center gap-4">
                <div class="w-24 h-24 rounded-full bg-gray-700 flex items-center justify-center text-gray-400 text-xl">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <div class="flex flex-col gap-2">
                    <h3 class="text-2xl font-bold">{{ $user->name }}</h3>
                    <p class="text-gray-400">Email: {{ $user->email }}</p>
                    <p class="text-gray-400">City: {{ $user->city ?? 'Not specified' }}</p>
                </div>
            </div>

            <div>
                <h4 class="font-semibold text-lg mb-1">About Me:</h4>
                <p class="text-gray-200">{{ $user->about ?? 'No description provided.' }}</p>
            </div>

            <div class="text-gray-400 text-sm">
                Joined: {{ $user->created_at->format('F d, Y') }}
            </div>
        </div>
    </div>

    <style>
        .btn-custom {
            position: relative;
            display: inline-block;
            padding: 0.6rem 1.5rem;
            font-weight: 700;
            color: #fff;
            border-radius: 1.5rem;
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
        .btn-custom:hover { transform: translateY(-2px) scale(1.03); box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .btn-purple { background: linear-gradient(135deg, #7e22ce, #5b21b6); }
        .btn-gray { background: linear-gradient(135deg, #6b7280, #4b5563); }
    </style>

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const banner = document.getElementById('success-banner');
                if(banner) {
                    setTimeout(() => {
                        banner.style.opacity = '0';
                        banner.style.transform = 'translateX(-50%) translateY(-20px)';
                        setTimeout(() => banner.remove(), 500);
                    }, 3000); // банер висить 3 секунди
                }
            });
        </script>
    </x-slot>
</x-app-layout>
