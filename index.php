<?php
// index.php
// Sementara: arahkan pengunjung ke halaman yang sesuai. (Nanti diganti halaman beranda/landing.)

session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}
exit;
