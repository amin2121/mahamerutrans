<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Absensi Pegawai</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Absensi</a></li>
                <li class="active">Absensi Pegawai</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- .row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title">Data Absensi Pegawai</h3>
                <div class="row">
                    <div class="col-sm-3">
                      <select class="form-control select2" id="pilih-pegawai">
                        <option value="Semua">Semua</option>
                        <optgroup label="Pegawai">
                            <?php foreach ($pegawai as $key => $p): ?>
                                <option value="<?= $p['id_pegawai'] ?>"><?= $p['nama_pegawai'] ?></option>
                            <?php endforeach ?>
                        </optgroup>
                      </select>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="input-daterange input-group" id="date-range">
                                <input type="text" class="form-control" id="date-start" name="start" value="<?php echo date('d-m-Y'); ?>" />
                                <span class="input-group-addon bg-info b-0 text-white">to</span>
                                <input type="text" class="form-control" id="date-end" name="end" value="<?php echo date('d-m-Y'); ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-2 col-sm-12">
                        <button class="btn btn-info btn-block" type="button" onclick="get_data();"><i class="fa fa-search"></i> Cari</button>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <button class="btn btn-success btn-block" type="button" onclick="export_excel();"><i class="fa fa-file-excel-o" style="margin-right: 4px;"></i> Export Excel</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="table-data">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center">Nama Pegawai</th>
                                <th class="text-center">Status Presensi</th>
                                <th class="text-center">Jam Presensi</th>
                                <th class="text-center">Tanggal</th>
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

<button type="button" data-toggle="modal" data-target="#modal-edit-data" style="display: none;" id="btn-show-modal-edit-data"></button>
<script>
    function export_excel() {
        let pilih_pegawai = $(`#pilih-pegawai`).val()
        let date_start = $(`#date-start`).val()
        let date_end = $(`#date-end`).val()
        window.open(`<?= base_url('absensi/presensi_pegawai/export_excel?pilih_pegawai=') ?>${pilih_pegawai}&date_start=${date_start}&date_end=${date_end}`, '_blank').focus();
    }

    function get_data() {
        let pilih_pegawai = $(`#pilih-pegawai`).val()
        let date_start = $(`#date-start`).val()
        let date_end = $(`#date-end`).val()

        let count_col = $(`#table-data thead tr th`).length

        $.ajax({
            url: '<?= base_url('absensi/presensi_pegawai/get_data') ?>',
            method: 'GET',
            data: {pilih_pegawai, date_start, date_end},
            dataType: 'json',
            beforeSend: function() { show_loading_table('#table-data tbody', count_col); },
            success: function (res) {
                let tr = ''
                if(res.length > 0) {
                  let no = 0
                  for(const item of res) {
                    let jam_presensi = ''
                    let status_presensi = ''
                    if (item.status == '0') {
                      status_presensi = `<span class="badge badge-warning">${item.keterangan}</span>`
                    }else {
                      if (item.status_masuk == 'Tepat Waktu') {
                          status_presensi = '<span class="badge badge-success">Tepat Waktu</span>'
                      } else {
                          status_presensi = '<span class="badge badge-danger">Tidak Tepat Waktu</span>'
                      }

                      jam_presensi = `
                          <div class="jam-text">
                              <span class="jam-title">Jam Masuk : </span>
                              <span><i class="fa fa-clock-o" style="margin-right: 4px;"></i> ${item.jam_masuk}</span>
                          </div>
                          <br>
                          <div class="jam-text">
                              <span class="jam-title">Jam Pulang : </span>
                              <span><i class="fa fa-clock-o" style="margin-right: 4px;"></i> ${item.jam_pulang}</span>
                          </div>`
                    }

                    tr += `
                        <tr>
                            <td class="text-center">${++no}</td>
                            <td class="text-center">${item.jabatan}</td>
                            <td class="text-center">
                                <span>${item.nama_pegawai}</span>
                            </td>
                            <td class="text-center">
                                ${status_presensi}
                            </td>
                            <td class="text-left">
                                ${jam_presensi}
                            </td>
                            <td class="text-center"><i class="fa fa-calendar" style="margin-right: 4px;"></i> ${reverse_date(item.tanggal)}</td>
                        </tr>`
                  }
                } else {
                  tr = `
                    <tr>
                      <td colspan="${count_col}" class="text-center text-muted" ><span style="display: block; padding: 12px;">Data Presensi Belum Ada, Tambahkan Data Presensi</span></td>
                    </tr>`
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
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                show_error_loading()
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
</script>
