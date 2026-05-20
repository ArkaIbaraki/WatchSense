<div>
    @if ($loading)
        <p class="text-platinum text-center py-12">Loading movie details...</p>
    @elseif(!$movie)
        <p class="text-red-500 text-center py-12">Failed to load movie details.</p>
    @else
        <div class="space-y-10">

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('home') }}" class="inline-flex items-center text-platinum hover:text-ash transition">
                    <span class="mr-2">←</span>
                    <span>Back to Movies</span>
                </a>
            </div>

            <!-- Hero Section -->
            <div class="relative w-full h-[320px] md:h-[500px] overflow-hidden rounded-xl">

                <!-- Backdrop -->
                @if ($movie['backdrop_url'] && $movie['backdrop_url'] != 'https://image.tmdb.org/t/p/w1280')
                    <img src="{{ $movie['backdrop_url'] }}" alt="{{ $movie['title'] }}"
                        class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-off-black flex items-center justify-center">
                        <span class="text-cod-gray">No Backdrop</span>
                    </div>
                @endif

                <!-- Overlay -->
                <div class="absolute inset-0 bg-black/70"></div>

                <!-- Content -->
                <div class="absolute inset-0 flex items-end">
                    <div class="p-6 md:p-10 flex flex-col md:flex-row gap-8 w-full">

                        <!-- Poster -->
                        <div
                            class="w-44 md:w-60 aspect-[2/3] rounded-xl overflow-hidden border border-ash shrink-0 shadow-lg">

                            @if ($movie['poster_url'] && $movie['poster_url'] != 'https://image.tmdb.org/t/p/w500')
                                <img src="{{ $movie['poster_url'] }}" alt="{{ $movie['title'] }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-off-black flex items-center justify-center">
                                    <span class="text-cod-gray">No Image</span>
                                </div>
                            @endif

                        </div>

                        <!-- Movie Info -->
                        <div class="flex-1 text-platinum space-y-5">

                            <!-- Genres -->
                            <div class="flex flex-wrap gap-2">
                                @forelse($movie['genres'] as $genre)
                                    <span class="bg-zinc-800 border border-zinc-700 px-3 py-1 rounded-md text-xs">
                                        {{ $genre }}
                                    </span>
                                @empty
                                    <span class="bg-zinc-800 border border-zinc-700 px-3 py-1 rounded-md text-xs">
                                        N/A
                                    </span>
                                @endforelse
                            </div>

                            <!-- Title -->
                            <div>
                                <h1 class="text-3xl md:text-5xl font-bold leading-tight">
                                    {{ $movie['title'] }}
                                </h1>
                            </div>

                            <!-- Meta -->
                            <div class="flex flex-wrap gap-5 text-sm text-gray-300">
                                <span>{{ $movie['release_date'] }}</span>

                                <span>
                                    {{ floor($movie['runtime'] / 60) }}H
                                    {{ $movie['runtime'] % 60 }}M
                                </span>

                                <span>{{ $movie['language'] }}</span>
                            </div>

                            <!-- Overview -->
                            <p class="max-w-4xl text-gray-200 leading-relaxed text-sm md:text-base">
                                {{ $movie['overview'] }}
                            </p>

                            <!-- Rating -->
                            <div class="flex items-center gap-4 pt-2">

                                <div class="text-5xl font-bold text-cyan-400">
                                    {{ number_format($movie['rating'], 1) }}
                                </div>

                                <div class="text-sm text-gray-300">
                                    <p>Movie Rating</p>
                                    <p>{{ number_format($movie['vote_count']) }} Votes</p>
                                </div>

                            </div>

                            <!-- Like Button -->
                                <div class="pt-4">
                                    <button
                                        wire:click="toggleLike"
                                        class="px-5 py-2 rounded-lg border transition
                                        {{ $isLiked
                                            ? 'bg-red-500 border-red-500 text-white'
                                            : 'bg-zinc-800 border-zinc-700 text-platinum hover:border-red-500' }}">

                                        @if($isLiked)
                                            ❤️ Liked
                                        @else
                                            🤍 Like Movie
                                        @endif

                                    </button>
                                </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Status -->
            <div class="flex items-center gap-3">

                <span class="text-sm text-gray-400 font-medium">
                    Status
                </span>

                <span class="bg-zinc-800 border border-zinc-700 text-platinum text-xs px-3 py-1 rounded-full">
                    {{ $movie['status'] }}
                </span>

            </div>

            <!-- Crew Section -->
            @if (count($crew) > 0)
                <div class="space-y-4">
                    <h2 class="text-2xl font-bold text-platinum">Crew</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($crew as $member)
                            <div class="space-y-2">
                                <p class="text-platinum font-bold text-sm">{{ $member['name'] }}</p>
                                <p class="text-gray-400 text-xs">{{ $member['job'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Cast Section -->
            <div class="space-y-4">

                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-platinum">
                        Actors
                    </h2>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

                    @forelse ($cast as $actor)
                        <div
                            class="bg-off-black border border-ash rounded-lg overflow-hidden hover:border-platinum transition">

                            <!-- Actor Image -->
                            <div class="aspect-[2/3] overflow-hidden bg-zinc-900">

                                @if ($actor['profile_path'])
                                    <img src="{{ $actor['profile_path'] }}" alt="{{ $actor['name'] }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-cod-gray text-sm">No Image</span>
                                    </div>
                                @endif

                            </div>

                            <!-- Actor Info -->
                            <div class="p-3 space-y-1">

                                <h3 class="text-platinum font-semibold text-sm">
                                    {{ $actor['name'] }}
                                </h3>

                                <p class="text-gray-400 text-xs">
                                    {{ $actor['character'] }}
                                </p>

                            </div>

                        </div>

                    @empty

                        <p class="text-gray-400 col-span-full">
                            No cast available.
                        </p>
                    @endforelse

                </div>

            </div>

            <!-- Recommended Movies (Using Weighted Graph) -->
            <livewire:recommended-movies :filmId="$movieId" />

        </div>
    @endif
</div>
