<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Показ профілю будь-якого користувача
     * Якщо $user не переданий — показує свій профіль
     */
    public function show(User $user = null)
    {
        $user = $user ?? auth()->user();
        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        return view('profile.show', compact('user'));
    }

    /**
     * Показ свого профілю (окремий маршрут /profile)
     */
    public function showSelf()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    /**
     * Форма редагування свого профілю
     */
    public function edit()
    {
        $user = auth()->user();
        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        return view('profile.edit', compact('user'));
    }

    /**
     * Оновлення профілю
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'city'  => 'nullable|string|max:255',
            'about' => 'nullable|string|max:1000',
        ]);

        $user->update($validated);

        return redirect()->route('profile.show', $user)
                         ->with('success', 'Profile updated successfully!');
    }
}
