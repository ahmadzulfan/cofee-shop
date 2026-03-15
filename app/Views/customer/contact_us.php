<?= $this->extend('customer/template/index.php') ?>
<?= $this->section('app') ?>
<div class="container py-5">
  <div class="text-center mb-5">
    <h2 class="fw-bold">Kontak Kami</h2>
    <p class="text-muted">Hubungi atau kunjungi kami untuk menikmati pengalaman terbaik di Asar Tamkin Coffee Shop.</p>
  </div>

  <div class="row justify-content-center g-4">
    <div class="col-md-6">
      <div class="card shadow-sm rounded-4 p-4 h-100">
        <h4 class="fw-semibold mb-3">Asar Tamkin</h4>
        <p class="mb-2"><strong>Kategori:</strong> Coffee Shop</p>
        <p class="mb-2">
          <strong>Jam Operasional:</strong><br>
          <span class="d-block">Senin – Selasa: 15.00 – 23.00 WIB</span>
          <span class="d-block">Rabu – Minggu: 08.00 – 23.00 WIB</span>
        </p>
        <p class="mb-2">
          <strong>Lokasi:</strong><br>
          Kajen, Pekalongan, Indonesia
        </p>
        <p class="mb-2">
          <strong>WhatsApp:</strong><br>
          081902518326
        </p>
        <p>
          <strong>Ikuti Kami:</strong><br>
          <a href="https://www.instagram.com/paras.selatan/" class="text-decoration-none me-2"><i class="bi bi-instagram"></i> Instagram</a>
        </p>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm rounded-4 h-100">
        <iframe
          class="rounded-4 w-100 h-100"
          src="https://www.google.com/maps?q=Kajen+Pekalongan+Indonesia&output=embed"
          frameborder="0"
          allowfullscreen
        ></iframe>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>