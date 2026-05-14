@extends('layouts.guest-auth')

@section('title', 'Register')

@section('content')
    <div class="flex h-screen">
        <!-- Left Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12">
            <div class="w-full max-w-md space-y-8">
                <!-- Header -->
                <div class="space-y-2">
                    <p class="text-platinum text-sm">WatchSense</p>
                    <h1 class="text-4xl font-bold text-platinum">Daftar Akun</h1>
                </div>
                
                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="text-platinum text-sm font-medium">Nama</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 bg-off-black border border-ash rounded-lg text-platinum placeholder-gray-600 focus:border-platinum focus:outline-none transition
                        @error('name') border-red-500 @enderror"
                            placeholder="email@example.com">
                        @error('name')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

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

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-platinum text-sm font-medium">Konfirmasi Kata
                            Sandi</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full px-4 py-3 bg-off-black border border-ash rounded-lg text-platinum placeholder-gray-600 focus:border-platinum focus:outline-none transition"
                            placeholder="••••••••">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full px-4 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg transition mt-6">
                        Daftar
                    </button>
                </form>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-ash text-sm">Sudah punya akun? <a href="{{ route('login') }}"
                            class="text-teal-500 hover:text-teal-400 font-semibold transition">Masuk</a></p>
                </div>
            </div>
        </div>

        <!-- Right Side - Image -->
        <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-8">
            <div class="w-full h-full rounded-2xl overflow-hidden">
                <img src="{{ asset('auth-images/register-image.jpg') }}" alt="WatchSense"
                    class="w-full h-full object-cover">
            </div>
        </div>
    </div>
@endsection
