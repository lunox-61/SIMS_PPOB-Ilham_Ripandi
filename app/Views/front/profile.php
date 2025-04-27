<?php
$page_title = "Profil - SIMS PPOB";
ob_start();
?>

<!-- ISI UTAMA PROFILE -->
<div class="d-flex flex-column align-items-center mb-5">
  <form action="<?= site_url('profile/image') ?>" method="post" enctype="multipart/form-data" id="photoForm">
    <?= csrf_field() ?>
    <div class="position-relative mb-4" style="width: 128px; height: 128px;">
      <div class="rounded-circle border overflow-hidden w-100 h-100">
        <img src="<?= base_url($user['photo']) ?>" alt="Profile avatar" class="w-100 h-100" style="object-fit: cover;">
      </div>
      <button type="button" class="position-absolute bottom-0 end-0 btn btn-light rounded-circle border shadow-sm p-0" style="width: 32px; height: 32px;" onclick="document.getElementById('photoInput').click()">
        <i class="bi bi-pencil text-muted" style="font-size: 18px;"></i>
      </button>
      <input type="file" name="photo" id="photoInput" class="d-none" accept="image/*" onchange="document.getElementById('photoForm').submit()">
    </div>
  </form>

  <h1 class="h3 fw-semibold"><?= esc($user['first_name'] . ' ' . $user['last_name']) ?></h1>
</div>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
  <div class="alert alert-danger">
    <?= implode('<br>', session()->getFlashdata('errors')) ?>
  </div>
<?php endif; ?>

<form action="<?= site_url('profile/update') ?>" method="post" enctype="multipart/form-data" class="mb-5">
  <?= csrf_field() ?>

  <!-- Email -->
  <div class="mb-3">
    <label for="email" class="form-label text-muted">Email</label>
    <div class="input-group">
      <span class="input-group-text">
        <i class="bi bi-envelope-fill"></i>
      </span>
      <input 
        type="email" 
        class="form-control" 
        id="email" 
        name="email" 
        value="<?= old('email', esc($user['email'])) ?>" 
        required
      >
    </div>
  </div>

  <!-- First Name -->
  <div class="mb-3">
    <label for="first_name" class="form-label text-muted">Nama Depan</label>
    <div class="input-group">
      <span class="input-group-text">
        <i class="bi bi-person-fill"></i>
      </span>
      <input 
        type="text" 
        class="form-control" 
        id="first_name" 
        name="first_name" 
        value="<?= esc($user['first_name']) ?>"
        required
      >
    </div>
  </div>

  <!-- Last Name -->
  <div class="mb-3">
    <label for="last_name" class="form-label text-muted">Nama Belakang</label>
    <div class="input-group">
      <span class="input-group-text">
        <i class="bi bi-person-fill"></i>
      </span>
      <input 
        type="text" 
        class="form-control" 
        id="last_name" 
        name="last_name" 
        value="<?= esc($user['last_name']) ?>"
        required
      >
    </div>
  </div>

  <button type="submit" class="btn btn-danger w-100 mb-2">Update Profil</button>
  <a href="<?= site_url('logout') ?>" class="btn btn-outline-danger w-100">Logout</a>
</form>

<?php
$content = ob_get_clean();
include(APPPATH . 'Views/front/layouts/main_layout.php');
?>
