<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_ijin_siswa extends CI_Model {

	public function get_data($search = '')
	{
		$where = '';
		if($search != '') {
			$where = " AND a.nama_siswa LIKE '%$search%'";
		}

		return $this->db->query("SELECT
								 a.*, b.id_kelas
								 FROM ijin_siswa a
								 LEFT JOIN siswa b ON a.id_siswa = b.id_siswa
								 WHERE 1=1
								 $where
								 LIMIT 500")->result_array();
	}

	public function tambah()
	{
		$id_siswa = $this->input->post('id_siswa');
		$tanggal = $this->input->post('tanggal');
		$row = $this->db->query("SELECT a.*, b.tingkatan_kelas, b.nama_kelas FROM siswa a LEFT JOIN kelas b ON a.id_kelas = b.id_kelas
								 WHERE a.id_siswa = '$id_siswa'")->row_array();
		
		$data = [
			'id_siswa' => $id_siswa,
			'kelas' => $row['tingkatan_kelas'] . ' '. $row['nama_kelas'],
			'nama_siswa' => $row['nama_lengkap'],
			'ijin' => $this->input->post('ijin'),
      		'tanggal' => $tanggal,
			'bulan' => date('m'),
			'tahun' => date('Y'),
		];

		$this->db->trans_begin();
		$this->db->insert('ijin_siswa', $data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	        return false;
	    } else {
	        $this->db->trans_commit();
	        return true;
	    }
	}

	public function edit()
	{
		$id_ijin_siswa = $this->input->post('id_ijin_siswa');
		$tanggal = $this->input->post('tanggal');
		$id_siswa = $this->input->post('id_siswa');

		$row = $this->db->query("SELECT a.*, b.tingkatan_kelas, b.nama_kelas FROM siswa a LEFT JOIN kelas b ON a.id_kelas = b.id_kelas
								 WHERE a.id_siswa = '$id_siswa'")->row_array();
		$data = [
			'id_siswa' => $id_siswa,
			'kelas' => $row['tingkatan_kelas'] . ' ' . $row['nama_kelas'],
			'nama_siswa' => $row['nama_lengkap'],
			'ijin' => $this->input->post('ijin'),
			'tanggal' => $tanggal,
		];

		$this->db->trans_begin();
		$this->db->where('id', $id_ijin_siswa);
		$this->db->update('ijin_siswa', $data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	        return false;
	    } else {
	        $this->db->trans_commit();
	        return true;
	    }
	}

	public function hapus($id)
	{
		$this->db->trans_begin();
		$this->db->where('id', $id);
		$this->db->delete('ijin_siswa');
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	        return false;
	    } else {
	        $this->db->trans_commit();
	        return true;
	    }
	}

	public function get_siswa($id_kelas)
	{
		return $this->db->query("SELECT
								 a.*
								 FROM siswa a
								 WHERE a.id_kelas = '$id_kelas'")->result_array();
	}
}

/* End of file M_ijin_pegawai.php */
/* Location: ./application/models/kepegawaian/M_ijin_pegawai.php */
