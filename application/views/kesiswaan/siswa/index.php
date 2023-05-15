<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Siswa</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Kesiswaan</a></li>
                <li class="active">Siswa</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- .row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title">Data Siswa</h3>
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <button class="btn btn-success waves-effect waves-light m-b-10" type="button" data-toggle="modal" data-target="#modal-import"><span class="btn-label"><i class="fa fa-file-excel-o"></i></span>Import</button>
                        <button class="btn btn-info waves-effect waves-light m-b-10" type="button" data-toggle="modal" data-target="#modal-tambah-data"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ti-search"></i></div>
                                <input type="text" class="form-control" id="search" placeholder="Cari Siswa" onkeyup="get_data()">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                      <select class="form-control select2" id="pilih-kelas" onchange="get_data()">
                          <option value="Kosong">-- Pilih Kelas --</option>
                          <optgroup label="Kelas">
                              <?php foreach ($kelas as $key => $k): ?>
                                  <option value="<?= $k['id_kelas'] ?>"><?= $k['tingkatan_kelas'] ?> <?= $k['nama_kelas'] ?></option>
                              <?php endforeach ?>
                          </optgroup>
                      </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="table-data">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Nama Siswa</th>
                                <th class="text-center">Nama Wali</th>
                                <th class="text-center">Foto</th>
                                <th class="text-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <div id="pagination"></div>
                    </div>
                    <div class="col-sm-1 offset-sm-4">
                        <select class="form-control" style="margin: 20px 0;" id="select-show-data" onchange="pagination()">
                            <option>5</option>
                            <option>10</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>

<div id="modal-import" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" id="main_account_name" style="font-weight: 600;">Import Data Siswa</h4>
      </div>
      <form action="<?= base_url('kesiswaan/siswa/import_excel') ?>" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="input-foto-profile">File Excel</label>
                            <input type="file" id="input-file-excel" name="file_excel" class="form-control" />
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="input-template-excel">Template Excel</label> <br>
                            <a class="btn btn-info" href="<?= base_url('storage/template/Siswa.xlsx') ?>" download="Siswa.xlsx"><i class="fa fa-download"></i> Download Template Excel</a>
                        </div>
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-success waves-effect waves-light" type="submit" id="btn-import-data"><span class="btn-label"><i class="fa fa-file-excel-o"></i></span>Import</button>
            <button type="button" data-dismiss="modal" class="btn dark btn-outline">Tutup</button>
          </div>
      </form>
    </div>
  </div>
</div>

<div id="modal-tambah-data" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" id="main_account_name" style="font-weight: 600;">Tambah Siswa</h4>
      </div>

      <form action="<?= base_url('kesiswaan/siswa/tambah') ?>" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="input-kelas">Kelas</label>
                    <select class="form-control select2" name="id_kelas">
                        <option value="Kosong">-- Pilih Kelas --</option>
                        <optgroup label="Kelas">
                            <?php foreach ($kelas as $key => $k): ?>
                                <option value="<?= $k['id_kelas'] ?>"><?= $k['tingkatan_kelas'] ?> <?= $k['nama_kelas'] ?></option>
                            <?php endforeach ?>
                        </optgroup>
                    </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="input-nisn">NISN</label>
                    <input type="text" class="form-control" name="nisn" id="input-nisn" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="input-nama-lengkap">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" id="input-nama-lengkap" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="input-jenis-kelamin">Jenis Kelamin</label>
                    <select class="form-control select2" name="jenis_kelamin">
                        <option value="Kosong">-- Pilih Jenis Kelamin --</option>
                        <optgroup label="Jenis Kelamin">
                            <?php foreach ($jenis_kelamin as $key => $jk): ?>
                                <option value="<?= $jk['jenis_kelamin'] ?>"><?= $jk['jenis_kelamin'] ?></option>
                            <?php endforeach ?>
                        </optgroup>
                    </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="input-nama-wali">Nama Wali</label>
                    <input type="text" class="form-control" name="nama_wali" id="input-nama-wali" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="input-no-telp-wali">No Telp Wali</label>
                    <input type="text" class="form-control" name="no_telp_wali" id="input-no-telp-wali" required>
                </div>
              </div>
              <div class="col-sm-12">
                  <div class="form-group">
                      <label for="input-foto-profile">Foto Profile</label>
                      <input type="file" id="input-foto-profile" name="foto_profile" class="dropify-siswa" />
                  </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                    <label for="input-kode-absen">Kode Absen</label>
                    <input type="text" class="form-control" name="kode_absen" id="input-kode-absen" required>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-success waves-effect waves-light" type="submit"><span class="btn-label"><i class="fa fa-plus"></i></span>Simpan</button>
            <button type="button" data-dismiss="modal" class="btn dark btn-outline">Tutup</button>
          </div>
      </form>
    </div>
  </div>
