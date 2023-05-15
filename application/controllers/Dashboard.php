<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_dashboard', 'model');
		date_default_timezone_set('Asia/Jakarta');
		if (!$this->session->userdata('logged_in')) {
	      redirect('auth/login');
	    }
	}

	public function index()
	{
		$currentDate = date('d-m-Y');
		$data_siswa = $this->model->get_data_siswa($currentDate);
		$data_pegawai = $this->model->get_data_pegawai($currentDate);

		// print_r($data_siswa);
		// die();

		$data['data_siswa'] = $data_siswa;
		$data['data_pegawai'] = $data_pegawai;

		$this->load->view('templates/header');
    $this->load->view('dashboard', $data);
    $this->load->view('templates/footer');
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */
