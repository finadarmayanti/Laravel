<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="register-box">
        <h2>Register</h2>
        <form action="{{ route('register.proses') }}" method="POST">
            @csrf
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
            <br>
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            @error('password_confirmation')
                <div class="error-message">{{ $message }}</div>
            @enderror
            <br><br>
            <input type="submit" value="Register">
        </form>
        <div class="footer">
            Already have an account? <a href="{{ route('login') }}">Login here</a>
        </div>
    </div>

</body>
</html>
