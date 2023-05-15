<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pengguna extends CI_Model {

	public function get_data($search = '')
	{
		$where = '';
		if($search != '') {
			$where = " WHERE a.nama_pegawai LIKE '%$search%'";
		}

		return $this->db->query("SELECT 
									a.*
								FROM pengguna a
								$where 
								LIMIT 500
							")->result_array();
	}

	public function edit()
	{
		$id 		= $this->input->post('id');
		$username 	= $this->input->post('username');
		$password 	= $this->input->post('password');

		$data = [
			'username'		=> $username,
			'password'		=> $password
		];

		$this->db->trans_begin();
		$this->db->where('id_pengguna', $id);
		$this->db->update('pengguna', $data);
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

/* End of file M_pengguna.php */
/* Location: ./application/models/setting/M_pengguna.php */