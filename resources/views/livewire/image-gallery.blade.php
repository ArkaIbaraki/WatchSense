<div>
    @if ($loading)
        <p class="text-platinum text-center py-12">Loading movies...</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse($movies as $movie)
                <div class="bg-off-black rounded-lg overflow-hidden border border-ash hover:border-platinum transition">
                    <!-- Poster Image -->
                    <div class="w-full aspect-square flex items-center justify-center overflow-hidden">
                        @if ($movie['poster_url'] && $movie['poster_url'] != 'https://image.tmdb.org/t/p/w500')
                            <img src="{{ $movie['poster_url'] }}" alt="{{ $movie['title'] }}"
                                class="w-full h-full object-cover">
                        @else
                            <span class="text-cod-gray">No Image</span>
                        @endif
                    </div>

                    <!-- Movie Info -->
                    <div class="p-4 space-y-3">
                        <h3 class="text-lg font-bold text-platinum">{{ $movie['title'] }}</h3>

                        <div class="space-y-2 text-sm text-platinum">
                            <div class="flex justify-between">
                                <span>Release Date :</span>
                                <span>{{ $movie['release_date'] }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Language :</span>
                                <span>English(EN)</span>
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
                </div>
            @empty
                <p class="text-platinum col-span-full text-center py-12">No movies found</p>
            @endforelse
        </div>
    @endif
</div>
