<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Presensi_pegawai extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('absensi/M_presensi_pegawai', 'model');
		if (!$this->session->userdata('logged_in')) {
	      redirect('auth/login');
	  }
	}

	public function index()
	{
    $data['pegawai'] = $this->db->get('pegawai')->result_array();

		$this->load->view('templates/header');
    $this->load->view('absensi/presensi_pegawai/index', $data);
    $this->load->view('templates/footer');
	}

	public function export_excel()
	{
		$pilih_pegawai = $this->input->get('pilih_pegawai');
    $date_start_cek = date('Y-m-d', strtotime($this->input->get('date_start')));
    $date_end = date('Y-m-d', strtotime($this->input->get('date_end')));
    $date_end_cek = new DateTime($date_end);
    $date_end_cek->add(new DateInterval('P1D'));
    $date_end_cek = $date_end_cek->format('Y-m-d');

    $get_data = $this->model->get_data($pilih_pegawai, $date_start_cek, $date_end_cek);

		$date_start = $this->input->get('date_start');
		$date_end = $this->input->get('date_end');

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
    $style_row = [
       'alignment' => [
	       'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ],
     	'borders' => [
       'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
       'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
       'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
       'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
	     ]
    ];

	  if($date_start == '' && $date_end == '') {
			$currentDate = date('d-m-Y');
			$title = "DATA ABSENSI TGL $currentDate";
		} else {
			$title = "DATA ABSENSI TGL $date_start sd $date_end";
		}

    $sheet->setCellValue('A1', $title); // Set kolom A1 dengan tulisan "DATA SISWA"
    $sheet->mergeCells('A1:H1'); // Set Merge Cell pada kolom A1 sampai E1
    $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

	  // Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$sheet->setCellValue('A3', 'No');
		$sheet->setCellValue('B3', 'Jabatan');
		$sheet->setCellValue('C3', 'Nama Pegawai');
		$sheet->setCellValue('D3', 'Status Presensi');
		$sheet->setCellValue('E3', 'Jam Masuk');
		$sheet->setCellValue('F3', 'Jam Pulang');
		$sheet->setCellValue('G3', 'Tanggal');

    $sheet->getStyle('A3')->applyFromArray($style_col);
    $sheet->getStyle('B3')->applyFromArray($style_col);
    $sheet->getStyle('C3')->applyFromArray($style_col);
    $sheet->getStyle('D3')->applyFromArray($style_col);
    $sheet->getStyle('E3')->applyFromArray($style_col);
    $sheet->getStyle('F3')->applyFromArray($style_col);
    $sheet->getStyle('G3')->applyFromArray($style_col);

		$x = 4;
		foreach ($get_data as $key => $data) {
			$status_presensi = '';
			$jam_masuk = '';
			$jam_pulang = '';
			if ($data['status'] == '0') {
				$status_presensi = $data['keterangan'];
				$jam_masuk = '';
				$jam_pulang = '';
			}else {
				$status_presensi = $data['status_masuk'];
				$jam_masuk = $data['jam_masuk'];
				$jam_pulang = $data['jam_pulang'];
			}

			$sheet->setCellValue('A'.$x, ++$key);
			$sheet->setCellValue('B'.$x, $data['jabatan']);
			$sheet->setCellValue('C'.$x, $data['nama_pegawai']);
			$sheet->setCellValue('D'.$x, $status_presensi);
			$sheet->setCellValue('E'.$x, $jam_masuk);
			$sheet->setCellValue('F'.$x, $jam_pulang);
			$sheet->setCellValue('G'.$x, $data['tanggal']);

			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
    	$sheet->getStyle('A'.$x)->applyFromArray($style_row);
    	$sheet->getStyle('B'.$x)->applyFromArray($style_row);
    	$sheet->getStyle('C'.$x)->applyFromArray($style_row);
    	$sheet->getStyle('D'.$x)->applyFromArray($style_row);
    	$sheet->getStyle('E'.$x)->applyFromArray($style_row);
    	$sheet->getStyle('F'.$x)->applyFromArray($style_row);
    	$sheet->getStyle('G'.$x)->applyFromArray($style_row);
			$x++;
		}

    $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
    $sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
    $sheet->getColumnDimension('C')->setWidth(30); // Set width kolom C
    $sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
    $sheet->getColumnDimension('E')->setWidth(20); // Set width kolom E
    $sheet->getColumnDimension('F')->setWidth(20); // Set width kolom F
    $sheet->getColumnDimension('G')->setWidth(20); // Set width kolom G

    $sheet->getDefaultRowDimension()->setRowHeight(-1);

  	$writer = new Xlsx($spreadsheet);
		if($date_start == '' && $date_end == '') {
			$currentDate = date('d-m-Y');
			$filename = 'laporan-rekap-absensi-pegawai-'.$currentDate;
		} else {
			$filename = 'laporan-rekap-absensi-pegawai-'.$date_start.'-sd-'.$date_end;
		}

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function get_data()
	{
		$pilih_pegawai = $this->input->get('pilih_pegawai');
    $date_start_cek = date('Y-m-d', strtotime($this->input->get('date_start')));
    $date_end = date('Y-m-d', strtotime($this->input->get('date_end')));
    $date_end_cek = new DateTime($date_end);
    $date_end_cek->add(new DateInterval('P1D'));
    $date_end_cek = $date_end_cek->format('Y-m-d');

    $data = $this->model->get_data($pilih_pegawai, $date_start_cek, $date_end_cek);

		echo json_encode($data);
	}

  public function get_pegawai(){
    $id_kelas = $this->input->get('id_kelas');
    $data = $this->model->get_pegawai($id_kelas);

    echo json_encode($data);
  }
}

/* End of file presensi.php */
/* Location: ./application/controllers/absensi/Master_perizinan.php */
