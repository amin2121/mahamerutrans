<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_siswa extends CI_Model {

	public function get_data($search = '', $pilih_kelas)
	{
		$where = '';
		if($search != '') {
			$where = " AND a.nama_lengkap LIKE '%$search%'";
		}

		$where_pilih_kelas = '';
		if($pilih_kelas != 'Kosong') {
			$where_pilih_kelas = " AND a.id_kelas = '$pilih_kelas'";
		}

		return $this->db->query("SELECT
									 a.*,
									 b.tingkatan_kelas,
									 b.nama_kelas
									 FROM siswa a
									 INNER JOIN kelas b ON a.id_kelas = b.id_kelas
									 WHERE 1=1
									 $where
									 $where_pilih_kelas
									 ORDER BY a.id_siswa DESC
									 LIMIT 500
								")->result_array();
	}

	public function tambah()
	{
		$config['upload_path'] = 'storage/foto_profile_siswa/';
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
      		'id_kelas' => $this->input->post('id_kelas'),
			'nisn' => $this->input->post('nisn'),
			'nama_lengkap' => $this->input->post('nama_lengkap'),
			'jenis_kelamin' => $this->input->post('jenis_kelamin'),
			'nama_wali' => $this->input->post('nama_wali'),
			'no_telp_wali' => $this->input->post('no_telp_wali'),
			'foto_profile'	=> $fileName,
			'kode_absen' => $this->input->post('kode_absen')
		];

		$this->db->trans_begin();
		$this->db->insert('siswa', $data);
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
		$id_siswa = $this->input->post('id_siswa');
		$foto_profile_lama = $this->input->post('foto_profile_lama');

	    $config['upload_path'] = 'storage/foto_profile_siswa/';
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
      		'id_kelas' => $this->input->post('id_kelas'),
			'nisn' => $this->input->post('nisn'),
			'nama_lengkap' => $this->input->post('nama_lengkap'),
			'jenis_kelamin' => $this->input->post('jenis_kelamin'),
			'nama_wali' => $this->input->post('nama_wali'),
			'no_telp_wali' => $this->input->post('no_telp_wali'),
			'foto_profile'	=> $fileName,
			'kode_absen' => $this->input->post('kode_absen')
		];

		$this->db->trans_begin();
		$this->db->where('id_siswa', $id_siswa);
		$this->db->update('siswa', $data);
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
		$data = $this->db->get_where('siswa', ['id_siswa' => $id])->row_array();
		@unlink('storage/foto_profile_siswa/'.$data['foto_profile']);

		$this->db->where('id_siswa', $id);
		$this->db->delete('siswa');
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
					$tingkatan_kelas = $sheetData[$i][0];
					$nama_kelas = $sheetData[$i][1];
					$nisn = $sheetData[$i][2];
					$nama_lengkap = $sheetData[$i][3];
					$jenis_kelamin = $sheetData[$i][4];
					$nama_wali = $sheetData[$i][5];
					$no_telp_wali = $sheetData[$i][6];
					$kode_absen = $sheetData[$i][8];
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
						copy($image_path,'storage/foto_profile_siswa/' . $file_image);
					}

					$id_kelas = '';
					$row_k = $this->db->get_where('kelas', array('tingkatan_kelas' => $tingkatan_kelas, 'nama_kelas' => $nama_kelas))->row_array();
					if (!empty($row_k)) {
						$id_kelas = $row_k['id_kelas'];
					}else {
						$data_k = [
				      		'tingkatan_kelas' => $tingkatan_kelas,
							'nama_kelas' => $nama_kelas
						];

						$this->db->insert('kelas', $data_k);
						$id_kelas = $this->db->insert_id();
					}

					$data[] = [
			      		'id_kelas' => $id_kelas,
						'nisn' => $nisn,
						'nama_lengkap' => $nama_lengkap,
						'jenis_kelamin' => $jenis_kelamin,
						'nama_wali' => $nama_wali,
						'no_telp_wali' => $no_telp_wali,
						'foto_profile'	=> $file_image,
						'kode_absen' => $kode_absen,
					];
				}
			}		

			return $this->db->insert_batch('siswa', $data);
    	}
	}
}

/* End of file M_siswa.php */
/* Location: ./application/models/kepegawaian/M_siswa.php */
