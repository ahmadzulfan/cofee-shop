<?= $this->extend('customer/template/index.php') ?>
<?= $this->section('app') ?>

<style>
  /* === MENU PAGE STYLING === */
  .menu-page-container {
    background-color: var(--cream, #F5F5DC);
    padding: 4rem 0;
  }

  /* === SIDEBAR KATEGORI YANG DISEMPURNAKAN === */
  .sidebar-card {
    background-color: #fff;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    position: sticky;
    /* Membuat sidebar tetap terlihat saat scroll */
    top: 120px;
    /* Jarak dari atas, sesuaikan dengan tinggi header */
  }

  .sidebar-title {
    font-family: var(--font-heading, 'Playfair Display', serif);
    font-size: 1.5rem;
    color: var(--dark-text, #333);
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #eee;
  }

  #category-list .list-group {
    border: none;
  }

  #category-list .category-link {
    font-family: var(--font-body, 'Montserrat', sans-serif);
    border: none;
    padding: 12px 15px;
    margin-bottom: 8px;
    border-radius: 10px;
    font-weight: 500;
    color: #555;
    cursor: pointer;
    transition: all 0.25s ease-in-out;
  }

  #category-list .category-link:hover {
    background-color: rgba(111, 78, 55, 0.1);
    /* Hover warna kopi transparan */
    color: var(--coffee-brown, #6F4E37);
  }

  #category-list .category-link.active {
    background-color: var(--coffee-brown, #6F4E37);
    color: var(--white-text, #fff);
    font-weight: bold;
    box-shadow: 0 4px 12px rgba(111, 78, 55, 0.3);
  }

  /* === KONTEN MENU UTAMA === */
  #menu-title {
    font-family: var(--font-heading, 'Playfair Display', serif);
    font-size: 2.5rem;
    color: var(--coffee-brown, #6F4E37);
    margin-bottom: 2rem;
  }

  /* === KARTU PRODUK YANG LEBIH SIMPEL === */
  .product-card {
    background: #fff;
    border: none;
    border-radius: 15px;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
    position: relative;
  }

  .product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 25px rgba(111, 78, 55, 0.15);
  }

  .product-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 15px 15px 0 0;
  }

  .product-card-body {
    padding: 1.2rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    text-align: center;
  }

  .product-title {
    font-family: var(--font-heading, 'Playfair Display', serif);
    font-size: 1.3rem;
    color: var(--dark-text, #333);
    margin-bottom: 0.5rem;
  }

  .product-price {
    font-family: var(--font-body, 'Montserrat', sans-serif);
    color: var(--coffee-brown, #6F4E37);
    font-weight: bold;
    font-size: 1.1rem;
    margin-bottom: 1rem;
  }

  .product-card .actions {
    margin-top: auto;
    /* Mendorong tombol ke bagian bawah kartu */
  }

  .btn-add-to-cart {
    background-color: var(--coffee-brown, #6F4E37);
    color: var(--white-text, #fff);
    border-radius: 8px;
    font-weight: 500;
    transition: background-color 0.3s ease;
  }

  .btn-add-to-cart:hover {
    background-color: var(--accent-color, #A87C5A);
    color: var(--white-text, #fff);
  }

  /* Overlay Stok Habis */
  .stok-habis-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    color: #999;
    font-weight: bold;
    font-size: 1.2em;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 15px;
    z-index: 2;
    backdrop-filter: blur(3px);
  }

  .img-grayscale {
    filter: grayscale(80%);
  }

  .product-card {
    border-radius: 12px;
    border: 1px solid #eee;
    overflow: hidden;
    background: #fff;
  }

  .product-img {
    width: 100%;
    height: 140px;
    object-fit: cover;
  }

  .product-title {
    font-size: 0.85rem;
    font-weight: 600;
    line-height: 1.2;
    height: 2.4em;
    overflow: hidden;
  }

  .product-price {
    font-size: 0.8rem;
    color: #198754;
    font-weight: bold;
  }

  .stok-habis-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, .6);
    color: #fff;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .img-grayscale {
    filter: grayscale(100%);
  }

  @media (max-width: 576px) {
    .product-img {
      height: 120px;
    }

    .product-title {
      font-size: 0.8rem;
    }
  }
</style>

<style>
  /* === FONT & COLOR PALETTE === */
  :root {
    --coffee-brown: #6F4E37;
    /* Warna utama, cokelat kopi */
    --cream: #F5F5DC;
    /* Warna latar belakang lembut */
    --dark-text: #333333;
    /* Warna teks utama */
    --white-text: #FFFFFF;
    --accent-color: #A87C5A;
    /* Aksen untuk tombol aktif/hover */

    --font-heading: 'Playfair Display', serif;
    --font-body: 'Montserrat', sans-serif;
  }

  body {
    font-family: var(--font-body);
    background-color: var(--cream);
  }

  h1,
  h2,
  h3 {
    font-family: var(--font-heading);
    color: var(--coffee-brown);
  }

  /* === HERO SECTION === */
  .hero-section {
    position: relative;
    height: 80vh;
    background-image: url('https://images.unsplash.com/photo-1559925393-8be0ec4767c8?q=80&w=2070&auto=format&fit=crop');
    /* Ganti dengan gambar coffee shop Anda */
    background-size: cover;
    background-position: center;
    color: var(--white-text);
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
  }

  .hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    /* Overlay gelap untuk keterbacaan teks */
  }

  .hero-content {
    position: relative;
    z-index: 2;
  }

  .hero-content h1 {
    font-size: 3.5rem;
    color: var(--white-text);
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
  }

  .hero-content p {
    font-size: 1.2rem;
    margin-top: 1rem;
    max-width: 600px;
  }

  .cta-button {
    background-color: var(--coffee-brown);
    color: var(--white-text);
    padding: 12px 25px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 500;
    transition: background-color 0.3s ease;
    border: 2px solid var(--coffee-brown);
  }

  .cta-button:hover {
    background-color: var(--accent-color);
    border-color: var(--accent-color);
    color: var(--white-text);
  }

  /* === ABOUT SECTION === */
  .about-section {
    padding: 5rem 0;
    background-color: #fff;
  }

  /* === MENU/PRODUCT SECTION === */
  .menu-section {
    padding: 5rem 0;
  }

  .section-header {
    margin-bottom: 3rem;
  }

  .section-title {
    font-size: 2.5rem;
    position: relative;
    display: inline-block;
    padding-bottom: 10px;
  }

  .section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background-color: var(--coffee-brown);
  }

  /* === CATEGORIES === */
  .category-item {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 15px 10px;
    transition: all 0.3s ease;
    cursor: pointer;
    text-align: center;
  }

  .category-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  }

  .category-image {
    width: 60px;
    height: 60px;
    object-fit: contain;
    margin-bottom: 10px;
  }

  .category-title {
    font-family: var(--font-body);
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--dark-text);
  }

  .active-category {
    background-color: var(--coffee-brown) !important;
    border-color: var(--coffee-brown) !important;
  }

  .categories-container .active-category .category-title {
    color: var(--white-text) !important;
  }

  /* === PRODUCT CARDS === */
  .product-item {
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    margin-bottom: 2rem;
    text-align: left;
    width: 100%;
  }

  .product-item:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
  }

  .product-item figure {
    width: 100%;
    height: 220px;
    margin: 0;
  }

  .product-item img.tab-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .product-info {
    padding: 1.2rem;
  }

  .product-info h3 {
    font-size: 1.2rem;
    margin-bottom: 0.5rem;
  }

  .product-info .price {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--coffee-brown);
  }

  .product-item .d-flex {
    padding: 0 1.2rem 1.2rem 1.2rem;
  }

  .btn-addcart-menu {
    background-color: var(--coffee-brown);
    color: var(--white-text);
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 0.8rem;
  }

  .btn-addcart-menu:hover {
    background-color: var(--accent-color);
  }

  /* Stok Habis Styling */
  .product-item.out-of-stock {
    opacity: 0.7;
    pointer-events: none;
  }

  .img-grayscale {
    filter: grayscale(100%);
  }

  .stok-habis-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #fff;
    background: rgba(0, 0, 0, 0.6);
    font-weight: bold;
    font-size: 1.2em;
    padding: 10px 20px;
    z-index: 3;
    border-radius: 8px;
  }

  .product-title {
    font-size: 0.9rem;
    line-height: 1.2;
    height: 2.4em;
    overflow: hidden;
  }

  .stok-habis-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, .6);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    border-radius: .5rem;
  }

  .img-grayscale {
    filter: grayscale(100%);
  }

  @media (max-width: 576px) {
    .btn-addcart-menu {
      font-size: 0.85rem;
      padding: 0.5rem;
    }
  }

  .category-item {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 10px 6px;
    transition: all 0.2s ease;
  }

  .category-item:hover,
  .category-item.active {
    background: #f8f9fa;
    border-color: #198754;
  }

  .category-image {
    width: 48px;
    height: 48px;
    object-fit: contain;
  }

  .category-title {
    font-size: 0.75rem;
    font-weight: 500;
    line-height: 1.1;
    height: 2.2em;
    overflow: hidden;
  }

  @media (max-width: 576px) {
    .category-image {
      width: 40px;
      height: 40px;
    }

    .category-title {
      font-size: 0.7rem;
    }
  }

  /* === NOTES FORM STYLING === */
  .notes-form {
    margin-top: 0.5rem;
  }

  .notes-textarea {
    width: 100%;
    height: 40px;
    border-radius: 2px;
    border: 1px solid #ccc;
    padding: 0.5rem;
    font-size: 0.8rem;
    min-height: 20px;
    resize: none;
  }

  .notes-textarea:focus {
    outline: none;
    border-color: var(--coffee-brown);
  }
</style>

<div class="menu-page-container">
  <div class="container">
    <div class="row">
      <aside class="col-lg-3 mb-4 mb-lg-0">
        <div class="sidebar-card">
          <h4 class="sidebar-title">Kategori Menu</h4>
          <div class="list-group" id="category-list">
          </div>
        </div>
      </aside>

      <main class="col-lg-9">
        <h2 id="menu-title">Semua Menu</h2>
        <div class="row" id="menu-list">
        </div>
      </main>
    </div>
  </div>
</div>

<script>
  $(function() {
    const id = <?= session('session')['table_id'] ?? '0' ?>;
    // Fungsi format rupiah (tidak berubah)
    function formatRupiah(angka) {
      return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
      }).format(angka);
    }

    // Definisikan elemen spinner untuk digunakan kembali
    const spinner = `<div class="col-12 text-center py-5"><div class="spinner-border" style="color: var(--coffee-brown);" role="status"><span class="visually-hidden">Loading...</span></div></div>`;

    // === FUNGSI loadMenus BARU YANG LEBIH STABIL ===
    function loadMenus(categoryId, categoryName) {
      const menuList = $('#menu-list');
      const hasContent = $.trim(menuList.html()) !== '';

      $('#menu-title').text(categoryName);

      const performLoad = function() {
        menuList.html(spinner).show();

        $.ajax({
          url: '<?= base_url('api/products') ?>',
          method: 'GET',
          dataType: 'json',
          data: {
            category: categoryId
          },

          success: function(res) {
            let html = '';
            const products = res.products || [];

            if (!products.length) {
              menuList.hide().html(
                '<div class="col-12 text-center text-muted mt-5">Menu tidak ditemukan.</div>'
              ).fadeIn(300);
              return;
            }

            products.forEach(product => {
              const nama = product.name ?? product.nama;
              const harga = product.price ?? product.harga;
              const stok = parseInt(product.stock ?? product.stok ?? 0);
              const gambar = product.image ?? product.gambar ?? '';
              const isOut = stok < 1;

              const qtyInputId = `quantity-${product.id}`;
              const minusBtnId = `minus-${product.id}`;
              const plusBtnId = `plus-${product.id}`;
              const notesTextareaId = `notes-${product.id}`;

              html += `
          <div class="col-6 col-md-4 col-lg-3 mb-3">
            <div class="product-item ${isOut ? 'out-of-stock' : ''}">

              <a href="<?= base_url('product/') ?>${product.id}" class="text-decoration-none text-dark">
                  <img 
                    src="<?= base_url('uploads/products/') ?>${gambar}"
                    class="img-fluid rounded ${isOut ? 'img-grayscale' : ''}"
                    alt="${nama}">
                  ${isOut ? '<span class="stok-habis-overlay">Stok Habis</span>' : ''}

                <div class="product-info text-center">
                  <h6 class="product-title">${nama}</h6>
                  <span class="price fw-bold">${formatRupiah(harga)}</span>
                </div>
              </a>

              <div class="product-action mt-2">
                <div class="input-group input-group-sm mb-2">
                  <button type="button"
                    id="${minusBtnId}"
                    class="btn btn-outline-danger btn-number"
                    ${isOut ? 'disabled' : ''}>
                    −
                  </button>

                  <input type="text"
                    id="${qtyInputId}"
                    class="form-control text-center"
                    value="1"
                    min="1"
                    max="${stok}"
                    ${isOut ? 'disabled' : ''}>

                  <button type="button"
                    id="${plusBtnId}"
                    class="btn btn-outline-success btn-number"
                    ${isOut ? 'disabled' : ''}>
                    +
                  </button>
                </div>

                <!-- Form untuk menambahkan notes -->
                <div class="notes-form mb-2">
                  <textarea 
                    id="${notesTextareaId}"
                    class="notes-textarea"
                    placeholder="Tambahkan catatan"
                    ${isOut ? 'disabled' : ''}></textarea>
                </div>

                <button
                  class="btn btn-success w-100 btn-addcart-menu"
                  data-id="${product.id}"
                  data-qty="1"
                  ${isOut ? 'disabled' : ''}>
                  <iconify-icon icon="uil:shopping-cart"></iconify-icon>
                  <span class="d-none d-sm-inline">Tambah</span>
                </button>
              </div>

            </div>
          </div>`;
            });

            menuList.hide().html(html).fadeIn(300);

            // ===============================
            // BIND QTY CONTROL (SAMA SEPERTI reloadProducts)
            // ===============================
            products.forEach(product => {
              const stok = parseInt(product.stock ?? product.stok ?? 0);
              if (stok < 1) return;

              const qtyInput = document.getElementById(`quantity-${product.id}`);
              const minusBtn = document.getElementById(`minus-${product.id}`);
              const plusBtn = document.getElementById(`plus-${product.id}`);

              if (!qtyInput || !minusBtn || !plusBtn) return;

              minusBtn.onclick = () => {
                let val = parseInt(qtyInput.value) || 1;
                val = val > 1 ? val - 1 : 1;
                qtyInput.value = val;
                setValue(product.id, val);
              };

              plusBtn.onclick = () => {
                let val = parseInt(qtyInput.value) || 1;
                val = val < stok ? val + 1 : stok;
                qtyInput.value = val;
                setValue(product.id, val);
              };

              qtyInput.oninput = () => {
                let val = parseInt(qtyInput.value);
                if (isNaN(val) || val < 1) val = 1;
                if (val > stok) val = stok;
                qtyInput.value = val;
                setValue(product.id, val);
              };
            });
          },

          error: function() {
            menuList.hide().html(
              '<div class="col-12 text-center text-danger mt-5">Gagal memuat menu.</div>'
            ).fadeIn(300);
          }
        });
      };

      if (hasContent) {
        menuList.fadeOut(200, performLoad);
      } else {
        performLoad();
      }
    }


    // Load kategori (hanya memanggil loadMenus saat pertama kali)
    function loadCategories() {
      $.get('<?= base_url('api/categories') ?>', function(res) {
        let html = '';
        const categories = res.categories || [];
        if (categories.length > 0) {
          categories.forEach((cat, idx) => {
            const catName = cat.name ?? cat.nama ?? cat.nama_category;
            html += `<a class="list-group-item category-link ${idx === 0 ? 'active' : ''}" data-id="${cat.id}">${catName}</a>`;
          });
          $('#category-list').html(html);

          // Panggil loadMenus untuk kategori pertama
          const firstCat = categories[0];
          loadMenus(firstCat.id, firstCat.name ?? firstCat.nama ?? firstCat.nama_category);
        }
      });
    }

    // Event handler untuk klik kategori (tidak berubah)
    $(document).on('click', '#category-list .category-link', function(e) {
      e.preventDefault();
      if ($(this).hasClass('active')) return;

      $('#category-list .category-link').removeClass('active');
      $(this).addClass('active');

      const id = $(this).data('id');
      const name = $(this).text();
      loadMenus(id, name);
    });

    // Handler tombol tambah ke keranjang (menggunakan SweetAlert2 untuk notifikasi)
    $(document).on('click', '.btn-addcart-menu', function(e) {
      e.preventDefault();
      e.stopPropagation();

      const $btn = $(this);
      if ($btn.data('loading')) return;

      $btn.data('loading', true);

      const productId = $btn.data('id');
      const qty = parseInt($(`#quantity-${productId}`).val()) || 1;
      const notes = $(`#notes-${productId}`).val().trim(); // Ambil nilai notes dari textarea

      $btn
        .prop('disabled', true)
        .data('orig-text', $btn.text())
        .text('Menambah...');

      $.ajax({
          url: '<?= base_url('api') ?>/' + productId + '/addcart',
          method: 'POST',
          data: {
            qty,
            notes // Sertakan notes dalam data yang dikirim
          },
          dataType: 'json'
        })
        .done(function(res) {
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: res.message || 'Berhasil ditambahkan',
            showConfirmButton: false,
            timer: 1400
          });
        })
        .fail(function(xhr) {
          Swal.fire('Gagal', 'Tidak dapat menambahkan ke keranjang', 'error');
        })
        .always(function() {
          $btn.data('loading', false);
          $btn.prop('disabled', false).text($btn.data('orig-text'));
        });
    });

    // Inisialisasi
    loadCategories();
  });
</script>

<?= $this->include('customer/partials/button_navigation_bar') ?>
<?= $this->endSection() ?>