<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "" ?> - Bhinneka Invoices</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">
    <!-- SweetAlert2 Theme -->
    <link rel="stylesheet" href="<?= base_url('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
    <!-- Custom CSS -->
    <?= $this->renderSection('styles') ?>
</head>

<body class="hold-transition <?= $title == 'Login' ? 'login-page' : 'sidebar-mini' ?>">
    <?php if ($title != 'Login') : ?>
        <div class="wrapper">
            <?= $this->include('partials/navbar') ?>
            <?= $this->include('partials/sidebar') ?>
            <div class="content-wrapper">
                <?= $this->renderSection('content-header') ?>

                <section class="content">
                    <div class="container-fluid">
                        <?= $this->renderSection('main-content') ?>
                        
                    </div>
                </section>
            </div>
            <?= $this->include('partials/footer') ?>
        </div>
    <?php endif ?>

    <!-- Login Page -->
    <?php if ($title == 'Login') : ?>
        <?= $this->renderSection('content') ?>
    <?php endif ?>

    <!-- jQuery -->
    <script src="<?= base_url('plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap -->
    <script src="<?= base_url('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE -->
    <script src="<?= base_url('dist/js/adminlte.js') ?>"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url('plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
    <!-- Toastr -->
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
    <!-- Custom Scripts -->
    <?= $this->renderSection('scripts') ?>

</body>

</html>