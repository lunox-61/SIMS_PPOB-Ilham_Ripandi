<header class="bg-white border-bottom py-3">
  <div class="container d-flex justify-content-between align-items-center">
    <a href="<?= site_url('/') ?>" class="fw-bold text-black d-flex align-items-center gap-2 text-decoration-none">
      <img src="<?= base_url('assets/Logo.png') ?>" alt="Logo" class="brand-logo" style="width: 24px; height: 24px;">
      SIMS PPOB
    </a>
    <nav class="d-flex gap-4">
      <a href="<?= site_url('/topup') ?>" class="text-black text-decoration-none">Top Up</a>
      <a href="<?= site_url('transaction/history') ?>" class="text-black text-decoration-none">Transaction</a>
      <a href="<?= site_url('/profile') ?>" class="text-danger text-decoration-none">Akun</a>
    </nav>
  </div>
</header>
