<?php
// includes/header.php
// Kepala halaman. Ada tiga tampilan, dipilih lewat $mode:
//   'auth'   : halaman login/register (kartu di tengah, latar biru)
//   'publik' : halaman umum seperti beranda dan tentang (navbar atas)
//   'app'    : halaman setelah login (navbar atas + sidebar kiri)
//
// Variabel yang dibaca (diisi halaman pemanggil SEBELUM require berkas ini):
//   $base         '' untuk halaman di folder utama, '../' untuk halaman di tugas/
//   $judul        judul tab browser
//   $mode         'auth' | 'publik' | 'app'
//   $menu_aktif   nama menu yang sedang dibuka (untuk menandai menu)

require_once __DIR__ . '/fungsi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($base))       { $base = ''; }
if (!isset($judul))      { $judul = NAMA_APP; }
if (!isset($mode))       { $mode = 'publik'; }
if (!isset($menu_aktif)) { $menu_aktif = ''; }

$sudah_login = isset($_SESSION['user_id']);

if ($mode === 'app') {
    $kelas_body = 'sb-nav-fixed';
} elseif ($mode === 'auth') {
    $kelas_body = 'bg-primary';
} else {
    $kelas_body = 'd-flex flex-column min-vh-100';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?= e($judul) ?> | <?= e(NAMA_APP) ?></title>
    <!-- CSS template SB Admin (sudah termasuk Bootstrap 5.2.3) -->
    <link href="<?= $base ?>assets/sb-admin/styles.css" rel="stylesheet" />
    <!-- CSS tambahan buatan kelompok -->
    <link href="<?= $base ?>assets/style.css" rel="stylesheet" />
    <!-- Ikon Font Awesome (butuh internet) -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="<?= $kelas_body ?>">

<?php if ($mode === 'app'): ?>
    <!-- Navbar atas -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="<?= $base ?>dashboard.php"><?= e(NAMA_APP) ?></a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" type="button" aria-label="Buka/tutup menu">
            <i class="fas fa-bars"></i>
        </button>
        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="menuUser" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i> <?= e($_SESSION['user_nama'] ?? '') ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuUser">
                    <li><a class="dropdown-item" href="<?= $base ?>logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <!-- Sidebar kiri -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link<?= aktif('dashboard', $menu_aktif) ?>" href="<?= $base ?>dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link<?= aktif('tugas', $menu_aktif) ?>" href="<?= $base ?>tugas/index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-list-check"></i></div>
                            Daftar Task
                        </a>
                        <a class="nav-link<?= aktif('tambah', $menu_aktif) ?>" href="<?= $base ?>tugas/tambah.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-plus"></i></div>
                            Tambah Task
                        </a>
                        <div class="sb-sidenav-menu-heading">Akun</div>
                        <a class="nav-link" href="<?= $base ?>logout.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-right-from-bracket"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Masuk sebagai:</div>
                    <?= e($_SESSION['user_nama'] ?? '') ?>
                </div>
            </nav>
        </div>

        <!-- Isi halaman -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">

<?php elseif ($mode === 'auth'): ?>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>

<?php else: ?>
    <!-- Navbar halaman publik -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= $base ?>index.php"><i class="fas fa-check-double me-2"></i><?= e(NAMA_APP) ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPublik"
                    aria-controls="menuPublik" aria-expanded="false" aria-label="Buka menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuPublik">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link<?= aktif('beranda', $menu_aktif) ?>" href="<?= $base ?>index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link<?= aktif('tentang', $menu_aktif) ?>" href="<?= $base ?>about.php">Tentang</a></li>
                    <?php if ($sudah_login): ?>
                        <li class="nav-item"><a class="btn btn-primary btn-sm ms-lg-2" href="<?= $base ?>dashboard.php">Dashboard</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?= $base ?>login.php">Login</a></li>
                        <li class="nav-item"><a class="btn btn-primary btn-sm ms-lg-2" href="<?= $base ?>register.php">Daftar</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <main class="flex-grow-1">

<?php endif; ?>
