<?= $this->extend('customer/template/index.php') ?>
<?= $this->section('app') ?>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
          <h3 class="mb-4 fw-bold text-center">
            <iconify-icon icon="uil:shopping-cart" width="28"></iconify-icon> Keranjang Belanja
          </h3>

          <div id="cart-empty" class="text-center text-muted py-5" style="display:none;">
            <iconify-icon icon="mdi:cart-off" width="48"></iconify-icon>
            <div class="mt-2">Keranjang masih kosong.</div>
            <a href="<?= base_url('menu') ?>" class="btn btn-outline-success mt-3">Lihat Menu</a>
          </div>

          <div id="cart-items-wrap" style="display:none;">
            <ul id="cart-items" class="list-group list-group-flush mb-3"></ul>
          </div>

        </div>
      </div>

      <div class="card shadow-sm border-0" id="cart-summary" style="display:none;">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div class="fw-bold">Total</div>
          <div class="text-success fw-bold fs-5" id="cart-total">Rp0</div>
        </div>
        <div class="card-body">
          <button class="btn btn-success w-100" id="btn-checkout">Checkout</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.iconify.design/3/3.1.1/iconify.min.js"></script>
<script>
const id = <?= session('session')['table_id'] ?? '0' ?>;
function formatRupiah(angka) {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
}

function updateCartBadgeFromApi() {
  $.get(`<?= base_url() ?>api/${id}/getcart`, function(r){
    const items = r.carts || [];
    const totalQty = items.reduce((s, it) => s + (parseInt(it.qty) || 0), 0);
    $('#countcart').text(totalQty).toggle(!!totalQty);
    $('.cart-badge-count').text(totalQty).toggle(!!totalQty);
  }).fail(()=>{/* silent */});
}

function loadCart() {
  $.get(`<?= base_url() ?>api/${id}/getcart`, function(res){
    const items = res.carts || [];
    const $list = $('#cart-items');
    $list.empty();

    if (!items.length) {
      $('#cart-items-wrap').hide();
      $('#cart-summary').hide();
      $('#cart-empty').show();
      updateCartBadgeFromApi();
      return;
    }

    $('#cart-empty').hide();
    $('#cart-items-wrap').show();
    $('#cart-summary').show();

    // compute total: prefer res.carts[0].total if provided, else sum subtotals
    let total = 0;
    if (items.length && typeof items[0].total !== 'undefined' && items[0].total !== null && items[0].total !== '') {
      total = parseFloat(items[0].total) || 0;
    } else {
      items.forEach(it => total += parseFloat(it.subtotal || 0));
    }

    // render each item
    items.forEach(it => {
      // prefer items_id (cart item id) else id else product_id
      const itemId = it.items_id ?? it.id ?? it.product_id;
      const qty = parseInt(it.qty) || 0;
      const subtotal = parseFloat(it.subtotal) || 0;
      const name = it.name ?? it.nama ?? 'Produk';
      const pricePer = qty ? (subtotal / qty) : 0;
      const notes = it.notes ?? '';

      const $li = $(`
        <li class="list-group-item d-flex align-items-center justify-content-between py-3">
          <div class="flex-grow-1">
            <div class="fw-semibold">${name}</div>
            <div class="small text-muted">Qty: ${qty} x ${formatRupiah(pricePer)}</div>
            <div class="small text-muted notes-display" data-notes="${notes}">Notes: ${notes || 'Tidak ada'}</div>
          </div>
          <div class="d-flex align-items-center gap-2">
            <div class="fw-bold text-success">${formatRupiah(subtotal)}</div>
            <button class="btn btn-sm btn-outline-primary btn-edit-notes" data-id="${itemId}" data-notes="${notes}" title="Edit Notes">
              <iconify-icon icon="mdi:pencil"></iconify-icon>
            </button>
            <button class="btn btn-sm btn-outline-danger btn-del-item" data-id="${itemId}" title="Hapus">
              <iconify-icon icon="mdi:trash-can-outline"></iconify-icon>
            </button>
          </div>
        </li>
      `);
      $list.append($li);
    });

    $('#cart-total').text(formatRupiah(total));

    // update badge
    const totalQty = items.reduce((s, it) => s + (parseInt(it.qty) || 0), 0);
    $('#countcart').text(totalQty).toggle(!!totalQty);
    $('.cart-badge-count').text(totalQty).toggle(!!totalQty);
  }).fail(function(xhr){
    console.error('getcart error', xhr);
    $('#cart-items-wrap').hide();
    $('#cart-summary').hide();
    $('#cart-empty').show();
  });
}

