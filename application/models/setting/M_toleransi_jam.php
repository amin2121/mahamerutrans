<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_toleransi_jam extends CI_Model {

	public function setting()
	{
		$toleransi_jam = $this->db->get('toleransi_jam')->result_array();
		$data = [
      		'jam_masuk_siswa' => $this->input->post('jam_masuk_siswa'),
			'jam_pulang_siswa' => $this->input->post('jam_pulang_siswa'),
			'jam_masuk_pegawai' => $this->input->post('jam_masuk_pegawai'),
			'jam_pulang_pegawai' => $this->input->post('jam_pulang_pegawai'),
		];

		$this->db->trans_begin();
		if(count($toleransi_jam) > 0) {

		}
		
		$this->db->update('toleransi_jam', $data);
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

/* End of file M_toleransi_jam.php */
/* Location: ./application/models/setting/M_toleransi_jam.php */