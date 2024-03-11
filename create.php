<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
}

require 'functions.php';

// Cek tombol submit
if (isset($_POST["submit"])) {
    // Cek berhasil
    if (store($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal ditambahkan.');
                document.location.href = 'create.php';
            </script>
        ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Buku</title>
    <style>
        label {
            display: block;
        }
    </style>
</head>
<body>

    <a href="index.php">Kembali</a>

    <h1>Tambah Data Buku</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="judul">Judul Buku: </label>
                <input type="text" name="judul" id="judul">
            </li>
            <li>
                <label for="penulis">Penulis: </label>
                <input type="text" name="penulis" id="penulis">
            </li>
            <li>
                <label for="penerbit">Penerbit: </label>
                <input type="text" name="penerbit" id="penerbit">
            </li>
            <li>
                <label for="kategori">Kategori: </label>
                <select name="kategori" id="kategori">
                    <option value="Light Novel">Light Novel</option>
                    <option value="Manga">Manga</option>
                    <option value="Novel">Novel</option>
                </select>
            </li>
            <li>
                <label for="gambar">Gambar: </label>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Tambah Data</button>
            </li>
        </ul>
    </form>

</body>
</html>