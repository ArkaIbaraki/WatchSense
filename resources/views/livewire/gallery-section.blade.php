<div>
    <!-- Header with Movie List and Search -->
    <div class="pt-6 px-6 pb-2 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-platinum">Movie List</h1>
        <input type="text" wire:model.live="search" placeholder="Search movies..."
            class="w-64 px-4 py-2 bg-off-black border border-ash rounded-lg text-platinum placeholder-ash focus:outline-none focus:border-platinum">
    </div>

    <div class="py-6 px-6">
        @livewire('image-gallery', ['search' => $search], key('gallery-' . $search))
    </div>
</div>
