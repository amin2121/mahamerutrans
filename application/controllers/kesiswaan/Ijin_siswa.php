<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ijin_siswa extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('kesiswaan/M_ijin_siswa', 'model');
		if (!$this->session->userdata('logged_in')) {
	      redirect('auth/login');
	    }
	}

	public function index()
	{
	    $data['kelas'] = $this->db->get('kelas')->result_array();

	    $this->load->view('templates/header');
	    $this->load->view('kesiswaan/ijin_siswa/index', $data);
	    $this->load->view('templates/footer');
	}

	public function tambah()
	{
		if($this->model->tambah()) {
	      $this->session->set_flashdata('message', 'Ijin Siswa Berhasil <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('kesiswaan/ijin_siswa');
	    } else {
	      $this->session->set_flashdata('message', 'Ijin Siswa Gagal <span class="text-semibold">Ditambahkan</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('kesiswaan/ijin_siswa');
	    }
	}

	public function edit()
	{
		if($this->model->edit()) {
	      $this->session->set_flashdata('message', 'Ijin Siswa Berhasil <span class="text-semibold">Diedit</span>');
	      $this->session->set_flashdata('status', 'success');
	      redirect('kesiswaan/ijin_siswa');
	    } else {
	      $this->session->set_flashdata('message', 'Ijin Siswa Gagal <span class="text-semibold">Diedit</span>');
	      $this->session->set_flashdata('status', 'danger');
	      redirect('kesiswaan/ijin_siswa');
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

	public function get_siswa(){
	    $id_kelas = $this->input->get('id_kelas');
	    $data = $this->model->get_siswa($id_kelas);

	    echo json_encode($data);
	}
}

/* End of file Ijin_pegawai.php */
/* Location: ./application/controllers/Ijin_pegawai.php */
