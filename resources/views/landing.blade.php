@extends('layouts.app')

@section('title', 'Welcome to WatchSense')

@section('content')
    <div class="min-h-screen bg-black relative overflow-hidden"
        @if ($trendingMovie && $trendingMovie['backdrop_url']) style="background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.8)), url('{{ $trendingMovie['backdrop_url'] }}'); background-size: cover; background-position: center;" @endif>

        <!-- Animated Background Elements - Dark & Sophisticated -->
        <div class="absolute inset-0 overflow-hidden">
            <div
                class="absolute -top-40 -right-40 w-80 h-80 bg-white/5 rounded-full mix-blend-screen filter blur-3xl animate-blob">
            </div>
            <div
                class="absolute -bottom-40 -left-40 w-80 h-80 bg-white/10 rounded-full mix-blend-screen filter blur-3xl animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-gray-700/20 rounded-full filter blur-3xl animate-blob animation-delay-4000">
            </div>
            <!-- Subtle grid pattern -->
            <div
                class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:64px_64px]">
            </div>
        </div>

        <div class="container mx-auto px-4 py-12 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                <!-- Left Side - Content with Dark Theme -->
                <div class="space-y-8 text-white">
                    <!-- Logo/Title with subtle gold accent -->
                    <div class="space-y-4">
                        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight">
                            <span
                                class="bg-gradient-to-r from-white via-gray-300 to-gray-400 bg-clip-text text-transparent">
                                WatchSense
                            </span>
                        </h1>
                        <p class="text-xl text-gray-400 leading-relaxed max-w-lg">
                            Discover movies tailored to your taste with AI-powered recommendations that learn what you love.
                        </p>
                    </div>

                    <!-- Features with sleek dark styling -->
                    <div class="space-y-4">
                        <div
                            class="group flex items-start gap-5 p-3 rounded-xl transition-all duration-300 hover:bg-white/5">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-gray-700 to-gray-800 rounded-xl flex items-center justify-center shrink-0 shadow-lg group-hover:scale-110 transition-transform border border-white/10">
                                <span class="text-xl">🎬</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Discover Movies</h3>
                                <p class="text-gray-500 text-sm">Browse thousands of movies from around the world</p>
                            </div>
                        </div>

                        <div
                            class="group flex items-start gap-5 p-3 rounded-xl transition-all duration-300 hover:bg-white/5">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-gray-700 to-gray-800 rounded-xl flex items-center justify-center shrink-0 shadow-lg group-hover:scale-110 transition-transform border border-white/10">
                                <span class="text-xl">⭐</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Personalized Recommendations</h3>
                                <p class="text-gray-500 text-sm">Get "More Like This" suggestions based on your preferences
                                </p>
                            </div>
                        </div>

                        <div
                            class="group flex items-start gap-5 p-3 rounded-xl transition-all duration-300 hover:bg-white/5">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-gray-700 to-gray-800 rounded-xl flex items-center justify-center shrink-0 shadow-lg group-hover:scale-110 transition-transform border border-white/10">
                                <span class="text-xl">🔍</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Smart Search</h3>
                                <p class="text-gray-500 text-sm">Find movies by title, genre, language, and more</p>
                            </div>
                        </div>

                        <div
                            class="group flex items-start gap-5 p-3 rounded-xl transition-all duration-300 hover:bg-white/5">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-gray-700 to-gray-800 rounded-xl flex items-center justify-center shrink-0 shadow-lg group-hover:scale-110 transition-transform border border-white/10">
                                <span class="text-xl">💬</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Community Reviews</h3>
                                <p class="text-gray-500 text-sm">Read and share reviews with fellow movie enthusiasts</p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons - Gold/White accent on dark -->
                    <div class="flex flex-col sm:flex-row gap-5 pt-6">
                        <a href="{{ route('register') }}"
                            class="relative group px-8 py-4 bg-white text-black font-bold rounded-xl hover:shadow-2xl hover:shadow-white/20 transition-all duration-300 text-center overflow-hidden">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                Get Started
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </span>
                        </a>
                        <a href="{{ route('login') }}"
                            class="px-8 py-4 backdrop-blur-sm bg-white/5 border border-white/20 text-white font-bold rounded-xl hover:bg-white/10 hover:border-white/40 transition-all duration-300 text-center group">
                            Sign In
                            <span class="inline-block group-hover:translate-x-1 transition-transform ml-1">→</span>
                        </a>
                    </div>
                </div>

                <!-- Right Side - Modern Dark Showcase -->
                <div class="hidden lg:block relative">
                    <!-- Subtle floating elements -->
                    <div class="absolute -top-20 -right-20 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>

                    <!-- Interactive Movie Cards Stack - Dark Theme -->
                    <div class="relative perspective-1000">
                        <!-- Card 1 (Back) -->
                        <div
                            class="absolute top-0 left-0 w-full transform rotate-6 translate-x-4 translate-y-4 transition-all duration-500 hover:rotate-0 hover:translate-x-0 hover:translate-y-0 z-0">
                            <div
                                class="bg-gradient-to-br from-gray-900 to-black rounded-2xl p-5 border border-white/10 shadow-2xl backdrop-blur-sm">
                                <div
                                    class="h-56 bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl mb-4 flex items-center justify-center overflow-hidden relative group">
                                    <span class="text-6xl transition-transform group-hover:scale-110">🎭</span>
                                    <div class="absolute inset-0 bg-black/50 group-hover:bg-black/30 transition-all"></div>
                                </div>
                                <h4 class="text-white font-bold text-xl mb-2">Drama & Emotion</h4>
                                <p class="text-gray-500 text-sm">Deep stories that touch your soul</p>
                            </div>
                        </div>

                        <!-- Card 2 (Front) -->
                        <div
                            class="relative z-10 transform -rotate-3 hover:rotate-0 transition-all duration-500 hover:translate-y-[-10px]">
                            <div
                                class="bg-gradient-to-br from-gray-900 to-black rounded-2xl p-5 border border-white/15 shadow-2xl backdrop-blur-sm">
                                @if ($trendingMovie && $trendingMovie['poster_url'])
                                    <div
                                        class="h-64 bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl mb-4 flex items-center justify-center overflow-hidden relative group cursor-pointer">
                                        <img src="{{ $trendingMovie['poster_url'] }}" alt="{{ $trendingMovie['title'] }}"
                                            class="w-full h-full object-cover">
                                        <div
                                            class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('login') }}"
                                                class="text-white font-semibold backdrop-blur-sm px-3 py-1 rounded-full bg-black/70 hover:bg-black/90 transition">View
                                                Now</a>
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="h-64 bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl mb-4 flex items-center justify-center overflow-hidden relative group cursor-pointer">
                                        <span class="text-7xl transition-transform group-hover:scale-110">🎬</span>
                                        <div
                                            class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <span
                                                class="text-white font-semibold backdrop-blur-sm px-3 py-1 rounded-full bg-black/70">Now
                                                Showing</span>
                                        </div>
                                    </div>
                                @endif
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="text-white font-bold text-xl">
                                        {{ $trendingMovie ? $trendingMovie['title'] : 'Latest Releases' }}</h4>
                                    <div class="flex gap-1">
                                        <span class="text-yellow-400">★</span>
                                        <span
                                            class="text-gray-400 text-sm">{{ $trendingMovie ? number_format($trendingMovie['rating'], 1) : '4.8' }}</span>
                                    </div>
                                </div>
                                <p class="text-gray-500 text-sm">
                                    {{ $trendingMovie ? $trendingMovie['overview'] : 'Discover trending blockbusters and hidden gems' }}
                                </p>
                                @if ($trendingMovie && count($trendingMovie['genres']) > 0)
                                    <div class="mt-3 flex gap-2 flex-wrap">
                                        @foreach ($trendingMovie['genres'] as $genre)
                                            <span
                                                class="text-xs bg-white/10 px-2 py-1 rounded-full text-gray-300">{{ $genre }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="mt-3 flex gap-2">
                                        <span class="text-xs bg-white/10 px-2 py-1 rounded-full text-gray-300">Action</span>
                                        <span
                                            class="text-xs bg-white/10 px-2 py-1 rounded-full text-gray-300">Adventure</span>
                                        <span class="text-xs bg-white/10 px-2 py-1 rounded-full text-gray-300">Sci-Fi</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Floating stats badge - Dark -->
                    <div
                        class="absolute -bottom-6 -left-6 bg-black/80 backdrop-blur-md rounded-full px-4 py-2 border border-white/15 flex items-center gap-3 animate-bounce-slow">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-gray-300 text-sm font-mono">+2,500 movies available</span>
                    </div>
                </div>
            </div>

            <!-- Footer Info - Dark & Minimal -->
            <div
                class="mt-24 pt-12 border-t border-white/10 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                <div class="group p-4 rounded-xl hover:bg-white/5 transition-all">
                    <div
                        class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center mb-4 mx-auto md:mx-0 group-hover:scale-110 transition-transform border border-white/10">
                        <span class="text-2xl">🎬</span>
                    </div>
                    <h5 class="text-white font-bold mb-2 text-lg">Thousands of Movies</h5>
                    <p class="text-gray-500 text-sm leading-relaxed">Access our comprehensive database of films from all
                        genres and eras</p>
                </div>
                <div class="group p-4 rounded-xl hover:bg-white/5 transition-all">
                    <div
                        class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center mb-4 mx-auto md:mx-0 group-hover:scale-110 transition-transform border border-white/10">
                        <span class="text-2xl">🌍</span>
                    </div>
                    <h5 class="text-white font-bold mb-2 text-lg">Global Content</h5>
                    <p class="text-gray-500 text-sm leading-relaxed">Movies in multiple languages from filmmakers around the
                        world</p>
                </div>
                <div class="group p-4 rounded-xl hover:bg-white/5 transition-all">
                    <div
                        class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center mb-4 mx-auto md:mx-0 group-hover:scale-110 transition-transform border border-white/10">
                        <span class="text-2xl">🔄</span>
                    </div>
                    <h5 class="text-white font-bold mb-2 text-lg">Always Updated</h5>
                    <p class="text-gray-500 text-sm leading-relaxed">New movies and content added regularly to our platform
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Animations -->
    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        @keyframes bounce-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-bounce-slow {
            animation: bounce-slow 3s infinite;
        }

        .perspective-1000 {
            perspective: 1000px;
        }
    </style>
@endsection
