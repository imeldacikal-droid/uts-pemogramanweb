<?php
// includes/fungsi.php
// Pengaturan aplikasi dan fungsi bantu yang dipakai banyak halaman.

const NAMA_APP = 'To-Do List';

// Singkatan dari htmlspecialchars($teks, ENT_QUOTES, 'UTF-8').
// Mengubah karakter seperti < dan > menjadi kode HTML sehingga teks tampil apa adanya
// dan tidak dijalankan browser (mencegah XSS). Pemakaian di HTML: tulis e($variabel) di dalam tag echo pendek.
function e($teks)
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

// Mengembalikan ' active' jika menu ini sedang dibuka (untuk menandai menu di sidebar/navbar).
function aktif($menu, $menu_aktif)
{
    return $menu === $menu_aktif ? ' active' : '';
}
