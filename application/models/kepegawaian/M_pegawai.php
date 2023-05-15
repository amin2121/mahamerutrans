<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pegawai extends CI_Model {

	public function get_data($search = '')
	{
		$where = '';
		if($search != '') {
			$where = " AND nama_pegawai LIKE '%$search%'";
		}

		return $this->db->query("SELECT
								 a.*,
								 b.jabatan
								 FROM pegawai a
								 LEFT JOIN jabatan b ON a.id_jabatan = b.id_jabatan
								 WHERE 1=1 $where
								 ORDER BY a.id_pegawai DESC
								 LIMIT 500")->result_array();
	}

	public function tambah()
	{
		$config['upload_path'] = 'storage/foto_profile_pegawai/';
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = true;
    $this->load->library('upload', $config);

    $fileName = '';
    if($this->upload->do_upload('foto_profile')) {
      $upload_data = $this->upload->data();
      $fileName = $upload_data['file_name'];
    }else {
    	$fileName = 'default.jpg';
    }

		$data = [
			'nigm'	=> $this->input->post('nigm'),
			'nama_pegawai'	=> $this->input->post('nama_pegawai'),
			'jenis_kelamin'		=> $this->input->post('jenis_kelamin'),
			'id_jabatan'		=> $this->input->post('id_jabatan'),
			'foto_profile'	=> $fileName,
			'kode_absen'		=> $this->input->post('kode_absen')
		];

		$this->db->trans_begin();
		$this->db->insert('pegawai', $data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	        return false;
	    } else {
	        $this->db->trans_commit();
	        return true;
	    }
	}

	public function edit()
	{
		$id_pegawai = $this->input->post('id_pegawai');
		$foto_profile_lama = $this->input->post('foto_profile_lama');

    $config['upload_path'] = 'storage/foto_profile_pegawai/';
    $config['allowed_types'] = '*';
    $config['encrypt_name'] = true;
    $this->load->library('upload', $config);

    $fileName = '';
    if($this->upload->do_upload('foto_profile')) {
        $upload_data = $this->upload->data();
        $fileName = $upload_data['file_name'];
    } else {
    	$fileName = $foto_profile_lama;
    }

		$data = [
			'nigm'	=> $this->input->post('nigm'),
			'nama_pegawai'	=> $this->input->post('nama_pegawai'),
			'jenis_kelamin'		=> $this->input->post('jenis_kelamin'),
			'id_jabatan'		=> $this->input->post('id_jabatan'),
			'foto_profile'	=> $fileName,
			'kode_absen'		=> $this->input->post('kode_absen')
		];

		$this->db->trans_begin();
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->update('pegawai', $data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	        return false;
	    } else {
	        $this->db->trans_commit();
	        return true;
	    }
	}

	public function hapus($id)
	{
		$this->db->trans_begin();
		$data = $this->db->get_where('pegawai', ['id_pegawai' => $id])->row_array();
		@unlink('storage/foto_profile_pegawai/'.$data['foto_profile']);

		$this->db->where('id_pegawai', $id);
		$this->db->delete('pegawai');
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	        return false;
	    } else {
	        $this->db->trans_commit();
	        return true;
	    }
	}

	public function import_excel(){
		$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    	if(isset($_FILES['file_excel']['name']) && in_array($_FILES['file_excel']['type'], $file_mimes)) {
	        $arr_file = explode('.', $_FILES['file_excel']['name']);
	        $extension = end($arr_file);
	        if('csv' == $extension){
	            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
	        }elseif('xls' == $extension){
	            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
	        }else {
	            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
	        }
	        $spreadsheet = $reader->load($_FILES['file_excel']['tmp_name']);
	        $sheetData = $spreadsheet->getActiveSheet()->toArray();

			$numrow = count($sheetData);
			$data = [];
			for ($i=1; $i < $numrow; $i++) {
				if($sheetData[$i][0] != null) {
					$jabatan = $sheetData[$i][0];
					$nigm = $sheetData[$i][1];
					$nama_pegawai = $sheetData[$i][2];
					$jenis_kelamin = $sheetData[$i][3];
					$kode_absen = $sheetData[$i][5];
					$file_image = 'default.jpg';

					$worksheet = $spreadsheet->getActiveSheet();

					// cari gambar dalam sheet tersebut, dan simpan ke dalam variabel
					$drawing = $worksheet->getDrawingCollection();

					// ambil gambar yang diinginkan dari koleksi gambar

					$idx = $i - 1;
					$image = $drawing[$idx];
					$image_path = $image->getPath();

					if($image_path != '') {
						$file_image = uniqid() . '.jpg';
						copy($image_path,'storage/foto_profile_pegawai/' . $file_image);
					}

					$id_jabatan = '';
					$row_j = $this->db->get_where('jabatan', array('jabatan' => $jabatan))->row_array();
					if (!empty($row_j)) {
						$id_jabatan = $row_j['id_jabatan'];
					} else {
						$data_j = [
							'jabatan' => $jabatan
						];

						$this->db->insert('jabatan', $data_j);
						$id_jabatan = $this->db->insert_id();
					}

					$data[] = [
						'nigm'	=> $nigm,
						'nama_pegawai'	=> $nama_pegawai,
						'jenis_kelamin'	=> $jenis_kelamin,
						'id_jabatan'	=> $id_jabatan,
						'foto_profile'	=> $file_image,
						'kode_absen'	=> $kode_absen,
					];
				}
			}

			return $this->db->insert_batch('pegawai', $data);
    	}
	}
}

/* End of file M_pegawai.php */
/* Location: ./application/models/kepegawaian/M_pegawai.php */
