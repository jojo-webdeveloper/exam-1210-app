@extends('layouts.app')

@section('content')
    <div class="login-container">
        <form method="POST" action="/register" class="login-form">
            @csrf
            <h2>Task Management Registration</h2>

            @if(session('error'))
                <div class="alert">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <ul class="alert">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn-login-register">Register</button>

            <p class="helper">
                Already have an account?
                <a href="/login">Login here!</a>
            </p>
        </form>
    </div>
@endsection