</div>

<div id="modal-edit-data" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" id="main_account_name" style="font-weight: 600;">Edit Siswa</h4>
      </div>

      <form action="<?= base_url('kesiswaan/siswa/edit') ?>" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="input-kelas">Kelas</label>
                    <select class="form-control select2" name="id_kelas" id="id-kelas">
                        <option value="Kosong">-- Pilih Kelas --</option>
                        <optgroup label="Kelas">
                            <?php foreach ($kelas as $key => $k): ?>
                                <option value="<?= $k['id_kelas'] ?>"><?= $k['tingkatan_kelas'] ?> <?= $k['nama_kelas'] ?></option>
                            <?php endforeach ?>
                        </optgroup>
                    </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="input-nisn">NISN</label>
                    <input type="hidden" name="id_siswa" id="id-siswa">
                    <input type="text" class="form-control" name="nisn" id="nisn" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="input-nama-lengkap">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" id="nama-lengkap" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="input-jenis-kelamin">Jenis Kelamin</label>
                    <select class="form-control select2" name="jenis_kelamin" id="jenis-kelamin">
                        <option value="Kosong">-- Pilih Jenis Kelamin --</option>
                        <optgroup label="Jenis Kelamin">
                            <?php foreach ($jenis_kelamin as $key => $jk): ?>
                                <option value="<?= $jk['jenis_kelamin'] ?>"><?= $jk['jenis_kelamin'] ?></option>
                            <?php endforeach ?>
                        </optgroup>
                    </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="input-nama-wali">Nama Wali</label>
                    <input type="text" class="form-control" name="nama_wali" id="nama-wali" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="input-no-telp-wali">No Telp Wali</label>
                    <input type="text" class="form-control" name="no_telp_wali" id="no-telp-wali" required>
                </div>
              </div>
              <div class="col-sm-12">
                  <div class="form-group">
                      <label for="input-foto-profile">Foto Profile</label>
                      <input type="file" id="foto-profile" name="foto_profile"/>
                      <input type="hidden" name="foto_profile_lama" id="foto-profile-lama">
                  </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                    <label for="input-kode-absen">Kode Absen</label>
                    <input type="text" class="form-control" name="kode_absen" id="kode-absen" required>
                </div>
              </div>
            </div>


          </div>
          <div class="modal-footer">
            <button class="btn btn-success waves-effect waves-light" type="submit"><span class="btn-label"><i class="fa fa-plus"></i></span>Simpan</button>
            <button type="button" data-dismiss="modal" class="btn dark btn-outline">Tutup</button>
          </div>
      </form>
    </div>
  </div>
</div>

