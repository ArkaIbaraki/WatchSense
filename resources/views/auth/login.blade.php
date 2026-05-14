@extends('layouts.guest-auth')

@section('title', 'Login')

@section('content')
    <div class="flex h-screen">
        <!-- Right Side - Image -->
        <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-8">
            <div class="w-full h-full rounded-2xl overflow-hidden">
                <img src="{{ asset('auth-images/login-image.jpg') }}" alt="WatchSense" class="w-full h-full object-cover">
            </div>
        </div>

        <!-- Left Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12">
            <div class="w-full max-w-md space-y-8">
                <!-- Header -->
                <div class="space-y-2">
                    <p class="text-platinum text-sm">WatchSense</p>
                    <h1 class="text-4xl font-bold text-platinum">Masuk ke WatchSense</h1>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="text-platinum text-sm font-medium">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 bg-off-black border border-ash rounded-lg text-platinum placeholder-gray-600 focus:border-platinum focus:outline-none transition
                        @error('email') border-red-500 @enderror"
                            placeholder="email@example.com">
                        @error('email')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="text-platinum text-sm font-medium">Kata Sandi</label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 bg-off-black border border-ash rounded-lg text-platinum placeholder-gray-600 focus:border-platinum focus:outline-none transition
                        @error('password') border-red-500 @enderror"
                            placeholder="••••••••">
                        @error('password')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                            class="w-4 h-4 rounded border-ash bg-off-black cursor-pointer">
                        <label for="remember" class="ml-2 text-platinum text-sm">Ingat saya</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full px-4 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg transition">
                        Masuk
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-ash"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-cod-gray text-ash">Atau</span>
                    </div>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-ash text-sm">Tidak punya akun? <a href="{{ route('register') }}"
                            class="text-teal-500 hover:text-teal-400 font-semibold transition">Daftar</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
