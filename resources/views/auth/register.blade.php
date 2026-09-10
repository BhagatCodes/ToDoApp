@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="w-full max-w-lg">
        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-xl shadow-slate-200/60">
            <div class="mb-6 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-orange-100 text-orange-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9V7.5A2.5 2.5 0 0 0 15.5 5h-7A2.5 2.5 0 0 0 6 7.5V9m12 0H6m12 0v9.5A1.5 1.5 0 0 1 16.5 20h-9A1.5 1.5 0 0 1 6 18.5V9m6 3.75V12m0 0v-1.5m0 1.5h1.5m-1.5 0H10.5"/>
                    </svg>
                </div>
                <h1 class="mt-4 text-3xl font-bold text-slate-900">Create account</h1>
                <p class="mt-2 text-sm text-slate-500">Get started with your personal to-do workspace</p>
            </div>

            <form action="{{ route('user.register') }}" method="post" novalidate>
                @csrf

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Full name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="John Doe" autocomplete="name">
                    </div>

                    <div class="md:col-span-2">
                        <label for="register-email" class="mb-1 block text-sm font-medium text-slate-700">Email address</label>
                        <input id="register-email" type="email" value="{{ old('email') }}" name="email" class="form-input" placeholder="you@example.com" autocomplete="email">
                    </div>

                    <div>
                        <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                        <input id="password" type="password" name="password" class="form-input" placeholder="Create a password" autocomplete="new-password">
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-1 block text-sm font-medium text-slate-700">Confirm</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-input" placeholder="Repeat password" autocomplete="new-password">
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn btn-primary w-full justify-center py-3 text-base font-semibold">
                        Create account
                    </button>
                </div>
                @if($errors->any())
                    <ul class="list-none text-red-500 bg-red-200 mt-2 p-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">
                Already have an account?
                <a href="{{ url('/login') }}" class="font-semibold text-orange-500 hover:text-orange-600">Sign in</a>
            </p>
        </div>
    </div>
@endsection
