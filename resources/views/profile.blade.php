<!-- Blade Template -->
@extends('layouts.mainlayout')

@section('title', 'Profile')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="container profile-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="profile-header text-center mb-4">
                    <div class="profile-image mb-3">
                        @if ($user->profile && $user->profile->image)
                            <img src="{{ asset('storage/' . $user->profile->image) }}" alt="Profile Image" class="rounded-circle">
                        @else
                            <img src="{{ asset('images/siluet.jpeg') }}" alt="Default Profile Image" class="rounded-circle">
                        @endif
                    </div>
                    <h2 class="mb-2">{{ $user->name }}</h2>
                </div>
                <div class="profile-bio text-center mb-4">
                    <p>{{ $user->profile ? $user->profile->bio : 'No bio available' }}</p>
                </div>

                <div class="profile-content">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea id="bio" class="form-control" name="bio" rows="3">{{ $user->profile ? $user->profile->bio : '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Change Profile Image</label>
                            <input id="image" type="file" class="form-control" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>

                @if(session('success'))
                    <div class="alert alert-success mt-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
