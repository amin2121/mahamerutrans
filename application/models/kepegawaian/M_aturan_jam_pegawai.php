<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_aturan_jam_pegawai extends CI_Model {

	public function get_data($search = '')
	{
		$where = '';
		if($search != '') {
			$where = " AND a.nama LIKE '%$search%'";
		}

		return $this->db->query("SELECT
														 a.*
														 FROM aturan_jam_pegawai a
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
		$this->db->insert('aturan_jam_pegawai', $data);

		$id_aturan_jam_pegawai = $this->db->insert_id();

		$jabatan = $this->input->post('jabatan');
		$data_detail = [];
		foreach ($jabatan as $key => $value) {
			$row_j = $this->db->get_where('jabatan', array('id_jabatan' => $value))->row_array();
			$data_detail[] = [
				'id_aturan_jam_pegawai' => $id_aturan_jam_pegawai,
				'id_jabatan' => $value,
				'nama_jabatan' => $row_j['jabatan']
			];
		}
		$this->db->insert_batch('aturan_jam_pegawai_detail', $data_detail);

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
		$id_aturan_jam_pegawai = $this->input->post('id_aturan_jam_pegawai');
		$data = [
			'nama' => $this->input->post('nama'),
			'jam_masuk' => $this->input->post('jam_masuk'),
			'jam_pulang' => $this->input->post('jam_pulang'),
		];

		$this->db->trans_begin();
		$this->db->where('id_aturan_jam_pegawai', $id_aturan_jam_pegawai);
		$this->db->update('aturan_jam_pegawai', $data);

		$this->db->where('id_aturan_jam_pegawai', $id_aturan_jam_pegawai);
		$this->db->delete('aturan_jam_pegawai_detail');

		$jabatan = $this->input->post('jabatan');
		$data_detail = [];

		foreach ($jabatan as $key => $value) {
			$row_j = $this->db->get_where('jabatan', array('id_jabatan' => $value))->row_array();
			$data_detail[] = [
				'id_aturan_jam_pegawai' => $id_aturan_jam_pegawai,
				'id_jabatan' => $value,
				'nama_jabatan' => $row_j['jabatan']
			];
		}

		$this->db->insert_batch('aturan_jam_pegawai_detail', $data_detail);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	        return false;
	    } else {
	        $this->db->trans_commit();
	        return true;
	    }
	}

  public function ubah_status($id, $status)
	{
		$this->db->trans_begin();
		$aturan_jam_pegawai = $this->db->get_where('aturan_jam_pegawai', ['id_aturan_jam_pegawai' => $id])->row_array();

		// $this->db->query("UPDATE aturan_jam_pegawai SET status = 'Tidak Aktif' WHERE id_aturan_jam_pegawai != '$id' AND status_jam = '$status_jam'");
		$status_jam = $status == 'Aktif' ? 'Tidak Aktif' : 'Aktif';
		$this->db->query("UPDATE aturan_jam_pegawai SET status = '$status_jam' WHERE id_aturan_jam_pegawai = '$id'");

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
		$this->db->where('id_aturan_jam_pegawai', $id);
		$this->db->delete('aturan_jam_pegawai');
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

/* End of file M_aturan_jam_pegawai.php */
/* Location: ./application/models/kepegawaian/M_aturan_jam_pegawai.php */
