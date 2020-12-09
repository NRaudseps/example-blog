@extends('layouts.app')
@section('content')
    <div class="container">
        <a href="{{ route('articles.index') }}" class="btn btn-primary btn-sm">
            Home
        </a>
        <form method="post" action="{{ route('user.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                       value="{{ $user->name }}">
            </div>
            <div class="form-group">
                <label for="cemail">Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                       value="{{ $user->email }}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>

@endsection
