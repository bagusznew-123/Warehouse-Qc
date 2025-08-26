<?php
session_start();
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Pastikan input tidak kosong
    if (empty($_POST['username']) || empty($_POST['password'])) {
        echo "<script>alert('Username dan Password harus diisi!');
              window.location='index.php';</script>";
        exit;
    }

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Gunakan prepared statement untuk keamanan
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM tblogin WHERE User = ? AND Password = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        // Login berhasil
        $_SESSION['username'] = $data['User'];
        header("Location: ../crud_2025/indexmenu.php");
        exit;
    } else {
        // Login gagal
        echo "<script>alert('Username atau Password salah!');
              window.location='index.php';</script>";
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}

?>
