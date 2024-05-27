@extends('layouts.mainlayout')

@section('title', 'Search')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="search-form">
        <form action="{{ route('search.users') }}" method="GET">
            <input type="text" name="query" placeholder="Search users...">
            <button type="submit">
                <img src="{{ asset('images/search-removebg.png') }}" alt="Search Icon">
            </button>
        </form>
    </div>
    <div class="search-results">
        <h1>Search Results for "{{ $query }}"</h1>

        @if($users->isEmpty())
            <p class="no-results">No results found.</p>
        @else
            <ul class="user-list">
                @foreach($users as $user)
                    <li><a href="{{ route('profile', ['userId' => $user->id]) }}">{{ $user->name }}</a></li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
