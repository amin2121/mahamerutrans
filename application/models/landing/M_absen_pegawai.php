<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_absen_pegawai extends CI_Model {

  public function insert_absen($data, $nama_pegawai, $data_pegawai)
  {
    $this->db->trans_begin();

    $this->db->insert('absen_pegawai', $data);

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
        'data' => $data_pegawai
      );
    }

    return $response;
  }

  public function update_absen($data, $nama_pegawai, $data_pegawai)
  {
    $id_pegawai = $data['id_pegawai'];
    $tanggal = date('d-m-Y');

    $this->db->trans_begin();

    $this->db->where('id_pegawai', $id_pegawai);
    $this->db->where('tanggal', $tanggal);
    $this->db->update('absen_pegawai', $data);

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
        'data' => $data_pegawai
      );
    }

    return $response;
  }
}

/* End of file M_absen_pegawai.php */
/* Location: ./application/models/kepegawaian/M_absen_pegawai.php */
