<!-- registration.php -->
<?php
$page_title = "Registrasi - SIMS PPOB"; // Mengatur judul halaman
ob_start(); // Start output buffering
?>

<?php if (session()->get('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->get('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>


<h1 class="h3 text-center fw-semibold mb-5">Lengkapi data untuk membuat akun</h1>

<form method="post" action="<?= site_url('/register/store') ?>">
  <div class="mb-3 position-relative">
    <i class="bi bi-envelope-fill form-icon"></i>
    <input type="email" name="email" class="form-control ps-5" placeholder="wallet@nutech.com" value="<?= old('email') ?>" required>
  </div>

  <div class="mb-3 position-relative">
    <i class="bi bi-person-fill form-icon"></i>
    <input type="text" name="first_name" class="form-control ps-5" placeholder="Kristanto" required>
  </div>

  <div class="mb-3 position-relative">
    <i class="bi bi-person-fill form-icon"></i>
    <input type="text" name="last_name" class="form-control ps-5" placeholder="Wibowo" required>
  </div>

  <div class="mb-3 position-relative">
    <i class="bi bi-lock-fill form-icon"></i>
    <input type="password" id="password" name="password" class="form-control ps-5 pe-5" placeholder="buat password" required>
    <i class="bi bi-eye-slash form-password-toggle"></i>
  </div>

  <div class="mb-3 position-relative">
    <i class="bi bi-lock-fill form-icon"></i>
    <input type="password" id="confirmPassword" name="confirm_password" class="form-control ps-5 pe-5" placeholder="konfirmasi password" required>
    <i class="bi bi-eye-slash form-password-toggle"></i>
  </div>

  <button type="submit" class="btn btn-danger w-100">Registrasi</button>
</form>

<p class="mt-4 text-center text-muted small">
  sudah punya akun?
  <a href="/login" class="text-danger text-decoration-none">login di sini</a>
</p>

<?php
$content = ob_get_clean(); // Menyimpan konten dalam variabel
include('auth_layout.php'); // Menyertakan auth_layout.php dengan konten dinamis
?>
