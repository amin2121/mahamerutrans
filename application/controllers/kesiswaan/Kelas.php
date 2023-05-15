<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('kesiswaan/M_kelas', 'model');
		if (!$this->session->userdata('logged_in')) {
	      redirect('auth/login');
	    }
	}

	public function index()
	{
    $data['tingkatan_kelas'] = [['tingkatan_kelas' => '10'], ['tingkatan_kelas' => '11'], ['tingkatan_kelas' => '12']];

	  $this->load->view('templates/header');
    $this->load->view('kesiswaan/kelas/index', $data);
    $this->load->view('templates/footer');
	}

	public function tambah()
	{
		if($this->model->tambah()) {
	      $this->session->set_flashdata('message', 'Kelas Berhasil <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('kesiswaan/kelas');
	    } else {
	      $this->session->set_flashdata('message', 'Kelas Gagal <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('kesiswaan/kelas');
	    }
	}

	public function edit()
	{
		if($this->model->edit()) {
	      $this->session->set_flashdata('message', 'Kelas Berhasil <span class="text-semibold">Diedit</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('kesiswaan/kelas');
	    } else {
	      $this->session->set_flashdata('message', 'Kelas Gagal <span class="text-semibold">Diedit</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('kesiswaan/kelas');
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

/* End of file Kelas.php */
/* Location: ./application/controllers/Kelas.php */
