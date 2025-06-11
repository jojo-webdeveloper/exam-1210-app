<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
</head>
<body>
    <h2>User Login</h2>

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="/login" method="POST">
        @csrf
        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email') }}"><br><br>
        
        <label>Password:</label><br>
        <input type="password" name="password"><br><br>
        
        <button type="submit">Login</button>        
    </form>
    <br><br>
    <a href="/logout" style="text-decoration: none; color: blue;">No Account? Register here!</a>
</body>
</html>