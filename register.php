<?php

require 'functions.php';

if (isset($_POST["register"])) {

    if (register($_POST) > 0) {
        echo "
            <script>
                alert('Registrasi berhasil!');
            </script>
        ";
    } else {
        echo mysqli_error($conn);
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <style>
        label {
            display: block;
        }
    </style>
</head>
<body>

    <h1>Halaman Registrasi</h1>

    <form action="" method="POST">

        <ul>
            <li>
                <label for="nama">Nama Lengkap: </label>
                <input type="nama" name="nama" id="nama" autofocus autocomplete="off">
            </li>
            <li>
                <label for="email">Email: </label>
                <input type="email" name="email" id="email">
            </li>
            <li>
                <label for="password">Password: </label>
                <input type="password" name="password" id="password">
            </li>
            <li>
                <label for="konfirmasi">Konfirmasi Password: </label>
                <input type="password" name="konfirmasi" id="konfirmasi">
            </li>
            <li>
                <button type="submit" name="register">Registrasi</button>
            </li>
        </ul>

    </form>

</body>
</html>