<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', trans('messages.app_name'))</title>
    <!-- Tailwind CSS via CDN for immediate styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container">
        @include('nav')

        <main>
            @yield('content')
        </main>

        <footer>
            <p>&copy; {{ date('Y') }} {{ trans('messages.app_name') }}</p>
        </footer>
    </div>
</body>
</html>
