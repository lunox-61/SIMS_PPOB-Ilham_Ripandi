<?php
$page_title = "Transaction History - SIMS PPOB";
ob_start();
?>

<!-- User Balance -->
<?php include(APPPATH . 'Views/front/layouts/user_balance.php'); ?>

<div class="mb-4">
  <h5 class="fw-semibold">Semua Transaksi</h5>
</div>

<div id="transaction-container" class="space-y-4"></div>

<div class="text-center mt-4">
  <button id="show-more" class="btn btn-link text-danger fw-semibold" style="display: none;">
    Show more
  </button>
</div>

<?php if (!empty($transactions)): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const transactions = <?= json_encode($transactions) ?>;
  const transactionContainer = document.getElementById('transaction-container');
  const showMoreButton = document.getElementById('show-more');

  let currentPage = 1;
  const itemsPerPage = 5;

  function formatCurrency(value) {
    return new Intl.NumberFormat('id-ID').format(value);
  }

  function loadTransactions() {
    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const currentTransactions = transactions.slice(start, end);

    currentTransactions.forEach(trx => {
      const isCredit = trx.transaction_type.toUpperCase() === 'TOPUP';
      const amountColor = isCredit ? 'text-success' : 'text-danger';
      const sign = isCredit ? '+' : '-';

      const div = document.createElement('div');
      div.className = 'border rounded-3 p-3 d-flex justify-content-between align-items-center mb-2';

      div.innerHTML = `
        <div>
          <div class="fw-semibold ${amountColor}">
            ${sign}Rp${formatCurrency(trx.amount)}
          </div>
          <div class="small text-muted">
            ${new Date(trx.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })} 
            ${new Date(trx.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })} WIB
          </div>
        </div>
        <div class="text-end small text-secondary">
          ${trx.service_name}
        </div>
      `;

      transactionContainer.appendChild(div);
    });

    if (transactions.length > end) {
      showMoreButton.style.display = 'inline-block';
    } else {
      showMoreButton.style.display = 'none';
    }
  }

  showMoreButton.addEventListener('click', function() {
    currentPage++;
    loadTransactions();
  });

  // First load
  loadTransactions();
});
</script>
<?php else: ?>
<div class="text-center text-muted py-5">
  Maaf tidak ada histori transaksi saat ini
</div>
<?php endif; ?>

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

<?php
$content = ob_get_clean();
include(APPPATH . 'Views/front/layouts/main_layout.php');
?>
