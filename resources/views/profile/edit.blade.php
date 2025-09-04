<x-app-layout> 
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-400 to-blue-400 drop-shadow-2xl">
                Edit Profile
            </h2>
            <a href="{{ route('profile.show', $user) }}" class="btn-custom btn-gray">
                &#8592; Back to Profile
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-8 p-6 bg-gray-800 rounded-xl shadow-xl">
        {{-- Банер успіху --}}
        @if(session('success'))
            <div id="success-banner" class="bg-green-600 bg-opacity-90 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Помилки валідації --}}
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-600 text-white rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="name" class="block font-semibold mb-1">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                       class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-purple-500" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block font-semibold mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                       class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-purple-500" required>
            </div>

            <div class="mb-4">
                <label for="city" class="block font-semibold mb-1">City</label>
                <input type="text" name="city" id="city" value="{{ old('city', $user->city) }}"
                       class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-purple-500">
            </div>

            <div class="mb-4">
                <label for="about" class="block font-semibold mb-1">About Me</label>
                <textarea name="about" id="about" rows="4"
                          class="w-full p-2 rounded bg-gray-900 text-white border border-gray-700 focus:ring-2 focus:ring-purple-500">{{ old('about', $user->about) }}</textarea>
            </div>

            <div class="flex gap-2 mt-4">
                <button type="submit" class="btn-custom btn-purple">Update Profile</button>
                <a href="{{ route('profile.show', $user) }}" class="btn-custom btn-gray">Cancel</a>
            </div>
        </form>
    </div>

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const banner = document.getElementById('success-banner');
                if (banner) setTimeout(() => banner.remove(), 3000); // банер зникає через 3 секунди
            });
        </script>
    </x-slot>

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
</x-app-layout>
