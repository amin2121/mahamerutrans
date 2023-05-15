<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_background extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function tambah()
	{
		$config['upload_path'] = 'storage/background/';
	    $config['allowed_types'] = '*';
	    $config['encrypt_name'] = true;
	    $this->load->library('upload', $config);
		$background = $this->db->get('background')->row_array();

	    $filename_background_siswa = '';
	    if($this->upload->do_upload('background_siswa')) {
	      $upload_data = $this->upload->data();
	      $filename_background_siswa = $upload_data['file_name'];
	    }else {
	    	if(!empty($background)) {
	    		$filename_background_siswa = $background['background_siswa'];
	    	} else {
	    		$filename_background_siswa = 'default.jpg';
	    	}
	    }

	    $filename_background_pegawai = '';
	    if($this->upload->do_upload('background_pegawai')) {
	      $upload_data = $this->upload->data();
	      $filename_background_pegawai = $upload_data['file_name'];
	    }else {
	    	if(!empty($background)) {
	    		$filename_background_pegawai = $background['background_pegawai'];
	    	} else {
	    		$filename_background_pegawai = 'default.jpg';
	    	}
	    }

	    $data = [
			'background_siswa' => $filename_background_siswa,
			'background_pegawai' => $filename_background_pegawai,
		];

		$this->db->trans_begin();
		if(!empty($background)) {
			$this->db->update('background', $data);
		} else {
			$this->db->insert('background', $data);
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	        return false;
	    } else {
	        $this->db->trans_commit();
	        return true;
	    }
	}
}

/* End of file M_background.php */
/* Location: ./application/models/M_background.php */