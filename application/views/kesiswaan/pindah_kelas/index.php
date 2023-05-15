<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Pindah Kelas</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Kesiswaan</a></li>
                <li class="active">Pindah Kelas</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- .row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title">Data Pindah Kelas</h3>
                <form action="<?= base_url('kesiswaan/pindah_kelas/pindah') ?>" method="POST">
                  <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <select class="form-control select2" name="kelas_sekarang" id="kelas-sekarang" onchange="get_data_kelas(this.value)">
                              <option value="Kosong">-- Pilih Kelas --</option>
                              <optgroup label="Kelas">
                                  <?php foreach ($kelas as $key => $k): ?>
                                      <option value="<?= $k['id_kelas'] ?>"><?= $k['tingkatan_kelas'] ?> <?= $k['nama_kelas'] ?></option>
                                  <?php endforeach ?>
                              </optgroup>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <select class="form-control select2" name="pindah_ke" id="pindah-ke">
                              <option value="Kosong">-- Pindah Ke --</option>
                              <optgroup label="Kelas">
                                  <?php foreach ($kelas as $key => $k): ?>
                                      <option value="<?= $k['id_kelas'] ?>"><?= $k['tingkatan_kelas'] ?> <?= $k['nama_kelas'] ?></option>
                                  <?php endforeach ?>
                              </optgroup>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <button class="btn btn-success waves-effect waves-light" type="submit"><span class="btn-label"><i class="fa fa-plus"></i></span>Simpan</button>
                      </div>
                  </div>
                  <div class="table-responsive">
                      <table class="table table-striped" id="table-data">
                          <thead>
                              <tr>
                                  <th class="text-center">
                                    <div class="form-check">
                                      <label class="custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input checkbox-parent">
                                          <span class="custom-control-indicator"></span>
                                      </label>
                                    </div>
                                  </th>
                                  <th class="text-center">No</th>
                                  <th class="text-center">Nisn</th>
                                  <th class="text-center">Nama Siswa</th>
                              </tr>
                          </thead>
                          <tbody>

                          </tbody>
                      </table>
                  </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>

<button type="button" data-toggle="modal" data-target="#modal-edit-data" style="display: none;" id="btn-show-modal-edit-data"></button>
<script>
    $(document).ready(function() {
        let kelas_sekarang = $('#kelas-sekarang').val();
        get_data_kelas(kelas_sekarang)

        $(`.checkbox-parent`).on('change', function() {
          if( $(this).is(':checked') ) {
            $(`.checkbox-child`).prop('checked', true)
          } else {
            $(`.checkbox-child`).prop('checked', false)
          }
        })
    })

    function get_data_kelas(kelas_sekarang) {
        let count_col = $(`#table-data thead tr th`).length

        $.ajax({
            url: '<?= base_url('kesiswaan/pindah_kelas/get_data_kelas') ?>',
            method: 'GET',
            data: {kelas_sekarang},
            dataType: 'json',
            beforeSend: function() { show_loading_table('#table-data tbody', count_col); },
            success: function (res) {
                let tr = ''
                if(res.length > 0) {
                  let no = 0
                  for(const item of res) {
                    console.log(item)
                    tr += `
                      <tr>
                        <td class="text-center">
                          <div class="form-check">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" name="id_siswa[]" value="${item.id_siswa}" class="custom-control-input checkbox-child">
                                <span class="custom-control-indicator"></span>
                            </label>
                          </div>
                        </td>
                        <td class="text-center">${++no}</td>
                        <td class="text-center">${item.nisn}</td>
                        <td class="text-center">${item.nama_lengkap}</td>
                      </tr>
                    `
                  }
                } else {
                  tr = `
                    <tr>
                      <td colspan="${count_col}" class="text-center text-muted" ><span style="display: block; padding: 12px;">Data Siswa Belum Ada, Pilih Kelas Terlebih Dahulu</span></td>
                    </tr>
                  `
                }

                $(`#table-data tbody`).html(tr)
            }
        })
    }
</script>
