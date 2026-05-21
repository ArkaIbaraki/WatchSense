@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="min-h-screen bg-cod-gray py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div
                class="bg-off-black border border-zinc-800 rounded-2xl shadow-xl overflow-hidden mb-6">
                <div
                    class="px-6 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div class="flex items-center gap-4">
                        <div
                            class="w-16 h-16 rounded-full bg-zinc-900 border border-zinc-700 flex items-center justify-center shadow-inner">
                            <span class="text-2xl font-bold text-platinum">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>

                        <div>
                            <h1 class="text-2xl font-bold text-platinum">
                                My Profile
                            </h1>
                            <p class="text-sm text-zinc-400 mt-1">
                                Manage and view your account information
                            </p>
                        </div>
                    </div>

                    {{-- Back Button --}}
                    <a href="{{ url('/') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-zinc-900 hover:bg-zinc-800 border border-zinc-700 text-platinum text-sm font-medium transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to Home
                    </a>
                </div>
            </div>

            {{-- Profile Card --}}
            <div
                class="bg-off-black border border-zinc-800 rounded-2xl shadow-xl overflow-hidden">

                {{-- Top Banner --}}
                <div
                    class="h-32 bg-gradient-to-r from-zinc-900 via-zinc-800 to-black border-b border-zinc-800">
                </div>

                <div class="px-6 pb-8">

                    {{-- Avatar & User Info --}}
                    <div
                        class="flex flex-col md:flex-row md:items-end md:justify-between -mt-14 mb-8 gap-6">

                        <div class="flex items-end gap-5">
                            <div
                                class="w-28 h-28 rounded-2xl bg-zinc-900 border-4 border-off-black shadow-lg flex items-center justify-center">
                                <span class="text-4xl font-bold text-platinum">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            </div>

                            <div class="pb-2">
                                <h2
                                    class="text-2xl font-bold text-platinum">
                                    {{ Auth::user()->name }}
                                </h2>

                                <p class="text-zinc-400 text-sm mt-1">
                                    {{ Auth::user()->email }}
                                </p>

                                @if (Auth::user()->is_admin)
                                    <div class="mt-3">
                                        <span
                                            class="inline-flex items-center px-4 py-1.5 rounded-full bg-zinc-800 border border-zinc-700 text-platinum text-xs font-semibold tracking-wide">
                                            Administrator
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Information Section --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div
                            class="bg-zinc-900/60 border border-zinc-800 rounded-2xl p-5 hover:border-zinc-700 transition duration-200">
                            <p
                                class="text-xs uppercase tracking-wider text-zinc-500 mb-2">
                                Full Name
                            </p>

                            <h3
                                class="text-lg font-semibold text-platinum break-all">
                                {{ Auth::user()->name }}
                            </h3>
                        </div>

                        <div
                            class="bg-zinc-900/60 border border-zinc-800 rounded-2xl p-5 hover:border-zinc-700 transition duration-200">
                            <p
                                class="text-xs uppercase tracking-wider text-zinc-500 mb-2">
                                Email Address
                            </p>

                            <h3
                                class="text-lg font-semibold text-platinum break-all">
                                {{ Auth::user()->email }}
                            </h3>
                        </div>

                        <div
                            class="bg-zinc-900/60 border border-zinc-800 rounded-2xl p-5 hover:border-zinc-700 transition duration-200 md:col-span-2">
                            <p
                                class="text-xs uppercase tracking-wider text-zinc-500 mb-2">
                                Member Since
                            </p>

                            <h3
                                class="text-lg font-semibold text-platinum">
                                {{ Auth::user()->created_at->format('M d, Y') }}
                            </h3>
                        </div>
                    </div>

                    {{-- Admin Statistics --}}
                    @if (Auth::user()->is_admin)
                        <div class="mt-8">
                            <div class="mb-4">
                                <h3
                                    class="text-xl font-bold text-platinum">
                                    Admin Statistics
                                </h3>

                                <p class="text-sm text-zinc-500 mt-1">
                                    Overview of system users
                                </p>
                            </div>

                            <div
                                class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <div
                                    class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 hover:border-zinc-700 transition duration-200">
                                    <div
                                        class="flex items-center justify-between">
                                        <div>
                                            <p
                                                class="text-sm text-zinc-500">
                                                Total Users
                                            </p>

                                            <h2
                                                class="text-4xl font-bold text-platinum mt-2">
                                                {{ \App\Models\User::count() }}
                                            </h2>
                                        </div>

                                        <div
                                            class="w-14 h-14 rounded-xl bg-black border border-zinc-700 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-6 h-6 text-platinum"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2m10 0H7m8-10a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 hover:border-zinc-700 transition duration-200">
                                    <div
                                        class="flex items-center justify-between">
                                        <div>
                                            <p
                                                class="text-sm text-zinc-500">
                                                Total Admins
                                            </p>

                                            <h2
                                                class="text-4xl font-bold text-platinum mt-2">
                                                {{ \App\Models\User::where('is_admin', true)->count() }}
                                            </h2>
                                        </div>

                                        <div
                                            class="w-14 h-14 rounded-xl bg-black border border-zinc-700 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-6 h-6 text-platinum"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.055a12.083 12.083 0 01-6.16-9.477L12 14zm0 0v6" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif

                    {{-- Liked Movies --}}
                    <div class="mt-10">

                        {{-- Header --}}
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

                            <div>
                                <h3 class="text-2xl font-bold text-platinum">
                                    Liked Movies
                                </h3>

                                <p class="text-sm text-zinc-500 mt-1">
                                    Movies you have liked
                                </p>
                            </div>

                            <div
                                class="inline-flex items-center px-4 py-2 rounded-xl bg-zinc-900 border border-zinc-800 text-sm text-zinc-400">
                                Total Likes :
                                <span class="ml-2 text-platinum font-semibold">
                                    {{ \App\Models\UserMovieLike::where('user_id', Auth::id())->where('is_liked', true)->count() }}
                                </span>
                            </div>

                        </div>

                        @php

                            use Illuminate\Support\Facades\Http;

                            $likedMovies = \App\Models\UserMovieLike::where(
                                'user_id',
                                Auth::id()
                            )
                                ->where('is_liked', true)
                                ->latest()
                                ->get()
                                ->map(function ($like) {

                                $apiKey = config('services.tmdb.api_key');

                                $response = Http::timeout(10)
                                    ->withoutVerifying()
                                    ->get(
                                        "https://api.themoviedb.org/3/movie/{$like->film_id}",
                                        [
                                            'api_key' => $apiKey,
                                        ]
                                    );

                                if (!$response->successful()) {
                                    return null;
                                }

                                $movie = $response->json();

                                return [

                                    'id' => $movie['id'],

                                    'title' => $movie['title'] ?? 'Unknown Movie',

                                    'description' => $movie['overview'] ?? null,

                                    'poster' => isset($movie['poster_path'])
                                        ? 'https://image.tmdb.org/t/p/w500' . $movie['poster_path']
                                        : null,

                                    'genres' => collect($movie['genres'] ?? [])
                                        ->pluck('name')
                                        ->join(', '),

                                    'liked_at' => $like->created_at,
                                ];
                            })
                            ->filter();

                        @endphp

                        @if ($likedMovies->count() > 0)

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                                @foreach ($likedMovies as $movieLike)

                                    <div
                                        class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden shadow-lg hover:border-zinc-700 hover:-translate-y-1 transition duration-300">

                                        {{-- Poster --}}
                                        <div class="h-72 bg-black overflow-hidden">

                                            @if ($movieLike['poster'])

                                                <img
                                                    src="{{ $movieLike['poster'] }}"
                                                    alt="{{ $movieLike['title'] }}"
                                                    class="w-full h-full object-cover">

                                            @else

                                                <div
                                                    class="w-full h-full flex items-center justify-center text-zinc-600 text-sm">
                                                    No Image
                                                </div>

                                            @endif

                                        </div>

                                        {{-- Content --}}
                                        <div class="p-5">

                                            {{-- Top --}}
                                            <div class="flex items-start justify-between gap-3">

                                                <div class="flex-1">

                                                    {{-- Title --}}
                                                    <h4
                                                        class="text-lg font-bold text-platinum line-clamp-1">
                                                        {{ $movieLike['title'] ?? 'Unknown Movie' }}
                                                    </h4>

                                                    {{-- Genres --}}
                                                    @if ($movieLike['genres'])

                                                        <p class="text-sm text-zinc-500 mt-1 line-clamp-1">
                                                            {{ $movieLike['genres'] }}
                                                        </p>

                                                    @endif

                                                </div>

                                                {{-- Like Icon --}}
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-black border border-zinc-700 flex items-center justify-center flex-shrink-0">

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-5 h-5 text-red-500"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor">

                                                        <path
                                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />

                                                    </svg>

                                                </div>

                                            </div>

                                            {{-- Description --}}
                                            @if ($movieLike['description'])

                                                <p
                                                    class="text-sm text-zinc-400 mt-4 line-clamp-3 leading-relaxed">

                                                    {{ $movieLike['description'] }}

                                                </p>

                                            @endif

                                            {{-- Bottom --}}
                                            <div
                                                class="mt-5 flex items-center justify-between">

                                                <span class="text-xs text-zinc-500">
                                                    Liked
                                                    {{ $movieLike['liked_at']->diffForHumans() }}
                                                </span>

                                                @if ($movieLike['id'])

                                                    <a href="{{ route('movie.details', $movieLike['id']) }}"
                                                        class="inline-flex items-center px-4 py-2 rounded-xl bg-black border border-zinc-700 hover:bg-zinc-800 text-sm text-platinum transition duration-200">

                                                        View

                                                    </a>

                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @else

                            {{-- Empty State --}}
                            <div
                                class="bg-zinc-900 border border-zinc-800 rounded-2xl p-10 text-center">

                                <div
                                    class="w-16 h-16 mx-auto rounded-2xl bg-black border border-zinc-700 flex items-center justify-center mb-4">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-8 h-8 text-zinc-600"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9.172 16.172a4 4 0 005.656 0L20 11m-8-8l-8 8m0 0l8 8" />

                                    </svg>

                                </div>

                                <h4 class="text-lg font-semibold text-platinum">
                                    No liked movies yet
                                </h4>

                                <p class="text-zinc-500 text-sm mt-2">
                                    Movies you like will appear here
                                </p>

                            </div>

                        @endif

                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection