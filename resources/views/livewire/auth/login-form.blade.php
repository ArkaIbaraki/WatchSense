<div class="bg-off-black rounded-lg shadow-md p-8 border border-off-black">
    <h1 class="text-3xl font-bold text-platinum mb-6 text-center">Login</h1>

    <form wire:submit="login" class="space-y-6">
        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-platinum">Email</label>
            <input type="email" id="email" wire:model="email"
                class="mt-1 w-full px-4 py-2 bg-cod-gray border border-ash text-platinum rounded-lg shadow-sm focus:ring-platinum focus:border-platinum placeholder-ash"
                placeholder="your@email.com" />
            @error('email')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-platinum">Password</label>
            <input type="password" id="password" wire:model="password"
                class="mt-1 w-full px-4 py-2 bg-cod-gray border border-ash text-platinum rounded-lg shadow-sm focus:ring-platinum focus:border-platinum placeholder-ash"
                placeholder="••••••••" />
            @error('password')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input type="checkbox" id="remember" wire:model="remember"
                class="h-4 w-4 bg-cod-gray border-ash rounded checked:bg-platinum" />
            <label for="remember" class="ml-2 block text-sm text-platinum">Remember me</label>
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full bg-platinum text-cod-gray py-2 px-4 rounded-lg hover:bg-ash transition font-medium">
            Sign In
        </button>
    </form>

    <!-- Register Link -->
    <p class="mt-6 text-center text-ash">
        Don't have an account?
        <a href="/register" class="text-platinum hover:text-ash font-medium">Create one</a>
    </p>
</div>
