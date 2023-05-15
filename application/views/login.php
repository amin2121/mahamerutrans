<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title>Login Absensi SMK</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url('') ?>assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('') ?>assets//plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="<?= base_url('') ?>assets/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('') ?>assets/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="<?= base_url('') ?>assets/css/colors/default.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <section id="wrapper" class="login-register" style="background:url(<?= base_url() ?>assets/bg-7.png) center center/cover no-repeat !important;">
        <div class="login-box" style="margin: 5% auto 0;  background: none;">
            <div style="width: 80px; margin: 15px auto;">
                <img src="<?= base_url('assets/logo-smk-mulu.png') ?>" alt="<?= base_url('assets/logo-smk.png') ?>" style="width: 100%; height: auto;">
            </div>
            <div class="white-box">
                <form class="form-horizontal form-material" action="<?= base_url('auth/action_login/') ?>" method="POST">
                    <h3 class="box-title" style="margin: 0 !important;">Login </h3>
                    <p class="m-b-20" style="color: #cbcbcb;">Selamat Datang, Silahkan Login Terlebih Dahulu</p>
                    <?php if ($this->session->userdata('message') != ''): ?>
                        <div class="alert alert-<?= $this->session->userdata('status') ?> alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?= $this->session->userdata('message') ?> 
                        </div>
                    <?php endif ?>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="username" required="" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" required="" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                    <p class="text-center">Menuju Ke Halaman</p>
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="<?= base_url('landing/absen_siswa') ?>" class="btn btn-outline-primary btn-block text-uppercase waves-effect waves-light" target="_blank">Absensi Siswa</a>
                        </div>
                        <div class="col-sm-6">
                            <a href="<?= base_url('landing/absen_pegawai') ?>" class="btn btn-outline-success btn-block text-uppercase waves-effect waves-light" target="_blank">Absensi Pegawai</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- jQuery -->
    <script src="<?= base_url('') ?>assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?= base_url('') ?>assets/bootstrap/dist/js/tether.min.js"></script>
    <script src="<?= base_url('') ?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url('') ?>assets/plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="<?= base_url('') ?>assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="<?= base_url('') ?>assets/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?= base_url('') ?>assets/js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?= base_url('') ?>assets/js/custom.min.js"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="<?= base_url('') ?>assets/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="<?= base_url('') ?>assets/plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>
    <!--Style Switcher -->
    <script src="<?= base_url('') ?>assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>
