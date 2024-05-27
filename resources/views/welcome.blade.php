<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Sociablesphere</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/welcome.css">
</head>
<body>
    <div class="container">
        <!-- <img src="images/logo.png" alt="Sociablesphere Logo" width="250"> -->
        <div class="content">
            <h2>Welcome to Sociablesphere</h2>
            <p>Website Sociablesphere dimana anda dapat terhubung dengan teman-teman lama, menjelajahi minat bersama & menciptakan momen-momen berharga dalam hidup Anda.</p>
            <div class="button-container">
            <a href="{{ route('login') }}" class="button" style="width: 300px;">Login</a>
                <a href="{{ route('register') }}" class="button" style="width: 300px;">Register</a>
            </div>
        </div>
    </div>
</body>
</html>
