<?= $this->extend('Customer/template/index.php') ?>
<?= $this->section('app') ?>

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

  .btn-addcart {
    background-color: var(--coffee-brown);
    color: var(--white-text);
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 0.8rem;
  }

  .btn-addcart:hover {
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

  .stok-habis-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,.6);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  border-radius: 8px;
}

.img-grayscale {
  filter: grayscale(100%);
}

.product-item {
  border: 1px solid #eee;
  border-radius: 12px;
  padding: 10px;
}

/* Tambahan CSS untuk textarea note */
.product-note {
  height: 60px;
  resize: none;
  font-size: 0.8rem;
}

</style>

<section class="hero-section">
  <div class="hero-content">
    <h1>Nikmati Cita Rasa Kopi Sempurna</h1>
    <p class="mx-auto">Diramu dengan kasih dari biji kopi terbaik dunia. Awali hari istimewamu di sini.</p>
    <a href="#menu" class="cta-button mt-4 d-inline-block">Cek Menu</a>
  </div>
</section>

<section class="about-section text-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <h2 class="section-title">Our Story</h2>
        <p class="mt-4">Kami percaya bahwa secangkir kopi adalah sebuah seni. Dimulai dari biji kopi pilihan yang dipanen oleh petani lokal terbaik, hingga proses roasting yang teliti oleh para ahli kami. Setiap tegukan adalah cerita tentang dedikasi dan cinta kami pada kopi.</p>
      </div>
    </div>
  </div>
</section>


