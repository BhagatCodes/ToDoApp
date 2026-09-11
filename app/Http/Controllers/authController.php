<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
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
            foreach([Task::class, Category::class] as $model){
                $model::where('session_id',session()->id())->whereNull('user_id')->update([
                    'user_id'=>auth()->id(),
                    'session_id'=>null,
                ]);
            }
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'The email or password is incorrect.',
        ])->onlyInput('email');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}