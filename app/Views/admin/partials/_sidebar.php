<?php
$role = session()->get('role');
?>
<aside class="left-sidebar">
  <!-- Sidebar scroll -->
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="<?= base_url() ?>" class="text-nowrap logo-img">
        <img src="<?= base_url('static/images/logo/favicon.jpg') ?>" alt="Logo" style="width:70px;height:70px;" class="rounded-circle" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-6"></i>
      </div>
    </div>

    <!-- Sidebar navigation -->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">

        <li class="nav-small-cap">
          <span class="hide-menu">Menu Utama</span>
        </li>

        <!-- Dashboard -->
        <?php if ($role === 'pemilik' || $role === 'admin'): ?>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= base_url('admin') ?>">
            <i class="ti ti-home"></i>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= base_url('admin/category-product') ?>">
            <i class="ti ti-category"></i>
            <span class="hide-menu">Kategori Produk</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= base_url('admin/products') ?>">
            <i class="ti ti-box"></i>
            <span class="hide-menu">Manajemen Produk</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= base_url('admin/tables') ?>">
            <i class="ti ti-table"></i>
            <span class="hide-menu">Manajemen Meja</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= base_url('admin/reviews') ?>">
            <i class="ti ti-star"></i>
            <span class="hide-menu">Review Management</span>
          </a>
        </li>
        <?php endif; ?>

        <!-- Manajemen Pesanan -->
        <?php if (in_array($role, ['pemilik', 'admin', 'dapur'])): ?>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= base_url('admin/orders') ?>">
            <i class="ti ti-shopping-cart"></i>
            <span class="hide-menu">Manajemen Pesanan</span>
          </a>
        </li>
        <?php endif; ?>

        <?php if ($role === 'dapur'): ?>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= base_url('admin/orders/riwayat') ?>">
            <i class="ti ti-history"></i>
            <span class="hide-menu">Riwayat Pesanan</span>
          </a>
        </li>
        <?php endif; ?>

        <!-- Manajemen Keuangan -->
        <?php if (in_array($role, ['pemilik', 'admin'])): ?>
        <li class="sidebar-item">
          <a class="sidebar-link justify-content-between has-arrow" href="javascript:void(0)" aria-expanded="false">
            <div class="d-flex align-items-center gap-3">
                <span class="d-flex">
                <i class="ti ti-cash"></i>
                </span>
                <span class="hide-menu">Manajemen Kas</span>
            </div>
          </a>
          <ul aria-expanded="false" class="collapse first-level">
            <li class="sidebar-item">
              <a class="sidebar-link justify-content-between" href="<?= base_url('admin/keuangan/dana_kas') ?>">
                <div class="d-flex align-items-center gap-3">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                    <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Dana Kas</span>
                </div>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link justify-content-between" href="<?= base_url('admin/keuangan/dana_masuk') ?>">
                <div class="d-flex align-items-center gap-3">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                    <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Dana Masuk</span>
                </div>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link justify-content-between" href="<?= base_url('admin/keuangan/dana_keluar') ?>">
                <div class="d-flex align-items-center gap-3">
                    <div class="round-16 d-flex align-items-center justify-content-center">
                    <i class="ti ti-circle"></i>
                    </div>
                    <span class="hide-menu">Dana Keluar</span>
                </div>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>

        <!-- Manajemen Pengguna -->
        <?php if ($role === 'pemilik'): ?>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= base_url('admin/users') ?>">
            <i class="ti ti-users"></i>
            <span class="hide-menu">Manajemen Pengguna</span>
          </a>
        </li>
        <?php endif; ?>

        <!-- Pengaturan -->
        <?php if ($role === 'pemilik' || $role === 'admin'): ?>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= base_url('admin/setting/payment') ?>">
            <i class="ti ti-settings"></i>
            <span class="hide-menu">Pengaturan</span>
          </a>
        </li>
        <?php endif; ?>

        <!-- Akun Saya -->
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= base_url('admin/my-account') ?>">
            <i class="ti ti-user-circle"></i>
            <span class="hide-menu">Akun Saya</span>
          </a>
        </li>

        <!-- Logout -->
        <li class="sidebar-item">
          <form action="<?= base_url('admin/auth/logout') ?>" method="POST" id="logoutForm">
            <?= csrf_field() ?>
            <button id="btnLogout" type="button" class="sidebar-link bg-transparent border-0 w-100 text-start">
              <i class="ti ti-logout"></i>
              <span class="hide-menu">Logout</span>
            </button>
          </form>
        </li>

      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll -->
</aside>

<!-- SweetAlert untuk konfirmasi logout -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('btnLogout').addEventListener('click', function(e) {
  e.preventDefault();
  Swal.fire({
    title: 'Konfirmasi Logout',
    text: 'Apakah Anda yakin ingin keluar?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Logout',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('logoutForm').submit();
    }
  });
});
</script>
