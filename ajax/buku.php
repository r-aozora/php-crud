<?php

require '../functions.php';

$data = search($_GET["keyword"]);

?>

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