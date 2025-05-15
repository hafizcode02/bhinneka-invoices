<?= $this->extend('layouts/main') ?>

<?= $this->section('content-header') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Akun</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Akun</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<?= $this->endsection() ?>

<?= $this->section('main-content') ?>
<div class="row">
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Data Profile Akun</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?= base_url('profile/update') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="card-body">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="<?= $user['email'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input name="name" type="text" class="form-control" placeholder="Masukan nama"
                            value="<?= $user['name'] ?>">
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['name'])): ?>
                            <small style="color: red;"><?= session()->getFlashdata('errors')['name'] ?></small>
                        <?php endif; ?>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Password</label>
                        <input name="password" type="password" class="form-control" placeholder="Password">
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['password'])): ?>
                            <small style="color: red;"><?= session()->getFlashdata('errors')['password'] ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label>Password Konfirmasi</label>
                        <input name="password_confirmation" type="password" class="form-control"
                            placeholder="Password Konfirmasi">
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['password_confirmation'])): ?>
                            <small style="color: red;"><?= session()->getFlashdata('errors')['password_confirmation'] ?></small>
                        <?php endif; ?>
                    </div>
                    <span class="text-muted float-start">
                        <strong class="text-danger">*</strong> Kosongkan password jika tidak ingin mengubah password
                    </span>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
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
<?= $this->endsection() ?>