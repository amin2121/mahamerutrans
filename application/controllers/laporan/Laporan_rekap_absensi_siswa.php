<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan_rekap_absensi_siswa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['kelas'] = $this->db->get('kelas')->result_array();

		$this->load->view('templates/header', $data);
    	$this->load->view('laporan/laporan_rekap_absensi_siswa');
    	$this->load->view('templates/footer');
	}

	public function print_laporan()
	{
		$status_absensi = $this->input->post('status_absensi');
		$siswa = $this->input->post('siswa');
		$kelas = $this->input->post('kelas');
		$start = $this->input->post('date_start');
		$end = $this->input->post('date_end');
		$date_start_cek = date('Y-m-d', strtotime($start));
	    $date_end = date('Y-m-d', strtotime($end));
	    $date_end_cek = new DateTime($date_end);
	    $date_end_cek->add(new DateInterval('P1D'));
	    $date_end_cek = $date_end_cek->format('Y-m-d');

	    $where_status_absensi = '';
	    if($status_absensi == 'telat') {
	    	$where_status_absensi = "AND a.status_masuk = 'Tidak Tepat Waktu'";
	    } else if($status_absensi == 'tepat_waktu') {
	    	$where_status_absensi = "AND a.status_masuk = 'Tepat Waktu'";
	    }

		$where_siswa = '';
		$nama_siswa = 'Semua';
		if ($siswa != 'Semua') {
			$where_siswa = "AND a.id_siswa = '$siswa'";
			$row_s = $this->db->get_where('siswa', ['id_siswa' => $siswa])->row_array();
			$nama_siswa = $row_s['nama_lengkap'];
		}

    	$result = $this->db->query("SELECT
										a.*
									FROM absen_siswa a
									LEFT JOIN siswa b ON a.id_siswa = b.id_siswa
                           			WHERE STR_TO_DATE(a.tanggal,'%d-%m-%Y') >= STR_TO_DATE('$start','%d-%m-%Y')
                            		AND STR_TO_DATE(a.tanggal,'%d-%m-%Y') <= STR_TO_DATE('$end','%d-%m-%Y')
                    				AND b.id_kelas = '$kelas'
									$where_siswa
                    				$where_status_absensi
                 				")->result_array();

    	$data['status_absensi'] = ucfirst(str_replace('_', ' ', $status_absensi));
		$data['res'] = $result;
		$data['kelas'] = $this->db->get_where('kelas', ['id_kelas' => $kelas])->row_array();
		$data['siswa'] = $nama_siswa;
		$data['tanggal'] = $start.' - '.$end;
    	$data['settitle'] = 'Laporan Rekap Absensi Siswa';

    	$this->load->view('laporan/cetak/laporan_rekap_absensi_siswa', $data);
	}

	public function export_excel()
	{
		$status_absensi = $this->input->get('status_absensi');
		$siswa = $this->input->get('siswa');
		$kelas = $this->input->get('kelas');
		$start = $this->input->get('date_start');
		$end = $this->input->get('date_end');
		$date_start_cek = date('Y-m-d', strtotime($start));
	    $date_end = date('Y-m-d', strtotime($end));
	    $date_end_cek = new DateTime($date_end);
	    $date_end_cek->add(new DateInterval('P1D'));
	    $date_end_cek = $date_end_cek->format('Y-m-d');

	    $where_status_absensi = '';
	    if($status_absensi == 'telat') {
	    	$where_status_absensi = "AND a.status_masuk = 'Tidak Tepat Waktu'";
	    } else if($status_absensi == 'tepat_waktu') {
	    	$where_status_absensi = "AND a.status_masuk = 'Tepat Waktu'";
	    }

		$where_siswa = '';
		$nama_siswa = 'Semua';
		if ($siswa != 'Semua') {
			$where_siswa = "AND a.id_siswa = '$siswa'";
			$row_s = $this->db->get_where('siswa', ['id_siswa' => $siswa])->row_array();
			$nama_siswa = $row_s['nama_lengkap'];
		}

    	$get_data = $this->db->query("SELECT
										a.*
									FROM absen_siswa a
									LEFT JOIN siswa b ON a.id_siswa = b.id_siswa
                           			WHERE STR_TO_DATE(a.tanggal,'%d-%m-%Y') >= STR_TO_DATE('$start','%d-%m-%Y')
                            		AND STR_TO_DATE(a.tanggal,'%d-%m-%Y') <= STR_TO_DATE('$end','%d-%m-%Y')
                    				AND b.id_kelas = '$kelas'
									$where_siswa
                    				$where_status_absensi
                 				")->result_array();

    	$data_kelas = $this->db->get_where('kelas', ['id_kelas' => $kelas])->row_array();

    	$tanggal = $start.' - '.$end;
		
		// setting excel
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
    	$style_col = [
	      'font' => ['bold' => true], // Set font nya jadi bold
	      'alignment' => [
	        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
	        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
	      ],
	      'borders' => [
	        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
	        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
	        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
	        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
	      ]
	    ];
	    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
	    $style_row_center = [
	      'alignment' => [
	        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
	        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
	      ],
	      'borders' => [
	        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
	        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
	        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
	        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
	      ]
	    ];

	    $style_row_left = [
	      'alignment' => [
	        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
	        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
	      ],
	      'borders' => [
	        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
	        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
	        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
	        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
	      ]
	    ];

		$title = "Laporan Rekapan Absensi Siswa Kelas " . $data_kelas['tingkatan_kelas'] . ' ' .$data_kelas['nama_kelas'];

	    $sheet->setCellValue('A1', $title); // Set kolom A1 dengan tulisan "DATA SISWA"
	    $sheet->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
	    $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
	    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);	    

	    $sheet->setCellValue('A3', 'Tanggal : ' . $tanggal);
	    $sheet->getStyle('A3')->getFont()->setBold(true);

	    $sheet->setCellValue('A4', 'Kelas : ' . $data_kelas['tingkatan_kelas'] . ' ' .$data_kelas['nama_kelas']);
	    $sheet->getStyle('A4')->getFont()->setBold(true);

	    $sheet->setCellValue('A5', 'Siswa : ' . $nama_siswa);
	    $sheet->getStyle('A5')->getFont()->setBold(true);

	   	$sheet->setCellValue('A6', 'Status Absen : ' . ucfirst(str_replace('_', ' ', $status_absensi)));
	    $sheet->getStyle('A6')->getFont()->setBold(true);

	    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$sheet->setCellValue('A8', 'No');
		$sheet->setCellValue('B8', 'Nama Siswa');
		$sheet->setCellValue('C8', 'Kelas');
		$sheet->setCellValue('D8', 'Status Presensi');
		$sheet->setCellValue('E8', 'Jam Masuk');
		$sheet->setCellValue('F8', 'Jam Pulang');
		$sheet->setCellValue('G8', 'Tanggal');

	    $sheet->getStyle('A8')->applyFromArray($style_col);
	    $sheet->getStyle('B8')->applyFromArray($style_col);
	    $sheet->getStyle('C8')->applyFromArray($style_col);
	    $sheet->getStyle('D8')->applyFromArray($style_col);
	    $sheet->getStyle('E8')->applyFromArray($style_col);
	    $sheet->getStyle('F8')->applyFromArray($style_col);
	    $sheet->getStyle('G8')->applyFromArray($style_col);

		$x = 9;
		foreach ($get_data as $key => $data) {
			$sheet->setCellValue('A'.$x, ++$key);
			$sheet->setCellValue('B'.$x, $data['nama_siswa']);
			$sheet->setCellValue('C'.$x, $data['kelas']);
			$sheet->setCellValue('D'.$x, $data['status_masuk']);
			$sheet->setCellValue('E'.$x, $data['jam_masuk']);
			$sheet->setCellValue('F'.$x, $data['jam_pulang']);
			$sheet->setCellValue('G'.$x, $data['tanggal']);
			
			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
	      	$sheet->getStyle('A'.$x)->applyFromArray($style_row_center);
	      	$sheet->getStyle('B'.$x)->applyFromArray($style_row_left);
	      	$sheet->getStyle('C'.$x)->applyFromArray($style_row_center);
	      	$sheet->getStyle('D'.$x)->applyFromArray($style_row_center);
	      	$sheet->getStyle('E'.$x)->applyFromArray($style_row_center);
	      	$sheet->getStyle('F'.$x)->applyFromArray($style_row_center);
	      	$sheet->getStyle('G'.$x)->applyFromArray($style_row_center);
			$x++;
		}

		// Set width kolom
	    $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
	    $sheet->getColumnDimension('B')->setWidth(30); // Set width kolom B
	    $sheet->getColumnDimension('C')->setWidth(20);
	    $sheet->getColumnDimension('D')->setWidth(20); // Set width kolom C
	    $sheet->getColumnDimension('E')->setWidth(20); // Set width kolom D
	    $sheet->getColumnDimension('F')->setWidth(20);
	    $sheet->getColumnDimension('G')->setWidth(20);

	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    	$sheet->getDefaultRowDimension()->setRowHeight(-1);

    	// Set judul file excel nya
    	// $sheet->setTitle("LAPORAN ". $title);

		$writer = new Xlsx($spreadsheet);
		$filename = 'laporan-rekap-absensi-siswa-kelas-'. $data_kelas['tingkatan_kelas'] . ' ' .$data_kelas['nama_kelas'];

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
	
		$writer->save('php://output');
	}

	public function export_excel_bulanan()
	{
		$kelas = $this->input->get('kelas');
	    $bulan = $this->input->get('bulan') == '' ? date('m') : $this->input->get('bulan');
	    $tahun = $this->input->get('tahun') == '' ? date('Y') : $this->input->get('tahun');

		$data_siswa = $this->db->query("SELECT
											a.*
										FROM siswa a
										WHERE id_kelas = $kelas
					")->result_array();

    	$data_kelas = $this->db->get_where('kelas', ['id_kelas' => $kelas])->row_array();
		
		// setting excel
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
    	$style_col = [
    	  'font' => ['size' => 11],
	      'alignment' => [
	        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
	        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
	      ],
	      'borders' => [
	        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
	        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
	        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
	        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
	      ]
	    ];
	    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
	    $style_row_center = [
	      'font' => ['size' => 11],
	      'alignment' => [
	        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
	        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
	      ],
	      'borders' => [
	        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
	        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
	        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
	        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
	      ]
	    ];

	    $style_row_left = [
	      'font' => ['size' => 11],
	      'alignment' => [
	        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
	        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
	      ],
	      'borders' => [
	        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
	        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
	        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
	        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
	      ]
	    ];

	    $bulan_text = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

	    $bulan_nominal = substr($bulan, 0, 1) == 0 ? substr($bulan, 1, 1) : $bulan;


		$title = "Laporan Rekapan Absensi Siswa " . $bulan_text[$bulan_nominal - 1] . ' ' . $tahun;

		// no
	    $sheet->setCellValue('A1', 'No'); // Set kolom A1 dengan tulisan "DATA SISWA"
	    $sheet->mergeCells('A1:A3'); // Set Merge Cell pada kolom A1 sampai E1
	    $sheet->getColumnDimension('A')->setWidth(5);
	    $sheet->getStyle('A1:A3')->applyFromArray($style_col);

	    // nama
	    $sheet->setCellValue('B1', 'Nama');
	    $sheet->mergeCells('B1:B3');
	    $sheet->getStyle('B1:B3')->applyFromArray($style_col);
	    $sheet->getColumnDimension('B')->setWidth(45);

	    // tanggal
	    $sheet->setCellValue('C1', 'Tanggal');
	    $sheet->mergeCells('C1:BL1');
	    $sheet->getStyle('C1:BL1')->applyFromArray($style_col);

	    // total kehadiran
	    $sheet->setCellValue('BM1', 'Total Kehadiran');
	    $sheet->mergeCells('BM1:BO1');
	    $sheet->getStyle('BM1:BO1')->applyFromArray($style_col);

	    // tepat waktu
	    $sheet->setCellValue('BM2', 'Tepat Waktu');
	    $sheet->mergeCells('BM2:BM3');
	    $sheet->getStyle('BM2:BM3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF92D050');
	    $sheet->getColumnDimension('BM')->setWidth(15);
	    $sheet->getStyle('BM2:BM3')->applyFromArray($style_col);

	    // terlambat
	    $sheet->setCellValue('BN2', 'Terlambat');
	    $sheet->mergeCells('BN2:BN3');
	    $sheet->getStyle('BN2:BN3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');
	    $sheet->getColumnDimension('BN')->setWidth(15);
	    $sheet->getStyle('BN2:BN3')->applyFromArray($style_col);

	    // izin
	    $sheet->setCellValue('BO2', 'Izin');
	    $sheet->mergeCells('BO2:BO3');
	    $sheet->getStyle('BO2:BO3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF00');
	    $sheet->getColumnDimension('BO')->setWidth(15);
	    $sheet->getStyle('BO2:BO3')->applyFromArray($style_col);

	    $column_absen_hari = ['C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL'];

	    $j = 1;
	    for ($i=0; $i < count($column_absen_hari); $i++) {
	    	// column Pulang
			$sheet->setCellValue($column_absen_hari[$i] . '3', 'P');
		    $sheet->getStyle($column_absen_hari[$i] . '3')->applyFromArray($style_col);

	    	if($i % 2 == 0) {
		    	$sheet->setCellValue($column_absen_hari[$i] . '2', $j);
			    $sheet->mergeCells($column_absen_hari[$i] . '2:' . $column_absen_hari[$i + 1] . '2');
			    $sheet->getStyle($column_absen_hari[$i] . '2:' . $column_absen_hari[$i + 1] . '2')->applyFromArray($style_col);

			    ++$j;

			    // column Datang
				$sheet->setCellValue($column_absen_hari[$i] . '3', 'D');
			    $sheet->getStyle($column_absen_hari[$i] . '3')->applyFromArray($style_col);		    
	    	}
	    }

	    $j = 1;

	    $test = [];
	    foreach ($data_siswa as $key => $siswa) {
	    	// column No
	    	$sheet->setCellValue('A'. (4 + $key), $j++);
	    	$sheet->getStyle('A'.(4 + $key))->applyFromArray($style_row_center);

	    	// column Siswa
			$sheet->setCellValue('B'.(4 + $key), $siswa['nama_lengkap']);
		    $sheet->getStyle('B'.(4 + $key))->applyFromArray($style_row_left);

		    $id_siswa = $siswa['id_siswa'];

	    	$k = 1;
		    $tanggal = '';
		    $data_absen_siswa = [];
		    $jumlah_tepat_waktu = 0;
		    $jumlah_terlambat = 0;
		    $jumlah_ijin = $this->db->query("SELECT
		    									a.* 
		    								FROM ijin_siswa a
		    								WHERE bulan = '$bulan'
		    								AND tahun = '$tahun'
		    								AND id_siswa = '$id_siswa'
		    				")->num_rows();

		    for ($i=0; $i < count($column_absen_hari); $i++) {

		    	if($i % 2 == 0) {
				    $tanggal = sprintf("%02d", $k) . '-' . $bulan . '-' . $tahun;
				    $data_absen_siswa = $this->db->query("SELECT
														a.jam_masuk as jam,
														IF(a.status_masuk = 'Tepat Waktu', 'TW', 'TL') as status,
														a.tanggal
													FROM
														absen_siswa a
														WHERE a.id_siswa = $id_siswa
														AND a.tanggal = '$tanggal'
														AND a.jam_masuk <> ''
														
													UNION ALL 

													SELECT
														a.jam_pulang as jam,
														'TW' as status,
														a.tanggal
													FROM
														absen_siswa a
														WHERE a.id_siswa = $id_siswa
														AND a.tanggal = '$tanggal'
														AND a.jam_pulang <> ''
	    							")->result_array();
		    		
		    		$test[] = $this->db->last_query();
			    	++$k;
		    	}

		    	if(empty($data_absen_siswa)) {
		    		// column Pulang kosong
			    	$sheet->setCellValue($column_absen_hari[$i] . (4 + $key), '');
			    	$sheet->getStyle($column_absen_hari[$i] . (4 + $key))->applyFromArray($style_col);

			    	if($i % 2 == 0) {
					    // column Datang kosong
						$sheet->setCellValue($column_absen_hari[$i] . (4 + $key), '');
					    $sheet->getStyle($column_absen_hari[$i] . (4 + $key))->applyFromArray($style_col);		    
			    	}
		    	} else {
			    	// column Pulang
					$sheet->setCellValue($column_absen_hari[$i] . (4 + $key), empty($data_absen_siswa[1]['status']) ? '' : $data_absen_siswa[1]['status']);
					if(!empty($data_absen_siswa[1]['status'])) {
						$warna = 'FF92D050';
						if($data_absen_siswa[1]['status'] == 'TL') {
							$warna = 'FFFF0000';
						}

						$sheet->getStyle($column_absen_hari[$i] . (4 + $key))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($warna);
					}

				    $sheet->getStyle($column_absen_hari[$i] . (4 + $key))->applyFromArray($style_col);

			    	if($i % 2 == 0) {
					    // column Datang
						$sheet->setCellValue($column_absen_hari[$i] . (4 + $key), $data_absen_siswa[0]['status']);
						if(!empty($data_absen_siswa[0]['status'])) {
							$warna = 'FF92D050';
							if($data_absen_siswa[0]['status'] == 'TL') {
								$warna = 'FFFF0000';
								$jumlah_terlambat += 1;
							} else {
								$jumlah_tepat_waktu += 1;
							}

							$sheet->getStyle($column_absen_hari[$i] . (4 + $key))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($warna);
						}

					    $sheet->getStyle($column_absen_hari[$i] . (4 + $key))->applyFromArray($style_col);		    
			    	}
		    	}
		    }

			// column Total Tepat Waktu
			$sheet->setCellValue('BM'.(4 + $key), $jumlah_tepat_waktu);
		    $sheet->getStyle('BM'.(4 + $key))->applyFromArray($style_row_center);

		    // column Total Terlambat
			$sheet->setCellValue('BN'.(4 + $key), $jumlah_terlambat);
		    $sheet->getStyle('BN'.(4 + $key))->applyFromArray($style_row_center);

		    // column Total Tepat Waktu
			$sheet->setCellValue('BO'.(4 + $key), $jumlah_ijin);
		    $sheet->getStyle('BO'.(4 + $key))->applyFromArray($style_row_center);
	    }

		$writer = new Xlsx($spreadsheet);
		$filename = 'laporan-rekap-absensi-siswa-' . strtolower($bulan_text[$bulan_nominal - 1]) . '-' . $tahun;

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
	
		$writer->save('php://output');
	}
}

/* End of file Laporan_rekapan_absensi_kelas.php */
/* Location: ./application/controllers/Laporan_rekapan_absensi_kelas.php */
