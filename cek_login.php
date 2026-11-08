<?php
// cek_login.php
// Penjaga halaman: dipanggil di bagian paling atas setiap halaman yang wajib login.
// Halaman di dalam folder tugas/ mengisi $base = '../' sebelum require berkas ini.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kalau tidak ada user_id di session, berarti belum login: kembalikan ke halaman login.
if (!isset($_SESSION['user_id'])) {
    $tujuan = isset($base) ? $base : '';
    header('Location: ' . $tujuan . 'login.php');
    exit;
}
