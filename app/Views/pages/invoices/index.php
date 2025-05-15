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
                <h1 class="m-0">Manage Invoices</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Invoices</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?= $this->endsection() ?>

<?= $this->section('main-content') ?>
<div class="card">
    <div class="card-header">
        <a href="<?= base_url('invoice/create') ?>" class="btn btn-info">
            <i class="fas fa-plus"></i>
            &nbsp;&nbsp;Buat Invoice
        </a>
    </div>
    <div class="card-body">
        <table id="invoiceTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Invoice</th>
                    <th>Staff</th>
                    <th>Perusahaan</th>
                    <th>Attention</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /.card-body -->
</div>

<!-- Modal Detail Invoice -->
<div class="modal fade" id="viewInvoiceModal" tabindex="-1" aria-labelledby="viewInvoiceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewInvoiceModalLabel">Detail Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="invoiceDetailContent">
                <!-- Invoice details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <a href="#" class="btn btn-primary" id="printInvoiceBtn" target="_blank">
                    <i class="fas fa-print"></i> Print
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteInvoiceModal" tabindex="-1" aria-labelledby="deleteInvoiceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteInvoiceModalLabel">Hapus Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus invoice ini?
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
        // Initialize DataTable
        $('#invoiceTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/invoice/getInvoices',
                type: 'POST',
            },
            columns: [{
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        const pageInfo = $('#invoiceTable').DataTable().page.info();
                        return pageInfo.start + meta.row + 1;
                    }
                },
                {
                    data: 'invoice_number',
                },
                {
                    data: 'staff_name',
                },
                {
                    data: 'company_to',
                },
                {
                    data: 'attention_to',
                },
                {
                    data: 'created_at',
                    render: function(data) {
                        return new Date(data).toLocaleDateString('id-ID');
                    }
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                        <a href="#" class="btn btn-sm btn-info view-btn" data-id="${row.id}" 
                         data-toggle="modal" data-target="#viewInvoiceModal">
                            <i class="fas fa-eye"></i>&nbsp;&nbsp;Detail
                        </a>
                        <a href="/invoice/edit/${row.id}" class="btn btn-sm btn-warning">
                            <i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" 
                        data-url="/invoice/destroy/${row.id}" data-toggle="modal" 
                        data-target="#deleteInvoiceModal">
                            <i class="fas fa-trash"></i>&nbsp;&nbsp;Delete
                        </button>
                    `;
                    },
                },
            ],
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
        });

        // View Invoice Details
        $(document).on('click', '.view-btn', function() {
            const invoiceId = $(this).data('id');

            $.ajax({
                url: `/invoice/detail/${invoiceId}`,
                type: 'GET',
                success: function(response) {
                    $('#invoiceDetailContent').html(response);
                    $('#printInvoiceBtn').attr('href', `/invoice/print/${invoiceId}`);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading invoice details:', error);
                }
            });
        });

        // Modal Delete
        $(document).on('click', '.delete-btn', function() {
            const url = $(this).data('url');
            $('#deleteForm').attr('action', url);
        });
    });
</script>
<?= $this->endsection() ?>