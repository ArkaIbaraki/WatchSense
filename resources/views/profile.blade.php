@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-off-black overflow-hidden shadow-sm sm:rounded-lg border border-off-black">
            <div class="px-4 py-6 bg-off-black border-b border-off-black">
                <h2 class="text-2xl font-bold text-platinum">My Profile</h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="bg-ash rounded-lg p-6 border border-off-black">
                    <h3 class="text-lg font-semibold text-platinum mb-4">Account Information</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-cod-gray">Full Name</p>
                            <p class="text-lg font-medium text-platinum">{{ Auth::user()->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-cod-gray">Email Address</p>
                            <p class="text-lg font-medium text-platinum">{{ Auth::user()->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-cod-gray">Member Since</p>
                            <p class="text-lg font-medium text-platinum">{{ Auth::user()->created_at->format('M d, Y') }}</p>
                        </div>
                        @if(Auth::user()->is_admin)
                            <div class="pt-4">
                                <span class="inline-block bg-platinum text-cod-gray px-3 py-1 rounded-full text-sm font-semibold">
                                    Administrator
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                @if(Auth::user()->is_admin)
                    <div class="bg-ash rounded-lg p-6 border border-off-black">
                        <h3 class="text-lg font-semibold text-platinum mb-4">Admin Statistics</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-cod-gray">Total Users</p>
                                <p class="text-3xl font-bold text-platinum">{{ \App\Models\User::count() }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-cod-gray">Total Admins</p>
                                <p class="text-3xl font-bold text-platinum">{{ \App\Models\User::where('is_admin', true)->count() }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
