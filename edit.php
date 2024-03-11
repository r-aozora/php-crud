<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
}

require 'functions.php';

// Ambil data dari url
$id = $_GET["id"];

// Query data buku berdasarkan id
$data = query("SELECT * FROM buku WHERE id = $id")[0];

// Cek tombol submit
if (isset($_POST["submit"])) {
    // Cek berhasil
    if (update($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil diedit!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal diedit.');
                document.location.href = 'edit.php';
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
    <title>Edit Data Buku</title>
    <style>
        label {
            display: block;
        }
    </style>
</head>
<body>

    <a href="index.php">Kembali</a>

    <h1>Edit Data Buku</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data->id ?>">
        <input type="hidden" name="oldGambar" value="<?= $data->gambar ?>">
        <ul>
            <li>
                <label for="judul">Judul Buku: </label>
                <input type="text" name="judul" id="judul" value="<?= $data->judul ?>">
            </li>
            <li>
                <label for="penulis">Penulis: </label>
                <input type="text" name="penulis" id="penulis" value="<?= $data->penulis ?>">
            </li>
            <li>
                <label for="penerbit">Penerbit: </label>
                <input type="text" name="penerbit" id="penerbit" value="<?= $data->penerbit ?>">
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
                <img src="images/<?= $data->gambar; ?>" alt="<?= $data->judul ?>" width="100"><br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Edit Data</button>
            </li>
        </ul>
    </form>

</body>
</html>