<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Ijin Siswa</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Absensi</a></li>
                <li class="active">Ijin Siswa</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- .row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title">Data Ijin Siswa</h3>
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <button class="btn btn-info waves-effect waves-light m-b-10" type="button" data-toggle="modal" data-target="#modal-tambah-data"><span class="btn-label"><i class="fa fa-plus"></i></span>Tambah</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ti-search"></i></div>
                                <input type="text" class="form-control" id="search" placeholder="Cari Ijin Siswa" onkeyup="get_data()">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="table-data">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Ijin</th>
                                <th class="text-center">Tanggal</th>
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

<div id="modal-tambah-data" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" id="main_account_name" style="font-weight: 600;">Tambah Ijin Siswa</h4>
      </div>

      <form action="<?= base_url('kesiswaan/ijin_siswa/tambah') ?>" method="POST">
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                    <label for="input-ijin">Tanggal</label>
                    <input type="text" class="form-control mydatepicker" name="tanggal" value="<?php echo date('d-m-Y'); ?>" id="input-tanggal" required>
                </div>
              </div>
              <div class="col-sm-12">
                  <div class="form-group">
                      <label for="input-kelas-tambah">Kelas</label>
                      <select class="form-control select2" id="input-kelas-tambah" name="id_kelas" onchange="get_siswa(this.value, 'tambah')">
                        <option value="Kosong">-- Pilih Kelas --</option>
                        <optgroup label="Kelas">
                            <?php foreach ($kelas as $key => $k): ?>
                                <option value="<?= $k['id_kelas'] ?>"><?= $k['tingkatan_kelas'] . ' ' .$k['nama_kelas'] ?></option>
                            <?php endforeach ?>
                        </optgroup>
                      </select>
                  </div>
              </div>
              <div class="col-sm-12">
                  <div class="form-group">
                      <label for="input-siswa-tambah">Siswa</label>
                      <select class="form-control select2" id="input-siswa-tambah" name="id_siswa">
                        <option value="Kosong">-- Pilih Siswa --</option>
                        <optgroup label="Siswa">
                        </optgroup>
                      </select>
                  </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                    <label for="input-ijin">Ijin</label>
                    <input type="text" class="form-control" name="ijin" id="input-ijin" required>
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
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" id="main_account_name" style="font-weight: 600;">Edit Ijin Siswa</h4>
      </div>

      <form action="<?= base_url('kesiswaan/ijin_siswa/edit') ?>" method="POST">
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                    <label for="input-nama">Tanggal</label>
                    <input type="hidden" name="id_ijin_siswa" id="id-ijin-siswa">
                    <input type="text" class="form-control" name="tanggal" id="tanggal" required>
                </div>
              </div>
              <div class="col-sm-12">
                  <div class="form-group">
                      <label for="input-kelas">Kelas</label>
                      <select class="form-control select2" id="input-kelas" name="id_kelas" onchange="get_siswa(this.value, 'edit')">
                        <option value="Kosong">-- Pilih Pegawai --</option>
                        <optgroup label="Kelas">
                            <?php foreach ($kelas as $key => $k): ?>
                                <option value="<?= $k['id_kelas'] ?>"><?= $k['tingkatan_kelas'] . ' ' .$k['nama_kelas'] ?></option>
                            <?php endforeach ?>
                        </optgroup>
                      </select>
                  </div>
              </div>
              <div class="col-sm-12">
                  <div class="form-group">
                      <label for="input-siswa-edit">Siswa</label>
                      <select class="form-control select2" id="input-siswa-edit" name="id_siswa">
                        <option value="Kosong">-- Pilih Siswa --</option>
                        <optgroup label="Siswa">
                        </optgroup>
                      </select>
                  </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                    <label for="input-ijin">Ijin</label>
                    <input type="text" class="form-control" name="ijin" id="ijin" required>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-success waves-effect waves-light" type="submit"><span class="btn-label"><i class="fa fa-save"></i></span>Simpan</button>
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
    })

    function get_siswa(id_kelas, aksi){
      $.ajax({
          url: '<?= base_url('kesiswaan/ijin_siswa/get_siswa') ?>',
          method: 'GET',
          data: {id_kelas},
          dataType: 'json',
          success: function (res) {
            let option = ``
            let id_siswa = $(`#input-kelas`).data('id-siswa')

            if(res != "" || res != null) {
              let i = 0
              for(const item of res) {
                option +=   `<option value="${item.id_siswa}">${item.nama_lengkap}</option>`
              }
            }

            $(`#input-siswa-${aksi}`).html(option)
            if(id_siswa != 0) {
                $(`#input-siswa-edit`).val(id_siswa).change()
            }
          }
      })
    }

    function get_data() {
        let search = $(`#search`).val()
        let count_col = $(`#table-data thead tr th`).length

        $.ajax({
            url: '<?= base_url('kesiswaan/ijin_siswa/get_data') ?>',
            method: 'GET',
            data: {search},
            dataType: 'json',
            beforeSend: function() { show_loading_table('#table-data tbody', count_col); },
            success: function (res) {
                let tr = ''
                if(res.length > 0) {
                  let no = 0
                  for(const item of res) {
                    tr += `
                      <tr>
                        <td class="text-center">${++no}</td>
                        <td class="text-center">${item.kelas}</td>
                        <td class="text-center">${item.nama_siswa}</td>
                        <td class="text-center">${item.ijin}</td>
                        <td class="text-center">${item.tanggal}</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm" type="button" onclick="edit_data(${item.id}, ${item.id_kelas}, ${item.id_siswa}, '${item.tanggal}', '${item.ijin}')" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger btn-sm" type="button" onclick="hapus_data(${item.id})" data-toggle="tooltip" data-original-title="Close"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>
                    `
                  }
                } else {
                  tr = `
                    <tr>
                      <td colspan="${count_col}" class="text-center text-muted" ><span style="display: block; padding: 12px;">Data Ijin Siswa Belum Ada, Tambahkan Data Ijin Siswa</span></td>
                    </tr>
                  `
                }

                $(`#table-data tbody`).html(tr)
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

    function edit_data(id, id_kelas, id_siswa, tanggal, ijin) {
        $(`#id-ijin-siswa`).val(id)
        $(`#input-kelas`).val(id_kelas).change()
        $(`#input-kelas`).data('id-siswa', id_siswa)
        $(`#tanggal`).val(tanggal)
        $(`#ijin`).val(ijin)

        jQuery('#tanggal').datepicker({
            toggleActive: true,
            format: 'dd-mm-yyyy',
        });

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
                url: '<?= base_url('kesiswaan/ijin_siswa/hapus') ?>',
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
