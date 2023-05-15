<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kelas extends CI_Model {

	public function get_data($search = '')
	{
		$where = '';
		if($search != '') {
			$where = " WHERE (CONCAT(tingkatan_kelas, ' ', nama_kelas) LIKE '%$search%')";
		}

		return $this->db->query("SELECT * FROM kelas $where LIMIT 500")->result_array();
	}

	public function tambah()
	{
		$data = [
      'tingkatan_kelas' => $this->input->post('tingkatan_kelas'),
			'nama_kelas' => $this->input->post('nama_kelas')
		];

		$this->db->trans_begin();
		$this->db->insert('kelas', $data);
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
		$id_kelas = $this->input->post('id_kelas');
    $data = [
      'tingkatan_kelas' => $this->input->post('tingkatan_kelas'),
			'nama_kelas' => $this->input->post('nama_kelas')
		];

		$this->db->trans_begin();
		$this->db->where('id_kelas', $id_kelas);
		$this->db->update('kelas', $data);
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
		$this->db->where('id_kelas', $id);
		$this->db->delete('kelas');
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

/* End of file M_kelas.php */
/* Location: ./application/models/kepegawaian/M_kelas.php */
