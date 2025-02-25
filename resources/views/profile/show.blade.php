@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h2>Welcome to User Profile</h2>
            @if($profile && $profile->user)
                <h2>{{ $profile->user->name }}</h2>
                <img src="{{ asset('storage/' . $profile->profile_picture) }}" alt="Profile Picture" class="img-thumbnail" width="150">
                <p><strong>Email:</strong> {{ $profile->user->email }}</p>
                <p><strong>Contact:</strong> {{ $profile->contact_number }}</p>
                <p><strong>Bio:</strong> {{ $profile->bio }}</p>
            @else
                <p>Profile not found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
