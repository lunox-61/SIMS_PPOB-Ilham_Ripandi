<?php
$page_title = "Home - SIMS PPOB";
ob_start();
?>

<!-- ISI MAIN CONTENT HOME -->

<?php include(APPPATH . 'Views/front/layouts/user_balance.php'); ?>

<!-- Services Icons (No Grid, Scrollable) -->
<h5 class="fw-semibold mb-3">Temukan Layanan</h5>
<div class="d-flex overflow-auto gap-3 mb-4 px-2">
  <?php foreach ($services as $service): ?>
    <?php if ($service['service_code'] !== 'TOPUP'): ?>
      <a href="<?= site_url('transaction/' . $service['service_code']) ?>" class="service-item text-decoration-none text-dark">
        <img src="<?= base_url($service['service_icon']) ?>" alt="<?= esc($service['service_name']) ?>">
        <div class="small mt-1"><?= esc($service['service_name']) ?></div>
      </a>
    <?php endif; ?>
  <?php endforeach; ?>
</div>

<!-- Banner Area -->
<h5 class="fw-semibold mb-3">Temukan promo menarik</h5>
<div class="scroll-area mb-5">
  <?php foreach ($banners as $banner): ?>
    <div class="card promo-card overflow-hidden">
      <img src="<?= base_url($banner['banner_image']) ?>" class="card-img-top" alt="<?= esc($banner['banner_name']) ?>">
      <div class="card-body">
        <h6 class="card-title fw-semibold mb-1"><?= esc($banner['banner_name']) ?></h6>
        <p class="card-text text-muted small"><?= esc($banner['description']) ?></p>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php
$content = ob_get_clean();
include(APPPATH . 'Views/front/layouts/main_layout.php');
?>
