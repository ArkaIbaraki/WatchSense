@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="py-12 px-6">
        @livewire('image-gallery')
    </div>
@endsection
