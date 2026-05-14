@extends('layouts.app')

@section('title', 'Welcome to WatchSense')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-cod-gray via-off-black to-cod-gray flex items-center justify-center">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Left Side - Content -->
                <div class="space-y-8 text-platinum">
                    <!-- Logo/Title -->
                    <div class="space-y-4">
                        <h1 class="text-5xl md:text-6xl font-bold">
                            <span class="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                                WatchSense
                            </span>
                        </h1>
                        <p class="text-xl text-ash">
                            Discover movies tailored to your taste with AI-powered recommendations
                        </p>
                    </div>

                    <!-- Features -->
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-cyan-400 rounded-full flex items-center justify-center shrink-0 mt-1">
                                <span class="text-off-black font-bold">🎬</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold">Discover Movies</h3>
                                <p class="text-ash text-sm">Browse thousands of movies from around the world</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-cyan-400 rounded-full flex items-center justify-center shrink-0 mt-1">
                                <span class="text-off-black font-bold">⭐</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold">Personalized Recommendations</h3>
                                <p class="text-ash text-sm">Get "More Like This" suggestions based on your preferences</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-cyan-400 rounded-full flex items-center justify-center shrink-0 mt-1">
                                <span class="text-off-black font-bold">🔍</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold">Smart Search</h3>
                                <p class="text-ash text-sm">Find movies by title, genre, language, and more</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-cyan-400 rounded-full flex items-center justify-center shrink-0 mt-1">
                                <span class="text-off-black font-bold">💬</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold">Community Reviews</h3>
                                <p class="text-ash text-sm">Read and share reviews with fellow movie enthusiasts</p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="{{ route('register') }}"
                            class="px-8 py-3 bg-gradient-to-r from-cyan-400 to-blue-500 text-off-black font-bold rounded-lg hover:shadow-lg hover:shadow-cyan-400/50 transition text-center">
                            Get Started
                        </a>
                        <a href="{{ route('login') }}"
                            class="px-8 py-3 border-2 border-cyan-400 text-cyan-400 font-bold rounded-lg hover:bg-cyan-400 hover:text-off-black transition text-center">
                            Sign In
                        </a>
                    </div>
                </div>

                <!-- Right Side - Image/Showcase -->
                <div class="hidden md:block">
                    <div class="relative">
                        <!-- Decorative gradient shapes -->
                        <div
                            class="absolute -top-20 -right-20 w-80 h-80 bg-gradient-to-br from-cyan-400/20 to-transparent rounded-full blur-3xl">
                        </div>
                        <div
                            class="absolute -bottom-20 -left-20 w-80 h-80 bg-gradient-to-tr from-blue-500/20 to-transparent rounded-full blur-3xl">
                        </div>

                        <!-- Movie showcase cards -->
                        <div class="relative z-10 space-y-4">
                            <!-- Card 1 -->
                            <div class="bg-off-black border border-ash rounded-xl p-4 hover:border-platinum transition">
                                <div
                                    class="w-full h-48 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-lg mb-3 flex items-center justify-center">
                                    <span class="text-4xl">🎥</span>
                                </div>
                                <h4 class="text-platinum font-bold mb-2">Popular Movies</h4>
                                <p class="text-ash text-sm">Explore trending and highly-rated films</p>
                            </div>

                            <!-- Card 2 -->
                            <div
                                class="bg-off-black border border-ash rounded-xl p-4 hover:border-platinum transition ml-12">
                                <div
                                    class="w-full h-48 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg mb-3 flex items-center justify-center">
                                    <span class="text-4xl">🎭</span>
                                </div>
                                <h4 class="text-platinum font-bold mb-2">Smart Matching</h4>
                                <p class="text-ash text-sm">Our AI finds movies you'll love</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="mt-20 pt-12 border-t border-ash/20 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                <div>
                    <h5 class="text-platinum font-bold mb-2">Thousands of Movies</h5>
                    <p class="text-ash text-sm">Access our comprehensive database of films from all genres and eras</p>
                </div>
                <div>
                    <h5 class="text-platinum font-bold mb-2">Global Content</h5>
                    <p class="text-ash text-sm">Movies in multiple languages from filmmakers around the world</p>
                </div>
                <div>
                    <h5 class="text-platinum font-bold mb-2">Always Updated</h5>
                    <p class="text-ash text-sm">New movies and content added regularly to our platform</p>
                </div>
            </div>
        </div>
    </div>
@endsection
