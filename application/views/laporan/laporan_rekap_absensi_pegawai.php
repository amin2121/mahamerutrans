<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Rekap Absensi Pegawai</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Laporan</a></li>
                <li class="active">Rekap Absensi Pegawai</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- .row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title">Laporan Rekap Absensi Pegawai</h3>

                <form action="<?php echo base_url(); ?>laporan/laporan_rekap_absensi_pegawai/print_laporan" target="_blank" method="POST">
                    <b>Laporan Harian</b><br><br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="pilih-status-absensi">Status Absensi</label>
                            <select class="form-control select2" id="pilih-status-absensi" name="status_absensi">
                                <option value="semua">Semua</option>
                                <option value="telat">Telat</option>
                                <option value="tepat_waktu">Tepat Waktu</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="pilih-tanggal">Tanggal</label>
                            <div class="input-daterange input-group" id="date-range">
                                <input type="text" class="form-control" id="date-start" name="date_start" value="<?php echo date('d-m-Y'); ?>" />
                                <span class="input-group-addon bg-info b-0 text-white">to</span>
                                <input type="text" class="form-control" id="date-end" name="date_end" value="<?php echo date('d-m-Y'); ?>" />
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-2 col-sm-12" style="display: flex; align-items: flex-end;">
                            <button class="btn btn-info btn-md mr-4" type="submit"><i class="fa fa-print mr-2"></i> Print</button>
                            <button class="btn btn-success btn-md" type="button" onclick="export_excel()"><i class="fa fa-file-excel-o mr-2"></i> Import</button>
                        </div>
                    </div>


                    <br><br><b>Laporan Bulanan</b><br><br>
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="pilih-kelas">Bulan</label>
                            <select class="form-control select2" id="pilih-bulan" name="bulan">
                                <optgroup label="Kelas">
                                    <?php $bulan_text = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']; ?>
                                    <?php foreach ($bulan_text as $key => $bulan): ?>
                                        <option value="<?= sprintf("%02d", $key + 1) ?>" <?= date('m') == sprintf("%02d", $key + 1) ? 'selected' : '' ?>><?= $bulan ?></option>
                                    <?php endforeach ?>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="pilih-kelas">Tahun</label>
                            <select class="form-control select2" id="pilih-tahun" name="tahun">
                                <optgroup label="Tahun">
                                    <?php for ($i= date('Y', strtotime('-3 years')); $i < date('Y', strtotime('+3 years')); $i++) : ?>
                                        <option value="<?= $i ?>" <?= $i == date('Y') ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor ?>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-lg-1 col-md-2 col-sm-12" style="display: flex; align-items: flex-end;">
                            <button class="btn btn-success btn-md" type="button" onclick="export_excel_bulanan()"><i class="fa fa-file-excel-o mr-2"></i> Import</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- /.row -->
</div>

<script>
    function export_excel() {
        let status_absensi = $(`#pilih-status-absensi`).val()
        let date_start = $(`#date-start`).val()
        let date_end = $(`#date-end`).val()

        window.open(`<?= base_url('laporan/laporan_rekap_absensi_pegawai/export_excel?status_absensi=') ?>${status_absensi}&date_start=${date_start}&date_end=${date_end}`, '_blank').focus();
    }

    function export_excel_bulanan() {
        let bulan = $(`#pilih-bulan`).val()
        let tahun = $(`#pilih-tahun`).val()

        window.open(`<?= base_url('laporan/laporan_rekap_absensi_pegawai/export_excel_bulanan?bulan=') ?>${bulan}&tahun=${tahun}`, '_blank').focus();
    }
</script>