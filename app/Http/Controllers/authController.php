<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function registerUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:255|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8|max:12',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function loginUser(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|max:12',
        ]);

        if (Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'The email or password is incorrect.',
        ])->onlyInput('email');
    }
}