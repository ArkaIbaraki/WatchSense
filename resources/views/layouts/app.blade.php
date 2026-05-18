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
    <div class="min-h-screen bg-cod-gray flex flex-col lg:flex-row">
        <!-- Mobile Menu Button -->
        @auth
            <button id="mobile-menu-btn"
                class="lg:hidden fixed top-4 left-4 z-40 text-platinum bg-off-black p-2 rounded-lg">
                <i class="fas fa-bars text-xl"></i>
            </button>
        @endauth

        <!-- Sidebar - Hidden on mobile, visible on desktop -->
        @auth
            <aside id="sidebar"
                class="fixed lg:sticky lg:top-0 w-52 bg-[#131313] border-r border-off-black flex flex-col h-screen lg:max-h-screen z-30
                hidden lg:flex lg:h-screen transform lg:transform-none transition-transform duration-300 ease-in-out">
                <!-- Close Button (Mobile) -->
                {{-- <button id="close-sidebar" class="lg:hidden absolute top-4 right-4 text-platinum p-2">
                    <i class="fas fa-times text-xl"></i>
                </button> --}}

                <!-- Logo at Top -->
                <div class="p-4 border-t border-off-black flex justify-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-platinum hover:text-teal-400 transition">
                        WatchSense
                    </a>
                </div>

                <!-- Main Content (expands to fill space) -->
                <nav class="flex-1 p-4">
                </nav>

                <!-- Footer at Bottom -->
                <div class="p-4 border-t">
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
                </div>
            </aside>

            <!-- Overlay for mobile menu -->
            <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden"></div>
        @endauth

        <!-- Main Content - Responsive padding and margin -->
        <main class="flex-1 w-full lg:flex-1 pt-16 lg:pt-0 px-4 lg:px-0">
            @yield('content')
        </main>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const closeSidebarBtn = document.getElementById('close-sidebar');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('hidden');
                sidebarOverlay.classList.toggle('hidden');
                mobileMenuBtn.classList.toggle('hidden');
            });
        }

        if (closeSidebarBtn) {
            closeSidebarBtn.addEventListener('click', () => {
                sidebar.classList.add('hidden');
                sidebarOverlay.classList.add('hidden');
                mobileMenuBtn.classList.remove('hidden');
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.add('hidden');
                sidebarOverlay.classList.add('hidden');
                mobileMenuBtn.classList.remove('hidden');
            });
        }

        // Logout functionality
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
