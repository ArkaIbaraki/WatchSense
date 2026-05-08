@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-4 py-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
                <p class="mt-2 text-gray-600">Welcome back, {{ Auth::user()->name }}!</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-ash rounded-lg p-6 border border-off-black">
                        <h3 class="text-lg font-semibold text-platinum">Total Users</h3>
                        <p class="text-3xl font-bold text-platinum mt-2">{{ \App\Models\User::count() }}</p>
                    </div>
                    
                    <div class="bg-ash rounded-lg p-6 border border-off-black">
                        <h3 class="text-lg font-semibold text-platinum">Your Email</h3>
                        <p class="text-sm text-cod-gray mt-2">{{ Auth::user()->email }}</p>
                    </div>
                    
                    <div class="bg-ash rounded-lg p-6 border border-off-black">
                        <h3 class="text-lg font-semibold text-platinum">Member Since</h3>
                        <p class="text-sm text-cod-gray mt-2">{{ Auth::user()->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
