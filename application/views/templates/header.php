<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/logo-smk-mulu.png">
    <title>Absensi SMK</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url() ?>assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="<?= base_url() ?>assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!--alerts CSS -->
    <link href="<?= base_url() ?>assets/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- Animation CSS -->
    <link href="<?= base_url() ?>assets/css/animate.css" rel="stylesheet">
    <!-- Popup CSS -->
    <link href="<?= base_url() ?>assets/plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/plugins/bower_components/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bower_components/dropify/dist/css/dropify.min.css">
    <link href="<?= base_url() ?>assets/plugins/bower_components/custom-select/custom-select.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/plugins/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- color CSS you can use different color css from css/colors folder -->
    <!-- We have chosen the skin-blue (blue.css) for this starter
          page. However, you can choose any other skin from folder css / colors .
-->
    <link href="<?= base_url() ?>assets/css/colors/purple.css" id="theme" rel="stylesheet">
    <script src="<?= base_url() ?>assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="<?= base_url() ?>assets/plugins/bower_components/raphael/raphael-min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bower_components/morrisjs/morris.js"></script>
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
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>

                <div class="top-left-part" style="background: white !important; color: black !important;">
                    <a class="logo" href="<?= base_url('dashboard') ?>"><b><img src="<?= base_url() ?>assets/plugins/images/eliteadmin-logo-dark.png" alt="home" /></b>
                        <span class="hidden-xs" style="color: black !important;">
                            <strong>Absensi</strong>MULU
                        </span>
                    </a>
                </div>

                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li>
                        <a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-arrow-left-circle ti-menu"></i></a>
                    </li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="<?= base_url() ?>assets/no-profile.png" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?= $this->session->userdata('username') ?></b> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li><a href="javascript:void(0)" onclick="show_logout()"><i class="fa fa-power-off"></i>  Logout</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    <li class="user-pro">
                        <a href="javascript:;" class="waves-effect"><img src="<?= base_url() ?>assets/no-profile.png" alt="user-img" class="img-circle"> <span class="hide-menu"><?= $this->session->userdata('username') ?><span class="fa arrow"></span></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?= base_url('landing/absen_siswa') ?>" target="_blank"><i class="fa fa-graduation-cap"></i>  Absensi Siswa</a></li>
                            <li><a href="<?= base_url('landing/absen_pegawai') ?>" target="_blank"><i class="fa fa-user"></i>  Absensi Pegawai</a></li>
                            <li><a href="javascript:void(0)" onclick="show_logout()"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                    </li>
                    <li class="nav-small-cap m-t-10">--- Main Menu</li>
                    <li> <a href="<?= base_url('dashboard') ?>" class="waves-effect <?= $this->uri->segment(2) == 'dashboard' ? 'active' : '' ?>"><i class="ti-dashboard p-r-10"></i> <span class="hide-menu">Dashboard</span></a> </li>
                    <li>
                        <a href="javascript:;" class="waves-effect <?= $this->uri->segment(1) == 'kesiswaan' ? 'active' : '' ?>"><i class="ti-bookmark-alt p-r-10"></i>
                            <span class="hide-menu">Kesiswaan<span class="fa arrow"></span>  </span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?= base_url('kesiswaan/aturan_jam_siswa/') ?>"><i class="ti-time p-r-10"></i>  Aturan Jam Siswa</a></li>
                            <li><a href="<?= base_url('kesiswaan/ijin_siswa/') ?>"><i class="ti-pencil-alt p-r-10"></i>  Ijin Siswa</a></li>
                            <li><a href="<?= base_url('kesiswaan/kelas/') ?>"><i class="ti-agenda p-r-10"></i>  Kelas</a></li>
                            <li><a href="<?= base_url('kesiswaan/pindah_kelas/') ?>"><i class="ti-direction-alt p-r-10"></i>  Pindah Kelas</a></li>
                            <li><a href="<?= base_url('kesiswaan/siswa/') ?>"><i class="ti-user p-r-10"></i>  Siswa</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="waves-effect <?= $this->uri->segment(1) == 'kepegawaian' ? 'active' : '' ?>"><i class="ti-bookmark-alt p-r-10"></i>
                            <span class="hide-menu">Kepegawaian<span class="fa arrow"></span>  </span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?= base_url('kepegawaian/aturan_jam_pegawai/') ?>"><i class="ti-time p-r-10"></i>  Aturan Jam Pegawai</a></li>
                            <li><a href="<?= base_url('kepegawaian/ijin_pegawai/') ?>"><i class="ti-pencil-alt p-r-10"></i>  Ijin Pegawai</a></li>
                            <li><a href="<?= base_url('kepegawaian/jabatan/') ?>"><i class="ti-medall-alt p-r-10"></i>  Jabatan</a></li>
                            <li><a href="<?= base_url('kepegawaian/pegawai/') ?>"><i class="ti-user p-r-10"></i>  Pegawai</a></li>
                        </ul>
                    </li>
                    <li> <a href="forms.html" class="waves-effect <?= $this->uri->segment(1) == 'absensi' ? 'active' : '' ?>"><i data-icon="&#xe01a;" class="linea-icon linea-basic fa-fw"></i> <span class="hide-menu">Absensi<span class="fa arrow"></span> </span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?= base_url('absensi/presensi_pegawai/') ?>"><i class="ti-alarm-clock p-r-10"></i>  Presensi Pegawai</a></li>
                            <li><a href="<?= base_url('absensi/presensi_siswa/') ?>"><i class="ti-alarm-clock p-r-10"></i>  Presensi Siswa</a></li>
                        </ul>
                    </li>
                    <li> <a href="forms.html" class="waves-effect <?= $this->uri->segment(1) == 'laporan' ? 'active' : '' ?>"><i class="ti-files p-r-10"></i> <span class="hide-menu">Laporan<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?= base_url('laporan/laporan_rekap_absensi_siswa/') ?>"><i class="ti-file p-r-10"></i>  Rekap Absensi Siswa </a></li>
                            <li><a href="<?= base_url('laporan/laporan_rekap_absensi_pegawai/') ?>"><i class="ti-file p-r-10"></i>  Rekap Absensi Pegawai</a></li>
                            <li><a href="<?= base_url('laporan/laporan_rekap_ijin_pegawai/') ?>"><i class="ti-file p-r-10"></i>  Rekap Ijin Pegawai</a></li>
                            <li><a href="<?= base_url('laporan/laporan_rekap_ijin_siswa/') ?>"><i class="ti-file p-r-10"></i>  Rekap Ijin Siswa</a></li>
                        </ul>
                    </li>
                    <li> <a href="forms.html" class="waves-effect <?= $this->uri->segment(1) == 'setting' ? 'active' : '' ?>"><i class="ti-settings p-r-10"></i> <span class="hide-menu">Setting<span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?= base_url('setting/login/') ?>"><i class="ti-user p-r-10"></i>  Login</a></li>
                            <li><a href="<?= base_url('setting/background/') ?>"><i class="ti-image p-r-10"></i>  Background</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">

<script>
    function show_logout() {
        swal({
            title: "Apakah Anda Yakin?",
            text: "Ingin Keluar Dari Dashboard",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Iya, Saya keluar",
            closeOnConfirm: false
        }, function(){
                $(".confirm").attr('disabled', 'disabled');
                window.location.href = '<?= base_url('auth/logout') ?>'
        });
    }
</script>
