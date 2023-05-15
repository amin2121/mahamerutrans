<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('setting/M_login', 'model');
		if (!$this->session->userdata('logged_in')) {
	      redirect('auth/login');
	    }
	}

	public function index()
	{
		$data['pegawai']	= $this->db->get('pegawai')->result_array();

		$this->load->view('templates/header');
	    $this->load->view('setting/login/index');
	    $this->load->view('templates/footer');
	}

	public function tambah()
	{
		if($this->model->tambah()) {
	      $this->session->set_flashdata('message', 'Login Berhasil <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('setting/login');
	    } else {
	      $this->session->set_flashdata('message', 'Login Gagal <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('setting/login');
	    }
	}

	public function edit()
	{
		if($this->model->edit()) {
	      $this->session->set_flashdata('message', 'Login Berhasil <span class="text-semibold">Diedit</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('setting/login');
	    } else {
	      $this->session->set_flashdata('message', 'Login Gagal <span class="text-semibold">Diedit</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('setting/login');
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
}

/* End of file Pengguna.php */
/* Location: ./application/controllers/setting/Pengguna.php */