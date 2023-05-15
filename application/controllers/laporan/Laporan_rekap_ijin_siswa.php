<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan_rekap_ijin_siswa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['kelas'] = $this->db->get('kelas')->result_array();

		$this->load->view('templates/header', $data);
	    $this->load->view('laporan/laporan_rekap_ijin_siswa');
	    $this->load->view('templates/footer');
	}

	public function print_laporan()
	{
		$kelas = $this->input->post('kelas');
		$siswa = $this->input->post('siswa');
		$start = $this->input->post('date_start');
		$end = $this->input->post('date_end');
		$date_start_cek = date('Y-m-d', strtotime($start));
	    $date_end = date('Y-m-d', strtotime($end));
	    $date_end_cek = new DateTime($date_end);
	    $date_end_cek->add(new DateInterval('P1D'));
	    $date_end_cek = $date_end_cek->format('Y-m-d');

	    $data_kelas = $this->db->get_where('kelas', ['id_kelas' => $kelas])->row_array();
	    $string_kelas = $data_kelas['tingkatan_kelas'] . ' '. $data_kelas['nama_kelas'];

        $where_siswa = '';
		$nama_siswa = 'Semua';
		if ($siswa != 'Semua') {
			$where_siswa = "AND a.id_siswa = '$siswa'";
			$row_s = $this->db->get_where('siswa', ['id_siswa' => $siswa])->row_array();
			$nama_siswa = $row_s['nama_lengkap'];
		}

        $result = $this->db->query("SELECT
								 		a.*
									FROM ijin_siswa a
	                               	WHERE STR_TO_DATE(a.tanggal,'%d-%m-%Y') >= STR_TO_DATE('$start','%d-%m-%Y')
	                                AND STR_TO_DATE(a.tanggal,'%d-%m-%Y') <= STR_TO_DATE('$end','%d-%m-%Y')
	                                AND kelas = '$string_kelas'
	                                $where_siswa
                             	")->result_array();

        // var_dump($this->db->last_query()); die();

        $data['siswa'] = $nama_siswa;
		$data['res'] = $result;
		$data['tanggal'] = $start.' - '.$end;
	    $data['settitle'] = 'Laporan Rekap Ijin Siswa';

	    $this->load->view('laporan/cetak/laporan_rekap_ijin_siswa', $data);
	}

	public function export_excel()
	{
		$kelas = $this->input->get('kelas');
		$siswa = $this->input->get('siswa');
		$start = $this->input->get('date_start');
		$end = $this->input->get('date_end');
		$date_start_cek = date('Y-m-d', strtotime($start));
	    $date_end = date('Y-m-d', strtotime($end));
	    $date_end_cek = new DateTime($date_end);
	    $date_end_cek->add(new DateInterval('P1D'));
	    $date_end_cek = $date_end_cek->format('Y-m-d');


        $where_siswa = '';
		$nama_siswa = 'Semua';
		if ($siswa != 'Semua') {
			$where_siswa = "AND a.id_siswa = '$siswa'";
			$row_s = $this->db->get_where('siswa', ['id_siswa' => $siswa])->row_array();
			$nama_siswa = $row_s['nama_lengkap'];
		}

        $get_data = $this->db->query("SELECT
								 		a.*
									FROM ijin_siswa a
	                               	WHERE STR_TO_DATE(a.tanggal,'%d-%m-%Y') >= STR_TO_DATE('$start','%d-%m-%Y')
	                                AND STR_TO_DATE(a.tanggal,'%d-%m-%Y') <= STR_TO_DATE('$end','%d-%m-%Y')
	                                AND kelas = '$kelas'
	                                $where_siswa
                             	")->result_array();

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

		$title = "Laporan Rekapan Ijin Siswa";

	    $sheet->setCellValue('A1', $title); // Set kolom A1 dengan tulisan "DATA SISWA"
	    $sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
	    $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
	    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);	    

	    $sheet->setCellValue('A3', 'Siswa : ' . $nama_siswa);
	    $sheet->getStyle('A3')->getFont()->setBold(true);

	    $sheet->setCellValue('A4', 'Tanggal : ' . $tanggal);
	    $sheet->getStyle('A4')->getFont()->setBold(true);

	    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$sheet->setCellValue('A6', 'No');
		$sheet->setCellValue('B6', 'Nama Siswa');
		$sheet->setCellValue('C6', 'Kelas');
		$sheet->setCellValue('D6', 'Ijin');
		$sheet->setCellValue('E6', 'Tanggal');

	    $sheet->getStyle('A6')->applyFromArray($style_col);
	    $sheet->getStyle('B6')->applyFromArray($style_col);
	    $sheet->getStyle('C6')->applyFromArray($style_col);
	    $sheet->getStyle('D6')->applyFromArray($style_col);
	    $sheet->getStyle('E6')->applyFromArray($style_col);

		$x = 7;
		foreach ($get_data as $key => $data) {
			$sheet->setCellValue('A'.$x, ++$key);
			$sheet->setCellValue('B'.$x, $data['nama_siswa']);
			$sheet->setCellValue('C'.$x, $data['kelas']);
			$sheet->setCellValue('D'.$x, $data['ijin']);
			$sheet->setCellValue('E'.$x, $data['tanggal']);
			
			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
	      	$sheet->getStyle('A'.$x)->applyFromArray($style_row_center);
	      	$sheet->getStyle('B'.$x)->applyFromArray($style_row_left);
	      	$sheet->getStyle('C'.$x)->applyFromArray($style_row_center);
	      	$sheet->getStyle('D'.$x)->applyFromArray($style_row_center);
	      	$sheet->getStyle('E'.$x)->applyFromArray($style_row_center);
			$x++;
		}

		// Set width kolom
	    $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
	    $sheet->getColumnDimension('B')->setWidth(30); // Set width kolom B
	    $sheet->getColumnDimension('C')->setWidth(20);
	    $sheet->getColumnDimension('D')->setWidth(20); // Set width kolom C
	    $sheet->getColumnDimension('E')->setWidth(20); // Set width kolom D

	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
    	$sheet->getDefaultRowDimension()->setRowHeight(-1);

    	// Set judul file excel nya
    	// $sheet->setTitle("LAPORAN ". $title);

		$writer = new Xlsx($spreadsheet);
		$filename = 'laporan-rekap-ijin-siswa-' .$tanggal;

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
	
		$writer->save('php://output');
	}
}

/* End of file Laporan_rekap_ijin_pegawai.php */
/* Location: ./application/controllers/Laporan_rekap_ijin_pegawai.php */