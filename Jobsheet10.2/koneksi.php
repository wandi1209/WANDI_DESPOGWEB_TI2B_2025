<?php
// Koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "root", "prakwebdb");

// Periksa koneksi
if (mysqli_connect_errno()) {
    die("Kondisi database gagal: " . mysqli_connect_error());
}
?>