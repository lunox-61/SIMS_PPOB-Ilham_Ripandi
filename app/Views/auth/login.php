<!-- login.php -->
<?php
$page_title = "Login - SIMS PPOB"; // Mengatur judul halaman
ob_start(); // Start output buffering
?>

<h1 class="h3 text-center fw-semibold mb-5">Masuk atau buat akun untuk memulai</h1>

<form method="post" action="/login">
  <div class="mb-3 position-relative">
    <i class="bi bi-envelope-fill form-icon"></i>
    <input type="email" class="form-control ps-5" name="email" placeholder="wallet@nutech.com" required>
  </div>

  <div class="mb-3 position-relative">
    <i class="bi bi-lock-fill form-icon"></i>
    <input type="password" id="password" class="form-control ps-5 pe-5" name="password" placeholder="••••••••" required>
    <i class="bi bi-eye-slash form-password-toggle"></i>
  </div>

  <button type="submit" class="btn btn-danger w-100">Masuk</button>
</form>

<p class="mt-4 text-center text-muted small">
  belum punya akun?
  <a href="/register" class="text-danger text-decoration-none">registrasi di sini</a>
</p>

<?php
$content = ob_get_clean(); // Menyimpan konten dalam variabel
include('auth_layout.php'); // Menyertakan auth_layout.php dengan konten dinamis
?>
