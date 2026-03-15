<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asar Tamkin</title>

    <!-- Flexy template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>flexy/assets/css/styles.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- DataTables + SweetAlert (CDN) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />

    <link rel="shortcut icon" href="<?= base_url('static/images/logo/favicon.jpg') ?>" type="image/x-icon">
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-header-position="fixed">

    <?= $this->include('admin/partials/_sidebar') ?>
    <div class="body-wrapper">
        <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
          </ul>
        </nav>
      </header>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <?= $this->renderSection('app') ?>

                <?= $this->include('admin/partials/_footer') ?>
            </div>
        </div>
    </div>

    <!-- Flexy template JS -->

    <script src="<?= base_url() ?>flexy/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url() ?>flexy/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>flexy/assets/js/sidebarmenu.js"></script>
    <script src="<?= base_url() ?>flexy/assets/js/app.min.js"></script>
    <script src="<?= base_url() ?>flexy/assets/libs/simplebar/dist/simplebar.js"></script>
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    <!-- DataTables + SweetAlert (CDN) -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Toast helper
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        // Init DataTable jika elemen ada
        $(function() {
            if ($('#dataTable').length) {
                try {
                    $('#dataTable').DataTable();
                } catch (e) {
                    console.warn(e);
                }
            }

            const succesSessionFlashMsg = '<?= session()->getFlashdata('success_message') ?>';
            const errorSessionFlashMsg = '<?= session()->getFlashdata('error_message') ?>';
            if (succesSessionFlashMsg) {
                Toast.fire({
                    icon: 'success',
                    title: succesSessionFlashMsg
                });
            }
            if (errorSessionFlashMsg) {
                Toast.fire({
                    icon: 'warning',
                    title: errorSessionFlashMsg
                });
            }
        });
    </script>

</body>

</html>