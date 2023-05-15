<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absen_siswa extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('landing/M_absen_siswa', 'model');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		$data_background = $this->db->get('background')->row_array();
		$data['background'] = !empty($data_background) ? base_url('storage/background/' . $data_background['background_siswa']) : base_url('assets_landing_absensi/walp_siswa.jpg');

		$data['aturan_jam'] = $this->db->get_where('aturan_jam_siswa', array('status' => 'Aktif'))->row_array();
    	$this->load->view('landing/absen_siswa/index', $data);
	}

	public function get_data_absen() {
		$input_absen = $this->input->get('input_absen');

		$row_a = $this->db->query("SELECT a.*, b.tingkatan_kelas, b.nama_kelas
								 	 FROM siswa a INNER JOIN kelas b ON a.id_kelas = b.id_kelas
								 	 WHERE a.kode_absen = '$input_absen'")->row_array();

		if (empty($row_a)) {
			$response = array(
		        'result' => "false",
		        'message' => "Gagal absen, Silahkan coba kembali",
		        'data' => 'Kosong'
		    );
		} else {
			$id_siswa = $row_a['id_siswa'];
		    $nama_siswa = $row_a['nama_lengkap'];
		    $now = date('d-m-Y');
		    $jamnow = date('H:i:s');
		    // $jamnow = '20:00:00';

			$id_aturan_jam_siswa = $this->input->get('id_aturan_jam_siswa');
			$nama_aturan_jam_siswa = $this->input->get('nama_aturan_jam_siswa');
			$jam_masuk = $this->input->get('jam_masuk');
			$jam_pulang = $this->input->get('jam_pulang');

	    	$sql = $this->db->query("SELECT COUNT(a.id) AS jumlah, a.* FROM absen_siswa a
	                             	WHERE id_siswa = '$id_siswa' AND tanggal = '$now'
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

			$data_siswa = array(
				'tanggal' => $now,
				'jam' => $jamnow,
				'status' => $status,
				'nisn' => $row_a['nisn'],
				'nama_siswa' => $nama_siswa,
				'nama_wali' => $row_a['nama_wali'],
				'no_telp_wali' => $row_a['no_telp_wali'],
				'jenis_kelamin' => $row_a['jenis_kelamin'],
				'kelas' => $row_a['tingkatan_kelas'].' '.$row_a['nama_kelas'],
				'foto_profile' => $row_a['foto_profile']
			);

		    if ($sql['jumlah'] == '0') {
			    $response = array(
			        'result' => "false",
			        'message' => "Gagal absen, Silahkan coba kembali",
			        'data' => 'Kosong'
			    );

		      	if (strtotime($jamnow) >= strtotime($range_jam_masuk1) && strtotime($jamnow) < strtotime($jam_pulang)) {
			        $data = array(
			          	'id_aturan_jam_siswa' => $id_aturan_jam_siswa,
						'nama_aturan_jam_siswa' => $nama_aturan_jam_siswa,
			          	'id_siswa' => $id_siswa,
						'kelas' => $row_a['tingkatan_kelas'].' '.$row_a['nama_kelas'],
			          	'nama_siswa' => $nama_siswa,
			          	'jam_masuk' => $jamnow,
						'status_masuk' => $status,
			          	'tanggal' => date('d-m-Y'),
			          	'bulan' => date('m'),
			          	'tahun' => date('Y')
			        );
		        	$response = $this->model->insert_absen($data, $nama_siswa, $data_siswa);
		      	}

		      	// mengatasi bug double
		      	$sql_sudah_absen = $this->db->query("SELECT a.* FROM absen_siswa a
	                             	WHERE id_siswa = '$id_siswa' AND tanggal = '$now'
	                            ")->row_array();

		      	if(!empty($sql_sudah_absen)) {
		      		$jam_masuk_sudah_absen = $sql_sudah_absen['jam_masuk'];
		      		$range_jam_masuk_sudah_absen = date('H:i:s', strtotime('+ 5 minutes', strtotime($jam_masuk_sudah_absen)));

		      		if(strtotime($jamnow) >= strtotime($range_jam_masuk_sudah_absen)) {
		      			if (strtotime($jamnow) >= strtotime($range_jam_pulang)) {
							$data = array(
			          			'id_aturan_jam_siswa' => $id_aturan_jam_siswa,
								'nama_aturan_jam_siswa' => $nama_aturan_jam_siswa,
			          			'id_siswa' => $id_siswa,
								'kelas' => $row_a['tingkatan_kelas'].' '.$row_a['nama_kelas'],
			          			'nama_siswa' => $nama_siswa,
			          			'jam_pulang' => $jamnow,
			          			'status_masuk' => $status,
			          			'tanggal' => date('d-m-Y'),
			          			'bulan' => date('m'),
			          			'tahun' => date('Y')
			        		);

							$response = $this->model->insert_absen($data, $nama_siswa, $data_siswa);
				      	}
		      		}
 		      	} else {
 		      		if(strtotime($jamnow) <= strtotime($jam_masuk)) {
 		      			$data = array(
				          	'id_aturan_jam_siswa' => $id_aturan_jam_siswa,
							'nama_aturan_jam_siswa' => $nama_aturan_jam_siswa,
				          	'id_siswa' => $id_siswa,
							'kelas' => $row_a['tingkatan_kelas'].' '.$row_a['nama_kelas'],
				          	'nama_siswa' => $nama_siswa,
				          	'jam_masuk' => $jamnow,
							'status_masuk' => $status,
				          	'tanggal' => date('d-m-Y'),
				          	'bulan' => date('m'),
				          	'tahun' => date('Y')
				        );
			        	$response = $this->model->insert_absen($data, $nama_siswa, $data_siswa);
			        } else if(strtotime($jamnow) > strtotime($jam_masuk) && strtotime($jamnow) < strtotime($jam_pulang)) {
			        	$data = array(
				          	'id_aturan_jam_siswa' => $id_aturan_jam_siswa,
							'nama_aturan_jam_siswa' => $nama_aturan_jam_siswa,
				          	'id_siswa' => $id_siswa,
							'kelas' => $row_a['tingkatan_kelas'].' '.$row_a['nama_kelas'],
				          	'nama_siswa' => $nama_siswa,
				          	'jam_masuk' => $jamnow,
							'status_masuk' => $status,
				          	'tanggal' => date('d-m-Y'),
				          	'bulan' => date('m'),
				          	'tahun' => date('Y')
				        );
			        	$response = $this->model->insert_absen($data, $nama_siswa, $data_siswa);
 		      		} else if(strtotime($jamnow) >= strtotime($range_jam_pulang)) {
						$data = array(
		          			'id_aturan_jam_siswa' => $id_aturan_jam_siswa,
							'nama_aturan_jam_siswa' => $nama_aturan_jam_siswa,
		          			'id_siswa' => $id_siswa,
							'kelas' => $row_a['tingkatan_kelas'].' '.$row_a['nama_kelas'],
		          			'nama_siswa' => $nama_siswa,
		          			'jam_pulang' => $jamnow,
		          			'status_masuk' => $status,
		          			'tanggal' => date('d-m-Y'),
		          			'bulan' => date('m'),
		          			'tahun' => date('Y')
		        		);

						$response = $this->model->insert_absen($data, $nama_siswa, $data_siswa);
 		      		}
 		      	}

		    }else {
				$response = array(
					'result' => "check",
					'message' => "Sudah melakukan absen",
					'nama_siswa' => $nama_siswa
				);

		      	if (strtotime($jamnow) >= strtotime($range_jam_pulang)) {
			        $data = array(
			          'id_siswa' => $id_siswa,
			          'jam_pulang' => $jamnow
			        );

					$siswa_pulang = $this->db->query("SELECT a.* FROM absen_siswa a
						                            	WHERE id_siswa = '$id_siswa'
														AND tanggal = '$now'
							                        ")->row_array();

				  	if($siswa_pulang['jam_pulang'] == '' || $siswa_pulang['jam_pulang'] == NULL) {
						$response = $this->model->update_absen($data, $nama_siswa, $data_siswa);
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

	public function send_wa()
	{
		$no_telp_wali = $this->input->get('no_telp_wali');
		$nama_siswa = $this->input->get('nama_siswa');
		$kelas = trim($this->input->get('kelas'));
		$jam = $this->input->get('jam');
		$status_absen = $this->input->get('status_absen');

		if ($no_telp_wali != '' || $no_telp_wali != '-' || $no_telp_wali != null || $no_telp_wali != '+0') {

			if($status_absen == 'masuk') {
				$message = '*_NOTIFIKASI ABSEN_*\nSMK MUHAMMADIYAH LUMAJANG\n\nAssalamualaikum,\nBpk/Ibu Wali\n\nSiswa Dengan Nama *'.$nama_siswa.'*\nKelas *'.$kelas.'*\nTelah Melakukan Absen Masuk\nPukul : *'.$jam.'*\n\nDemikian Yang Bisa Kami Sampaikan\n\n*_Terima Kasih_*';
			} else if($status_absen == 'pulang') {
				$message ='*_NOTIFIKASI ABSEN_*\nSMK MUHAMMADIYAH LUMAJANG\n\nAssalamualaikum,\nBpk/Ibu Wali\n\nSiswa Dengan Nama *'.$nama_siswa.'*\nKelas *'.$kelas.'*\nTelah Melakukan Absen Pulang\nPukul : *'.$jam.'*\n\nSemoga Selamat Sampai Tujuan\n\n*_Terima Kasih_*';
			}

	      $key='e2c8b02841c32f78913b8e1473eaaad3fdaf8a65ee34c7d2';
	      $url='http://116.203.191.58/api/send_message';
	      $data = array(
	        "phone_no"  => $no_telp_wali,
	        "key"       => $key,
	        "message"   => $message
	      );

	      $data_string = json_encode($data);

	      $ch = curl_init($url);
	      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	      curl_setopt($ch, CURLOPT_VERBOSE, 0);
	      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
	      curl_setopt($ch, CURLOPT_TIMEOUT, 360);
	      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	        'Content-Type: application/json',
	        'Content-Length: ' . strlen($data_string))
	      );

	      $res = curl_exec($ch);
	      curl_close($ch);
	    }
	}
}

/* End of file Absen_siswa.php */
/* Location: ./application/controllers/Absen_siswa.php */
