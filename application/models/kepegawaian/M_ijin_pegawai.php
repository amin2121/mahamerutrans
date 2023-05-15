<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_ijin_pegawai extends CI_Model {

	public function get_data($search = '')
	{
		$where = '';
		if($search != '') {
			$where = " AND a.nama_pegawai LIKE '%$search%'";
		}

		return $this->db->query("SELECT
														 a.*
														 FROM ijin_pegawai a
														 WHERE 1=1
														 $where
														 LIMIT 500")->result_array();
	}

	public function tambah()
	{
		$id_pegawai = $this->input->post('id_pegawai');
		$tanggal = $this->input->post('tanggal');
		$row = $this->db->query("SELECT a.*, b.jabatan FROM pegawai a LEFT JOIN jabatan b ON a.id_jabatan = b.id_jabatan
														 WHERE a.id_pegawai = '$id_pegawai'")->row_array();
		$data = [
			'id_pegawai' => $id_pegawai,
			'jabatan' => $row['jabatan'],
			'nama_pegawai' => $row['nama_pegawai'],
			'ijin' => $this->input->post('ijin'),
      		'tanggal' => $tanggal,
			'bulan' => date('m'),
			'tahun' => date('Y')
		];

		$this->db->trans_begin();
		$this->db->insert('ijin_pegawai', $data);
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
		$id_ijin_pegawai = $this->input->post('id_ijin_pegawai');
		$tanggal = $this->input->post('tanggal');
		$id_pegawai = $this->input->post('id_pegawai');
		$row = $this->db->query("SELECT a.*, b.jabatan FROM pegawai a LEFT JOIN jabatan b ON a.id_jabatan = b.id_jabatan
														 WHERE a.id_pegawai = '$id_pegawai'")->row_array();
		$data = [
			'id_pegawai' => $id_pegawai,
			'jabatan' => $row['jabatan'],
			'nama_pegawai' => $row['nama_pegawai'],
			'ijin' => $this->input->post('ijin'),
			'tanggal' => $tanggal,
		];

		$this->db->trans_begin();
		$this->db->where('id', $id_ijin_pegawai);
		$this->db->update('ijin_pegawai', $data);
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
		$this->db->delete('ijin_pegawai');
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	        return false;
	    } else {
	        $this->db->trans_commit();
	        return true;
	    }
	}
}

/* End of file M_ijin_pegawai.php */
/* Location: ./application/models/kepegawaian/M_ijin_pegawai.php */
