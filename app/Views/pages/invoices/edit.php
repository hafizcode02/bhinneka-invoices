<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url('plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
<?= $this->endsection() ?>

<?= $this->section('content-header') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Invoice</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('invoice') ?>">Invoices</a></li>
                    <li class="breadcrumb-item active">Edit Invoice</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?= $this->endsection() ?>

<?= $this->section('main-content') ?>
<!-- Debug Information -->
<?php if (ENVIRONMENT === 'development'): ?>
    <div class="alert alert-info">
        <h5>Debug Information</h5>
        <p>Items count: <?= count($items) ?></p>
        <pre><?= json_encode($items, JSON_PRETTY_PRINT) ?></pre>
    </div>
<?php endif; ?>
<!-- End Debug Information -->

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Invoice - <?= $invoice['invoice_number'] ?></h3>
    </div>
    <form id="editInvoiceForm" method="POST" action="<?= base_url('invoice/update/' . $invoice['id']) ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="invoiceNumber">No. Invoice</label>
                        <input type="text" class="form-control" id="invoiceNumber" name="invoice_number" value="<?= $invoice['invoice_number'] ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="companyTo">Perusahaan</label>
                        <input type="text" class="form-control" id="companyTo" name="company_to" value="<?= $invoice['company_to'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="companyAddress">Alamat Perusahaan</label>
                        <input type="text" class="form-control" id="companyAddress" name="company_address" value="<?= $invoice['company_address'] ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="attentionTo">Kepada</label>
                        <input type="text" class="form-control" id="attentionTo" name="attention_to" value="<?= $invoice['attention_to'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="staffId">Purchasing Staff</label>
                        <select class="form-control select2bs4" id="staffId" name="staff_id" required>
                            <option value="">Pilih Staff</option>
                            <!-- Staff options will be loaded dynamically -->
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-4 mb-3">
                <h5>Detail Item</h5>
                <div class="table-responsive">
                    <table class="table table-bordered" id="itemsTable">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0;
                            foreach ($items as $item): ?>
                                <tr id="row-<?= $i ?>">
                                    <td>
                                        <input type="hidden" name="items[<?= $i ?>][id]" value="<?= $item['id'] ?>">
                                        <select class="form-control product-select select2bs4" name="items[<?= $i ?>][product_id]" required>
                                            <option value="">Pilih Produk</option>
                                            <!-- Product options will be loaded dynamically -->
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control item-quantity" name="items[<?= $i ?>][quantity]" min="1" value="<?= $item['quantity'] ?>" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control item-price" name="items[<?= $i ?>][price]" value="<?= $item['price'] ?>" readonly>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control item-subtotal" name="items[<?= $i ?>][subtotal]" value="<?= $item['subtotal'] ?>" readonly>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-item" <?= $i === 0 ? 'disabled' : '' ?>>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php $i++;
                            endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <button type="button" class="btn btn-primary btn-sm" id="addItemBtn">
                                        <i class="fas fa-plus"></i> Tambah Item
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                <td>
                                    <input type="number" class="form-control" id="totalAmount" name="total_amount" readonly>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('invoice') ?>" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
<?= $this->endsection() ?>

<?= $this->section('scripts') ?>
<!-- Select2 -->
<script src="<?= base_url('plugins/select2/js/select2.full.min.js') ?>"></script>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        // Load staff and set selected
        loadStaffs();

        // Load products for existing items
        loadExistingProducts();

        // Calculate initial total
        updateTotal();

        // Load Staffs
        function loadStaffs() {
            $.ajax({
                url: '/invoice/getAllStaffs',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let options = '<option value="">Pilih Staff</option>';
                    data.forEach(function(staff) {
                        const selected = staff.id == <?= $invoice['staff_id'] ?> ? 'selected' : '';
                        options += `<option value="${staff.id}" ${selected}>${staff.name}</option>`;
                    });
                    $('#staffId').html(options);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading staffs:', error);
                }
            });
        }

        // Load Products for existing items
        function loadExistingProducts() {
            $.ajax({
                url: '/invoice/getAllProducts',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // For each item row, set the selected product
                    <?php foreach ($items as $idx => $item): ?>

                        let options<?= $idx ?> = '<option value="">Pilih Produk</option>';
                        data.forEach(function(product) {
                            // Use double equals for loose comparison since one might be string and one might be number
                            const selected = product.id == <?= $item['product_id'] ?> ? 'selected' : '';
                            options<?= $idx ?> += `<option value="${product.id}" data-price="${product.price}" ${selected}>${product.name} (${product.code})</option>`;
                        });
                        $(`#row-<?= $idx ?> .product-select`).html(options<?= $idx ?>);

                        // Re-initialize select2
                        $(`#row-<?= $idx ?> .product-select`).select2({
                            theme: 'bootstrap4'
                        });

                        // Make sure subtotals are calculated
                        updateSubtotal($(`#row-<?= $idx ?>`));
                    <?php endforeach; ?>

                    // Update total after all items are loaded
                    updateTotal();
                },
                error: function(xhr, status, error) {
                    console.error('Error loading products:', error);
                    // Show error message to user
                    Toast.fire({
                        icon: 'error',
                        title: 'Error loading products: ' + error,
                    });
                }
            });
        }

        // Handle product selection
        $(document).on('change', '.product-select', function() {
            const row = $(this).closest('tr');
            const selectedOption = $(this).find('option:selected');
            const price = selectedOption.data('price') || 0;

            row.find('.item-price').val(price);
            updateSubtotal(row);
        });

        // Handle quantity change
        $(document).on('change', '.item-quantity', function() {
            const row = $(this).closest('tr');
            updateSubtotal(row);
        });

        // Update subtotal
        function updateSubtotal(row) {
            const quantity = parseInt(row.find('.item-quantity').val()) || 0;
            const price = parseFloat(row.find('.item-price').val()) || 0;
            const subtotal = quantity * price;

            row.find('.item-subtotal').val(subtotal);
            updateTotal();
        }

        // Update total
        function updateTotal() {
            let total = 0;
            $('.item-subtotal').each(function() {
                total += parseFloat($(this).val()) || 0;
            });
            $('#totalAmount').val(total);
        }

        // Add new item row
        let itemCounter = <?= count($items) ?>;
        $('#addItemBtn').click(function() {
            const newRow = `
                <tr id="row-${itemCounter}">
                    <td>
                        <select class="form-control product-select select2bs4" name="items[${itemCounter}][product_id]" required>
                            <option value="">Pilih Produk</option>
                            <!-- Options will be loaded dynamically -->
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control item-quantity" name="items[${itemCounter}][quantity]" min="1" value="1" required>
                    </td>
                    <td>
                        <input type="number" class="form-control item-price" name="items[${itemCounter}][price]" readonly>
                    </td>
                    <td>
                        <input type="number" class="form-control item-subtotal" name="items[${itemCounter}][subtotal]" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#itemsTable tbody').append(newRow);

            // Load products for the new row and initialize select2 immediately
            const $newRow = $(`#row-${itemCounter}`);
            const $select = $newRow.find('.product-select');

            // First initialize select2
            $select.select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih Produk'
            });

            // Then load the data
            $.ajax({
                url: '/invoice/getAllProducts',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let options = '<option value="">Pilih Produk</option>';
                    data.forEach(function(product) {
                        options += `<option value="${product.id}" data-price="${product.price}">${product.name} (${product.code})</option>`;
                    });

                    // Update the options and refresh select2
                    $select.html(options);
                    $select.trigger('change');
                },
                error: function(xhr, status, error) {
                    console.error('Error loading products:', error);
                }
            });

            itemCounter++;
        });

        // Remove item row
        $(document).on('click', '.remove-item', function() {
            $(this).closest('tr').remove();
            updateTotal();
        });
    });
</script>
<?= $this->endsection() ?>