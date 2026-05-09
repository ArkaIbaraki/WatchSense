<div class="bg-off-black rounded-lg shadow-md p-8 border border-off-black">
    <h1 class="text-3xl font-bold text-platinum mb-6 text-center">Create Account</h1>

    <form wire:submit="register" class="space-y-6">
        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-platinum">Full Name</label>
            <input type="text" id="name" wire:model="name"
                class="mt-1 w-full px-4 py-2 bg-cod-gray border border-ash text-platinum rounded-lg shadow-sm focus:ring-platinum focus:border-platinum placeholder-ash"
                placeholder="John Doe" />
            @error('name')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

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

        <!-- Password Confirmation -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-platinum">Confirm Password</label>
            <input type="password" id="password_confirmation" wire:model="password_confirmation"
                class="mt-1 w-full px-4 py-2 bg-cod-gray border border-ash text-platinum rounded-lg shadow-sm focus:ring-platinum focus:border-platinum placeholder-ash"
                placeholder="••••••••" />
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full bg-platinum text-cod-gray py-2 px-4 rounded-lg hover:bg-ash transition font-medium">
            Create Account
        </button>
    </form>

    <!-- Login Link -->
    <p class="mt-6 text-center text-ash">
        Already have an account?
        <a href="/login" class="text-platinum hover:text-ash font-medium">Sign in</a>
    </p>
</div>
