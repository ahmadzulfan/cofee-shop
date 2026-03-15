<style>
  /* ===== BOTTOM NAV GAYA COFFEE SHOP ===== */
  .nav-bottom {
    background: #ffffff;
    border-top: none; /* Hapus border atas yang kaku */
    box-shadow: 0 -2px 15px rgba(0, 0, 0, 0.08); /* Ganti dengan shadow yang halus */
    padding: 8px 0;
    z-index: 1000;
    font-family: var(--font-body, 'Montserrat', sans-serif); /* Gunakan font tema */
  }

  .nav-bottom .nav-item {
    color: #555; /* Sedikit lebih lembut dari hitam pekat */
    font-size: 14px;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .nav-bottom .nav-item .icon-wrapper {
    margin-bottom: 2px;
    transition: transform 0.3s ease;
  }

  /* Animasi "pop" saat aktif */
  .nav-bottom .nav-item.active .icon-wrapper {
    transform: translateY(-3px);
  }

  .nav-bottom .nav-item .nav-label {
    font-weight: 500;
  }

  /* Warna aktif & hover menggunakan palet tema */
  .nav-bottom .nav-item.active,
  .nav-bottom .nav-item:hover {
    color: var(--coffee-brown, #6F4E37); /* Warna tema utama */
  }
  .nav-bottom .nav-item.active .nav-label {
    font-weight: 600;
  }

  /* ===== BADGE STYLE YANG DISESUAIKAN ===== */
  .nav-bottom .badge {
    position: absolute;
    top: -5px;
    right: -8px;
    background: var(--coffee-brown, #6F4E37); /* Warna tema utama */
    color: #fff;
    font-size: 11px;
    border-radius: 50%;
    padding: 2px 6px;
    font-weight: 600;
    border: 1px solid #fff; /* Memberi sedikit outline */
  }

  /* ===== RESPONSIVE ===== */
  @media (max-width: 768px) {
    .nav-bottom .nav-item .nav-label {
      font-size: 12px;
    }
    .nav-bottom .nav-item iconify-icon {
      width: 26px;
    }
  }
</style>

<nav class="navbar fixed-bottom nav-bottom">
  <div class="container-fluid d-flex justify-content-around px-0">
    <a href="<?= base_url() ?>" class="nav-item text-center flex-fill" id="nav-beranda">
      <div class="icon-wrapper">
        <iconify-icon icon="solar:home-2-outline" width="28"></iconify-icon>
      </div>
      <div class="nav-label">Beranda</div>
    </a>
    <a href="<?= base_url('menu') ?>" class="nav-item text-center flex-fill" id="nav-menu">
      <div class="icon-wrapper">
        <iconify-icon icon="solar:notebook-outline" width="28"></iconify-icon>
      </div>
      <div class="nav-label">Menu</div>
    </a>
    <a href="<?= base_url('keranjang') ?>" class="nav-item text-center flex-fill" id="nav-keranjang">
      <div class="icon-wrapper position-relative">
        <iconify-icon icon="solar:bag-4-outline" width="28"></iconify-icon>
        </div>
      <div class="nav-label">Keranjang</div>
    </a>
  </div>
</nav>

<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

<script>
  // Script untuk highlight navigasi aktif (tidak perlu diubah)
  $(function(){
    const path = window.location.pathname.toLowerCase();
    // Normalisasi base_url untuk perbandingan yang akurat
    const baseUrlPath = new URL('<?= base_url() ?>').pathname;

    $('.nav-bottom .nav-item').removeClass('active'); // Reset semua

    if (path === baseUrlPath || path === baseUrlPath + 'index.php') {
      $('#nav-beranda').addClass('active');
    } else if (path.includes('keranjang')) {
      $('#nav-keranjang').addClass('active');
    } else if (path.includes('menu')) {
      $('#nav-menu').addClass('active');
    }
  });
</script>