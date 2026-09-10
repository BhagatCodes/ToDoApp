<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
        ]);

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile = Storage::url($path);
        }

        $user->save();

        return back()->with('status', 'Profile updated successfully.');
    }
}
