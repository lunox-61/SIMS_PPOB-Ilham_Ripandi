<header class="bg-white border-bottom py-3">
  <div class="container d-flex justify-content-between align-items-center">
    <a href="<?= site_url('/') ?>" class="fw-bold text-black d-flex align-items-center gap-2 text-decoration-none">
      <img src="<?= base_url('assets/Logo.png') ?>" alt="Logo" class="brand-logo" style="width: 32px; height: 32px;">
      <span class="d-none d-md-inline">SIMS PPOB</span> <!-- Hide text in small screen -->
    </a>

    <!-- Toggle button for mobile -->
    <button class="navbar-toggler d-md-none border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <i class="bi bi-list fs-1"></i>
    </button>

    <nav id="navbarNav" class="d-none d-md-flex gap-4 align-items-center">
      <a href="<?= site_url('/topup') ?>" class="text-black text-decoration-none">Top Up</a>
      <a href="<?= site_url('transaction/history') ?>" class="text-black text-decoration-none">Transaction</a>
      <a href="<?= site_url('/profile') ?>" class="text-danger text-decoration-none">Akun</a>
    </nav>

    <!-- Navbar Mobile -->
    <div class="collapse d-md-none" id="navbarNav">
      <div class="d-flex flex-column mt-3">
        <a href="<?= site_url('/topup') ?>" class="text-black text-decoration-none py-2">Top Up</a>
        <a href="<?= site_url('transaction/history') ?>" class="text-black text-decoration-none py-2">Transaction</a>
        <a href="<?= site_url('/profile') ?>" class="text-danger text-decoration-none py-2">Akun</a>
      </div>
    </div>
  </div>
</header>
