<?php
// koneksi.php
// Membuka koneksi ke database MySQL. Dipanggil dengan require oleh halaman lain.

$host     = 'localhost';
$user     = 'root';      // bawaan XAMPP
$password = '';          // bawaan XAMPP: kosong
$database = 'todo_db';

// Matikan exception otomatis mysqli agar pesan kesalahan bisa kita atur sendiri.
mysqli_report(MYSQLI_REPORT_OFF);

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}

mysqli_set_charset($koneksi, 'utf8mb4');
