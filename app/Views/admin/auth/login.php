<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Admin</title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('static/images/logo/favicon.jpg') ?>" />
  <link rel="stylesheet" href="<?= base_url('flexy/assets/css/styles.min.css') ?>" />
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="<?= base_url('/') ?>" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="<?= base_url('static/images/logo/favicon.jpg') ?>" alt="logo" style="width:80px;height:80px;border-radius:50%;">
                </a>

                <p class="text-center">Masuk ke Dashboard Admin</p>

                <?php if (session()->getFlashdata('error')): ?>
                  <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <form action="<?= base_url('admin/auth/login') ?>" method="POST" class="mt-3">
                  <?= csrf_field() ?>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required autofocus>
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                  </div>

                  <button type="submit" class="btn btn-primary w-100 py-2 fs-6 mb-3">Sign In</button>
                    <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-6 mb-0 fw-bold">Need access?</p>
                    <a 
                        class="text-primary fw-bold ms-2" 
                        href="https://wa.me/6282242183269?text=Halo%20Admin,%20saya%20butuh%20akses."
                        target="_blank"
                    >
                        Contact Admin
                    </a>
                    </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="<?= base_url('flexy/assets/libs/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('flexy/assets/libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('flexy/assets/js/app.min.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>