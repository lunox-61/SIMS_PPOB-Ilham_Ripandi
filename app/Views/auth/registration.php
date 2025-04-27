<?php
$page_title = "Registrasi - SIMS PPOB"; 
ob_start(); 
?>

<h1 class="h3 text-center fw-semibold mb-5">Lengkapi data untuk membuat akun</h1>

<form method="post" action="<?= site_url('/register/store') ?>" id="registration-form" novalidate>
  <?= csrf_field() ?>

  <!-- Email -->
  <div class="mb-3 position-relative">
    <i class="bi bi-envelope-fill form-icon"></i>
    <input 
      type="email" 
      name="email" 
      id="email" 
      class="form-control ps-5 <?= session('errors.email') ? 'is-invalid' : '' ?>" 
      placeholder="wallet@nutech.com" 
      value="<?= old('email') ?>" 
      required
    >
  </div>
  <div class="invalid-feedback text-end" style="<?= session('errors.email') ? '' : 'display: none;' ?>">
    <?= esc(session('errors.email') ?? '') ?>
  </div>

  <!-- First Name -->
  <div class="mb-3 position-relative">
    <i class="bi bi-person-fill form-icon"></i>
    <input 
      type="text" 
      name="first_name" 
      id="first_name" 
      class="form-control ps-5 <?= session('errors.first_name') ? 'is-invalid' : '' ?>" 
      placeholder="Kristanto" 
      value="<?= old('first_name') ?>" 
      required
    >
  </div>
  <div class="invalid-feedback text-end" style="<?= session('errors.first_name') ? '' : 'display: none;' ?>">
    <?= esc(session('errors.first_name') ?? '') ?>
  </div>

  <!-- Last Name -->
  <div class="mb-3 position-relative">
    <i class="bi bi-person-fill form-icon"></i>
    <input 
      type="text" 
      name="last_name" 
      id="last_name" 
      class="form-control ps-5 <?= session('errors.last_name') ? 'is-invalid' : '' ?>" 
      placeholder="Wibowo" 
      value="<?= old('last_name') ?>" 
      required
    >
  </div>
  <div class="invalid-feedback text-end" style="<?= session('errors.last_name') ? '' : 'display: none;' ?>">
    <?= esc(session('errors.last_name') ?? '') ?>
  </div>

  <!-- Password -->
  <div class="mb-3">
    <div class="position-relative">
      <i class="bi bi-lock-fill form-icon"></i>
      <input 
        type="password" 
        id="password" 
        name="password" 
        class="form-control ps-5 pe-5 <?= session('errors.password') ? 'is-invalid' : '' ?>" 
        placeholder="buat password" 
        required
      >
      <i class="bi bi-eye-slash form-password-toggle"></i>
    </div>
  </div>
  <div class="invalid-feedback text-end" style="<?= session('errors.password') ? '' : 'display: none;' ?>">
    <?= esc(session('errors.password') ?? '') ?>
  </div>

  <!-- Confirm Password -->
  <div class="mb-3">
    <div class="position-relative">
      <i class="bi bi-lock-fill form-icon"></i>
      <input 
        type="password" 
        id="confirmPassword" 
        name="confirm_password" 
        class="form-control ps-5 pe-5 <?= session('errors.confirm_password') ? 'is-invalid' : '' ?>" 
        placeholder="konfirmasi password" 
        required
      >
      <i class="bi bi-eye-slash form-password-toggle"></i>
    </div>
  </div>
  <div class="invalid-feedback text-end" style="<?= session('errors.confirm_password') ? '' : 'display: none;' ?>">
    <?= esc(session('errors.confirm_password') ?? '') ?>
  </div>
  <div class="invalid-feedback text-end" id="confirmPasswordError" style="display: none;">
    Password tidak sama
  </div>

  <button type="submit" class="btn btn-danger w-100">Registrasi</button>
</form>

<p class="mt-4 text-center text-muted small">
  sudah punya akun?
  <a href="/login" class="text-danger text-decoration-none">login di sini</a>
</p>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('registration-form');
  const password = document.getElementById('password');
  const confirmPassword = document.getElementById('confirmPassword');
  const confirmPasswordError = document.getElementById('confirmPasswordError');

  form.addEventListener('submit', function(e) {
    let isValid = true;

    if (password.value !== confirmPassword.value) {
      confirmPassword.classList.add('is-invalid');
      confirmPasswordError.style.display = 'block';
      isValid = false;
    } else {
      confirmPassword.classList.remove('is-invalid');
      confirmPasswordError.style.display = 'none';
    }

    if (!isValid) {
      e.preventDefault();
    }
  });
});
</script>

<?php
$content = ob_get_clean(); 
include('auth_layout.php'); 
?>
