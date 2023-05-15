<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Pengguna</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
            <ol class="breadcrumb">
                <li><a href="#">Setting</a></li>
                <li class="active">Pengguna</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- .row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title">Data Pengguna</h3>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="ti-search"></i></div>
                                <input type="text" class="form-control" id="search" placeholder="Cari Pegawai" onkeyup="get_data()">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="table-data">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nomor Pegawai</th>
                                <th class="text-center">Nama Pegawai</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Level</th>
                                <th class="text-center">Status Login</th>
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
    <!-- .right-sidebar -->
    <div class="right-sidebar">
        <div class="slimscrollright">
            <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
            <div class="r-panel-body">
                <ul>
                    <li><b>Layout Options</b></li>
                    <li>
                        <div class="checkbox checkbox-info">
                            <input id="checkbox1" type="checkbox" class="fxhdr">
                            <label for="checkbox1"> Fix Header </label>
                        </div>
                    </li>
                    <li>
                        <div class="checkbox checkbox-warning">
                            <input id="checkbox2" type="checkbox" checked="" class="fxsdr">
                            <label for="checkbox2"> Fix Sidebar </label>
                        </div>
                    </li>
                    <li>
                        <div class="checkbox checkbox-success">
                            <input id="checkbox4" type="checkbox" class="open-close">
                            <label for="checkbox4"> Toggle Sidebar </label>
                        </div>
                    </li>
                </ul>
                <ul id="themecolors" class="m-t-20">
                    <li><b>With Light sidebar</b></li>
                    <li><a href="javascript:void(0)" theme="default" class="default-theme">1</a></li>
                    <li><a href="javascript:void(0)" theme="green" class="green-theme">2</a></li>
                    <li><a href="javascript:void(0)" theme="gray" class="yellow-theme">3</a></li>
                    <li><a href="javascript:void(0)" theme="blue" class="blue-theme working">4</a></li>
                    <li><a href="javascript:void(0)" theme="purple" class="purple-theme">5</a></li>
                    <li><a href="javascript:void(0)" theme="megna" class="megna-theme">6</a></li>
                    <li><b>With Dark sidebar</b></li>
                    <br/>
                    <li><a href="javascript:void(0)" theme="default-dark" class="default-dark-theme">7</a></li>
                    <li><a href="javascript:void(0)" theme="green-dark" class="green-dark-theme">8</a></li>
                    <li><a href="javascript:void(0)" theme="gray-dark" class="yellow-dark-theme">9</a></li>
                    <li><a href="javascript:void(0)" theme="blue-dark" class="blue-dark-theme">10</a></li>
                    <li><a href="javascript:void(0)" theme="purple-dark" class="purple-dark-theme">11</a></li>
                    <li><a href="javascript:void(0)" theme="megna-dark" class="megna-dark-theme">12</a></li>
                </ul>
                <ul class="m-t-20 chatonline">
                    <li><b>Chat option</b></li>
                    <li>
                        <a href="javascript:void(0)"><img src="<?= base_url() ?>assets/plugins/images/users/varun.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><img src="<?= base_url() ?>assets/plugins/images/users/genu.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><img src="<?= base_url() ?>assets/plugins/images/users/ritesh.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><img src="<?= base_url() ?>assets/plugins/images/users/arijit.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><img src="<?= base_url() ?>assets/plugins/images/users/govinda.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><img src="<?= base_url() ?>assets/plugins/images/users/hritik.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><img src="<?= base_url() ?>assets/plugins/images/users/john.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><img src="<?= base_url() ?>assets/plugins/images/users/pawandeep.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /.right-sidebar -->
</div>

<div id="modal-edit-data" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title" id="main_account_name" style="font-weight: 600;">Edit Pengguna</h4>
      </div>

      <form action="<?= base_url('setting/pengguna/edit') ?>" method="POST">
            <input type="hidden" name="id" id="id">
            <div class="modal-body">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div class="form-group">
                    <label for="input-password">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" id="password" required>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick="show_password('edit')"><i class="fa fa-eye-slash" id="icon-eye-edit"></i></button>
                        </span>
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
    let show_password_tambah = true
    let show_password_edit = true

    $(document).ready(function() {
        get_data()
    })

    function get_data() {
        let search = $(`#search`).val()
        let count_col = $(`#table-data thead tr th`).length

        $.ajax({
            url: '<?= base_url('setting/pengguna/get_data') ?>',
            method: 'GET',
            data: {search},
            dataType: 'json',
            beforeSend: function() { show_loading_table('#table-data tbody', count_col); },
            success: function (res) {
                let tr = ''
                if(res.length > 0) {
                  let no = 0
                  for(const item of res) {

                    let status_login = ''
                    if(item.status_login == 1) {
                        status_login = '<span class="badge badge-success">Login</span>'
                    } else {
                        status_login = '<span class="badge badge-danger">Tidak Login</span>'
                    }

                    tr += `
                      <tr>
                        <td class="text-center">${++no}</td>
                        <td class="text-center">${item.nomor_pegawai}</td>
                        <td class="text-center">${item.nama_pegawai}</td>
                        <td class="text-center">${item.username}</td>
                        <td class="text-center">${item.level}</td>
                        <td class="text-center">${status_login}</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm" type="button" onclick="edit_data(${item.id_pengguna}, '${item.username}', '${item.password}')" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil"></i></button>
                        </td>
                      </tr>
                    `
                  }
                } else {
                  tr = `
                    <tr>
                      <td colspan="${count_col}" class="text-center text-muted" ><span style="display: block; padding: 12px;">Data Pengguna Belum Ada, Tambahkan Data Pengguna</span></td>
                    </tr>
                  `
                }

                $(`#table-data tbody`).html(tr)
                pagination()
            }
        })
    }

    function pagination() {
        var jumlah_tampil = $(`#select-show-data`).val() || 10;

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

    function show_password(status) {
        if(status == 'tambah') {
            if(show_password_tambah == true) {
                $(`#input-password`).attr('type', 'text')
                $(`#icon-eye-tambah`).removeClass('fa-eye-slash')
                $(`#icon-eye-tambah`).addClass('fa-eye')

                show_password_tambah = false
            } else {
                $(`#input-password`).attr('type', 'password')
                $(`#icon-eye-tambah`).removeClass('fa-eye')
                $(`#icon-eye-tambah`).addClass('fa-eye-slash')

                show_password_tambah = true
            }
        } else {
            if(show_password_edit == true) {
                $(`#password`).attr('type', 'text')
                $(`#icon-eye-edit`).removeClass('fa-eye-slash')
                $(`#icon-eye-edit`).addClass('fa-eye')

                show_password_edit = false
            } else {
                $(`#password`).attr('type', 'password')
                $(`#icon-eye-edit`).removeClass('fa-eye')
                $(`#icon-eye-edit`).addClass('fa-eye-slash')

                show_password_edit = true
            }
        }

    }

    function edit_data(id, username, password) {
        $(`#id`).val(id)

        $(`#username`).val(username)
        $(`#password`).val(password)

        $(`#btn-show-modal-edit-data`).click()
    }
</script>