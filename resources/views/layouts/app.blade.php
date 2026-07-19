<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BuildHive — Build Teams. Build Projects. Build Futures.')</title>
    <meta name="description" content="@yield('meta_description', 'BuildHive is a collaborative freelance marketplace where clients post projects, freelancers form teams, and great work gets built together.')">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-bg-primary text-text-primary antialiased">

    {{-- Navigation (hidden on auth pages) --}}
    @unless(View::hasSection('hide_chrome'))
        @include('components.navbar')
    @endunless

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer (hidden on auth pages) --}}
    @unless(View::hasSection('hide_chrome'))
        @include('components.footer')
    @endunless

    {{-- Page-specific scripts --}}
    @stack('scripts')

</body>
</html>
