<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absen_pegawai extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('landing/M_absen_pegawai', 'model');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$data_background = $this->db->get('background')->row_array();
		$data['background'] = !empty($data_background) ? base_url('storage/background/' . $data_background['background_pegawai']) : base_url('assets_landing_absensi/walp_pegawai.jpg');

    	$this->load->view('landing/absen_pegawai/index', $data);
	}

	public function get_data_absen(){
		$input_absen = $this->input->get('input_absen');
		$row_a = $this->db->query("SELECT a.*, b.id_jabatan, b.jabatan
								 	 FROM pegawai a INNER JOIN jabatan b ON a.id_jabatan = b.id_jabatan
								 	 WHERE a.kode_absen = '$input_absen'
							 	 ")->row_array();
		if (empty($row_a)) {
			$response = array(
	        	'result' => "false",
	        	'message' => "Gagal absen, Silahkan coba kembali",
	       	 	'data' => 'Kosong'
      		);
		}else {
			$id_jabatan = $row_a['id_jabatan'];
			$row_s = $this->db->query("SELECT a.*, b.nama AS nama_aturan_jam_pegawai, b.jam_masuk, b.jam_pulang, b.status
															 FROM aturan_jam_pegawai_detail a
															 INNER JOIN aturan_jam_pegawai b ON a.id_aturan_jam_pegawai = b.id_aturan_jam_pegawai
															 WHERE a.id_jabatan = '$id_jabatan'
															 AND b.status = 'Aktif'")->row_array();

			// var_dump($row_s); die();

			$id_pegawai = $row_a['id_pegawai'];
		    $nama_pegawai = $row_a['nama_pegawai'];
		    $now = date('d-m-Y');
		    $jamnow = date('H:i:s');

			$id_aturan_jam_pegawai = $row_s['id_aturan_jam_pegawai'];
			$nama_aturan_jam_pegawai = $row_s['nama_aturan_jam_pegawai'];
			$jam_masuk = $row_s['jam_masuk'];
			$jam_pulang = $row_s['jam_pulang'];

		    $sql = $this->db->query("SELECT COUNT(a.id) AS jumlah, a.* FROM absen_pegawai a
		                             WHERE id_pegawai = '$id_pegawai' AND tanggal = '$now'
		                            ")->row_array();

		    $range_jam_masuk1 = date('H:i:s', strtotime('- 90 minutes', strtotime($jam_masuk)));
		    $range_jam_masuk2 = date('H:i:s', strtotime('+ 60 minutes', strtotime($jam_masuk)));
		    $range_jam_pulang = date('H:i:s', strtotime('- 10 minutes', strtotime($jam_pulang)));

			$status = '';
			if (strtotime($jamnow) > strtotime($jam_masuk) && strtotime($jamnow) < strtotime($jam_pulang)) {
				$status = 'Tidak Tepat Waktu';
			} elseif (strtotime($jamnow) <= strtotime($jam_masuk)) {
				$status = 'Tepat Waktu';
			}elseif (strtotime($jamnow) >= strtotime($jam_pulang)) {
				$status = 'Pulang';
			}

			$data_pegawai = array(
				'tanggal' => $now,
				'jam' => $jamnow,
				'status' => $status,
				'nigm' => $row_a['nigm'],
				'nama_pegawai' => $nama_pegawai,
				'jenis_kelamin' => $row_a['jenis_kelamin'],
				'jabatan' => $row_a['jabatan'],
        		'foto_profile' => $row_a['foto_profile']
			);

	    	if ($sql['jumlah'] == '0') {
		      $response = array(
		        'result' => "false",
		        'message' => "Gagal absen, Silahkan coba kembali",
		        'data' => 'Kosong'
		      );

		      	if (strtotime($jamnow) >= strtotime($range_jam_masuk1)) {
		        	$data = array(
			          'id_aturan_jam_pegawai' => $id_aturan_jam_pegawai,
								'nama_aturan_jam_pegawai' => $nama_aturan_jam_pegawai,
			          'id_pegawai' => $id_pegawai,
								'jabatan' => $row_a['jabatan'],
			          'nama_pegawai' => $nama_pegawai,
			          'jam_masuk' => $jamnow,
								'status_masuk' => $status,
			          'tanggal' => date('d-m-Y'),
			          'bulan' => date('m'),
			          'tahun' => date('Y')
		        	);
		        	$response = $this->model->insert_absen($data, $nama_pegawai, $data_pegawai);
		      	}

		      	if (strtotime($jamnow) >= strtotime($range_jam_pulang)) {
			        $data = array(
			          'id_aturan_jam_pegawai' => $id_aturan_jam_pegawai,
								'nama_aturan_jam_pegawai' => $nama_aturan_jam_pegawai,
			          'id_pegawai' => $id_pegawai,
								'jabatan' => $row_a['jabatan'],
			          'nama_pegawai' => $nama_pegawai,
			          'jam_pulang' => $jamnow,
			          'tanggal' => date('d-m-Y'),
			          'bulan' => date('m'),
			          'tahun' => date('Y')
			        );
		        	$response = $this->model->insert_absen($data, $nama_pegawai, $data_pegawai);
		      	}
	    	}else {
				$response = array(
					'result' => "check",
					'message' => "Sudah melakukan absen",
					'nama_pegawai' => $nama_pegawai
				);

	      		if (strtotime($jamnow) >= strtotime($range_jam_pulang)) {
			        $data = array(
			          'id_pegawai' => $id_pegawai,
			          'jam_pulang' => $jamnow
			        );

					$pegawai_pulang = $this->db->query("SELECT a.* FROM absen_pegawai a
							                              WHERE id_pegawai = '$id_pegawai'
																						AND tanggal = '$now'
							                             ")->row_array();

				  	if($pegawai_pulang['jam_pulang'] == '' || $pegawai_pulang['jam_pulang'] == NULL) {
							$response = $this->model->update_absen($data, $nama_pegawai, $data_pegawai);
					}
	      		}
    		}
		}

		$this->output
				->set_status_header(200)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($response,  JSON_PRETTY_PRINT))
				->_display();
				exit;
	}
}

/* End of file Absen_pegawai.php */
/* Location: ./application/controllers/Absen_pegawai.php */
