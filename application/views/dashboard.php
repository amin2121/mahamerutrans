<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Dashboard</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="fa fa-home"></i></a></li>
                <li class="active">Dashboard</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!--row -->
    <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
            <div class="white-box">
                <h3 class="box-title">Presensi Siswa Hari Ini | <?= date('d-m-Y') ?></h3>
                <ul class="list-inline text-center">
                    <li>
                        <h5><i class="fa fa-circle m-r-5" style="color: #00C292;"></i>Tepat Waktu</h5>
                    </li>
                    <li>
                        <h5><i class="fa fa-circle m-r-5" style="color: #2196F3;"></i>Izin</h5>
                    </li>
                    <li>
                        <h5><i class="fa fa-circle m-r-5" style="color: #FEC107;"></i>Terlambat</h5>
                    </li>
                    <li>
                        <h5><i class="fa fa-circle m-r-5" style="color: #FB9678;"></i>Tanpa Keterangan</h5>
                    </li>
                </ul>
                <div id="morris-chart-siswa" style="height: 370px;"></div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
            <div class="white-box">
                <h3 class="box-title">Presensi Pegawai Hari Ini | <?= date('d-m-Y') ?></h3>
                <ul class="list-inline text-center">
                    <li>
                        <h5><i class="fa fa-circle m-r-5" style="color: #00C292;"></i>Tepat Waktu</h5>
                    </li>
                    <li>
                        <h5><i class="fa fa-circle m-r-5" style="color: #2196F3;"></i>Izin</h5>
                    </li>
                    <li>
                        <h5><i class="fa fa-circle m-r-5" style="color: #FEC107;"></i>Terlambat</h5>
                    </li>
                    <li>
                        <h5><i class="fa fa-circle m-r-5" style="color: #FB9678;"></i>Tanpa Keterangan</h5>
                    </li>
                </ul>
                <div id="morris-chart-pegawai" style="height: 370px;"></div>
            </div>
        </div>
    </div>
    <!-- row -->
</div>

<script type="text/javascript">
  Morris.Donut({
          element: 'morris-chart-siswa',
          data: [
              {label: "Tepat Waktu", value: <?= $data_siswa['count_tepat_waktu']; ?>},
              {label: "Izin", value: <?= $data_siswa['count_ijin']; ?>},
              {label: "Terlambat", value: <?= $data_siswa['count_telat']; ?>},
              {label: "Tanpa Keterangan", value: <?= $data_siswa['count_tanpa_keterangan']; ?>},
          ],
          colors: ['#00C292', '#2196F3', '#FEC107', '#FB9078']
   });

  Morris.Donut({
          element: 'morris-chart-pegawai',
          data: [
            {label: "Tepat Waktu", value: <?= $data_pegawai['count_tepat_waktu']; ?>},
            {label: "Izin", value: <?= $data_pegawai['count_ijin']; ?>},
            {label: "Terlambat", value: <?= $data_pegawai['count_telat']; ?>},
            {label: "Tanpa Keterangan", value: <?= $data_pegawai['count_tanpa_keterangan']; ?>},
          ],
          colors: ['#00C292', '#2196F3', '#FEC107', '#FB9078']
   });
</script>
