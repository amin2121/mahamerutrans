<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_presensi_pegawai extends CI_Model {

	public function get_data($pilih_pegawai, $date_start_cek, $date_end_cek)
	{
		$period = new DatePeriod(
     new DateTime($date_start_cek),
     new DateInterval('P1D'),
     new DateTime($date_end_cek)
    );

		$search_pegawai = '';
		if ($pilih_pegawai != 'Semua') {
			$search_pegawai = "AND a.id_pegawai = '$pilih_pegawai'";
		}

    $row_s = $this->db->query("SELECT a.*, b.jabatan
														   FROM pegawai a INNER JOIN jabatan b ON a.id_jabatan = b.id_jabatan
															 WHERE 1=1 $search_pegawai")->result_array();
    $result = [];
    foreach ($row_s as $rs) {
      foreach ($period as $key => $value) {
        $tanggal_cek = $value->format('d-m-Y');

        $id_pegawai = $rs['id_pegawai'];
        $abs = $this->db->query("SELECT
      													 a.*,
                                 COUNT(a.id) AS jumlah
      													 FROM absen_pegawai a
      													 WHERE a.id_pegawai = '$id_pegawai'
                                 AND a.tanggal = '$tanggal_cek'")->row_array();

         if ($abs['jumlah'] == '0') {
           $ijn = $this->db->query("SELECT a.*, COUNT(a.id) AS jumlah FROM ijin_pegawai a
                                    WHERE a.id_pegawai = '$id_pegawai' AND a.tanggal = '$tanggal_cek'")->row_array();

           if ($ijn['jumlah'] == '0') {
             $result[] = array(
               'status' => '0',
							 'nama_pegawai' => $rs['nama_pegawai'],
	             'jabatan' => $rs['jabatan'],
               'keterangan' => 'kosong',
               'tanggal' => $tanggal_cek
             );
           }else {
             $result[] = array(
               'status' => '0',
							 'nama_pegawai' => $ijn['nama_pegawai'],
	             'jabatan' => $ijn['jabatan'],
               'keterangan' => $ijn['ijin'],
               'tanggal' => $tanggal_cek
             );
           }
         }else {
           $result[] = array(
             'status' => '1',
             'nama_aturan_jam_pegawai' => $abs['nama_aturan_jam_pegawai'],
             'nama_pegawai' => $abs['nama_pegawai'],
             'jabatan' => $abs['jabatan'],
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

	public function get_pegawai($id_jabatan)
	{
		return $this->db->query("SELECT
														 a.*
														 FROM pegawai a
														 WHERE a.id_jabatan = '$id_jabatan'")->result_array();
	}
}

/* End of file M_presensi.php */
/* Location: ./application/models/absensi/M_presensi.php */
