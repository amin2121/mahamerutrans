<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('setting/M_pengguna', 'model');
		if (!$this->session->userdata('logged_in')) {
	      redirect('auth/login');
	    }
	}

	public function index()
	{
		$data['pegawai']	= $this->db->get('pegawai')->result_array();

		$this->load->view('templates/header');
	    $this->load->view('setting/pengguna/index');
	    $this->load->view('templates/footer');
	}

	public function edit()
	{
		if($this->model->edit()) {
	      $this->session->set_flashdata('message', 'Pengguna Berhasil <span class="text-semibold">Diedit</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('setting/pengguna');
	    } else {
	      $this->session->set_flashdata('message', 'Pengguna Gagal <span class="text-semibold">Diedit</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('setting/pengguna');
	    }
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