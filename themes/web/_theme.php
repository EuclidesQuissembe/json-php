<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>JSON - PHP</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= theme('assets/plugins/fontawesome-free/css/all.min.css'); ?>" >
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= theme('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= theme('assets/plugins/toastr/toastr.min.css'); ?>">

    <!-- Include Styles Dynamic -->
    <?= $this->section('styles'); ?>

    <link rel="stylesheet" href="<?= theme('assets/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?= theme('assets/css/custom.css'); ?>">
    <!-- Google Font: Source Sans Pro -->
<!--    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">-->

<!--    <link rel="icon" type="icon/image" href="<?= theme('assets/img/logo.jpg'); ?>"> -->

</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
            <a href="<?= url('/'); ?>" class="navbar-brand">

                <span class="brand-text font-weight-light">Home</span>
            </a>
        </div>
    </nav>
    <!-- /.navbar -->

    <?= $this->section('content'); ?>


<!--    <footer class="main-footer">-->
<!--        -->
<!--        <div class="float-right d-none d-sm-inline">-->
<!---->
<!--        </div>-->
<!---->
<!--        <strong>&copy; 2020 - ENAMI.</strong> Todos Direitos Reservados.-->
<!--    </footer>-->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?= theme('assets/plugins/jquery/jquery.min.js'); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?= theme('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- SweetAlert2 -->
<script src="<?= theme('assets/plugins/sweetalert2/sweetalert2.min.js'); ?>"></script>
<!-- Toastr -->
<script src="<?= theme('assets/plugins/toastr/toastr.min.js'); ?>"></script>
<!-- Scripts -->
<?= $this->section('scripts'); ?>
<!-- AdminLTE App -->
<script src="<?= theme('assets/js/adminlte.min.js'); ?>"></script>
<!-- Custom Scripts -->
<script src="<?= theme('assets/js/custom.js'); ?>"></script>
</body>
</html>
