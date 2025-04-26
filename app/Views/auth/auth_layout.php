<!-- auth_layout.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $page_title ?? 'SIMS PPOB' ?></title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Google Fonts: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    .brand-logo {
      height: 30px;
      width: auto;
    }

    .bg-red-50 {
      background-color: #fef2f2;
    }

    .form-icon {
      position: absolute;
      top: 50%;
      left: 16px;
      transform: translateY(-50%);
      font-size: 1rem;
      color: #6c757d;
    }

    .form-password-toggle {
      position: absolute;
      top: 50%;
      right: 16px;
      transform: translateY(-50%);
      color: #6c757d;
      cursor: pointer;
    }

    .full-height {
      height: 100vh;
    }

    .text-center.mb-4 {
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row full-height">
    <!-- Left Section -->
    <div class="col-md-6 d-flex align-items-center justify-content-center p-4">
      <div class="w-100" style="max-width: 400px;">
        <div class="text-center mb-4">
          <div class="d-flex align-items-center justify-content-center gap-2">
            <img src="assets/Logo.png" alt="Logo" class="brand-logo">
            <h4 class="fw-bold text-black m-0">SIMS PPOB</h4>
          </div>
        </div>

        <!-- Konten Halaman yang Dinamis -->
        <?= $content ?>

      </div>
    </div>

    <!-- Right Section -->
    <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center bg-red-50">
      <img src="assets/Illustrasi Login.png" alt="Illustration" class="img-fluid" style="max-width: 72%;">
    </div>
  </div>
</div>

<script>
  // Toggle show/hide password functionality
  document.querySelectorAll(".form-password-toggle").forEach(function(toggle) {
    toggle.addEventListener("click", function(e) {
      const input = this.previousElementSibling;
      const type = input.type === "password" ? "text" : "password";
      input.type = type;
      this.classList.toggle("bi-eye");
      this.classList.toggle("bi-eye-slash");
    });
  });
</script>

</body>
</html>
