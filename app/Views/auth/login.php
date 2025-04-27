<?php
$page_title = "Login - SIMS PPOB"; 
ob_start();
?>

<h1 class="h3 text-center fw-semibold mb-5">Masuk atau buat akun untuk memulai</h1>

<form method="post" action="/login" novalidate>
  <?= csrf_field() ?>

  <!-- Email -->
  <div class="mb-3 position-relative">
    <i class="bi bi-envelope-fill form-icon" id="icon-email"></i>
    <input 
      type="email" 
      class="form-control ps-5 <?= session('email_error') ? 'is-invalid' : '' ?>" 
      name="email" 
      id="email"
      placeholder="wallet@nutech.com" 
      value="<?= old('email') ?>"
      required
    >
  </div>

  <!-- Password -->
  <div class="mb-3 position-relative">
    <i class="bi bi-lock-fill form-icon" id="icon-password"></i>
    <input 
      type="password" 
      class="form-control ps-5 pe-5 <?= session('password_error') ? 'is-invalid' : '' ?>" 
      name="password" 
      id="password"
      placeholder="••••••••" 
      required
    >
    <i class="bi bi-eye-slash form-password-toggle"></i>
  </div>

  <button type="submit" class="btn btn-danger w-100">Masuk</button>
</form>

<p class="mt-4 text-center text-muted small">
  belum punya akun?
  <a href="/register" class="text-danger text-decoration-none">registrasi di sini</a>
</p>

<?php if (session()->getFlashdata('email_error')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= esc(session('email_error')) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('password_error')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= esc(session('password_error')) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const alertBox = document.querySelector('.alert');

  // Auto close alert setelah 3 detik
  if (alertBox) {
    setTimeout(() => {
      const bsAlert = new bootstrap.Alert(alertBox);
      bsAlert.close();
    }, 3000);
  }

  const emailInput = document.getElementById('email');
  const passwordInput = document.getElementById('password');
  const emailIcon = document.getElementById('icon-email');
  const passwordIcon = document.getElementById('icon-password');

  <?php if (session()->getFlashdata('email_error')): ?>
    if (emailInput) {
      emailInput.classList.add('is-invalid');
    }
    if (emailIcon) {
      emailIcon.classList.add('input-error-icon');
    }
  <?php endif; ?>

  <?php if (session()->getFlashdata('password_error')): ?>
    if (passwordInput) {
      passwordInput.classList.add('is-invalid');
    }
    if (passwordIcon) {
      passwordIcon.classList.add('input-error-icon');
    }
  <?php endif; ?>

  // Saat mengetik, langsung reset error
  if (emailInput) {
    emailInput.addEventListener('input', function() {
      emailInput.classList.remove('is-invalid');
      emailIcon.classList.remove('input-error-icon');
    });
  }

  if (passwordInput) {
    passwordInput.addEventListener('input', function() {
      passwordInput.classList.remove('is-invalid');
      passwordIcon.classList.remove('input-error-icon');
    });
  }
});
</script>

<?php
$content = ob_get_clean();
include('auth_layout.php');
?>
