<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Peminjaman Fasilitas Fakultas</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="/css/auth.css">
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="img/images.png" alt="Logo">
        </div>
        <div class="title">
            <h2>SISTEM INFORMASI PEMINJAMAN FASILITAS FAKULTAS</h2>
            <h3>UIN SUNAN GUNUNG DJATI BANDUNG</h3>
        </div>

        @yield('content')

    </div>
</body>

</html>
