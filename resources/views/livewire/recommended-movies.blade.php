<div>
    @if ($loading)
        <p class="text-platinum text-center py-8">Loading recommendations...</p>
    @elseif(count($recommendedMovies) > 0)
        <div class="space-y-6">
            <!-- Section Header -->
            <div>
                <h2 class="text-2xl font-bold text-platinum mb-4">
                    Recommended For You
                </h2>
                <p class="text-ash text-sm mb-6">
                    Based on your viewing history and preferences
                </p>
            </div>

            <!-- Recommended Movies Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3">
                @foreach ($recommendedMovies as $movie)
                    <a href="{{ route('movie.details', ['id' => $movie['id']]) }}"
                        class="group relative aspect-[2/3] rounded-lg overflow-hidden border border-ash hover:border-platinum transition cursor-pointer hover:shadow-lg hover:shadow-platinum/50">

                        <!-- Poster Image -->
                        <div class="w-full h-full bg-off-black flex items-center justify-center">
                            <img src="{{ $movie['poster_url'] }}" alt="{{ $movie['judul'] }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                        </div>

                        <!-- Hover Overlay -->
                        <div
                            class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-3">
                            <h3 class="text-platinum font-bold text-sm leading-tight mb-2">
                                {{ $movie['judul'] }}
                            </h3>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-ash">{{ $movie['tahun_rilis'] }}</span>
                                <span class="text-cyan-400 font-bold">
                                    ⭐ {{ number_format($movie['rating'], 1) }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-ash text-center py-8">
            No recommendations available yet. Start liking movies to get personalized recommendations!
        </p>
    @endif
</div>
