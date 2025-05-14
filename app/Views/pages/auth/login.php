<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <img src="<?= base_url('logo-bhisa-landscape.webp') ?>" alt="Logo" width="150px" height="100px" style="object-fit:contain">
            <h2><b>Bhinneka</b> Invoices</h2>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Login untuk memulai</p>

            <form action="<?= base_url('/login') ?>" method="post">
                <?= csrf_field() ?>

                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="<?= old('email') ?>" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>

                    <?php if (isset(session()->getFlashdata('validation')['email'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('validation')['email'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" value="<?= old('password') ?>" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>

                    <?php if (isset(session()->getFlashdata('validation')['password'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('validation')['password'] ?></small>
                    <?php endif; ?>
                </div>
                <?php if (session()->getFlashdata('error')): ?>
                    <p class="text-danger">
                        <?= session()->getFlashdata('error') ?>
                    </p>
                <?php endif; ?>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
</div>
<?= $this->endsection() ?>