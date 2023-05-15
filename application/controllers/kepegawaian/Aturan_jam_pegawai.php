<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aturan_jam_pegawai extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('kepegawaian/M_aturan_jam_pegawai', 'model');
		if (!$this->session->userdata('logged_in')) {
	      redirect('auth/login');
	    }
	}

	public function index()
	{
		$data['jabatan'] = $this->db->get('jabatan')->result_array();

    $this->load->view('templates/header');
    $this->load->view('kepegawaian/aturan_jam_pegawai/index', $data);
    $this->load->view('templates/footer');
	}

	public function tambah()
	{
		if($this->model->tambah()) {
	      $this->session->set_flashdata('message', 'Aturan Jam Pegawai Berhasil <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('kepegawaian/aturan_jam_pegawai');
	    } else {
	      $this->session->set_flashdata('message', 'Aturan Jam Pegawai Gagal <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('kepegawaian/aturan_jam_pegawai');
	    }
	}

	public function edit()
	{
		if($this->model->edit()) {
	      $this->session->set_flashdata('message', 'Aturan Jam Pegawai Berhasil <span class="text-semibold">Diedit</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('kepegawaian/aturan_jam_pegawai');
	    } else {
	      $this->session->set_flashdata('message', 'Aturan Jam Pegawai Gagal <span class="text-semibold">Diedit</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('kepegawaian/aturan_jam_pegawai');
	    }
	}

  public function ubah_status()
	{
		$id = $this->input->get('id');
		$status = $this->input->get('status');
		$ubah_status = $this->model->ubah_status($id, $status);
		echo json_encode(['status' => $ubah_status]);
	}

	public function hapus()
	{
		$id = $this->input->get('id');
		$hapus_data = $this->model->hapus($id);
		echo json_encode(['status' => $hapus_data]);
	}

	public function get_data()
	{
		$search = $this->input->get('search');
		$get_data = $this->model->get_data($search);

		$data = [];
		foreach ($get_data as $key => $value) {
			$aturan_jam_pegawai_detail = $this->db->get_where('aturan_jam_pegawai_detail', ['id_aturan_jam_pegawai' => $value['id_aturan_jam_pegawai']])->result_array();

			$data[] = [
				'id_aturan_jam_pegawai' => $value['id_aturan_jam_pegawai'],
				'nama' => $value['nama'],
				'jam_masuk' => $value['jam_masuk'],
				'jam_pulang' => $value['jam_pulang'],
				'status' => $value['status'],
				'detail' => $aturan_jam_pegawai_detail,
			];

		}
		echo json_encode($data);
	}
}

/* End of file Aturan_jam_pegawai.php */
/* Location: ./application/controllers/Aturan_jam_pegawai.php */
