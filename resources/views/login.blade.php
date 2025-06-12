@extends('layouts.app')

@section('content')
    <div class="login-container">
        <form method="POST" action="/login" class="login-form">
            @csrf
            <h2>Task Management Login</h2>

            @if(session('error'))
                <div class="alert">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <ul class="alert">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn-login-register">Login</button>

            <p class="helper">
                No Account?
                <a href="/register">Register here!</a>
            </p>
        </form>
    </div>
@endsection