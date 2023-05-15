<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Aturan Jam Siswa</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Absensi</a></li>
                <li class="active">Aturan Jam Siswa</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- .row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title">Data Aturan Jam Siswa</h3>
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
                                <input type="text" class="form-control" id="search" placeholder="Cari Aturan Jam Siswa" onkeyup="get_data()">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="table-data">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jam Masuk</th>
                                <th class="text-center">Jam Pulang</th>
                                <th class="text-center">Status</th>
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
        <h4 class="modal-title" id="main_account_name" style="font-weight: 600;">Tambah Aturan Jam Siswa</h4>
      </div>

      <form action="<?= base_url('kesiswaan/aturan_jam_siswa/tambah') ?>" method="POST">
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                    <label for="input-nama">Nama</label>
                    <input type="text" class="form-control" name="nama" id="input-nama" required>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                    <label for="input-jam-masuk">Jam Masuk</label>
                    <div class="input-group">
                        <input type="text" class="form-control input-time" name="jam_masuk" id="input-jam-masuk" required>
                        <span class="input-group-addon" id="basic-addon2"><i class="fa fa-clock-o"></i></span>
                    </div>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                    <label for="input-jam-pulang">Jam Pulang</label>
                    <div class="input-group">
                        <input type="text" class="form-control input-time" name="jam_pulang" id="input-jam-pulang" required>
                        <span class="input-group-addon" id="basic-addon2"><i class="fa fa-clock-o"></i></span>
                    </div>
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
        <h4 class="modal-title" id="main_account_name" style="font-weight: 600;">Edit Aturan Jam Siswa</h4>
      </div>

      <form action="<?= base_url('kesiswaan/aturan_jam_siswa/edit') ?>" method="POST">
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                    <label for="input-nama">Nama</label>
                    <input type="hidden" name="id_aturan_jam_siswa" id="id-aturan_jam_siswa">
                    <input type="text" class="form-control" name="nama" id="nama" required>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                    <label for="input-jam-masuk">Jam Masuk</label>
                    <div class="input-group">
                        <input type="text" class="form-control input-time" name="jam_masuk" id="jam-masuk" required>
                        <span class="input-group-addon" id="basic-addon2"><i class="fa fa-clock-o"></i></span>
                    </div>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                    <label for="input-jam-pulang">Jam Pulang</label>
                    <div class="input-group">
                        <input type="text" class="form-control input-time" name="jam_pulang" id="jam-pulang" required>
                        <span class="input-group-addon" id="basic-addon2"><i class="fa fa-clock-o"></i></span>
                    </div>
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
    })

    function get_data() {
        let search = $(`#search`).val()
        let count_col = $(`#table-data thead tr th`).length

        $.ajax({
            url: '<?= base_url('kesiswaan/aturan_jam_siswa/get_data') ?>',
            method: 'GET',
            data: {search},
            dataType: 'json',
            beforeSend: function() { show_loading_table('#table-data tbody', count_col); },
            success: function (res) {
                let tr = ''
                if(res.length > 0) {
                  let no = 0
                  for(const item of res) {
                    console.log(item)
                    let status = ''
                    if(item.status == 'Aktif') {
                      status = '<span class="badge badge-success">Aktif</span>'
                    } else {
                      status = '<span class="badge badge-danger">Tidak Aktif</span>'
                    }

                    tr += `
                      <tr>
                        <td class="text-center">${++no}</td>
                        <td class="text-center">${item.nama}</td>
                        <td class="text-center">${item.jam_masuk}</td>
                        <td class="text-center">${item.jam_pulang}</td>
                        <td class="text-center">${status}</td>
                        <td class="text-center">
                            <button class="btn btn-info btn-sm" type="button" onclick="ubah_status(${item.id_aturan_jam_siswa}, '${item.nama}')" data-toggle="tooltip" data-original-title="Close"><i class="fa fa-info"></i></button>
                            <button class="btn btn-warning btn-sm" type="button" onclick="edit_data(${item.id_aturan_jam_siswa}, '${item.nama}', '${item.jam_masuk}', '${item.jam_pulang}')" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger btn-sm" type="button" onclick="hapus_data(${item.id_aturan_jam_siswa})" data-toggle="tooltip" data-original-title="Close"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>
                    `
                  }
                } else {
                  tr = `
                    <tr>
                      <td colspan="${count_col}" class="text-center text-muted" ><span style="display: block; padding: 12px;">Data Aturan Jam Siswa Belum Ada, Tambahkan Data Aturan Jam Siswa</span></td>
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
                //custom paging logic here
                //console.log(paging);
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

    function ubah_status(id, nama) {
      console.log(id)
        swal({
            title: "Apakah Anda Yakin?",
            text: "Ingin merubah status "+nama+" menjadi aktif?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Iya, Saya rubah",
            closeOnConfirm: false
        }, function(){
                $(".confirm").attr('disabled', 'disabled');

                $.ajax({
                url: '<?= base_url('kesiswaan/aturan_jam_siswa/ubah_status') ?>',
                method: 'GET',
                data: {id},
                dataType: 'json',
                success: function (res) {
                    if(res.status == true) {
                        swal("Berhasil", "Data Berhasil Dirubah", "success");
                    } else {
                        swal("Gagal", "Data Gagal Dirubah", "danger");
                    }
                    get_data()
                }
            })
        });
    }

    function edit_data(id, nama, jam_masuk, jam_pulang) {
        $(`#id-aturan_jam_siswa`).val(id)
        $(`#nama`).val(nama)
        $(`#jam-masuk`).val(jam_masuk)
        $(`#jam-pulang`).val(jam_pulang)

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
                url: '<?= base_url('kesiswaan/aturan_jam_siswa/hapus') ?>',
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
