<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Asar Tamkin</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?=base_url() ?>Foodmart/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url() ?>Foodmart/style.css">
    <link rel="shortcut icon" href="<?= base_url('static/images/logo/favicon.jpg') ?>" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <style>
    a {
      text-decoration: none !important;
    }
    </style>
  </head>
  <body>
    <!-- Modal Snap bisa kamu tempatkan jika pakai embed -->
    <div class="modal fade" id="modalBooking" tabindex="-1" aria-labelledby="modalBookingLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content" style="height: 100vh;">
          <div id="snap-container" style="width: 100%; height:100%"></div>
        </div>
      </div>
    </div>
    <?= $this->include('customer/partials/header') ?>       
        <?= $this->renderSection('app') ?>
    <?= $this->include('customer/partials/footer') ?>  

    <script src="<?=base_url() ?>Foodmart/js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="<?=base_url() ?>Foodmart/js/plugins.js"></script>
    <script src="<?=base_url() ?>Foodmart/js/script.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if(session()->has('error_message')): ?>
    <script>
        const errorMessage = "<?= session()->get('error_message') ?>";
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: errorMessage,
        });
    </script>
    <?php endif; ?>
    <?php if(session()->has('success_message')): ?>
    <script>
        const successMsg = "<?= session()->get('success_message') ?>";
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: successMsg,
        });
    </script>
    <?php endif; ?>
    
    <script>
      const BASE_URL = '<?= base_url() ?>';
      const CSRF_NAME = '<?= csrf_token() ?>';
      const CSRF_HASH = '<?= csrf_hash() ?>';

      function showCartToast() {
          Swal.fire({ toast:true, position:'top-end', icon:'success', title: 'Berhasil ditambahkan ke keranjang', showConfirmButton:false, timer:1400, timerProgressBar:true });
      }

        // Tambah ke keranjang
        $(document).on('click', '.btn-addcart', function(e) {
          e.preventDefault();
          const id  = $(this).data('id');
          const qty = parseInt($(this).attr('data-qty')) || 1;

          $.ajax({
            url: `<?= base_url() ?>api/${id}/addcart`,
            method: 'POST',
            dataType: 'json',
            data: { qty: qty, [CSRF_NAME]: CSRF_HASH },
            success: function (resp) {
              showCartToast();
            }
          });
        });

        // Hapus item cart (pindahkan ke sini, bukan setelah endSection)
        $(document).on('click', '#my-cart ul .delete-item', function(e) {
          e.preventDefault();
          const id = $(this).data('index');
          $.ajax({
            url: `<?= base_url() ?>api/${id}/deleteitem`,
            method: 'POST',
            dataType: 'json',
            data: { [CSRF_NAME]: CSRF_HASH },
            success: function () {}
          });
        });

        $(document).on('click', '#btn-checkout', function(e) {
          const id = 151515;
          $.ajax({
            url: `<?= base_url() ?>api/${id}/checkout`,
            method: 'POST',
            dataType: 'json',
            success: function (response) {
              alert(response.message);
              window.location.href = '<?= base_url() ?>checkout';
            },
            error: function (xhr, status, error) {
                console.error('Terjadi kesalahan saat mengambil data:', error);
            }
          });
        });
    </script>
  </body>
</html>