@extends('layouts.app')

@section('title', 'Movie Gallery')

@section('content')
    <div class="py-8 px-6 space-y-6">
        <!-- Search Bar Header -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <h1 class="text-3xl font-bold text-platinum">Movie List</h1>

            <!-- Search Form -->
            <form method="GET" action="{{ route('gallery.index') }}" class="w-full md:w-96">
                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search movies..."
                        class="w-full px-4 py-2 bg-off-black border border-ash rounded-lg text-platinum placeholder-gray-500 focus:border-platinum focus:outline-none transition">
                    <button type="submit"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-platinum transition">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Error Message -->
        @if (isset($error))
            <div class="bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 rounded-lg">
                {{ $error }}
            </div>
        @endif

        <!-- Movies Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
            @forelse($movies as $movie)
                <a href="{{ route('movie.details', ['id' => $movie['id']]) }}"
                    class="bg-off-black rounded-lg overflow-hidden border border-ash hover:border-platinum transition cursor-pointer hover:shadow-lg hover:shadow-platinum/50 block">

                    <!-- Poster Image -->
                    <div class="w-full aspect-[2/3] flex items-center justify-center overflow-hidden">
                        @if ($movie['poster_url'] && $movie['poster_url'] != 'https://image.tmdb.org/t/p/w500')
                            <img src="{{ $movie['poster_url'] }}" alt="{{ $movie['title'] }}"
                                class="w-full h-full object-cover">
                        @else
                            <span class="text-cod-gray">No Image</span>
                        @endif
                    </div>

                    <!-- Movie Info -->
                    <div class="p-3 space-y-2">
                        <div>
                            <h3 class="text-lg font-bold text-platinum">{{ $movie['title'] }}</h3>
                            @if ($movie['original_title'] && $movie['original_title'] !== $movie['title'])
                                <p class="text-xs text-ash italic">{{ $movie['original_title'] }}</p>
                            @endif
                        </div>

                        <div class="space-y-2 text-sm text-platinum">
                            <div class="flex justify-between">
                                <span>Release Date :</span>
                                <span>{{ $movie['release_date'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Language :</span>
                                <span>{{ $movie['language'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Rate :</span>
                                <span>{{ number_format($movie['rating'], 1) }}</span>
                            </div>
                        </div>

                        <!-- Genre Tags -->
                        <div class="flex flex-wrap gap-2 pt-2">
                            @forelse($movie['genres'] as $genre)
                                <span
                                    class="bg-gray-700 text-platinum px-3 py-1 rounded-full text-xs font-medium">{{ $genre }}</span>
                            @empty
                                <span
                                    class="bg-gray-700 text-platinum px-3 py-1 rounded-full text-xs font-medium">N/A</span>
                            @endforelse
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-platinum text-lg">No movies found</p>
                    <p class="text-ash text-sm mt-2">Try adjusting your search terms</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if (count($movies) > 0)
            <div class="flex justify-center items-center gap-2 mt-8 mb-4">
                <!-- Previous Button -->
                @if ($currentPage > 1)
                    <a href="{{ route('gallery.index', ['search' => $search, 'page' => $currentPage - 1]) }}"
                        class="px-3 py-2 bg-ash text-platinum rounded hover:bg-platinum hover:text-off-black transition">
                        ← Previous
                    </a>
                @else
                    <button disabled class="px-3 py-2 bg-gray-700 text-gray-500 rounded cursor-not-allowed">
                        ← Previous
                    </button>
                @endif

                <!-- Page Numbers -->
                <div class="flex gap-1">
                    @php
                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($totalPages, $currentPage + 2);
                    @endphp

                    @if ($startPage > 1)
                        <a href="{{ route('gallery.index', ['search' => $search, 'page' => 1]) }}"
                            class="px-3 py-2 bg-off-black border border-ash text-platinum rounded hover:border-platinum transition">1</a>
                        @if ($startPage > 2)
                            <span class="px-2 py-2 text-platinum">...</span>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        @if ($i === $currentPage)
                            <button
                                class="px-3 py-2 bg-platinum text-off-black rounded font-bold">{{ $i }}</button>
                        @else
                            <a href="{{ route('gallery.index', ['search' => $search, 'page' => $i]) }}"
                                class="px-3 py-2 bg-off-black border border-ash text-platinum rounded hover:border-platinum transition">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($endPage < $totalPages)
                        @if ($endPage < $totalPages - 1)
                            <span class="px-2 py-2 text-platinum">...</span>
                        @endif
                        <a href="{{ route('gallery.index', ['search' => $search, 'page' => $totalPages]) }}"
                            class="px-3 py-2 bg-off-black border border-ash text-platinum rounded hover:border-platinum transition">{{ $totalPages }}</a>
                    @endif
                </div>

                <!-- Next Button -->
                @if ($currentPage < $totalPages)
                    <a href="{{ route('gallery.index', ['search' => $search, 'page' => $currentPage + 1]) }}"
                        class="px-3 py-2 bg-ash text-platinum rounded hover:bg-platinum hover:text-off-black transition">
                        Next →
                    </a>
                @else
                    <button disabled class="px-3 py-2 bg-gray-700 text-gray-500 rounded cursor-not-allowed">
                        Next →
                    </button>
                @endif
            </div>
            <p class="text-center text-ash text-sm">Page {{ $currentPage }} of {{ $totalPages }}</p>
        @endif
    </div>
@endsection
