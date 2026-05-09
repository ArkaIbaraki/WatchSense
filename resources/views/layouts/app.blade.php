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

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-cod-gray flex">
        <!-- Sidebar -->
        <aside class="w-35 bg-[#131313] border-r border-off-black flex flex-col fixed h-screen">
            <!-- Logo at Top -->
            <div class="p-2.5 flex items-center gap-4">
                <a href="{{ route('home') }}" class="text-xl text-center font-bold text-platinum">WatchSense</a>
            </div>

            <!-- Main Content (expands to fill space) -->
            <nav class="flex-1 p-4">
            </nav>

            <!-- Footer at Bottom -->
            <div class="p-4 border-t">
                @auth
                    <div class="space-y-2">
                        <a href="{{ route('profile') }}" class="text-platinum hover:text-gray-300 transition">
                            <div class="flex items-center justify-between bg-cod-gray rounded-lg p-3">
                                <i class="fas fa-user text-lg"></i>
                                <span class="text-platinum font-medium truncate text-sm">{{ Auth::user()->name }}</span>
                            </div>
                        </a>
                        <br>
                        <button type="button" id="logout-btn"
                            class="w-full bg-platinum text-cod-gray py-2 px-3 rounded-lg hover:bg-ash transition font-medium text-sm">
                            Logout
                        </button>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                            @csrf
                        </form>
                    </div>
                @else
                    <div class="space-y-2">
                        <a href="{{ route('login') }}"
                            class="block w-full bg-platinum text-cod-gray py-2 px-3 rounded-lg hover:bg-ash transition font-medium text-center text-sm">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="block w-full bg-ash text-cod-gray py-2 px-3 rounded-lg hover:bg-platinum transition font-medium text-center text-sm">
                            Register
                        </a>
                    </div>
                @endauth
            </div>
        </aside>

        <!-- Main Content -->
        <main class="ml-52 flex-1">
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
