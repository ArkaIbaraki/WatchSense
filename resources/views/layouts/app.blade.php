<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WatchSense') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased ">
    <div class="min-h-screen bg-cod-gray">
        <!-- Navigation -->
        <nav class="bg-cod-gray shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="text-xl font-bold text-platinum">WatchSense</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ route('profile') }}"
                                class="text-platinum hover:text-gray-300 font-medium">{{ Auth::user()->name }}</a>
                            <button type="button" id="logout-btn" class="text-platinum hover:text-gray-300">Logout</button>
                            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-platinum hover:text-gray-300">Login</a>
                            <a href="{{ route('register') }}" class="text-platinum hover:text-gray-300">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.getElementById('logout-btn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You will be logged out of your account.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#0b0b0b',
                        cancelButtonColor: '#9CA3AF',
                        confirmButtonText: 'Yes, Logout',
                        cancelButtonText: 'Cancel',
                        background: '#2a2a2a',
                        color: '#E5E5E5'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('logout-form').submit();
                        }
                    });
                });
            }
        });
    </script>
