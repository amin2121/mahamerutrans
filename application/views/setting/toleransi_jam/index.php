<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Toleransi Jam</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
            <ol class="breadcrumb">
                <li><a href="#">Setting</a></li>
                <li class="active">Toleransi Jam</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- .row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title">Toleransi Jam</h3>
                <form action="<?= base_url('setting/toleransi_jam/setting') ?>" method="POST">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="jam-masuk-siswa">Jam Masuk Siswa</label>
                                <input type="number" class="form-control" name="jam_masuk_siswa" id="jam_masuk_siswa">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="jam-masuk-siswa">Jam Pulang Siswa</label>
                                <input type="number" class="form-control" name="jam_pulang_siswa" id="jam_masuk_siswa">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="jam-masuk-siswa">Jam Masuk Pegawai</label>
                                <input type="number" class="form-control" name="jam_masuk_pegawai" id="jam_masuk_siswa">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="jam-masuk-siswa">Jam Pulang Pegawai</label>
                                <input type="number" class="form-control" name="jam_pulang_pegawai" id="jam_masuk_siswa">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <button class="btn btn-success waves-effect waves-light" type="submit"><span class="btn-label"><i class="fa fa-plus"></i></span>Simpan</button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <!-- .right-sidebar -->
</div>