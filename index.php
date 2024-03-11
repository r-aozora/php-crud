<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
}

require 'functions.php';

// Pagination
// Konfigurasi
$perPage = 5;
$dataCount = count(query("SELECT * FROM buku"));
$pageCount = ceil($dataCount / $perPage);
$page = (isset($_GET["page"])) ? $_GET["page"] : 1;
$firstData = ($perPage * $page) - $perPage;

$data = query("SELECT * FROM buku ORDER BY judul LIMIT $firstData, $perPage");

// Cek tombol cari
if (isset($_POST["search"])) {
    $data = search($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <style>
        .loading {
            width: 20px;
            position: absolute;
            z-index: -1;
            margin-left: 10px;
            display: none;
        }
    </style>
</head>
<body>

    <a href="logout.php">Logout</a>

    <h1>Daftar Buku</h1>

    <a href="create.php">Tambah Data Buku</a>
    <br><br>
    
    <!-- Search -->
    <p>Search: </p>
    <form action="" method="POST">

        <input type="text" name="keyword" size="40" autofocus placeholder="Cari buku..." autocomplete="off">
        <button type="submit" name="search">Cari</button>

    </form>

    <p>Live search: </p>
    <form action="" method="POST">

        <input type="text" name="keyword" id="keyword-ajax" size="40" placeholder="Cari buku..." autocomplete="off">
        <button type="submit" name="search" id="search-button-ajax">Cari</button>

    </form>

    <p>Live search dengan JQuery: </p>
    <form action="" method="POST">

        <input type="text" name="keyword" id="keyword-jquery" size="40" placeholder="Cari buku..." autocomplete="off">
        <button type="submit" name="search" id="search-button-jquery">Cari</button>

        <img src="images/loading.gif" class="loading">

    </form>
    <br>

    <div id="container">

        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>No.</td>
                <th>Gambar</td>
                <th>Judul</td>
                <th>Penulis</td>
                <th>Penerbit</td>
                <th>Kategori</td>
                <th>Aksi</td>
            </tr>
    
            <?php $i = 1; ?>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td>
                        <img src="images/<?= $row->gambar; ?>" alt="<?= $row->judul ?>" width="100">
                    </td>
                    <td><?= $row->judul ?></td>
                    <td><?= $row->penulis ?></td>
                    <td><?= $row->penerbit ?></td>
                    <td><?= $row->kategori ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row->id ?>">Edit</a> | 
                        <a href="destroy.php?id=<?= $row->id ?>" onclick="return confirm('Yakin?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach ?>
    
        </table>

    </div>

    <br>

    <!-- Paginasi -->
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1; ?>">&laquo;</a>
    <?php endif ?>

    <?php for ($i = 1; $i <= $pageCount; $i++): ?>
        <?php if ($i == $page): ?>
            <a href="?page=<?= $i; ?>" style="font-weight: bold; color: green;"><?= $i; ?></a>
        <?php else: ?>
            <a href="?page=<?= $i; ?>"><?= $i; ?></a>
        <?php endif ?>
    <?php endfor ?>

    <?php if ($page < $pageCount): ?>
        <a href="?page=<?= $page + 1; ?>">&raquo;</a>
    <?php endif ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/script-ajax.js"></script>
    <script src="js/script-jquery.js"></script>

</body>
</html>