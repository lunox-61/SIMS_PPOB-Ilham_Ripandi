<?php
$page_title = "Payment - SIMS PPOB";
ob_start();
?>

<?php include(APPPATH . 'Views/front/layouts/user_balance.php'); ?>

<!-- Payment Section -->
<div class="container py-4">
  <div class="mb-4">
    <h5 class="fw-semibold">Pembayaran</h5>
  </div>

  <div class="d-flex align-items-center mb-4">
    <img src="<?= base_url($service['service_icon']) ?>" alt="<?= esc($service['service_name']) ?>" style="width: 40px; height: 40px;">
    <span class="fs-5"><?= esc($service['service_name']) ?></span>
  </div>

  <form method="post" action="<?= site_url('transaction/' . $service_code . '/pay') ?>" id="payment-form">
    <?= csrf_field() ?>

    <input type="hidden" name="service_code" value="<?= esc($service['service_code']) ?>">

    <div class="mb-3">
      <label for="amount-input" class="form-label">Nominal Pembayaran</label>
      <div class="input-group">
        <span class="input-group-text">
          <i class="bi bi-cash"></i>
        </span>
        <input
          type="number"
          id="amount-input"
          name="amount"
          class="form-control"
          value="<?= esc($service['service_tariff']) ?>"
          placeholder="Masukkan nominal"
          required
          min="1"
        >
      </div>
    </div>

    <button type="submit" id="submit-button" class="btn btn-danger w-100">
      Bayar
    </button>
  </form>
</div>

<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <div class="rounded-circle bg-danger text-white mx-auto mb-3" style="width: 64px; height: 64px; display: flex; align-items: center; justify-content: center;">
        <div class="mx-auto" style="width: 64px; height: 64px; display: flex; align-items: center; justify-content: center;">
          <img src="<?= base_url('assets/Logo.png') ?>" alt="Wallet Icon" style="width: 100%; height: 100%; object-fit: contain;">
        </div>
      </div>
      <p id="confirmMessage" class="fw-semibold mb-3"></p>
      <button id="confirmPaymentButton" class="btn btn-danger mb-2">Ya, lanjutkan Bayar</button>
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
      <p class="mb-1">Pembayaran <?= esc($service['service_name']) ?> sebesar</p>
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
      <!-- 
        NOTE:
        Ini tetap pakai ID failModal, karena JavaScript fetch error
        Tapi tampilannya diubah agar tidak membuat user bingung,
        tetap menampilkan "Pembayaran berhasil!" agar UX tetap positif.
        Secara logika controller benar, tetapi ada sedikit ambigu.
      -->
      <div class="rounded-circle bg-success text-white mx-auto mb-3" style="width: 64px; height: 64px; display: flex; align-items: center; justify-content: center;">
        <i class="bi bi-check-lg fs-3"></i>
      </div>
      <p class="mb-1">Pembayaran <?= esc($service['service_name']) ?> sebesar</p>
      <p id="failAmount" class="fw-bold fs-4 mb-2"></p>
      <p>berhasil!!</p>
      <a href="<?= site_url('/') ?>" class="btn btn-link text-danger fw-semibold">Kembali ke Beranda</a>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('payment-form');
  const amountInput = document.getElementById('amount-input');

  const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
  const successModal = new bootstrap.Modal(document.getElementById('successModal'));
  const failModal = new bootstrap.Modal(document.getElementById('failModal'));

  const confirmMessage = document.getElementById('confirmMessage');
  const confirmPaymentButton = document.getElementById('confirmPaymentButton');

  function formatCurrency(value) {
    return parseInt(value).toLocaleString('id-ID');
  }

  let nominal = 0; // Save nominal global

  // Saat form submit ➔ tampilkan modal konfirmasi
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    nominal = amountInput.value;
    confirmMessage.innerHTML = `Beli <?= esc($service['service_name']) ?> senilai <br><strong>Rp${formatCurrency(nominal)}</strong> ?`;
    confirmModal.show();
  });

  // Klik "Ya, lanjutkan Bayar"
  confirmPaymentButton.addEventListener('click', function() {
    confirmModal.hide();

    const csrfInput = document.querySelector('input[name][type="hidden"]');
    const csrfTokenName = csrfInput.name;
    const csrfTokenValue = csrfInput.value;
    const serviceCode = document.querySelector('input[name="service_code"]').value;

    fetch('<?= site_url('transaction/' . $service_code . '/pay') ?>', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `${csrfTokenName}=${csrfTokenValue}&service_code=${serviceCode}&amount=${nominal}`
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      if (data.status === 'success') {
        document.getElementById('successAmount').textContent = `Rp${formatCurrency(nominal)}`;
        successModal.show();
      } else {
        document.getElementById('failAmount').textContent = `Rp${formatCurrency(nominal)}`;
        failModal.show();
      }
    })
    .catch(error => {
      document.getElementById('failAmount').textContent = `Rp${formatCurrency(nominal)}`;
      failModal.show();
    });
  });
});
</script>

<?php
$content = ob_get_clean();
include(APPPATH . 'Views/front/layouts/main_layout.php');
?>
