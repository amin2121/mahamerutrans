<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aturan_jam_siswa extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('kesiswaan/M_aturan_jam_siswa', 'model');
		if (!$this->session->userdata('logged_in')) {
	      redirect('auth/login');
	    }
	}

	public function index()
	{
		$this->load->view('templates/header');
    $this->load->view('kesiswaan/aturan_jam_siswa/index');
    $this->load->view('templates/footer');
	}

	public function tambah()
	{
		if($this->model->tambah()) {
	      $this->session->set_flashdata('message', 'Aturan Jam Pegawai Berhasil <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('kesiswaan/aturan_jam_siswa');
	    } else {
	      $this->session->set_flashdata('message', 'Aturan Jam Pegawai Gagal <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('kesiswaan/aturan_jam_siswa');
	    }
	}

	public function edit()
	{
		if($this->model->edit()) {
	      $this->session->set_flashdata('message', 'Aturan Jam Pegawai Berhasil <span class="text-semibold">Diedit</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('kesiswaan/aturan_jam_siswa');
	    } else {
	      $this->session->set_flashdata('message', 'Aturan Jam Pegawai Gagal <span class="text-semibold">Diedit</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('kesiswaan/aturan_jam_siswa');
	    }
	}

  public function ubah_status()
	{
		$id = $this->input->get('id');
		$ubah_status = $this->model->ubah_status($id);
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
		echo json_encode($get_data);
	}
}

/* End of file Aturan_jam_siswa.php */
/* Location: ./application/controllers/Aturan_jam_siswa.php */
