<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_absen_siswa extends CI_Model {

  public function send_message_jam_masuk($data_siswa){
    if ($data_siswa['no_telp_wali'] != '' || $data_siswa['no_telp_wali'] != '-' || $data_siswa['no_telp_wali'] != null || $data_siswa['no_telp_wali'] != '+0') {
      $message =
      '*_NOTIFIKASI ABSEN_*\nSMK MUHAMMADIYAH LUMAJANG\n\nAssalamualaikum,\nBpk/Ibu Wali\n\nSiswa Dengan Nama *'.$data_siswa['nama_siswa'].'*\nKelas *'.$data_siswa['kelas'].'*\nTelah Melakukan Absen Masuk\nPukul : *'.$data_siswa['jam'].'*\n\nDemikian Yang Bisa Kami Sampaikan\n\n*_Terima Kasih_*';

      $key='e2c8b02841c32f78913b8e1473eaaad3fdaf8a65ee34c7d2';
      $url='http://116.203.191.58/api/async_send_message';
      $data = array(
        "phone_no"  => $data_siswa['no_telp_wali'],
        "key"       => $key,
        "message"   => $message
      );

      $data_string = json_encode($data);

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_VERBOSE, 0);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
      curl_setopt($ch, CURLOPT_TIMEOUT, 360);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
      );

      $res = curl_exec($ch);
      curl_close($ch);
    }
  }

  public function send_message_jam_pulang($data_siswa){
    if ($data_siswa['no_telp_wali'] != '' || $data_siswa['no_telp_wali'] != '-' || $data_siswa['no_telp_wali'] != null || $data_siswa['no_telp_wali'] != '+0') {
      $message =
      '*_NOTIFIKASI ABSEN_*\nSMK MUHAMMADIYAH LUMAJANG\n\nAssalamualaikum,\nBpk/Ibu Wali\n\nSiswa Dengan Nama *'.$data_siswa['nama_siswa'].'*\nKelas *'.$data_siswa['kelas'].'*\nTelah Melakukan Absen Pulang\nPukul : *'.$data_siswa['jam'].'*\n\nSemoga Selamat Sampai Tujuan\n\n*_Terima Kasih_*';

      $key='e2c8b02841c32f78913b8e1473eaaad3fdaf8a65ee34c7d2';
      $url='http://116.203.191.58/api/async_send_message';
      $data = array(
        "phone_no"  => $data_siswa['no_telp_wali'],
        "key"       => $key,
        "message"   => $message
      );

      $data_string = json_encode($data);

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_VERBOSE, 0);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
      curl_setopt($ch, CURLOPT_TIMEOUT, 360);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
      );

      $res = curl_exec($ch);
      curl_close($ch);
    }
  }

  public function insert_absen($data, $nama_siswa, $data_siswa)
  {
    $this->db->trans_begin();

    $this->db->insert('absen_siswa', $data);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $response = array(
        'result' => "false",
        'message' => "Gagal absen, Silahkan coba kembali",
        'data' => 'Kosong'
      );
    } else {
      $this->db->trans_commit();
      $response = array(
        'result' => "true",
        'message' => "Absen Berhasil",
        'data' => $data_siswa,
      );
    }

    return $response;
  }

  public function update_absen($data, $nama_siswa, $data_siswa)
  {
    $id_siswa = $data['id_siswa'];
    $tanggal = date('d-m-Y');

    $this->db->trans_begin();

    $this->db->where('id_siswa', $id_siswa);
    $this->db->where('tanggal', $tanggal);
    $this->db->update('absen_siswa', $data);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $response = array(
        'result' => "false",
        'message' => "Gagal absen, Silahkan coba kembali",
        'data' => 'Kosong'
      );
    } else {
      $response = array(
        'result' => "true",
        'message' => "Absen Berhasil",
        'data' => $data_siswa,
      );
    }

    return $response;
  }
}

/* End of file M_absen_siswa.php */
/* Location: ./application/models/kesiswaan/M_absen_siswa.php */
