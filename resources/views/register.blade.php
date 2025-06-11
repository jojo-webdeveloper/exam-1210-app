<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>

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

    <form action="/register" method="POST">
        @csrf
        <label>Name:</label><br>
        <input type="text" name="name" value="{{ old('name') }}"><br><br>
        
        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email') }}"><br><br>
        
        <label>Password:</label><br>
        <input type="password" name="password"><br><br>
        
        <label>Confirm Password:</label><br>
        <input type="password" name="password_confirmation"><br><br>
        
        <button type="submit">Registration</button>        
    </form>
</body>
</html>