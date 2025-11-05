<?php
$server   = "localhost";
$user     = "root";
$password = "root";
$database = "prakwebdb";
$port     = 8889;

$connect = mysqli_connect($server, $user, $password, $database, $port);

if (!$connect) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
