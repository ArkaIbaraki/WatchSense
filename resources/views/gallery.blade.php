@extends('layouts.app')

@section('title', 'Movie Gallery')

@section('content')
    <div class="py-8 px-6 space-y-6">
        <!-- Search Bar Header -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <h1 class="text-3xl font-bold text-platinum">Movie List</h1>

            <!-- Search Form with Dropdown -->
            <div class="w-full md:w-96 relative" id="searchContainer">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Search movies..."
                        class="w-full px-4 py-2 bg-off-black border border-ash rounded-lg text-platinum placeholder-gray-500 focus:border-platinum focus:outline-none transition"
                        autocomplete="off">
                    <button type="button"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-platinum transition">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                <!-- Search Dropdown Preview -->
                <div id="searchDropdown"
                    class="absolute top-full left-0 right-0 mt-1 bg-off-black border border-ash rounded-lg shadow-lg z-50 hidden max-h-96 overflow-y-auto">
                    <div id="searchResults" class="divide-y divide-ash">
                        <!-- Results will be populated here -->
                    </div>
                    <div id="noResults" class="p-4 text-center text-ash hidden">
                        No movies found
                    </div>
                </div>
            </div>
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

    <script>
        const searchInput = document.getElementById('searchInput');
        const searchDropdown = document.getElementById('searchDropdown');
        const searchResults = document.getElementById('searchResults');
        const noResults = document.getElementById('noResults');

        let debounceTimer;
        const debounce = (func, delay) => {
            return function(...args) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => func(...args), delay);
            };
        };

        const performSearch = async (query) => {
            if (query.trim().length === 0) {
                searchDropdown.classList.add('hidden');
                return;
            }

            try {
                const response = await fetch(`{{ route('search.preview') }}?q=${encodeURIComponent(query)}`);
                const movies = await response.json();

                searchResults.innerHTML = '';

                if (movies.length === 0) {
                    searchDropdown.classList.remove('hidden');
                    noResults.classList.remove('hidden');
                    return;
                }

                noResults.classList.add('hidden');
                searchDropdown.classList.remove('hidden');

                movies.forEach(movie => {
                    const resultItem = document.createElement('a');
                    resultItem.href = `/movie/${movie.id}`;
                    resultItem.className =
                        'flex gap-3 p-3 hover:bg-gray-800 transition cursor-pointer block';
                    resultItem.innerHTML = `
                        <div class="flex-shrink-0 w-16 h-24">
                            ${movie.poster_url && movie.poster_url !== 'https://image.tmdb.org/t/p/w200' ?
                                `<img src="${movie.poster_url}" alt="${movie.title}" class="w-full h-full object-cover rounded">` :
                                `<div class="w-full h-full bg-gray-700 rounded flex items-center justify-center text-xs text-gray-500">No Image</div>`
                            }
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-platinum font-bold truncate">${movie.title}</h4>
                            <p class="text-ash text-xs">${movie.release_date}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-cyan-400 font-bold text-sm">${movie.rating.toFixed(1)}</span>
                                <span class="text-ash text-xs">${movie.language}</span>
                            </div>
                            <div class="flex flex-wrap gap-1 mt-2">
                                ${movie.genres.slice(0, 3).map(genre => `<span class="bg-gray-700 text-platinum px-2 py-0.5 rounded text-xs">${genre}</span>`).join('')}
                            </div>
                        </div>
                    `;
                    searchResults.appendChild(resultItem);
                });
            } catch (error) {
                console.error('Search error:', error);
            }
        };

        searchInput.addEventListener('input', debounce((e) => {
            performSearch(e.target.value);
        }, 300));

        // Handle Enter key - navigate to full search results
        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                const query = searchInput.value.trim();
                if (query.length > 0) {
                    window.location.href = `{{ route('gallery.index') }}?search=${encodeURIComponent(query)}`;
                }
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!document.getElementById('searchContainer').contains(e.target)) {
                searchDropdown.classList.add('hidden');
            }
        });

        // Show dropdown on focus if there's text
        searchInput.addEventListener('focus', () => {
            if (searchInput.value.trim().length > 0) {
                searchDropdown.classList.remove('hidden');
            }
        });
    </script>
@endsection
