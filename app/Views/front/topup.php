<?php
$page_title = "Top Up - SIMS PPOB";
ob_start();
?>

<?php include(APPPATH . 'Views/front/layouts/user_balance.php'); ?>

<!-- Top Up Section -->
<div class="mb-4">
  <div class="text-secondary">Silahkan masukkan</div>
  <h2 class="fs-5 fw-semibold">Nominal Top Up</h2>
</div>

<form method="post" action="<?= site_url('topup') ?>" id="topup-form">
  <?= csrf_field() ?>

  <div class="row g-3 align-items-start">
    <!-- Form Input + Submit Button (KIRI) -->
    <div class="col-md-8">
      <div class="input-group mb-3">
        <span class="input-group-text bg-white"><i class="bi bi-credit-card-2-front"></i></span>
        <input
          type="number"
          name="amount"
          id="amount"
          class="form-control"
          placeholder="Masukkan nominal Top Up"
          required
          min="1"
        >
      </div>

      <button type="submit" id="submit-button" class="btn btn-secondary w-100" disabled>
        Top Up
      </button>
    </div>

    <!-- Quick Amount Buttons (KANAN) -->
    <div class="col-md-4">
      <div class="row row-cols-3 g-2">
        <?php foreach ([10000, 20000, 50000, 100000, 250000, 500000] as $amt): ?>
        <div class="col">
          <button type="button"
                  class="btn btn-outline-secondary w-100 quick-amount"
                  data-amount="<?= $amt ?>">
            Rp<?= number_format($amt, 0, ',', '.') ?>
          </button>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</form>

<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <div class="rounded-circle bg-danger text-white mx-auto mb-3" style="width: 64px; height: 64px; display: flex; align-items: center; justify-content: center;">
        <i class="bi bi-wallet2 fs-3"></i>
      </div>
      <p id="confirmMessage" class="fw-semibold mb-3"></p>
      <button id="confirmTopupButton" class="btn btn-danger mb-2">Ya, lanjutkan Top Up</button>
      <button type="button" class="btn btn-light text-danger" data-bs-dismiss="modal">Batalkan</button>
    </div>
  </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <div class="rounded-circle bg-success text-white mx-auto mb-3" style="width: 64px; height: 64px; display: flex; align-items: center; justify-content: center;">
        <i class="bi bi-check-lg fs-3"></i>
      </div>
      <p class="mb-1">Top Up sebesar</p>
      <p id="successAmount" class="fw-bold fs-4 mb-2"></p>
      <p>berhasil!!</p>
      <a href="<?= site_url('/') ?>" class="btn btn-link text-danger fw-semibold">Kembali ke Beranda</a>
    </div>
  </div>
</div>

<!-- Failed Modal -->
<div class="modal fade" id="failModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <div class="rounded-circle bg-danger text-white mx-auto mb-3" style="width: 64px; height: 64px; display: flex; align-items: center; justify-content: center;">
        <i class="bi bi-x-lg fs-3"></i>
      </div>
      <p class="mb-1">Top Up sebesar</p>
      <p id="failAmount" class="fw-bold fs-4 mb-2"></p>
      <p>gagal</p>
      <a href="<?= site_url('/') ?>" class="btn btn-link text-danger fw-semibold">Kembali ke Beranda</a>
    </div>
  </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Bootstrap modal instances
const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
const successModal = new bootstrap.Modal(document.getElementById('successModal'));
const failModal = new bootstrap.Modal(document.getElementById('failModal'));

// Elements
const amountInput = document.getElementById('amount');
const form = document.getElementById('topup-form');
const submitButton = document.getElementById('submit-button');
const confirmMessage = document.getElementById('confirmMessage');
const confirmTopupButton = document.getElementById('confirmTopupButton');
const successAmount = document.getElementById('successAmount');
const failAmount = document.getElementById('failAmount');

// Format currency
function formatCurrency(value) {
  return parseInt(value).toLocaleString('id-ID');
}

// Enable/disable submit button
amountInput.addEventListener('input', updateSubmitState);

function updateSubmitState() {
  const value = amountInput.value.trim();
  if (value && parseInt(value) > 0) {
    submitButton.disabled = false;
    submitButton.classList.replace('btn-secondary', 'btn-danger');
  } else {
    submitButton.disabled = true;
    submitButton.classList.replace('btn-danger', 'btn-secondary');
  }
}

// Quick amount button click
document.querySelectorAll('.quick-amount').forEach(btn => {
  btn.addEventListener('click', function() {
    amountInput.value = Number(this.dataset.amount);
    updateSubmitState();
  });
});

// Saat form submit ➔ tampilkan modal konfirmasi
form.addEventListener('submit', function(e) {
  e.preventDefault();
  const nominal = amountInput.value;
  confirmMessage.innerHTML = `Anda yakin untuk Top Up sebesar <br><strong>Rp${formatCurrency(nominal)}</strong> ?`;
  confirmModal.show();
});

// Klik "Ya, lanjutkan Top Up"
confirmTopupButton.addEventListener('click', function() {
  confirmModal.hide();

  const nominal = amountInput.value;

  // Ambil CSRF token name dan value secara dinamis
  const csrfInput = document.querySelector('input[name][type="hidden"]');
  const csrfTokenName = csrfInput.name;
  const csrfTokenValue = csrfInput.value;

  fetch('<?= site_url('topup') ?>', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `${csrfTokenName}=${csrfTokenValue}&amount=${nominal}`
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'success') {
      successAmount.textContent = `Rp${formatCurrency(nominal)}`;
      successModal.show();
    } else {
      failAmount.textContent = `Rp${formatCurrency(nominal)}`;
      failModal.show();
    }
  })
  .catch(error => {
    failAmount.textContent = `Rp${formatCurrency(nominal)}`;
    failModal.show();
  });
});
</script>

<?php
$content = ob_get_clean();
include(APPPATH . 'Views/front/layouts/main_layout.php');
?>
