<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jabatan extends CI_Model {

	public function get_data($search = '')
	{
		$where = '';
		if($search != '') {
			$where = " AND jabatan LIKE '%$search%'";
		}

		return $this->db->query("SELECT * FROM jabatan WHERE 1=1 $where LIMIT 500")->result_array();
	}

	public function tambah()
	{
		$data = [
			'jabatan' => $this->input->post('jabatan')
		];

		$this->db->trans_begin();
		$this->db->insert('jabatan', $data);
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
		$id_jabatan = $this->input->post('id_jabatan');
		$data = [
			'jabatan' => $this->input->post('jabatan')
		];

		$this->db->trans_begin();
		$this->db->where('id_jabatan', $id_jabatan);
		$this->db->update('jabatan', $data);
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
		$this->db->where('id_jabatan', $id);
		$this->db->delete('jabatan');
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

/* End of file M_jabatan.php */
/* Location: ./application/models/kepegawaian/M_jabatan.php */
