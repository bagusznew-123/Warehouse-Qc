<?php
$server = "localhost";
$user   = "root";   // sesuaikan
$pass   = "";       // sesuaikan
$db     = "dbcrud2025"; // sesuaikan nama database

$koneksi = mysqli_connect($server, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

