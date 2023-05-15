<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model {

	public function get_data_siswa($currentDate){
		$row_s = $this->db->query("SELECT a.*, b.tingkatan_kelas, b.nama_kelas
															 FROM siswa a INNER JOIN kelas b ON a.id_kelas = b.id_kelas")->result_array();
		$count_tanpa_keterangan = [];
		$count_ijin = [];
		$count_telat = [];
		$count_tepat_waktu = [];
		foreach ($row_s as $rs) {
			$tanggal_cek = $currentDate;
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
					 $count_tanpa_keterangan[] = array(
						 'status' => '0',
						 'nama_siswa' => $rs['nama_lengkap'],
						 'kelas' => $rs['tingkatan_kelas'].' '.$rs['nama_kelas'],
						 'keterangan' => 'kosong',
						 'tanggal' => $tanggal_cek
					 );
				 }else {
					 $count_ijin[] = array(
						 'status' => '0',
						 'nama_siswa' => $ijn['nama_siswa'],
						 'kelas' => $ijn['kelas'],
						 'keterangan' => $ijn['ijin'],
						 'tanggal' => $tanggal_cek
					 );
				 }
			 }else {
				 if ($abs['status_masuk'] == 'Tepat Waktu') {
					 $count_tepat_waktu[] = array(
  					 'status' => '1',
  					 'nama_aturan_jam_siswa' => $abs['nama_aturan_jam_siswa'],
  					 'nama_siswa' => $abs['nama_siswa'],
  					 'kelas' => $abs['kelas'],
  					 'jam_masuk' => $abs['jam_masuk'],
  					 'jam_pulang' => $abs['jam_pulang'],
  					 'status_masuk' => $abs['status_masuk'],
  					 'tanggal' => $abs['tanggal']
  				 );
				 }elseif ($abs['status_masuk'] == 'Tidak Tepak Waktu') {
					 $count_telat[] = array(
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

		$data['count_tanpa_keterangan'] = count($count_tanpa_keterangan);
		$data['count_ijin'] = count($count_ijin);
		$data['count_tepat_waktu'] = count($count_tepat_waktu);
		$data['count_telat'] = count($count_telat);
		return $data;
	}

	public function get_data_pegawai($currentDate){
		$row_s = $this->db->query("SELECT a.*, b.jabatan
														   FROM pegawai a INNER JOIN jabatan b ON a.id_jabatan = b.id_jabatan")->result_array();
		$count_tanpa_keterangan = [];
 		$count_ijin = [];
		$count_telat = [];
		$count_tepat_waktu = [];
    foreach ($row_s as $rs) {
      $tanggal_cek = $currentDate;

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
           $count_tanpa_keterangan[] = array(
             'status' => '0',
						 'nama_pegawai' => $rs['nama_pegawai'],
             'jabatan' => $rs['jabatan'],
             'keterangan' => 'kosong',
             'tanggal' => $tanggal_cek
           );
         }else {
           $count_ijin[] = array(
             'status' => '0',
						 'nama_pegawai' => $ijn['nama_pegawai'],
             'jabatan' => $ijn['jabatan'],
             'keterangan' => $ijn['ijin'],
             'tanggal' => $tanggal_cek
           );
         }
       }else {
				 if ($abs['status_masuk'] == 'Tepat Waktu') {
					 $count_tepat_waktu[] = array(
						 'status' => '1',
	           'nama_aturan_jam_pegawai' => $abs['nama_aturan_jam_pegawai'],
	           'nama_pegawai' => $abs['nama_pegawai'],
	           'jabatan' => $abs['jabatan'],
	           'jam_masuk' => $abs['jam_masuk'],
	           'jam_pulang' => $abs['jam_pulang'],
	           'status_masuk' => $abs['status_masuk'],
	           'tanggal' => $abs['tanggal']
  				 );
				 }elseif ($abs['status_masuk'] == 'Tidak Tepak Waktu') {
					 $count_telat[] = array(
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

		$data['count_tanpa_keterangan'] = count($count_tanpa_keterangan);
		$data['count_ijin'] = count($count_ijin);
		$data['count_tepat_waktu'] = count($count_tepat_waktu);
		$data['count_telat'] = count($count_telat);
		return $data;
	}
}

/* End of file M_dashboard.php */
/* Location: ./application/models/M_dashboard.php */
