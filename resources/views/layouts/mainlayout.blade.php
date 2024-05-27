<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-xCnEjR0zqQll42OI74J9jJ6Mn0++w05PIs6+Zr0ju4GcwzH0tT+jSZJWH8oLR2lE" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/layouts.css') }}"> <!-- Ubah path untuk mengambil CSS dari asset -->
    @yield('css')
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <h1>Sociablesphere</h1>
        </div>
    </header>
    <!-- End Header -->

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fas fa-globe"></i></a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/home">
                            <i class="fas fa-user"></i>
                            <img src="/images/logohome.png" alt="Home" style="width: 30px; height: 30px;">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/search">
                            <i class="fas fa-user"></i>
                            <img src="/images/logo_search.png" alt="Search" style="width: 30px; height: 30px;">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-user"></i>
                            <img src="/images/friendlogo.png" alt="Messages" style="width: 30px; height: 30px;">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.show') }}">
                            <i class="fas fa-user"></i>
                            <img src="/images/logo_profile.png" alt="profile" style="width: 30px; height: 30px;">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha384-71EFe/OoU45Kz+lrpBiGiOzj9bE0xkgC+JuXpfh5un2kaRqK0TOC+Vd21ufDLh/x" crossorigin="anonymous"></script>
</body>
</html>
