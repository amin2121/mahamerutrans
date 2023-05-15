<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_aturan_jam_siswa extends CI_Model {

	public function get_data($search = '')
	{
		$where = '';
		if($search != '') {
			$where = " AND a.nama LIKE '%$search%'";
		}

		return $this->db->query("SELECT
														 a.*
														 FROM aturan_jam_siswa a
														 WHERE 1=1
														 $where
														 LIMIT 500")->result_array();
	}

	public function tambah()
	{
		$data = [
			'nama' => $this->input->post('nama'),
			'jam_masuk' => $this->input->post('jam_masuk'),
			'jam_pulang' => $this->input->post('jam_pulang'),
      'status' => 'Tidak Aktif'
		];

		$this->db->trans_begin();
		$this->db->insert('aturan_jam_siswa', $data);
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
		$id_aturan_jam_siswa = $this->input->post('id_aturan_jam_siswa');
    $data = [
			'nama' => $this->input->post('nama'),
			'jam_masuk' => $this->input->post('jam_masuk'),
			'jam_pulang' => $this->input->post('jam_pulang'),
		];

		$this->db->trans_begin();
		$this->db->where('id_aturan_jam_siswa', $id_aturan_jam_siswa);
		$this->db->update('aturan_jam_siswa', $data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	        return false;
	    } else {
	        $this->db->trans_commit();
	        return true;
	    }
	}

  public function ubah_status($id)
	{
		$this->db->trans_begin();

    $this->db->query("UPDATE aturan_jam_siswa SET status = 'Tidak Aktif' WHERE id_aturan_jam_siswa != '$id'");
    $this->db->query("UPDATE aturan_jam_siswa SET status = 'Aktif' WHERE id_aturan_jam_siswa = '$id'");

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
		$this->db->where('id_aturan_jam_siswa', $id);
		$this->db->delete('aturan_jam_siswa');
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

/* End of file M_aturan_jam_siswa.php */
/* Location: ./application/models/kepegawaian/M_aturan_jam_siswa.php */
