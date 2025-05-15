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
                <h1 class="m-0">Manage Purchasing Staff</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Staff</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?= $this->endsection() ?>

<?= $this->section('main-content') ?>
<div class="card">
    <div class="card-header">
        <button class="btn btn-info btn-add" data-toggle="modal" data-target="#addStaffModal">
            <i class="fas fa-plus"></i>
            &nbsp;&nbsp;Tambah Staff
        </button>
    </div>
    <div class="card-body">
        <table id="staffTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>No.HP</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- Modal Tambah Staff -->
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addStaffForm" method="POST" action="<?= base_url('staff/store') ?>">
            <?= csrf_field() ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStaffModalLabel">Tambah Staff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="StaffName" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="StaffName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="StaffEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="StaffEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="StaffGender" class="form-label">Jenis Kelamin</label>
                        <select class="form-control" id="StaffGender" name="gender" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="StaffPhone" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="StaffPhone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="StaffAddress" class="form-label">Alamat</label>
                        <textarea class="form-control" id="StaffAddress" name="address" rows="3" required></textarea>
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

<!-- Modal Edit Staff -->
<div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editStaffForm" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStaffModalLabel">Edit Staff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editStaffName" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="editStaffName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStaffEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editStaffEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStaffGender" class="form-label">Jenis Kelamin</label>
                        <select class="form-control" id="editStaffGender" name="gender" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editStaffPhone" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="editStaffPhone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStaffAddress" class="form-label">Alamat</label>
                        <textarea class="form-control" id="editStaffAddress" name="address" rows="3" required></textarea>
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
<div class="modal fade" id="deleteStaffModal" tabindex="-1" aria-labelledby="deleteStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteStaffModalLabel">Hapus Staff</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus staff ini?
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
        $('#staffTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/staff/getStaffList',
                type: 'POST',
                dataSrc: function(json) {
                    return json.data.data;
                }
            },
            columns: [{
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        const pageInfo = $('#staffTable').DataTable().page.info();
                        return pageInfo.start + meta.row + 1;
                    }
                },
                {
                    data: 'name',
                },
                {
                    data: 'email',
                },
                {
                    data: 'gender',
                },
                {
                    data: 'phone',
                },
                {
                    data: 'address',
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                        <a href="#" class="btn btn-sm btn-warning edit-btn" data-url="/staff/update/${row.id}"
                         data-name="${row.name}" data-email="${row.email}" 
                         data-gender="${row.gender}" data-phone="${row.phone}" 
                         data-address="${row.address}" data-toggle="modal" 
                         data-target="#editStaffModal">
                            <i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" 
                        data-url="/staff/destroy/${row.id}" data-toggle="modal" 
                        data-target="#deleteStaffModal">
                            <i class="fas fa-trash"></i>&nbsp;&nbsp;Delete
                        </button>
                    `;
                    },
                },
            ],
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
        });

        // Modal Edit
        $(document).on('click', '.edit-btn', function() {
            const url = $(this).data('url');
            const name = $(this).data('name');
            const email = $(this).data('email');
            const gender = $(this).data('gender');
            const phone = $(this).data('phone');
            const address = $(this).data('address');
            $('#editStaffForm').attr('action', url);
            $('#editStaffName').val(name);
            $('#editStaffEmail').val(email);
            $('#editStaffGender').val(gender);
            $('#editStaffPhone').val(phone);
            $('#editStaffAddress').val(address);
            $('#editStaffModal').modal('show');
        });

        // Modal Delete
        $(document).on('click', '.delete-btn', function() {
            const url = $(this).data('url');
            $('#deleteForm').attr('action', url);
            $('#deleteStaffModal').modal('show');
        });
    });
</script>
<?= $this->endsection() ?>