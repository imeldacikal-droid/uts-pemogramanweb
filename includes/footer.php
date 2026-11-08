<?php
// includes/footer.php
// Penutup halaman. Menutup tag yang dibuka header.php sesuai $mode, lalu memuat JavaScript.

if (!isset($base)) { $base = ''; }
if (!isset($mode)) { $mode = 'publik'; }
$tahun = date('Y');
?>
<?php if ($mode === 'app'): ?>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">&copy; <?= $tahun ?> To-Do List &middot; UTS Pemrograman Web</div>
                        <div class="text-muted">Template: <a href="https://startbootstrap.com/template/sb-admin" target="_blank" rel="noopener">SB Admin</a> oleh Start Bootstrap (MIT)</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

<?php elseif ($mode === 'auth'): ?>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">&copy; <?= $tahun ?> To-Do List &middot; UTS Pemrograman Web</div>
                        <div class="text-muted">Template: <a href="https://startbootstrap.com/template/sb-admin" target="_blank" rel="noopener">SB Admin</a> oleh Start Bootstrap (MIT)</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

<?php else: ?>
    </main>
    <footer class="py-4 bg-light mt-auto">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between small">
                <div class="text-muted">&copy; <?= $tahun ?> To-Do List &middot; UTS Pemrograman Web</div>
                <div class="text-muted">Template: <a href="https://startbootstrap.com/template/sb-admin" target="_blank" rel="noopener">SB Admin</a> oleh Start Bootstrap (MIT)</div>
            </div>
        </div>
    </footer>

<?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= $base ?>assets/sb-admin/scripts.js"></script>
    <script src="<?= $base ?>assets/script.js"></script>
</body>
</html>