<button type="button" data-toggle="modal" data-target="#modal-edit-data" style="display: none;" id="btn-show-modal-edit-data"></button>
<script>
    $(document).ready(function() {
        get_data()
        $(`.dropify-siswa`).dropify()
    })

    function get_data() {
        let search = $(`#search`).val()
        let pilih_kelas = $('#pilih-kelas').val()
        let count_col = $(`#table-data thead tr th`).length

        $.ajax({
            url: '<?= base_url('kesiswaan/siswa/get_data') ?>',
            method: 'GET',
            data: {search, pilih_kelas},
            dataType: 'json',
            beforeSend: function() { show_loading_table('#table-data tbody', count_col); },
            success: function (res) {
                let tr = ''
                if(res.length > 0) {
                  let no = 0
                  for(const item of res) {
                    let foto_profile = ''
                    if(item.foto_profile == '' || item.foto_profile == null || item.foto_profile == 'default.jpg') {
                        foto_profile = '<?= base_url('assets/') ?>default.jpg'
                    } else {
                        foto_profile = `<?= base_url('storage/foto_profile_siswa/') ?>${item.foto_profile}`
                    }

                    tr += `
                      <tr>
                        <td class="text-center">${++no}</td>
                        <td class="text-center">${item.tingkatan_kelas} ${item.nama_kelas}</td>
                        <td class="text-center">${item.nama_lengkap}<br>Nisn : ${item.nisn}</td>
                        <td class="text-center">${item.nama_wali}<br>Telp : ${item.no_telp_wali}</td>
                        <td class="text-center">
                            <div style="width: 150px; height: 150px; margin: 0 auto;">
                                <a class="image-popup-no-margins" href="${foto_profile}">
                                    <img src="${foto_profile}" alt="${foto_profile}" style="max-width: 100% !important; max-height: 100% !important;">
                                </a>
                            </div>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm" type="button" onclick="edit_data(${item.id_siswa}, ${item.id_kelas}, '${item.nama_lengkap}', '${item.jenis_kelamin}', '${item.nisn}', '${item.nama_wali}', '${item.no_telp_wali}', '${item.foto_profile}', '${item.kode_absen}')" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger btn-sm" type="button" onclick="hapus_data(${item.id_siswa})" data-toggle="tooltip" data-original-title="Close"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>
                    `
                  }
                } else {
                  tr = `
                    <tr>
                      <td colspan="${count_col}" class="text-center text-muted" ><span style="display: block; padding: 12px;">Data Siswa Belum Ada, Tambahkan Data Siswa</span></td>
                    </tr>
                  `
                }

                $(`#table-data tbody`).html(tr)
                $('.image-popup-no-margins').magnificPopup({
                        type: 'image',
                        closeOnContentClick: true,
                        image: {
                            verticalFit: false
                        }
                });

                pagination()
            }
        })
    }

    function pagination() {
        var jumlah_tampil = $(`#select-show-data`).val() || 5;

        if(typeof $selector == 'undefined')
        {
            $selector = $("#table-data tbody tr");
        }

        window.tp = new Pagination('#pagination', {
            itemsCount:$("#table-data tbody tr").length,
            pageSize : parseInt(jumlah_tampil),
            onPageSizeChange: function (ps) {
                console.log('changed to ' + ps);
            },
            onPageChange: function (paging) {
                var start = paging.pageSize * (paging.currentPage - 1),
                    end = start + paging.pageSize,
                    $rows = $("#table-data tbody tr");

                $rows.hide();

                for (var i = start; i < end; i++) {
                    $rows.eq(i).show();
                }
            }
        });
    }

    function edit_data(id, id_kelas, nama_lengkap, jenis_kelamin, nisn, nama_wali, no_telp_wali, foto_profile, kode_absen) {
        $(`#id-siswa`).val(id)
        $(`#id-kelas`).val(id_kelas).change()
        $(`#nama-lengkap`).val(nama_lengkap)
        $(`#jenis-kelamin`).val(jenis_kelamin).change()
        $(`#nisn`).val(nisn)
        $(`#nama-wali`).val(nama_wali)
        $(`#no-telp-wali`).val(no_telp_wali)
        $(`#kode-absen`).val(kode_absen)

        var imagenUrl = "";
        var drEvent = $('#foto-profile').dropify(
        {
          defaultFile: `<?= base_url('storage/foto_profile_siswa/') ?>${foto_profile}`
        });
        drEvent = drEvent.data('dropify');
        drEvent.resetPreview();
        drEvent.clearElement();
        drEvent.settings.defaultFile = `<?= base_url('storage/foto_profile_siswa/') ?>${foto_profile}`;
        drEvent.destroy();
        drEvent.init();

        $(`#btn-show-modal-edit-data`).click()
    }

    function hapus_data(id) {
        swal({
            title: "Apakah Anda Yakin?",
            text: "Ingin menghapus data ini",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Iya, Saya Hapus",
            closeOnConfirm: false
        }, function(){
                $(".confirm").attr('disabled', 'disabled');

                $.ajax({
                url: '<?= base_url('kesiswaan/siswa/hapus') ?>',
                method: 'GET',
                data: {id},
                dataType: 'json',
                success: function (res) {
                    if(res.status == true) {
                        swal("Berhasil", "Data Berhasil Dihapus", "success");
                    } else {
                        swal("Gagal", "Data Gagal Dihapus", "danger");
                    }

                    get_data()
                }
            })
        });

    }
</script>
