<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pindah_kelas extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('kesiswaan/M_pindah_kelas', 'model');
		if (!$this->session->userdata('logged_in')) {
	      redirect('auth/login');
	    }
	}

	public function index()
	{
    $data['kelas'] = $this->db->get('kelas')->result_array();

	  $this->load->view('templates/header');
    $this->load->view('kesiswaan/pindah_kelas/index', $data);
    $this->load->view('templates/footer');
	}

	public function pindah()
	{
		if($this->model->pindah()) {
	      $this->session->set_flashdata('message', 'Pindah Kelas Berhasil <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('kesiswaan/pindah_kelas');
	    } else {
	      $this->session->set_flashdata('message', 'Pindah Kelas Gagal <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('kesiswaan/pindah_kelas');
	    }
	}
	
	public function get_data_kelas()
	{
		$kelas_sekarang = $this->input->get('kelas_sekarang');
		$get_data_kelas = $this->model->get_data_kelas($kelas_sekarang);
		echo json_encode($get_data_kelas);
	}
}

/* End of file Pindah_kelas.php */
/* Location: ./application/controllers/Pindah_kelas.php */
