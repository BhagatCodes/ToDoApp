@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="w-full max-w-md">
        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-xl shadow-slate-200/60">
            <div class="mb-6 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-orange-100 text-orange-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Zm-7.5 9.75c0-2.35 2.15-4.25 4.8-4.25h2.9c2.65 0 4.8 1.9 4.8 4.25v.5h-12.5v-.5Z"/>
                    </svg>
                </div>
                <h1 class="mt-4 text-3xl font-bold text-slate-900">Welcome back</h1>
                <p class="mt-2 text-sm text-slate-500">Sign in to continue to your dashboard</p>
            </div>

            <form action="{{ route('user.login') }}" method="post" novalidate>
                @csrf

                <div class="space-y-5">
                    <div>
                        <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email address</label>
                        <input id="email" type="email" name="email" class="form-input" placeholder="you@example.com" autocomplete="email">
                    </div>

                    <div>
                        <div class="mb-1 flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                            <a href="#" class="text-xs font-medium text-orange-500 hover:text-orange-600">Forgot password?</a>
                        </div>
                        <input id="password" type="password" name="password" class="form-input" placeholder="Enter your password" autocomplete="current-password">
                    </div>

                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-orange-500 focus:ring-orange-300">
                        Remember me
                    </label>

                    <button type="submit" class="btn btn-primary w-full justify-center py-3 text-base font-semibold">
                        Sign in
                    </button>
                    @if($errors->any())
                        <ul class="bg-red-200 text-red-500">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    @endif
                </div>
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">
                Don’t have an account?
                <a href="{{ url('/register') }}" class="font-semibold text-orange-500 hover:text-orange-600">Create one</a>
            </p>
        </div>
    </div>
@endsection
