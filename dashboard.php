<?php
// dashboard.php
// Halaman utama setelah login: ringkasan jumlah task milik user yang sedang login.

$base = '';
require 'cek_login.php';   // wajib paling atas: blokir yang belum login
require 'koneksi.php';

$judul      = 'Dashboard';
$mode       = 'app';
$menu_aktif = 'dashboard';

// Hitung task milik user ini saja (WHERE user_id = ?). COALESCE: jika belum ada task, hasilnya 0 bukan kosong.
$user_id = (int) $_SESSION['user_id'];
$stmt = mysqli_prepare($koneksi,
    "SELECT COUNT(*) AS total,
            COALESCE(SUM(status = 'selesai'), 0) AS selesai,
            COALESCE(SUM(status = 'belum'), 0)   AS belum
     FROM tasks WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$ringkasan = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

require 'includes/header.php';
?>

<h1 class="mt-4">Dashboard</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Halo, <?= e($_SESSION['user_nama']) ?>!</li>
</ol>

<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <div class="card-angka"><?= (int) $ringkasan['total'] ?></div>
                Total Task
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="tugas/index.php">Lihat semua</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">
                <div class="card-angka"><?= (int) $ringkasan['belum'] ?></div>
                Belum Selesai
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="tugas/index.php">Lihat daftar</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                <div class="card-angka"><?= (int) $ringkasan['selesai'] ?></div>
                Selesai
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="tugas/index.php">Lihat daftar</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
