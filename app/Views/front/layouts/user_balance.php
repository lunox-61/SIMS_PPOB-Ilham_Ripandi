<div class="row align-items-start mb-5">
  <!-- User Welcome -->
  <div class="col-12 col-md-6 mb-4 mb-md-0">
    <div class="d-flex flex-column align-items-left text-start">
      <img src="<?= base_url(esc($user_photo)) ?>" alt="Profile avatar" width="96" height="96" class="rounded-circle mb-2">
      <div>
        <div class="text-muted medium">Selamat datang,</div>
        <div class="fw-semibold fs-3"><?= esc($user_fullname) ?></div>
      </div>
    </div>
  </div>

  <!-- Balance Card -->
  <div class="col-12 col-md-6">
    <div class="card text-white p-4 h-100" style="background: url('<?= base_url('assets/Background Saldo.png') ?>') center/cover no-repeat; border: none;">
      <div class="mb-2 small">Saldo anda</div>
      <div class="d-flex flex-column align-items-start">
        <div class="fs-4 fw-bold mb-2" id="saldo-nominal">Rp •••••••</div>
        <button class="btn btn-outline-light btn-sm d-flex align-items-center outline-0" id="toggle-saldo">
          Lihat Saldo
          <i class="bi bi-eye ms-2" id="eye-icon"></i>
        </button>
      </div>
    </div>
  </div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {
	  const toggleButton = document.getElementById('toggle-saldo');
	  const eyeIcon = document.getElementById('eye-icon');
	  const saldoNominal = document.getElementById('saldo-nominal');

	  const nominalSaldo = 'Rp <?= number_format($user_balance, 0, ',', '.') ?>';
	  let isSaldoVisible = false;

	  toggleButton.addEventListener('click', function() {
	    isSaldoVisible = !isSaldoVisible;
	    if (isSaldoVisible) {
	      saldoNominal.textContent = nominalSaldo;
	      eyeIcon.classList.remove('bi-eye');
	      eyeIcon.classList.add('bi-eye-slash');
	      toggleButton.textContent = 'Sembunyikan Saldo';
	      toggleButton.appendChild(eyeIcon);
	    } else {
	      saldoNominal.textContent = 'Rp •••••••';
	      eyeIcon.classList.remove('bi-eye-slash');
	      eyeIcon.classList.add('bi-eye');
	      toggleButton.textContent = 'Lihat Saldo';
	      toggleButton.appendChild(eyeIcon);
	    }
	  });
	});
</script>
