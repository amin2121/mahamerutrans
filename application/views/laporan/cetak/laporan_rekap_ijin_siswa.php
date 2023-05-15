<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Laporan Rekap Ijin Siswa</title>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
  </head>
  <style type="text/css" media="print">
  @page {
    /* size: landscape; */
    margin: 1cm;
  }

  table{
    width: 100%;
  }

  .body {
    font-family: Arial, Helvetica, sans-serif;
  }

   .grid th {
      background: white;
      vertical-align: middle;
      border: 1px solid black;
      color : black;
        text-align: center;
        height: 30px;
        font-size: 13px;
    }
    .grid td {
      background: #FFFFFF;
      vertical-align: middle;
      border: 1px solid black;
      font: 11px/15px sans-serif;
      font-size: 11px;
        height: 20px;
        padding-left: 5px;
        padding-right: 5px;
    }
    .grid {
      background: black;
      border: 1px solid black;
      border-collapse: collapse;
        border-spacing: 0;
    }

    .grid tfoot td{
      background: white;
      vertical-align: middle;
      color : black;
        text-align: center;
        height: 20px;
    }

   .footer{
    position:absolute;
    /* right:0; */
    bottom:0;
  }
  </style>
  <style>
    .text-center {
      text-align: center;
    }
  </style>
  <body class="body">
  <h2 style="text-align:center;">Rekap Ijin Siswa</h2>

  <br>
  <table>
    <tbody>
      <tr>
        <td style="width: 15%;">Siswa</td>
        <td style="width: 2%;">:</td>
        <td><?php echo $siswa; ?></td>
      </tr>
      <tr>
        <td style="width: 15%;">Tanggal</td>
        <td style="width: 2%;">:</td>
        <td><?php echo $tanggal; ?></td>
      </tr>
    </tbody>
  </table>
  <br>

  <table style="width: 100%;" class="grid">
    <thead>
      <tr>
        <th class="text-center">No</th>
        <th class="text-center">Nama Siswa</th>
        <th class="text-center">Kelas</th>
        <th class="text-center">Ijin</th>
        <th class="text-center">Tanggal</th>
      </tr>
    </thead>
      <tbody>
        <?php foreach ($res as $key => $item): ?>
          <tr>
            <td class="text-center"><?= ++$key ?></td>
            <td class="text-left"><?= $item['nama_siswa'] ?></td>
            <td class="text-center"><?= $item['kelas'] ?></td>
            <td class="text-center"><?= $item['ijin'] ?></td>
            <td class="text-center"><?= $item['tanggal'] ?></td>
          </tr>
        <?php endforeach ?>
    </tbody>
  </table>
  <script>
    window.print();
    window.onfocus = function () { window.close(); }
  </script>
</body>
</html>
