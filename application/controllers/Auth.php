<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function login()
	{
	    $this->load->view('login');
	}

	public function action_login()
	{
		if ($this->session->userdata('logged_in')) {
	      redirect('dashboard');
	    }

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$get_login = $this->db->query("SELECT * FROM login WHERE username = '$username'")->row_array();
		if(!empty($get_login)) {
			if($get_login['password'] == $password) {
				$data = [
					'id'		=> $get_login['id'],
					'username'	=> $get_login['username'],
					'password'	=> $get_login['password'],
					'logged_in'	=> true
				];

				$this->session->set_userdata($data);
				$this->session->set_flashdata('message', 'Selamat Datang Di Aplikasi Absensi SMK');
	      		$this->session->set_flashdata('status', 'success');
				redirect('dashboard');
			} else {
				$this->session->set_flashdata('message', 'Password yang Anda Masukkan Salah');
				$this->session->set_flashdata('status', 'danger');
				redirect('auth/login');
			}
		} else {
			$this->session->set_flashdata('message', 'Username yang Anda Masukkan Tidak Ada');
			$this->session->set_flashdata('status', 'danger');
			redirect('auth/login');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('logged_in');
      	$this->session->unset_userdata('id');
      	$this->session->unset_userdata('username');
      	$this->session->unset_userdata('password');
      	$this->session->sess_destroy();

      	redirect('auth/login');
	}
}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */