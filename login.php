<?php
// login.php
// Form login: cek username, verifikasi password ber-hash, lalu simpan status login di $_SESSION.

session_start();
require 'koneksi.php';

// User yang sudah login langsung diarahkan ke dashboard.
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$base     = '';
$judul    = 'Login';
$mode     = 'auth';
$error    = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username dan password wajib diisi.';
    } else {
        $stmt = mysqli_prepare($koneksi, 'SELECT id, nama, password FROM users WHERE username = ?');
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        mysqli_stmt_close($stmt);

        if ($user && password_verify($password, $user['password'])) {
            // Ganti ID session setelah login berhasil (mencegah session fixation).
            session_regenerate_id(true);
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_nama'] = $user['nama'];

            header('Location: dashboard.php');
            exit;
        }

        // Satu pesan umum agar tidak membocorkan username mana yang terdaftar.
        $error = 'Username atau password salah.';
    }
}

// Pesan dari halaman lain (hanya nilai yang dikenal yang ditampilkan).
$pesan_info = '';
if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] === 'logout') {
        $pesan_info = 'Anda sudah keluar.';
    } elseif ($_GET['pesan'] === 'daftar') {
        $pesan_info = 'Akun berhasil dibuat. Silakan login.';
    }
}

require 'includes/header.php';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                <div class="card-body">

                    <?php if ($pesan_info !== ''): ?>
                        <div class="alert alert-success"><?= e($pesan_info) ?></div>
                    <?php endif; ?>

                    <?php if ($error !== ''): ?>
                        <div class="alert alert-danger"><?= e($error) ?></div>
                    <?php endif; ?>

                    <form method="post" action="login.php">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="username" name="username" type="text" placeholder="Username"
                                   value="<?= e($username) ?>" autocomplete="username" autofocus required />
                            <label for="username">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="password" name="password" type="password" placeholder="Password"
                                   autocomplete="current-password" required />
                            <label for="password">Password</label>
                        </div>
                        <div class="d-grid mt-4 mb-0">
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="small"><a href="register.php">Belum punya akun? Daftar</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
