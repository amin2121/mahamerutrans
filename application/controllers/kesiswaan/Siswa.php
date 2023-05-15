<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('kesiswaan/M_siswa', 'model');
		if (!$this->session->userdata('logged_in')) {
	      redirect('auth/login');
	    }
	}

	public function index()
	{
    $data['kelas'] = $this->db->get('kelas')->result_array();
		$data['jenis_kelamin'] = [['jenis_kelamin' => 'Laki - Laki'], ['jenis_kelamin' => 'Perempuan']];

	  $this->load->view('templates/header');
    $this->load->view('kesiswaan/siswa/index', $data);
    $this->load->view('templates/footer');
	}

	public function tambah()
	{
		if($this->model->tambah()) {
	      $this->session->set_flashdata('message', 'Siswa Berhasil <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('kesiswaan/siswa');
	    } else {
	      $this->session->set_flashdata('message', 'Siswa Gagal <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('kesiswaan/siswa');
	    }
	}

	public function edit()
	{
		if($this->model->edit()) {
	      $this->session->set_flashdata('message', 'Siswa Berhasil <span class="text-semibold">Diedit</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('kesiswaan/siswa');
	    } else {
	      $this->session->set_flashdata('message', 'Siswa Gagal <span class="text-semibold">Diedit</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('kesiswaan/siswa');
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
		$pilih_kelas = $this->input->get('pilih_kelas');
		$get_data = $this->model->get_data($search, $pilih_kelas);
		echo json_encode($get_data);
	}

	public function import_excel()
	{
		if($this->model->import_excel()) {
      $this->session->set_flashdata('message', 'Import Excel Berhasil <span class="text-semibold">Ditambahkan</span>');
      $this->session->set_flashdata('status', 'success');
      redirect('kesiswaan/siswa');
    } else {
      $this->session->set_flashdata('message', 'Import Excel Gagal <span class="text-semibold">Ditambahkan</span>');
      $this->session->set_flashdata('status', 'danger');
      redirect('kesiswaan/siswa');
    }
	}
}

/* End of file Siswa.php */
/* Location: ./application/controllers/Siswa.php */
