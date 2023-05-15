<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('kepegawaian/M_pegawai', 'model');
		if (!$this->session->userdata('logged_in')) {
	      redirect('auth/login');
	    }
	}

	public function index()
	{
		$data['jabatan'] = $this->db->get('jabatan')->result_array();
		$data['jenis_kelamin'] = [['jenis_kelamin' => 'Laki - Laki'], ['jenis_kelamin' => 'Perempuan']];

		$this->load->view('templates/header', $data);
	    $this->load->view('kepegawaian/pegawai/index');
	    $this->load->view('templates/footer');
	}

	public function tambah()
	{
		if($this->model->tambah()) {
	      $this->session->set_flashdata('message', 'Pegawai Berhasil <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('kepegawaian/pegawai');
	    } else {
	      $this->session->set_flashdata('message', 'Pegawai Gagal <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('kepegawaian/pegawai');
	    }
	}

	public function edit()
	{
		if($this->model->edit()) {
	      $this->session->set_flashdata('message', 'Pegawai Berhasil <span class="text-semibold">Diedit</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('kepegawaian/pegawai');
	    } else {
	      $this->session->set_flashdata('message', 'Pegawai Gagal <span class="text-semibold">Diedit</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('kepegawaian/pegawai');
	    }
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
		echo json_encode($get_data);
	}

	public function import_excel()
	{
		if($this->model->import_excel()) {
	      $this->session->set_flashdata('message', 'Import Excel Berhasil <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('kepegawaian/pegawai');
	    } else {
	      $this->session->set_flashdata('message', 'Import Excel Gagal <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('kepegawaian/pegawai');
	    }
	}

}

/* End of file pegawai.php */
/* Location: ./application/controllers/pegawai.php */
