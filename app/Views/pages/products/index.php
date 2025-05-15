<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">
<?= $this->endsection() ?>

<?= $this->section('content-header') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manage Product</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Product</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?= $this->endsection() ?>

<?= $this->section('main-content') ?>
<div class="card">
    <div class="card-header">
        <button class="btn btn-info btn-add" data-toggle="modal" data-target="#addProductModal">
            <i class="fas fa-plus"></i>
            &nbsp;&nbsp;Tambah Produk
        </button>
    </div>
    <div class="card-body">
        <table id="productTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Produk</th>
                    <th>Unit</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- Modal Tambah Product -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form id="addProductForm" method="POST" action="<?= base_url('product/store') ?>">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Tambah Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="ProductCode" class="form-label">Kode Produk</label>
                        <input type="text" class="form-control" id="ProductCode" name="code" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="ProductName" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="ProductName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="ProductUnit" class="form-label">Satuan Unit</label>
                        <select class="form-control" id="ProductUnit" name="unit" required>
                            <option value="">Pilih Satuan Unit</option>
                            <option value="Pcs">Pcs</option>
                            <option value="Box">Box</option>
                            <option value="Kg">Kg</option>
                            <option value="Dus">Dus</option>
                            <option value="Liter">Liter</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ProductPrice" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="ProductPrice" name="price" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Edit Produk -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form id="editProductForm" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editProductCode" class="form-label">Kode Produk</label>
                        <input type="text" class="form-control" id="editProductCode" name="code" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editProductName" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="editProductName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editProductUnit" class="form-label">Satuan Unit</label>
                        <select class="form-control" id="editProductUnit" name="unit" required>
                            <option value="">Pilih Satuan Unit</option>
                            <option value="Pcs">Pcs</option>
                            <option value="Box">Box</option>
                            <option value="Kg">Kg</option>
                            <option value="Dus">Dus</option>
                            <option value="Liter">Liter</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editProductPrice" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="editProductPrice" name="price" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">Hapus Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus produk ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <form id="deleteForm" action="" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endsection() ?>

<?= $this->section('scripts') ?>
<?php if (session()->getFlashdata('success')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Toast.fire({
                icon: 'success',
                title: '<?= session()->getFlashdata('success') ?>',
            });
        });
    </script>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Toast.fire({
                icon: 'error',
                title: '<?= session()->getFlashdata('error') ?>',
            });
        });
    </script>
<?php endif; ?>
<?php if ($errors = session()->getFlashdata('errors')): ?>
    <script>
        // Display each error message (consider to move to toastr)
        document.addEventListener('DOMContentLoaded', function() {
            <?php foreach ($errors as $error): ?>
                console.log('<?= esc($error) ?>');
                Toast.fire({
                    icon: 'error',
                    title: '<?= esc($error) ?>',
                });
            <?php endforeach; ?>
        });
    </script>
<?php endif; ?>

<script src="<?= base_url('plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>

<script>
    $(function() {
        $('#productTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/product/getProducts',
                type: 'POST',
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'code'
                },
                {
                    data: 'name'
                },
                {
                    data: 'unit'
                },
                {
                    data: 'price',
                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                        <a href="#" class="btn btn-sm btn-warning edit-btn" data-url="/product/update/${row.id}"
                         data-code="${row.code}" data-name="${row.name}" 
                         data-unit="${row.unit}" data-price="${row.price}" 
                         data-toggle="modal" data-target="#editProductModal">
                            <i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" 
                        data-url="/product/destroy/${row.id}" data-toggle="modal" 
                        data-target="#deleteProductModal">
                            <i class="fas fa-trash"></i>&nbsp;&nbsp;Delete
                        </button>
                    `;
                    },
                },
            ],
            order: [
                [0, 'asc']
            ],
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
        });

        // Generate Product Code
        $(document).on('click', '.btn-add', function() {
            $.ajax({
                url: '/product/generateCode',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#ProductCode').val(data.code);
                },
                error: function(xhr, status, error) {
                    console.error('Error generating code:', error);
                }
            });
        });

        // Modal Edit
        $(document).on('click', '.edit-btn', function() {
            const url = $(this).data('url');
            const name = $(this).data('name');
            const code = $(this).data('code');
            const unit = $(this).data('unit');
            const price = $(this).data('price');

            $('#editProductForm').attr('action', url);
            $('#editProductCode').val(code);
            $('#editProductName').val(name);
            $('#editProductUnit').val(unit);
            $('#editProductPrice').val(price);

            $('#editProductModal').modal('show');
        });

        // Modal Delete
        $(document).on('click', '.delete-btn', function() {
            const url = $(this).data('url');
            $('#deleteForm').attr('action', url);
            $('#deleteProductModal').modal('show');
        });
    });
</script>
<?= $this->endsection() ?>