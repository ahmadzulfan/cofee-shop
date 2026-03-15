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

    <div class="container vh-100 d-flex justify-content-center align-items-center bg-light">
        <div class="card shadow-lg border-0 rounded-4 p-4" style="max-width: 500px; width: 100%;">
            <!-- Tombol Kembali -->
            <div class="mt-4">
                <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary rounded-pill px-4">
                ← Kembali
                </a>
            </div>
            <div class="card-body text-center">
            <img src="<?= base_url('static/images/logo/favicon.jpg') ?>" class="rounded-circle mb-3" alt="Paras Selatan" style="width: 100px; height: 100px;">

            <h4 class="mb-2 fw-bold">Selamat Datang di Asar Tamkin</h4>
            <p class="text-muted mb-4">Silakan scan QR Code di meja Anda untuk login</p>

            <div class="my-4">
                <img id="qr-code" src="" alt="QR Code" class="img-fluid" style="max-width: 180px; height: auto;">
                <select id="select-meja" class="form-control mt-4">
                    <option value="">Pilih Meja Anda</option>
                    <option value="T01">Meja #1</option>
                    <option value="T02">Meja #2</option>
                    <option value="T03">Meja #3</option>
                    <option value="T04">Meja #4</option>
                </select>
            </div>

            <button id="btn-login" class="btn btn-secondary">Masuk</button>

            </div>
        </div>
    </div>

    <script src="<?=base_url() ?>Foodmart/js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="<?=base_url() ?>Foodmart/js/plugins.js"></script>
    <script src="<?=base_url() ?>Foodmart/js/script.js"></script>
    <script>
      $(document).ready(function() {
        // URL endpoint untuk mengambil QR Code
        const qrCodeUrl = '<?= base_url('api/get/qr/') ?>'; // Ganti dengan URL yang sesuai
        
        // Fungsi untuk mengambil dan menampilkan QR Code
        function fetchQRCode(id) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', qrCodeUrl+id, true);
            xhr.responseType = 'blob'; // Mengatur tipe respons menjadi 'blob' untuk gambar

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Membuat objek URL untuk menampilkan gambar QR Code
                    const qrImageUrl = URL.createObjectURL(xhr.response);
                    // Menampilkan gambar QR di elemen dengan id "qr-code"
                    $('#qr-code').attr('src', qrImageUrl);
                } else {
                    console.error("Error fetching QR code:", xhr.statusText);
                }
            };

            xhr.onerror = function() {
                console.error("Error fetching QR code: Network error");
            };

            xhr.send();
        }

        $('#select-meja').change(function() {
            const selectedValue = $(this).val();
            if (selectedValue) {
                // Set data Login
                const btnLogin = document.getElementById('btn-login');
                btnLogin.setAttribute('data-qr', selectedValue);
                
                // Mengambil QR Code untuk meja yang dipilih
                fetchQRCode(selectedValue);
            }else{
              $('#qrCodeContainer').html('');
            }
        });

        $('#btn-login').click(function() {
            const qrValue = $(this).data('qr');
            const url = "/auth/login/"+qrValue;

            window.location.href = url;
        });
    });
    </script>
  </body>
</html>