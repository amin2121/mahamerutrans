<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pindah_kelas extends CI_Model {

	public function get_data_kelas($kelas_sekarang = '')
	{
		return $this->db->query("SELECT a.* FROM siswa a WHERE a.id_kelas = '$kelas_sekarang' LIMIT 500")->result_array();
	}

	public function pindah()
	{
		$data = [
      'kelas_sekarang' => $this->input->post('kelas_sekarang'),
			'pindah_ke' => $this->input->post('pindah_ke'),
			'tanggal' => date('d-m-Y')
		];

		$data_update_kelas = [];
		foreach ($this->input->post('id_siswa') as $key => $value) {
			$data_update_kelas[] = [
				'id_siswa' => $value,
	      'id_kelas' => $this->input->post('pindah_ke')
			];
		}

		$this->db->trans_begin();

		$this->db->insert('pindah_kelas', $data);
		$this->db->update_batch('siswa', $data_update_kelas, 'id_siswa');

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

/* End of file M_pindah_kelas.php */
/* Location: ./application/models/kepegawaian/M_pindah_kelas.php */
