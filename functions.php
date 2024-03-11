<?php

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "php_crud");

// Get data (Index)
function query($query)
{
    global $conn;

    $res = mysqli_query($conn, $query);
    $rows = [];

    while ($row = mysqli_fetch_object($res)) {
        $rows[] = $row;
    }

    return $rows;
}

// Insert data (Create)
function store($data)
{
    global $conn;

    // Terima data dari form
    $judul = htmlspecialchars($data["judul"]);
    $penulis = htmlspecialchars($data["penulis"]);
    $penerbit = htmlspecialchars($data["penerbit"]);
    $kategori = htmlspecialchars($data["kategori"]);

    // Upload gambar
    $gambar = upload();

    if (!$gambar) {
        return false;
    }

    // Query insert data
    $query = "INSERT INTO buku VALUES ('', '$judul', '$penulis', '$penerbit', '$kategori', '$gambar')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// Upload gambar
function upload()
{
    $image = [
        'file' => $_FILES["gambar"]["name"],
        'size' => $_FILES["gambar"]["size"],
        'error' => $_FILES["gambar"]["error"],
        'tmp' => $_FILES["gambar"]["tmp_name"],
    ];

    // Cek apakah tidak ada gambar yang diupload
    if ($image["error"] === 4) {
        echo "
            <script>
                alert('Gambar harus diisi.');
            </script>
        ";

        return false;
    }

    // Cek apakah yang diupload adalah gambar
    $ekstensiValid = ['jpg', 'jpeg', 'png'];
    $ekstensi = explode('.', $image["file"]);
    $ekstensi = strtolower(end($ekstensi));

    if (!in_array($ekstensi, $ekstensiValid)) {
        echo "
            <script>
                alert('Gambar tidak valid.');
            </script>
        ";

        return false;
    }

    // Cek jika ukuran terlalu besar (1MB)
    if ($image["size"] > 1000000) {
        echo "
            <script>
                alert('Ukuran gambar terlalu besar.');
            </script>
        ";

        return false;
    }

    // Lolos pengecekan, gambar siap di upload
    // Buat nama file batu
    $file = uniqid() . '.' . $ekstensi;

    move_uploaded_file($image["tmp"], 'storage/images/' . $file);

    return $file;
}

// Hapus data (Destroy)
function destroy($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM buku WHERE id = $id");

    return mysqli_affected_rows($conn);
}

// Update data (Update)
function update($data)
{
    global $conn;

    // Terima data dari form
    $id = $data["id"];
    $judul = htmlspecialchars($data["judul"]);
    $penulis = htmlspecialchars($data["penulis"]);
    $penerbit = htmlspecialchars($data["penerbit"]);
    $kategori = htmlspecialchars($data["kategori"]);
    $oldGambar = htmlspecialchars($data["oldGambar"]);

    // Cek apakah user pilih gamba baru
    if ($_FILES["gambar"]["error"] === 4) {
        $gambar = $oldGambar;
    } else {
        $gambar = upload();
    }

    // Query update data
    $query = "UPDATE buku SET 
            judul = '$judul', 
            penulis = '$penulis', 
            penerbit = '$penerbit', 
            kategori = '$kategori', 
            gambar = '$gambar'
        WHERE id = $id
    ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// Search data
function search($keyword)
{
    $query = "SELECT * FROM buku WHERE
        judul LIKE '%$keyword%' OR 
        penulis LIKE '%$keyword%' OR 
        penerbit LIKE '%$keyword%' OR 
        kategori LIKE '%$keyword%'
    ";

    return query($query);
}

// Registrasi
function register($data)
{
    global $conn;

    $nama = strtolower(stripcslashes($data["nama"]));
    $email = stripcslashes($data["email"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $konfirmasi = mysqli_real_escape_string($conn, $data["konfirmasi"]);

    // Cek email sudah ada atau belum
    $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");

    if (mysqli_fetch_object($res)) {
        echo "
            <script>
                alert('Email sudah terdaftar.');
            </script>
        ";

        return false;
    }

    // Cek konfirmasi password
    if ($password !== $konfirmasi) {
        echo "
            <script>
                alert('Konfirmasi passsword tidak sesuai.');
            </script>
        ";

        return false;
    }

    // Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Tambah user baru ke database
    mysqli_query($conn, "INSERT INTO users VALUES ('', '$nama', '$email', '$password')");

    return mysqli_affected_rows($conn);
}