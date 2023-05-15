<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Toleransi_jam extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('setting/M_toleransi_jam', 'model');
		if (!$this->session->userdata('logged_in')) {
	      redirect('auth/login');
	    }
	}

	public function index()
	{
		$data['toleransi_jam'] = $this->db->get('toleransi_jam')->row_array();

		$this->load->view('templates/header', $data);
	    $this->load->view('setting/toleransi_jam/index');
	    $this->load->view('templates/footer');
	}

	public function setting()
	{
		if($this->model->setting()) {
	      $this->session->set_flashdata('message', 'Setting Toleransi Jam Berhasil <span class="text-semibold">Diubah</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('setting/toleransi_jam');
	    } else {
	      $this->session->set_flashdata('message', 'Setting Toleransi Jam Gagal <span class="text-semibold">Diubah</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('setting/toleransi_jam');
	    }
	}

}

/* End of file ToleransiJam.php */
/* Location: ./application/controllers/setting/ToleransiJam.php */