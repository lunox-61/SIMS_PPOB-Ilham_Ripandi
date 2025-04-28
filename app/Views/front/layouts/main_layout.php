<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($page_title ?? 'SIMS PPOB') ?></title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    /* General Scroll Area */
    .scroll-area {
      display: flex;
      overflow-x: auto;
      gap: 1rem;
      padding-bottom: 1rem;
    }

    /* Promo Card */
    .promo-card {
      flex: 0 0 auto;
      width: 270px;
      border: none;
      box-shadow: 0 0 8px rgba(0,0,0,0.05);
      border-radius: 0.5rem;
    }
    .promo-card img {
      height: 121px;
      object-fit: cover;
    }

    /* Services */
    .service-item {
      flex: 0 0 auto;
      width: 80px;
      text-align: center;
    }
    .service-item img {
      width: 64px;
      height: 64px;
      object-fit: contain;
    }
    .service-item .small {
      font-size: 0.8rem;
    }

    /* Responsive Adjustment */
    @media (max-width: 768px) {
      main.container {
        padding: 1rem;
      }
      .brand-logo {
        width: 28px;
        height: 28px;
      }
      h5.fw-semibold {
        font-size: 1.1rem;
      }
      .service-item img {
        width: 56px;
        height: 56px;
      }
      .service-item {
        width: 72px;
      }
    }
  </style>
</head>
<body class="bg-light">

  <!-- Header -->
  <?php include(APPPATH . 'Views/front/layouts/header.php'); ?>

  <!-- Main -->
  <main class="container py-5">
    <?= $content ?>
  </main>

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
