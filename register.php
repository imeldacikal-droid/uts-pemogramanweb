<?php
// register.php
// Daftar akun baru. GET menampilkan form, POST memvalidasi lalu INSERT ke tabel users.

session_start();
require 'koneksi.php';

// Yang sudah login tidak perlu mendaftar lagi.
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$base     = '';
$judul    = 'Daftar Akun';
$mode     = 'auth';
$errors   = [];
$nama     = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama       = trim($_POST['nama'] ?? '');
    $username   = trim($_POST['username'] ?? '');
    $password   = $_POST['password'] ?? '';
    $konfirmasi = $_POST['konfirmasi'] ?? '';

    // 1. Validasi isian
    if ($nama === '' || mb_strlen($nama) > 100) {
        $errors[] = 'Nama wajib diisi (maksimal 100 karakter).';
    }
    if (!preg_match('/^[A-Za-z0-9_]{3,50}$/', $username)) {
        $errors[] = 'Username 3-50 karakter, hanya huruf, angka, dan underscore.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password minimal 6 karakter.';
    }
    if ($password !== $konfirmasi) {
        $errors[] = 'Konfirmasi password tidak sama.';
    }

    // 2. Cek username belum dipakai (prepared statement)
    if (empty($errors)) {
        $stmt = mysqli_prepare($koneksi, 'SELECT id FROM users WHERE username = ?');
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $sudah_ada = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        mysqli_stmt_close($stmt);

        if ($sudah_ada) {
            $errors[] = 'Username sudah dipakai, pilih yang lain.';
        }
    }

    // 3. Simpan. Password disimpan sebagai hash, bukan teks asli.
    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($koneksi, 'INSERT INTO users (nama, username, password) VALUES (?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'sss', $nama, $username, $hash);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header('Location: login.php?pesan=daftar');
            exit;
        }
        mysqli_stmt_close($stmt);
        $errors[] = 'Gagal menyimpan ke database. Coba lagi.';
    }
}

require 'includes/header.php';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Buat Akun</h3></div>
                <div class="card-body">

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $pesan): ?>
                                    <li><?= e($pesan) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="register.php">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="nama" name="nama" type="text" placeholder="Nama lengkap"
                                   value="<?= e($nama) ?>" required />
                            <label for="nama">Nama lengkap</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="username" name="username" type="text" placeholder="Username"
                                   value="<?= e($username) ?>" autocomplete="username" required />
                            <label for="username">Username</label>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="password" name="password" type="password"
                                           placeholder="Password" autocomplete="new-password" required />
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="konfirmasi" name="konfirmasi" type="password"
                                           placeholder="Ulangi password" autocomplete="new-password" required />
                                    <label for="konfirmasi">Ulangi password</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 mb-0">
                            <div class="d-grid"><button class="btn btn-primary btn-block" type="submit">Daftar</button></div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="small"><a href="login.php">Sudah punya akun? Login</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
