<?= $this->extend('customer/template/index.php') ?>
<?= $this->section('app') ?>
<div class="container py-5">
  <div class="text-center mb-5">
    <h2 class="fw-bold">Frequently Asked Questions</h2>
    <p class="text-muted">Pertanyaan umum yang sering ditanyakan oleh pelanggan Paras Selatan</p>
  </div>

  <div class="accordion" id="faqAccordion">

    <div class="accordion-item rounded-4 mb-3 shadow-sm">
      <h2 class="accordion-header" id="faqOne">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true">
          Apa saja jam buka Paras Selatan?
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          <strong>Senin – Selasa:</strong> 15.00 – 23.00 WIB <br>
          <strong>Rabu – Minggu:</strong> 08.00 – 23.00 WIB
        </div>
      </div>
    </div>

    <div class="accordion-item rounded-4 mb-3 shadow-sm">
      <h2 class="accordion-header" id="faqTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
          Apakah Paras Selatan menyediakan WiFi?
        </button>
      </h2>
      <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Ya, kami menyediakan koneksi WiFi gratis untuk semua pelanggan.
        </div>
      </div>
    </div>

    <div class="accordion-item rounded-4 mb-3 shadow-sm">
      <h2 class="accordion-header" id="faqThree">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
          Apakah bisa melakukan reservasi tempat?
        </button>
      </h2>
      <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Untuk saat ini, kami melayani berdasarkan kedatangan langsung (first come, first served). Namun, reservasi untuk acara kecil bisa didiskusikan melalui kontak kami.
        </div>
      </div>
    </div>

    <div class="accordion-item rounded-4 mb-3 shadow-sm">
      <h2 class="accordion-header" id="faqFour">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
          Di mana lokasi Asar Tamkin?
        </button>
      </h2>
      <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Kami berlokasi di Kajen, Kabupaten Pekalongan, Indonesia.
        </div>
      </div>
    </div>

  </div>
</div>
<?= $this->endSection() ?>