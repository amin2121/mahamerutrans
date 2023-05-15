<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_presensi_siswa extends CI_Model {

	public function get_data($pilih_kelas, $pilih_siswa, $date_start_cek, $date_end_cek)
	{
		$period = new DatePeriod(
     new DateTime($date_start_cek),
     new DateInterval('P1D'),
     new DateTime($date_end_cek)
    );

		$search_siswa = '';
		if ($pilih_siswa != 'Semua') {
			$search_siswa = "AND a.id_siswa = '$pilih_siswa'";
		}

    $row_s = $this->db->query("SELECT a.*, b.tingkatan_kelas, b.nama_kelas
														   FROM siswa a INNER JOIN kelas b ON a.id_kelas = b.id_kelas
															 WHERE 1=1 $search_siswa")->result_array();
    $result = [];
    foreach ($row_s as $rs) {
      foreach ($period as $key => $value) {
        $tanggal_cek = $value->format('d-m-Y');

        $id_siswa = $rs['id_siswa'];
        $abs = $this->db->query("SELECT
      													 a.*,
                                 COUNT(a.id) AS jumlah
      													 FROM absen_siswa a
      													 WHERE a.id_siswa = '$id_siswa'
                                 AND a.tanggal = '$tanggal_cek'")->row_array();

         if ($abs['jumlah'] == '0') {
           $ijn = $this->db->query("SELECT a.*, COUNT(a.id) AS jumlah FROM ijin_siswa a
                                    WHERE a.id_siswa = '$id_siswa' AND a.tanggal = '$tanggal_cek'")->row_array();

           if ($ijn['jumlah'] == '0') {
             $result[] = array(
               'status' => '0',
							 'nama_siswa' => $rs['nama_lengkap'],
	             'kelas' => $rs['tingkatan_kelas'].' '.$rs['nama_kelas'],
               'keterangan' => 'kosong',
               'tanggal' => $tanggal_cek
             );
           }else {
             $result[] = array(
               'status' => '0',
							 'nama_siswa' => $ijn['nama_siswa'],
	             'kelas' => $ijn['kelas'],
               'keterangan' => $ijn['ijin'],
               'tanggal' => $tanggal_cek
             );
           }
         }else {
           $result[] = array(
             'status' => '1',
             'nama_aturan_jam_siswa' => $abs['nama_aturan_jam_siswa'],
             'nama_siswa' => $abs['nama_siswa'],
             'kelas' => $abs['kelas'],
             'jam_masuk' => $abs['jam_masuk'],
             'jam_pulang' => $abs['jam_pulang'],
             'status_masuk' => $abs['status_masuk'],
             'tanggal' => $abs['tanggal']
           );
         }
      }
    }

		return $result;
	}

	public function get_siswa($id_kelas)
	{
		return $this->db->query("SELECT
														 a.*
														 FROM siswa a
														 WHERE a.id_kelas = '$id_kelas'")->result_array();
	}
}

/* End of file M_presensi.php */
/* Location: ./application/models/absensi/M_presensi.php */
