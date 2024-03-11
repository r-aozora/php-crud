<?php

session_start();

require 'functions.php';

// Cek cookie
if (isset($_COOKIE["id"]) && isset($_COOKIE["key"])) {
    $id = $_COOKIE["id"];
    $key = $_COOKIE["key"];

    // Ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM users WHERE id = $id");
    $row = mysqli_fetch_object($result);

    // Cek cookie dan username
    if ($key === hash('sha256', $row->username)) {
        $_SESSION["login"] = true;
    }
}

// Cek session
if (isset($_SESSION["login"])) {
    header("Location: index.php");
}

if (isset($_POST["login"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $res = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    // Cek email
    if (mysqli_num_rows($res) === 1) {

        // Cek password
        $row = mysqli_fetch_object($res);

        if (password_verify($password, $row->password)) {

            // Set session
            $_SESSION["login"] = true;

            // Cek remember
            if (isset($_POST["remember"])) {
                // Buat cookie
                setcookie("id", $row->id, time() + 60);
                setcookie("key", hash('sha256', $row->email), time() + 60);
            }

            // Redirect ke index
            header("Location: index.php");
            exit;

        }
    }

    $error = true;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        label {
            display: block;
        }
    </style>
</head>
<body>

    <h1>Halaman Login</h1>

    <?php if (isset($error)): ?>
        <p style="color: red; font-style: italic;">Username atau password salah.</p>
    <?php endif ?>

    <form action="" method="POST">

        <ul>
            <li>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" autofocus autocomplete="off">
            </li>
            <li>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </li>
            <li>
                <label for="remember">
                    <input type="checkbox" name="remember" id="remember">
                    Remember me
                </label>
            </li>
            <li>
                <button type="submit" name="login">Login</button>
            </li>
        </ul>

    </form>

</body>
</html>