@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Dashboard</h2>
                </div>
                <div class="card-body">
                    <p class="lead">Welcome, {{ Auth::user()->name }}!</p>
                    <p>Your dashboard content goes here.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