// Delete handler — sends items_id to delete endpoint and refreshes view
$(document).on('click', '.btn-del-item', function(e){
  e.preventDefault();
  const id = $(this).data('id');
  if (!id) {
    return Swal.fire('Error','ID item tidak tersedia','error');
  }

  Swal.fire({
    title: 'Hapus item?',
    text: 'Item akan dihapus dari keranjang.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Hapus',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#d33'
  }).then(result => {
    if (!result.isConfirmed) return;

    $.ajax({
      url: '<?= base_url('api') ?>/' + id + '/deleteitem',
      method: 'POST',
      dataType: 'json'
    }).done(function(res, textStatus, jqXHR){
      // toleran terhadap berbagai response shape
      const ok = res && (res.success === true || res.deleted === true || res.status === 'OK' || res.status === 'Ok' || res.status === 'ok' || typeof res.cart_count !== 'undefined' || Array.isArray(res.carts));
      if (ok || jqXHR.status === 200) {
        const msg = (res && res.message) ? res.message : 'Item berhasil dihapus';
        Swal.fire({ toast:true, position:'top-end', icon:'success', title: msg, showConfirmButton:false, timer:1200, timerProgressBar:true });
        loadCart();
        updateCartBadgeFromApi();
      } else {
        const err = (res && (res.message || res.error)) ? (res.message || res.error) : 'Gagal menghapus item';
        Swal.fire('Gagal', err, 'error');
      }
    }).fail(function(xhr){
      const msg = xhr && xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan server';
      Swal.fire('Gagal', msg, 'error');
    });
  });
});

// Checkout
$(document).on('click', '#btn-checkout', function(){
  window.location.href = '<?= base_url('checkout') ?>';
});

// Tambahkan modal untuk edit notes
$(document).on('click', '.btn-edit-notes', function(e){
  e.preventDefault();
  const itemId = $(this).data('id');
  const currentNotes = $(this).data('notes');

  Swal.fire({
    title: 'Edit Catatan',
    input: 'textarea',
    inputValue: currentNotes,
    inputPlaceholder: 'Tambahkan catatan untuk item ini...',
    showCancelButton: true,
    confirmButtonText: 'Simpan',
    cancelButtonText: 'Batal',
    inputValidator: (value) => {
      // Optional validation
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const newNotes = result.value;
      $.ajax({
        url: '<?= base_url('api') ?>/updatecartitem/' + itemId,
        method: 'POST',
        data: { notes: newNotes },
        dataType: 'json'
      }).done(function(res){
        if (res.status === 'OK') {
          Swal.fire({ toast:true, position:'top-end', icon:'success', title: 'Notes berhasil diupdate', showConfirmButton:false, timer:1200 });
          loadCart(); // Reload cart to show updated notes
        } else {
          Swal.fire('Gagal', res.message || 'Gagal update notes', 'error');
        }
      }).fail(function(xhr){
        const msg = xhr.responseJSON?.message || 'Terjadi kesalahan';
        Swal.fire('Gagal', msg, 'error');
      });
    }
  });
});

// Init
$(function(){ loadCart(); });
</script>

<style>
#cart-items .list-group-item { border: none; border-bottom: 1px solid #f0f0f0; background: transparent; }
#cart-items .btn-del-item { padding: 4px 8px; }
#cart-summary { border-top: 2px solid #e0e0e0; }
</style>

<?= $this->include('customer/partials/button_navigation_bar') ?>
<?= $this->endSection() ?>