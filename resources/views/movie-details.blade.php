@extends('layouts.app')

@section('title', 'Movie Details')

@section('content')
    <div class="py-8 px-6">
        @livewire('movie-details', ['movieId' => $movieId])
    </div>
@endsection