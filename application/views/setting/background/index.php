<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Background</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
            <ol class="breadcrumb">
                <li><a href="#">Setting</a></li>
                <li class="active">Background</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- .row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title">Background Siswa</h3>
                <form action="<?= base_url('setting/background/tambah') ?>" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="input-background-siswa">Background Siswa</label>
                                <input type="file" id="input-background-siswa" name="background_siswa" class="dropify" data-default-file="<?= !empty($background) ? base_url('storage/background/'. $background['background_siswa']) : '' ?>"/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="input-background-pegawai">Background Pegawai</label>
                                <input type="file" id="input-background-pegawai" name="background_pegawai" class="dropify" data-default-file="<?= !empty($background) ? base_url('storage/background/'. $background['background_pegawai']) : '' ?>"/>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button class="btn btn-success waves-effect waves-light" type="submit"><span class="btn-label"><i class="fa fa-save"></i></span>Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>