<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Background extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('setting/M_background', 'model');
		if (!$this->session->userdata('logged_in')) {
	      redirect('auth/login');
	    }
	}

	public function index()
	{
		$data['background'] = $this->db->get('background')->row_array();

		$this->load->view('templates/header', $data);
	    $this->load->view('setting/background/index');
	    $this->load->view('templates/footer');
	}

	public function tambah()
	{
		if($this->model->tambah()) {
	      $this->session->set_flashdata('message', 'Background Berhasil <span class="text-semibold">Diubah</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('setting/background');
	    } else {
	      $this->session->set_flashdata('message', 'Background Gagal <span class="text-semibold">Diubah</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('setting/background');
	    }
	}
}

/* End of file Background.php */
/* Location: ./application/controllers/Background.php */