<section id="menu" class="menu-section">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="section-header text-center">
          <h2 class="section-title">Our Signature Menu</h2>
        </div>
      </div>
    </div>

    <div class="row justify-content-center mb-5 px-3">
      <div class="col-lg-10">
        <div class="categories-container row g-3"></div>
      </div>
    </div>

    <div>
      <div id="products-section" class="products-container row">
      </div>
    </div>
  </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // JavaScript Anda tidak perlu diubah, karena sudah berfungsi dengan baik.
  // Cukup salin-tempel semua kode JS yang Anda miliki sebelumnya ke sini.

  $(function() {
    // ... (SELURUH KODE JAVASCRIPT ANDA DARI AWAL)
    function formatRupiah(angka) {
      return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
      }).format(angka);
    }

    function setValue(id, val) {
      const btn = document.querySelector(`.btn-addcart[data-id="${id}"]`);
      if (btn) btn.setAttribute('data-qty', String(val));
    }

    function reloadProducts(category = null) {
      $.ajax({
        url: BASE_URL + 'api/products',
        method: 'GET',
        dataType: 'json',
        data: {
          category
        },
        success: function(data) {
          const contentParent = $('.products-container');
          let html = "";

          if (data.products?.length) {
            data.products.forEach(product => {
              const qtyInputId = `quantity-${product.id}`;
              const minusBtnId = `minus-${product.id}`;
              const plusBtnId = `plus-${product.id}`;
              const noteTextareaId = `note-${product.id}`;

              // PERHATIKAN STRUKTUR HTML BARU UNTUK KARTU PRODUK
              html += `
                <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                  <div class="product-item ${product.stock == 0 ? 'out-of-stock' : ''} d-flex flex-column">
                    
                    <a href="${BASE_URL}product/${product.id}" class="text-decoration-none text-dark">
                        <img 
                          src="${BASE_URL}uploads/products/${product.image}" 
                          class="img-fluid rounded ${product.stock == 0 ? 'img-grayscale' : ''}" 
                          alt="${product.name}"
                        >
                        ${product.stock == 0 ? `<div class="stok-habis-overlay">Stok Habis</div>` : ''}

                      <div class="product-info text-center px-1">
                        <h6 class="mb-1 text-truncate">${product.name}</h6>
                        <span class="price fw-bold">${formatRupiah(product.price)}</span>
                      </div>
                    </a>

                    <div class="mt-2">
                      <div class="d-flex flex-column gap-2">

                        <div class="input-group input-group-sm justify-content-center">
                          <button 
                            type="button" 
                            id="${minusBtnId}" 
                            class="btn btn-outline-danger btn-number"
                            data-type="minus" 
                            data-id="${product.id}" 
                            ${product.stock == 0 ? 'disabled' : ''}
                          >
                            −
                          </button>

                          <input 
                            type="number" 
                            id="${qtyInputId}" 
                            class="form-control text-center"
                            value="1" 
                            min="1" 
                            max="${product.stock}"
                            ${product.stock == 0 ? 'disabled' : ''}
                          >

                          <button 
                            type="button" 
                            id="${plusBtnId}" 
                            class="btn btn-outline-success btn-number"
                            data-type="plus" 
                            data-id="${product.id}" 
                            ${product.stock == 0 ? 'disabled' : ''}
                          >
                            +
                          </button>
                        </div>

                        <textarea 
                          id="${noteTextareaId}" 
                          class="form-control product-note" 
                          placeholder="Catatan (opsional)" 
                          ${product.stock == 0 ? 'disabled' : ''}
                        ></textarea>

                        <button 
                          class="btn btn-primary w-100 btn-addcart"
                          data-id="${product.id}" 
                          data-qty="1"
                          ${product.stock == 0 ? 'disabled' : ''}
                        >
                          <iconify-icon icon="uil:shopping-cart"></iconify-icon>
                          <span class="ms-1">Tambah</span>
                        </button>

                      </div>
                    </div>

                  </div>
                </div>
                `;
            });
          } else {
            html = '<p class="text-center col-12">Produk tidak ditemukan.</p>';
          }

          contentParent.html(html);

          // Bind qty controls
          (data.products || []).forEach(product => {
            if (product.stock == 0) return;
            const qtyInput = document.getElementById(`quantity-${product.id}`);
            const minusBtn = document.getElementById(`minus-${product.id}`);
            const plusBtn = document.getElementById(`plus-${product.id}`);
            const maxStock = parseInt(product.stock);

            minusBtn?.addEventListener('click', () => {
              let val = parseInt(qtyInput.value) || 1;
              qtyInput.value = val > 1 ? val - 1 : 1;
              setValue(product.id, qtyInput.value);
            });

            plusBtn?.addEventListener('click', () => {
              let val = parseInt(qtyInput.value) || 1;
              qtyInput.value = val < maxStock ? val + 1 : maxStock;
              setValue(product.id, qtyInput.value);
            });

            qtyInput?.addEventListener('input', () => {
              let val = parseInt(qtyInput.value);
              if (isNaN(val) || val < 1) val = 1;
              if (val > maxStock) val = maxStock;
              qtyInput.value = val;
              setValue(product.id, val);
            });
          });
        }
      });
    }

    function getBanners() {
      /* Kosongkan atau sesuaikan jika masih perlu */
    }

    function getCategories() {
      $.ajax({
        url: BASE_URL + 'api/categories',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
          const contentParent = $('.categories-container');
          let html = "";

          (data.categories || []).forEach(category => {
            // PERHATIKAN STRUKTUR HTML BARU UNTUK KATEGORI
            html += `
            <div class="col-4 col-md-3 col-lg-2">
              <button data-id="${category.id}" class="category-item nav-link w-100">
                <img src="${BASE_URL}uploads/category/${category.image}" alt="${category.nama_category}" class="category-image">
                <h3 class="category-title">${category.nama_category}</h3>
              </button>
            </div>`;
          });

          contentParent.html(html);
        }
      });
    }

    // Delegasi klik kategori
    $(document).on('click', '.category-item', function(e) {
      e.preventDefault();
      $('.category-item').removeClass('active-category');
      $(this).addClass('active-category');

      const id = $(this).data('id');
      reloadProducts(id || null);

      // Scroll ke menu, bukan ke section
      document.getElementById('menu')?.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    });

    // Inisialisasi awal
    getCategories();
    reloadProducts();
  });
</script>

<?= $this->include('customer/partials/button_navigation_bar') ?>

<?= $this->endSection() ?>