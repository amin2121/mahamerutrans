<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model {

	public function get_data($search = '')
	{
		$where = '';
		if($search != '') {
			$where = " WHERE a.username LIKE '%$search%'";
		}

		return $this->db->query("SELECT 
									a.*
								FROM login a
								$where 
								LIMIT 500
							")->result_array();
	}

	public function tambah()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$data = [
			'username'		=> $username,
			'password'		=> $password
		];

		$this->db->trans_begin();
		$this->db->insert('login', $data);
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
		$id 		= $this->input->post('id');
		$username 	= $this->input->post('username');
		$password 	= $this->input->post('password');

		$data = [
			'username'		=> $username,
			'password'		=> $password
		];

		$this->db->trans_begin();
		$this->db->where('id', $id);
		$this->db->update('login', $data);
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
		$this->db->delete('login');
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

/* End of file M_login.php */
/* Location: ./application/models/settings/M_login.php */