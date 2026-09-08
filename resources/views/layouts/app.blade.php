<!DOCTYPE html>
<html lang="en" class="h-full w-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title','To Do App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full w-full">
    <main>
        <x-sidebar />
        @yield('content')
    </main>
</body>
@stack('scripts')
</html>