<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Http;
use Session;
class LaporanController extends Controller
{
    //
    public function absen($TypeRole)
    {
        $page_title = 'Laporan';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Absen'];
        $satuan_kerja = null;
        
        if ($TypeRole == 'super_admin') {
            $url = env('API_URL');
            $token = session()->get('user.access_token');
            $data = Http::withToken($token)->get($url."/satuan_kerja/list");
            $satuan_kerja = $data['data'];
        }
        return view('pages.laporan.absen', compact('page_title', 'page_description','breadcumb','TypeRole','satuan_kerja'));
    }

    public function skp()
    {
        $page_title = 'Laporan';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['SKP'];
        return view('pages.laporan.skp', compact('page_title', 'page_description','breadcumb'));
    }


    public function aktivitas()
    {
        $page_title = 'Laporan';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Aktivitas'];


        return view('pages.laporan.aktivitas', compact('page_title', 'page_description','breadcumb'));
    }

    public function getRekapPegawai($params1,$params2){
      
            $url = env('API_URL');
            $token = session()->get('user.access_token');
          
            $response = Http::withToken($token)->get($url."/laporan-rekapitulasi-absen/rekapByUser/".$params1."/".$params2);
       
            if ($response->successful() && isset($response->object()->data)) {
                return $response->json();
            }else{
                return 'err';
            }
        
    }

    public function getRekappegawaiByOpd($params1,$params2,$satuan_kerja){
        // return $params1;
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = '';

        if(!is_null($satuan_kerja)){
            $response = Http::withToken($token)->get($url."/laporan-rekapitulasi-absen/rekapByOpd/".$params1."/".$params2.'/'.$satuan_kerja);
        }else{
            $response = Http::withToken($token)->get($url."/laporan-rekapitulasi-absen/rekapByOpd/".$params1."/".$params2.'/0');
        }


        if ($response->successful()) {
            return $response->json();
        }else{
            return 'err';
        }
    
    }

    public function exportRekapAbsen($params){
        $val = json_decode($params);

        if ($val->role == 'pegawai') {

            $data = $this->getRekapPegawai($val->startDate,$val->endDate); 
            $this->exportrekapPegawai($data,$val->type,'desktop');  
        }else if($val->role == 'admin' || $val->role == 'super_admin'){
            $data = $this->getRekappegawaiByOpd($val->startDate,$val->endDate,$val->satuanKerja); 
            $this->exportrekapOpd($data,$val->type,$val->startDate,$val->endDate);
        }
    }

    public function checkLevel(){
        $level = session()->get('user.level_jabatan');
        return $level;
    }

    public function getSkp($level){
      
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $data = Http::withToken($token)->get($url."/laporan/skp/".$level);
        return $data;
    }

    public function exportLaporanSkp($jenis,$type,$bulan){
        // return 'cek';
        $level = $this->checkLevel();
        $res = [];

        if ($level == 1 || $level == 2) {
            $level = 'kepala';
        }else{
            $level = 'pegawai';
        }

       

        $data = $this->getSkp($level); 
  
        if ($data['status'] == true) {
            $res = $data['data'];
        }

        if ($jenis == 'skp') {

            if ($level == 'pegawai') {
                return $this->exportSkp($res,$bulan,$type,$level);
            }else{
                return $this->exportKepala($res,$bulan,$type,$level);
            }

             
        }else{
            if ($level == 'pegawai') {
                return $this->exportRealisasi($res,$bulan,$type,$level);
            }else{
                return $this->exportRealisasiKepala($res,$bulan,$type,$level);
            }
            
        }
    }

    public function exportKepala($data,$bulan,$type,$level){
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('BKPSDM BULUKUMBA')
            ->setLastModifiedBy('BKPSDM BULUKUMBA')
            ->setTitle('Laporan SKP Pejabat administrator')
            ->setSubject('Laporan SKP Pejabat administrator')
            ->setDescription('Laporan SKP Pejabat administrator')
            ->setKeywords('pdf php')
            ->setCategory('LAPORAN SKP');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(5)->setRowHeight(25);
        $sheet->getRowDimension(1)->setRowHeight(17);
        $sheet->getRowDimension(2)->setRowHeight(17);
        $sheet->getRowDimension(3)->setRowHeight(17);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        // //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        $sheet->setCellValue('A2', 'SASARAN KINIRJA PEGAWAI (SKP')->mergeCells('A2:L2');
        $sheet->setCellValue('A6', 'PEGAWAI YANG DINILAI')->mergeCells('A6:C6');
        // $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->setCellValue('D6', 'PEJABAT PENILAI PEKERJA')->mergeCells('D6:F6');
        // $sheet->getColumnDimension('D')->setWidth(10);
       

        $sheet->setCellValue('A7', 'Nama')->mergeCells('A7:B7');
        $sheet->setCellValue('C7', $data['pegawai_dinilai']['nama']);
        $sheet->setCellValue('A8', 'NIP')->mergeCells('A8:B8');
        $sheet->setCellValue('C8', $data['pegawai_dinilai']['nip']);
        $sheet->setCellValue('A9', 'Pangkat / Gol Ruang')->mergeCells('A9:B9');
        $sheet->setCellValue('C9', $data['pegawai_dinilai']['golongan']);
        $sheet->setCellValue('A10', 'Jabatan')->mergeCells('A10:B10');
        $sheet->setCellValue('C10', $data['pegawai_dinilai']['nama_jabatan']);
        $sheet->setCellValue('A11', 'Unit kerja')->mergeCells('A11:B11');
        $sheet->setCellValue('C11', $data['pegawai_dinilai']['nama_satuan_kerja']);

        
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(90);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(40);

        $sheet->setCellValue('D7', 'Nama');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('E7', $data['atasan']['nama'])->mergeCells('E7:F7');
        } else {
            $sheet->setCellValue('E7', '-')->mergeCells('E7:F7');
        }
        $sheet->setCellValue('D8', 'NIP');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('E8', $data['atasan']['nip'])->mergeCells('E8:F8');
        } else {
            $sheet->setCellValue('E8', '-')->mergeCells('E8:F8');
        }
  
        $sheet->setCellValue('D9', 'Pangkat / Gol Ruang');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('E9', $data['atasan']['golongan'])->mergeCells('E9:F9');
        } else {
            $sheet->setCellValue('E9', '-')->mergeCells('E9:F9');
        } 
       
        $sheet->setCellValue('D10', 'Jabatan');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('E10', $data['atasan']['nama_jabatan'])->mergeCells('E10:F10');
        } else {
            $sheet->setCellValue('E10', '-')->mergeCells('E10:F10');
        } 
        $sheet->setCellValue('D11', 'Unit kerja');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('E11', $data['atasan']['nama_satuan_kerja'])->mergeCells('E11:F11');
        } else {
            $sheet->setCellValue('E11', '-')->mergeCells('E11:F11');
        } 
        $sheet->getColumnDimension('E')->setWidth(20);

        $sheet->setCellValue('A12', 'No')->mergeCells('A12:A13');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B12', 'RENCANA KINERJA ATASAN LANGSUNG')->mergeCells('B12:B13');
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->setCellValue('C12', 'RENCANA KINERJA')->mergeCells('C12:C13');
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->setCellValue('D12', 'ASPEK')->mergeCells('D12:D13');
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->setCellValue('E12', 'INDIKATOR KINERJA INDIVIDU')->mergeCells('E12:E13');
        $sheet->getColumnDimension('E')->setWidth(40);

        $sheet->setCellValue('F12', 'TARGET')->mergeCells('F12:F13');
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getStyle('A:F')->getAlignment()->setWrapText(true);

        $sheet->setCellValue('A14', 'A. KINERJA UTAMA')->mergeCells('A14:F14');
        // $sheet->getStyle('A10:G11')->getFont()->setBold(true);
        $cell = 15;


        foreach ( $data['skp'] as $index => $value ){
            $sheet->setCellValue('C' . $cell, $value['rencana_kerja']);
            foreach ($value['aspek_skp'] as $k => $v) {
                
                $sheet->setCellValue('D' . $cell, $v['aspek_skp']);
                $sheet->setCellValue('E' . $cell, $v['iki']);
                
                foreach ($v['target_skp'] as $mk => $rr) {
                    $sum_capaian = 0;
                    $kategori_ = '';
                    if ($rr['bulan'] ==  $bulan) {
                        $capaian_iki = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;
                        $sum_capaian += $capaian_iki;
                        $sheet->setCellValue('F' . $cell, $rr['target'].' '.$v['satuan']);                                
                    }
                }
                

                $cell++;  
            }
            
        }
 

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];
       
        $sheet->getStyle('A6:F' . $cell)->applyFromArray($border);

        // $sheet->getStyle('A12:F' . $cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        // $sheet->getStyle('A6:F6')->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A14:F14')->getAlignment()->setVertical('left')->setHorizontal('left');
         $sheet->getStyle('A14:F14')->getFont()->setBold(true);

   
        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan_absensi_.xlsx"');
        }else{
            $spreadsheet->getActiveSheet()->getHeaderFooter()
            ->setOddHeader('&C&H' . url()->current());
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddFooter('&L&B &RPage &P of &N');
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            header('Content-Type: application/pdf');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
        }

        $writer->save('php://output');
    }

    public function exportSkp($data,$bulan,$type,$level){
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('BKPSDM BULUKUMBA')
            ->setLastModifiedBy('BKPSDM BULUKUMBA')
            ->setTitle('Laporan SKP Pejabat administrator')
            ->setSubject('Laporan SKP Pejabat administrator')
            ->setDescription('Laporan SKP Pejabat administrator')
            ->setKeywords('pdf php')
            ->setCategory('LAPORAN SKP');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(5)->setRowHeight(25);
        $sheet->getRowDimension(1)->setRowHeight(17);
        $sheet->getRowDimension(2)->setRowHeight(17);
        $sheet->getRowDimension(3)->setRowHeight(17);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        // //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        $sheet->setCellValue('A2', 'SASARAN KINIRJA PEGAWAI (SKP')->mergeCells('A2:L2');
        $sheet->setCellValue('A6', 'PEGAWAI YANG DINILAI')->mergeCells('A6:C6');
        // $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->setCellValue('D6', 'PEJABAT PENILAI PEKERJA')->mergeCells('D6:F6');
        // $sheet->getColumnDimension('D')->setWidth(10);
       

        $sheet->setCellValue('A7', 'Nama')->mergeCells('A7:B7');
        
            $sheet->setCellValue('C7', $data['pegawai_dinilai']['nama']);
        
        
        $sheet->setCellValue('A8', 'NIP')->mergeCells('A8:B8');
        
        $sheet->setCellValue('C8', $data['pegawai_dinilai']['nip']);
        
        $sheet->setCellValue('A9', 'Pangkat / Gol Ruang')->mergeCells('A9:B9');
        $sheet->setCellValue('C9', $data['pegawai_dinilai']['golongan']);
        $sheet->setCellValue('A10', 'Jabatan')->mergeCells('A10:B10');
        $sheet->setCellValue('C10', $data['pegawai_dinilai']['nama_jabatan']);
        $sheet->setCellValue('A11', 'Unit kerja')->mergeCells('A11:B11');
        $sheet->setCellValue('C11', $data['pegawai_dinilai']['nama_satuan_kerja']);

        
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(90);
        $sheet->getColumnDimension('E')->setWidth(60);
        $sheet->getColumnDimension('F')->setWidth(40);

        $sheet->setCellValue('D7', 'Nama');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('E7', $data['atasan']['nama'])->mergeCells('E7:F7');
        } else {
            $sheet->setCellValue('E7', '-')->mergeCells('E7:F7');
        }
        $sheet->setCellValue('D8', 'NIP');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('E8', $data['atasan']['nip'])->mergeCells('E8:F8');
        } else {
            $sheet->setCellValue('E8', '-')->mergeCells('E8:F8');
        }
  
        $sheet->setCellValue('D9', 'Pangkat / Gol Ruang');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('E9', $data['atasan']['golongan'])->mergeCells('E9:F9');
        } else {
            $sheet->setCellValue('E9', '-')->mergeCells('E9:F9');
        } 
       
        $sheet->setCellValue('D10', 'Jabatan');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('E10', $data['atasan']['nama_jabatan'])->mergeCells('E10:F10');
        } else {
            $sheet->setCellValue('E10', '-')->mergeCells('E10:F10');
        } 
        $sheet->setCellValue('D11', 'Unit kerja');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('E11', $data['atasan']['nama_satuan_kerja'])->mergeCells('E11:F11');
        } else {
            $sheet->setCellValue('E11', '-')->mergeCells('E11:F11');
        } 
        $sheet->getColumnDimension('E')->setWidth(20);

        $sheet->setCellValue('A12', 'No')->mergeCells('A12:A13');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B12', 'RENCANA KINERJA ATASAN LANGSUNG')->mergeCells('B12:B13');
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->setCellValue('C12', 'RENCANA KINERJA')->mergeCells('C12:C13');
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->setCellValue('D12', 'ASPEK')->mergeCells('D12:D13');
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->setCellValue('E12', 'INDIKATOR KINERJA INDIVIDU')->mergeCells('E12:E13');
        $sheet->getColumnDimension('E')->setWidth(40);

        $sheet->setCellValue('F12', 'TARGET')->mergeCells('F12:F13');
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getStyle('A:F')->getAlignment()->setWrapText(true);

        $sheet->setCellValue('A14', 'A. KINERJA UTAMA')->mergeCells('A14:F14');
        // $sheet->getStyle('A10:G11')->getFont()->setBold(true);
        $cell = 15;

        $data_column = $data['skp']['utama'];
        $data_tambahan = $data['skp']['tambahan'];

        foreach ( $data_column as $index => $value ){
            $sheet->setCellValue('A' . $cell, $index+1);
                if(isset($value['atasan']['rencana_kerja'])){
                    $sheet->setCellValue('B' . $cell, $value['atasan']['rencana_kerja']);
                }else{
                    $sheet->setCellValue('B' . $cell, '');
                }
                foreach ($value['skp_child'] as $key => $res) {
                    $sheet->setCellValue('C' . $cell, $res['rencana_kerja']);
                    foreach ($res['aspek_skp'] as $k => $v) {
                       
                        $sheet->setCellValue('D' . $cell, $v['aspek_skp']);
                        $sheet->setCellValue('E' . $cell, $v['iki']);
                       
                        foreach ($v['target_skp'] as $mk => $rr) {
                            $sum_capaian = 0;
                            $kategori_ = '';
                            if ($rr['bulan'] ==  $bulan) {
                                $capaian_iki = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;
                                $sum_capaian += $capaian_iki;
    
                                $sheet->setCellValue('F' . $cell, $rr['target'].' '.$v['satuan']);
                               
                            }
                        }
                        
    
                        $cell++;  
                    }
                }         
        }

       

        if(isset($data_tambahan)){
             // TAMBAHAN
        $sheet->setCellValue('A'.$cell, 'B. KINERJA TAMBAHAN')->mergeCells('A'.$cell.':F'.$cell);
        $sheet->getStyle('A'.$cell.':F'.$cell)->getAlignment()->setVertical('left')->setHorizontal('left');
        $sheet->getStyle('A'.$cell.':F'.$cell)->getFont()->setBold(true);
        $cell++;
            foreach ($data_tambahan as $keyy => $values) {
                $sheet->setCellValue('A' . $cell, $index+1);
                $sheet->setCellValue('B' . $cell, '-');
                $sheet->setCellValue('C' . $cell, $values['rencana_kerja']);
                foreach ($values['aspek_skp'] as $k => $v) {
                    
                    $sheet->setCellValue('D' . $cell, $v['aspek_skp']);
                    $sheet->setCellValue('E' . $cell, $v['iki']);
                    
                    foreach ($v['target_skp'] as $mk => $rr) {
                        $sum_capaian = 0;
                        $kategori_ = '';
                        if ($rr['bulan'] ==  $bulan) {
                            $capaian_iki = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;
                            $sum_capaian += $capaian_iki;
    
                            $sheet->setCellValue('F' . $cell, $rr['target'].' '.$v['satuan']);
                            
                        }
                    }
                    
    
                    $cell++;  
                }
            }
        }
        

        

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];
       
        $sheet->getStyle('A6:F' . $cell)->applyFromArray($border);

        // $sheet->getStyle('A12:F' . $cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        // $sheet->getStyle('A6:F6')->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A14:F14')->getAlignment()->setVertical('left')->setHorizontal('left');
         $sheet->getStyle('A14:F14')->getFont()->setBold(true);

   
        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan_absensi_.xlsx"');
        }else{
            $spreadsheet->getActiveSheet()->getHeaderFooter()
            ->setOddHeader('&C&H' . url()->current());
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddFooter('&L&B &RPage &P of &N');
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            header('Content-Type: application/pdf');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
        }

        $writer->save('php://output');

    }

    public function exportRealisasiKepala($data,$bulan,$type,$level){
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('BKPSDM BULUKUMBA')
            ->setLastModifiedBy('BKPSDM BULUKUMBA')
            ->setTitle('Laporan SKP Pejabat administrator')
            ->setSubject('Laporan SKP Pejabat administrator')
            ->setDescription('Laporan SKP Pejabat administrator')
            ->setKeywords('pdf php')
            ->setCategory('LAPORAN SKP');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(5)->setRowHeight(25);
        $sheet->getRowDimension(1)->setRowHeight(17);
        $sheet->getRowDimension(2)->setRowHeight(17);
        $sheet->getRowDimension(3)->setRowHeight(17);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        // //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        $sheet->setCellValue('A2', 'PENILAIAN PEJABAT ADMINISTRATOR')->mergeCells('A2:L2');
        $sheet->setCellValue('A6', 'PEGAWAI YANG DINILAI')->mergeCells('A6:E6');
        $sheet->setCellValue('F6', 'PEJABAT PENILAI PEKERJA')->mergeCells('F6:L6');

        $sheet->setCellValue('A7', 'Nama')->mergeCells('A7:B7');
        $sheet->setCellValue('C7', $data['pegawai_dinilai']['nama'])->mergeCells('C7:E7');
        $sheet->setCellValue('A8', 'NIP')->mergeCells('A8:B8');
        $sheet->setCellValue('C8', $data['pegawai_dinilai']['nip'])->mergeCells('C8:E8');
        $sheet->setCellValue('A9', 'Pangkat / Gol Ruang')->mergeCells('A9:B9');
        $sheet->setCellValue('C9', $data['pegawai_dinilai']['golongan'])->mergeCells('C9:E9');
        $sheet->setCellValue('A10', 'Jabatan')->mergeCells('A10:B10');
        $sheet->setCellValue('C10', $data['pegawai_dinilai']['nama_jabatan'])->mergeCells('C10:E10');
        $sheet->setCellValue('A11', 'Unit kerja')->mergeCells('A11:B11');
        $sheet->setCellValue('C11', $data['pegawai_dinilai']['nama_satuan_kerja'])->mergeCells('C11:E11');

        $sheet->setCellValue('F7', 'Nama');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('G7', $data['atasan']['nama'])->mergeCells('G7:L7');
        } else {
            $sheet->setCellValue('G7', '-')->mergeCells('G7:L7');
        }
        $sheet->setCellValue('F8', 'NIP');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('G8', $data['atasan']['nip'])->mergeCells('G8:L8');
        } else {
            $sheet->setCellValue('G8', '-')->mergeCells('G8:L8');
        }
  
        $sheet->setCellValue('F9', 'Pangkat / Gol Ruang');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('G9', $data['atasan']['golongan'])->mergeCells('G9:L9');
        } else {
            $sheet->setCellValue('G9', '-')->mergeCells('G9:L9');
        } 
       
        $sheet->setCellValue('F10', 'Jabatan');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('G10', $data['atasan']['nama_jabatan'])->mergeCells('G10:L10');
        } else {
            $sheet->setCellValue('G10', '-')->mergeCells('G10:L10');
        } 
        $sheet->setCellValue('F11', 'Unit kerja');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('G11', $data['atasan']['nama_satuan_kerja'])->mergeCells('G11:L11');
        } else {
            $sheet->setCellValue('G11', '-')->mergeCells('G11:L11');
        } 
        $sheet->getColumnDimension('F')->setWidth(20);

        $sheet->setCellValue('A12', 'No')->mergeCells('A12:A13');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B12', 'RENCANA KINERJA ATASAN LANGSUNG')->mergeCells('B12:B13');
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->setCellValue('C12', 'RENCANA KINERJA')->mergeCells('C12:C13');
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->setCellValue('D12', 'ASPEK')->mergeCells('D12:D13');
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->setCellValue('E12', 'INDIKATOR KINERJA INDIVIDU')->mergeCells('E12:E13');
        $sheet->getColumnDimension('E')->setWidth(25);

        $sheet->setCellValue('F12', 'TARGET')->mergeCells('F12:F13');
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->setCellValue('G12', 'REALISASI')->mergeCells('G12:G13');
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->setCellValue('H12', 'CAPAIAN IKI')->mergeCells('H12:H13');
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->setCellValue('I12', 'KATEGORI PENCAPAIAN IKI')->mergeCells('I12:I13');
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->setCellValue('J12', 'CAPAIAN RENCANA KINERJA')->mergeCells('J12:K12');
        $sheet->setCellValue('J13', 'KATEGORI');
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->setCellValue('K13', 'NILAI');
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->setCellValue('L12', 'NILAI TERTIMBANG')->mergeCells('L12:L13');
        $sheet->getColumnDimension('L')->setWidth(20);

        $sheet->getStyle('A:L')->getAlignment()->setWrapText(true);
        // $sheet->getStyle('A10:G11')->getFont()->setBold(true);
        $cell = 14;

        foreach ( $data['skp'] as $index => $value ){
            
            $sheet->setCellValue('C' . $cell, $value['rencana_kerja']);
                    foreach ($value['aspek_skp'] as $k => $v) {
                       
                        $sheet->setCellValue('D' . $cell, $v['aspek_skp']);
                        $sheet->setCellValue('E' . $cell, $v['iki']);
                       
                        foreach ($v['target_skp'] as $mk => $rr) {
                            $sum_capaian = 0;
                            $kategori_ = '';
                            if ($rr['bulan'] ==  $bulan) {
                                $capaian_iki = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;
                                $sum_capaian += $capaian_iki;
    
                                $sheet->setCellValue('F' . $cell, $rr['target'].' '.$v['satuan']);
                                $sheet->setCellValue('G' . $cell, $v['realisasi_skp'][$mk]['realisasi_bulanan'].' '.$v['satuan']);
                                $sheet->setCellValue('H' . $cell, round($capaian_iki,0) .' %');
                                if ($capaian_iki > 100) {
                                    $sheet->setCellValue('I' . $cell, 'Sangat baik');
                                }elseif($capaian_iki == 100){
                                    $sheet->setCellValue('I' . $cell, 'Baik');
                                }elseif($capaian_iki > 80 && $capaian_iki < 90){
                                    $sheet->setCellValue('I' . $cell, 'Cukup');
                                }elseif($capaian_iki > 60 && $capaian_iki < 79){
                                    $sheet->setCellValue('I' . $cell, 'Kurang');
                                }else{
                                    $sheet->setCellValue('I' . $cell, 'Sangat kurang');
                                }

                                if ($sum_capaian > 110) {
                                    $kategori_ = 'Sangat baik';
                                }elseif($sum_capaian >= 90 && $sum_capaian <= 109){
                                    $kategori_ = 'Baik'; 
                                }elseif($sum_capaian >= 70 && $sum_capaian <= 89){
                                    $kategori_ = 'Cukup'; 
                                }elseif($sum_capaian >= 50 && $sum_capaian <= 69){
                                    $kategori_ = 'Kurang';
                                }elseif($sum_capaian >= 0 && $sum_capaian <= 49){
                                    $kategori_ = 'Sangat kurang'; 
                                }else{
                                    $kategori_ = '-';
                                }

                                $sheet->setCellValue('J' . $cell, $kategori_);
                                $sheet->setCellValue('K' . $cell, round($sum_capaian,2));
    
                                
                            }
                        }
                        
    
                        $cell++;  
                    }
        }
        

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];
       
        $sheet->getStyle('A6:L' . $cell)->applyFromArray($border);

        $sheet->getStyle('A12:L' . $cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A6:F6')->getAlignment()->setVertical('center')->setHorizontal('center');

   
        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan_absensi_.xlsx"');
        }else{
            $spreadsheet->getActiveSheet()->getHeaderFooter()
            ->setOddHeader('&C&H' . url()->current());
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddFooter('&L&B &RPage &P of &N');
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            header('Content-Type: application/pdf');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
        }

        $writer->save('php://output');
    }

    public function exportRealisasi($data,$bulan,$type,$level){
     
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('BKPSDM BULUKUMBA')
            ->setLastModifiedBy('BKPSDM BULUKUMBA')
            ->setTitle('Laporan SKP Pejabat administrator')
            ->setSubject('Laporan SKP Pejabat administrator')
            ->setDescription('Laporan SKP Pejabat administrator')
            ->setKeywords('pdf php')
            ->setCategory('LAPORAN SKP');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(5)->setRowHeight(25);
        $sheet->getRowDimension(1)->setRowHeight(17);
        $sheet->getRowDimension(2)->setRowHeight(17);
        $sheet->getRowDimension(3)->setRowHeight(17);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        // //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        $sheet->setCellValue('A2', 'PENILAIAN PEJABAT ADMINISTRATOR')->mergeCells('A2:L2');
        $sheet->setCellValue('A6', 'PEGAWAI YANG DINILAI')->mergeCells('A6:E6');
        $sheet->setCellValue('F6', 'PEJABAT PENILAI PEKERJA')->mergeCells('F6:L6');

        $sheet->setCellValue('A7', 'Nama')->mergeCells('A7:B7');
        $sheet->setCellValue('C7', $data['pegawai_dinilai']['nama'])->mergeCells('C7:E7');
        $sheet->setCellValue('A8', 'NIP')->mergeCells('A8:B8');
        $sheet->setCellValue('C8', $data['pegawai_dinilai']['nip'])->mergeCells('C8:E8');
        $sheet->setCellValue('A9', 'Pangkat / Gol Ruang')->mergeCells('A9:B9');
        $sheet->setCellValue('C9', $data['pegawai_dinilai']['golongan'])->mergeCells('C9:E9');
        $sheet->setCellValue('A10', 'Jabatan')->mergeCells('A10:B10');
        $sheet->setCellValue('C10', $data['pegawai_dinilai']['nama_jabatan'])->mergeCells('C10:E10');
        $sheet->setCellValue('A11', 'Unit kerja')->mergeCells('A11:B11');
        $sheet->setCellValue('C11', $data['pegawai_dinilai']['nama_satuan_kerja'])->mergeCells('C11:E11');

        $sheet->setCellValue('F7', 'Nama');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('G7', $data['atasan']['nama'])->mergeCells('G7:L7');
        } else {
            $sheet->setCellValue('G7', '-')->mergeCells('G7:L7');
        }
        $sheet->setCellValue('F8', 'NIP');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('G8', $data['atasan']['nip'])->mergeCells('G8:L8');
        } else {
            $sheet->setCellValue('G8', '-')->mergeCells('G8:L8');
        }
  
        $sheet->setCellValue('F9', 'Pangkat / Gol Ruang');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('G9', $data['atasan']['golongan'])->mergeCells('G9:L9');
        } else {
            $sheet->setCellValue('G9', '-')->mergeCells('G9:L9');
        } 
       
        $sheet->setCellValue('F10', 'Jabatan');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('G10', $data['atasan']['nama_jabatan'])->mergeCells('G10:L10');
        } else {
            $sheet->setCellValue('G10', '-')->mergeCells('G10:L10');
        } 
        $sheet->setCellValue('F11', 'Unit kerja');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('G11', $data['atasan']['nama_satuan_kerja'])->mergeCells('G11:L11');
        } else {
            $sheet->setCellValue('G11', '-')->mergeCells('G11:L11');
        } 
        $sheet->getColumnDimension('F')->setWidth(20);

        $sheet->setCellValue('A12', 'No')->mergeCells('A12:A13');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B12', 'RENCANA KINERJA ATASAN LANGSUNG')->mergeCells('B12:B13');
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->setCellValue('C12', 'RENCANA KINERJA')->mergeCells('C12:C13');
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->setCellValue('D12', 'ASPEK')->mergeCells('D12:D13');
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->setCellValue('E12', 'INDIKATOR KINERJA INDIVIDU')->mergeCells('E12:E13');
        $sheet->getColumnDimension('E')->setWidth(25);

        $sheet->setCellValue('F12', 'TARGET')->mergeCells('F12:F13');
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->setCellValue('G12', 'REALISASI')->mergeCells('G12:G13');
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->setCellValue('H12', 'CAPAIAN IKI')->mergeCells('H12:H13');
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->setCellValue('I12', 'KATEGORI PENCAPAIAN IKI')->mergeCells('I12:I13');
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->setCellValue('J12', 'CAPAIAN RENCANA KINERJA')->mergeCells('J12:K12');
        $sheet->setCellValue('J13', 'KATEGORI');
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->setCellValue('K13', 'NILAI');
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->setCellValue('L12', 'NILAI TERTIMBANG')->mergeCells('L12:L13');
        $sheet->getColumnDimension('L')->setWidth(20);

        $sheet->getStyle('A:L')->getAlignment()->setWrapText(true);
        // $sheet->getStyle('A10:G11')->getFont()->setBold(true);
        $cell = 14;
       

        $data_column = '';

        $data_column = $data['skp']['utama'];
        $data_tambahan = $data['skp']['tambahan'];

        foreach ( $data_column as $index => $value ){
            
            $sheet->setCellValue('A' . $cell, $index);
            if(isset($value['atasan']['rencana_kerja'])){
                $sheet->setCellValue('B' . $cell, $value['atasan']['rencana_kerja']);
            }else{
                $sheet->setCellValue('B' . $cell, '');
            }
            foreach ($value['skp_child'] as $key => $res) {
                $sheet->setCellValue('C' . $cell, $res['rencana_kerja']);
                foreach ($res['aspek_skp'] as $k => $v) {
                   
                    $sheet->setCellValue('D' . $cell, $v['aspek_skp']);
                    $sheet->setCellValue('E' . $cell, $v['iki']);
                   
                    foreach ($v['target_skp'] as $mk => $rr) {
                        $sum_capaian = 0;
                        $kategori_ = '';
                        if ($rr['bulan'] ==  $bulan) {
                            $capaian_iki = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;
                            $sum_capaian += $capaian_iki;

                            $sheet->setCellValue('F' . $cell, $rr['target'].' '.$v['satuan']);
                            $sheet->setCellValue('G' . $cell, $v['realisasi_skp'][$mk]['realisasi_bulanan'].' '.$v['satuan']);
                            $sheet->setCellValue('H' . $cell, round($capaian_iki,0) .' %');
                            if ($capaian_iki > 100) {
                                $sheet->setCellValue('I' . $cell, 'Sangat baik');
                            }elseif($capaian_iki == 100){
                                $sheet->setCellValue('I' . $cell, 'Baik');
                            }elseif($capaian_iki >= 80 && $capaian_iki <= 90){
                                $sheet->setCellValue('I' . $cell, 'Cukup');
                            }elseif($capaian_iki >= 60 && $capaian_iki <= 79){
                                $sheet->setCellValue('I' . $cell, 'Kurang');
                            }else{
                                $sheet->setCellValue('I' . $cell, 'Sangat kurang');
                            }

                            if ($sum_capaian > 110) {
                                $kategori_ = 'Sangat baik';
                            }elseif($sum_capaian >= 90 && $sum_capaian <= 109){
                                $kategori_ = 'Baik'; 
                            }elseif($sum_capaian >= 70 && $sum_capaian <= 89){
                                $kategori_ = 'Cukup'; 
                            }elseif($sum_capaian >= 50 && $sum_capaian <= 69){
                                $kategori_ = 'Kurang';
                            }elseif($sum_capaian >= 0 && $sum_capaian <= 49){
                                $kategori_ = 'Sangat kurang'; 
                            }else{
                                $kategori_ = '-';
                            }

                            $sheet->setCellValue('J' . $cell, $kategori_);
                            $sheet->setCellValue('K' . $cell, round($sum_capaian,2));
                            
                        }
                    }
                    

                    $cell++;  
                }
            }
        }
        

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];
       
        $sheet->getStyle('A6:L' . $cell)->applyFromArray($border);

        $sheet->getStyle('A12:L' . $cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A6:F6')->getAlignment()->setVertical('center')->setHorizontal('center');

   
        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan_absensi_.xlsx"');
        }else{
            $spreadsheet->getActiveSheet()->getHeaderFooter()
            ->setOddHeader('&C&H' . url()->current());
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddFooter('&L&B &RPage &P of &N');
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            header('Content-Type: application/pdf');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
        }

        $writer->save('php://output');
    }



    public function viewexportRekapAbsen($params1,$params2, $idpegawai){
        
        // return $params1;

        $url = env('API_URL');
        $token = session()->get('user.access_token');
      
        $response = Http::withToken($token)->get($url."/"."view-rekapByUser/".$params1."/".$params2."/".$idpegawai);

        if ($response->successful() && isset($response->object()->data)) {
            $data = $response->json();
            $this->exportrekapPegawai($data,'pdf','mobile');

        }else{
            return 'err';
        }
        // $data = $this->getRekapPegawai($val->startDate,$val->endDate); 
          
    }

    public function exportrekapPegawai($data,$type,$orientation){
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('BKPSDM BULUKUMBA')
            ->setLastModifiedBy('BKPSDM BULUKUMBA')
            ->setTitle('Laporan Rekapitulasi Absen Pegawai')
            ->setSubject('Laporan Rekapitulasi Absen Pegawai')
            ->setDescription('Laporan Rekapitulasi Absen Pegawai')
            ->setKeywords('pdf php')
            ->setCategory('LAPORAN ABSEN');
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
        

        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(1)->setRowHeight(20);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(3)->setRowHeight(20);

        
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        // //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        $sheet->setCellValue('A1', 'Laporan Rekapitulasi Absen Pegawai')->mergeCells('A1:G1');
        $sheet->setCellValue('A2', ''.$data['data']['pegawai']['satuan_kerja']['nama_satuan_kerja'])->mergeCells('A2:G2');
        $sheet->setCellValue('A3',  $data['data']['pegawai']['nama'].'/ '.$data['data']['pegawai']['nip'])->mergeCells('A3:G3');
        $sheet->getStyle('A1:G3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:G3')->getFont()->setSize(14);

        $sheet->setCellValue('A5', 'Jumlah hari kerja')->mergeCells('A5:B5');
        $sheet->setCellValue('C5', ': '.$data['data']['jml_hari_kerja'])->mergeCells('C5:G5');
        $sheet->setCellValue('A6', 'Kehadiran kerja')->mergeCells('A6:B6');
        $sheet->setCellValue('C6', ': '.$data['data']['kehadiran'])->mergeCells('C6:G6');
        $sheet->setCellValue('A7', 'Tanpa keterangan')->mergeCells('A7:B7');
        $sheet->setCellValue('C7', ': '.$data['data']['tanpa_keterangan'])->mergeCells('C7:G7');
        $sheet->setCellValue('A8', 'Jumlah potongan kehadiran')->mergeCells('A8:B8');
        $sheet->setCellValue('C8', ': '.$data['data']['potongan_kehadiran'])->mergeCells('C8:G8');
        $sheet->setCellValue('A9', 'Persentase pemotongan')->mergeCells('A9:B9');
        $sheet->setCellValue('C9', ': '.$data['data']['persentase_pemotongan'])->mergeCells('C9:G9');
        $sheet->getStyle('A5:G9')->getFont()->setSize(12);
        
        $sheet->setCellValue('A10',' ')->mergeCells('A10:G10');
        
        $sheet->setCellValue('A11', 'No')->mergeCells('A11:A12');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B11', 'Tanggal')->mergeCells('B11:B12');
        $sheet->getColumnDimension('B')->setWidth(32);
        $sheet->setCellValue('C11', 'Status Absen')->mergeCells('C11:C12');
        $sheet->getColumnDimension('C')->setWidth(32);
        $sheet->setCellValue('D11', 'Masuk')->mergeCells('D11:E11');
        $sheet->setCellValue('D12', 'Waktu');
        $sheet->getColumnDimension('D')->setWidth(32);
        $sheet->setCellValue('E12', 'Keterangan');
        $sheet->getColumnDimension('E')->setWidth(32);
        $sheet->setCellValue('F11', 'Keluar')->mergeCells('F11:G11');
        $sheet->setCellValue('F12', 'Waktu');
        $sheet->getColumnDimension('F')->setWidth(32);
        $sheet->setCellValue('G12', 'Keterangan');
        $sheet->getColumnDimension('G')->setWidth(32);

        $sheet->getStyle('A:G')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A11:G12')->getFont()->setBold(true);
        $sheet->getRowDimension(11)->setRowHeight(30);
        $sheet->getRowDimension(12)->setRowHeight(30);
        $cell = 13;
        

        foreach ( $data['data']['data_absen'] as $index => $value ){
            $sheet->getRowDimension($cell)->setRowHeight(30);
            $sheet->setCellValue('A' . $cell, $index+1);
            $sheet->setCellValue('B' . $cell, $value['tanggal']);
        
           if (isset($value['data_tanggal'])) {
                if (isset($value['data_tanggal'][0])) {
                    $sheet->setCellValue('C' . $cell, $value['data_tanggal'][0]['status_absen']);

                    foreach ($value['data_tanggal'] as $k => $v) {
                        if ($v['jenis'] == 'checkin') {
                            $sheet->setCellValue('D' . $cell, $value['data_tanggal'][$k]['waktu_absen']);
                            $sheet->setCellValue('E' . $cell, $value['data_tanggal'][$k]['keterangan']);         
                        }else{
                            $sheet->setCellValue('F' . $cell, $value['data_tanggal'][$k]['waktu_absen']);
                            $sheet->setCellValue('G' . $cell, $value['data_tanggal'][$k]['keterangan']);
                        }
                    }

                }else{
                    
                    if(isset($value['data_tanggal']['status_absen'])){
                        $sheet->setCellValue('C' . $cell, $value['data_tanggal']['status_absen']);
                    }else{
                        $sheet->setCellValue('C' . $cell, '-');
                    }
                    
                    $sheet->setCellValue('D' . $cell, '-');
                    $sheet->setCellValue('E' . $cell, '-');  
                    $sheet->setCellValue('F' . $cell, '-');
                    $sheet->setCellValue('G' . $cell, '-');   
                }

                // foreach ($value['data_tanggal'] as $k => $v) {
                //     if ($v['jenis'] == 'checkin') {
                //         $sheet->setCellValue('D' . $cell, $value['data_tanggal'][$k]['waktu_absen']);
                //         $sheet->setCellValue('E' . $cell, $value['data_tanggal'][$k]['keterangan']);         
                //     }else{
                //         $sheet->setCellValue('F' . $cell, $value['data_tanggal'][$k]['waktu_absen']);
                //         $sheet->setCellValue('G' . $cell, $value['data_tanggal'][$k]['keterangan']);
                //     }
                // }
                
           }

            $cell++;
        }

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];
       
        $sheet->getStyle('A11:G' . $cell)->applyFromArray($border);



       

        $sheet->getStyle('A11:G'.$cell)->getAlignment()->setVertical('center')->setHorizontal('center');

   
        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan_absensi_'.$data['data']['pegawai']['nama'].'.xlsx"');
        }else{
            $spreadsheet->getActiveSheet()->getHeaderFooter()
            ->setOddHeader('&C&H' . url()->current());
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddFooter('&L&B &RPage &P of &N');
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            header('Content-Type: application/pdf');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
        }

        $writer->save('php://output');
    }

    public function exportrekapOpd($data,$type,$startDate,$endDate){
        // return $type;
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('BKPSDM BULUKUMBA')
            ->setLastModifiedBy('BKPSDM BULUKUMBA')
            ->setTitle('Laporan Rekapitulasi Absen Pegawai')
            ->setSubject('Laporan Rekapitulasi Absen Pegawai')
            ->setDescription('Laporan Rekapitulasi Absen Pegawai')
            ->setKeywords('pdf php')
            ->setCategory('LAPORAN ABSEN');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(3)->setRowHeight(17);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        // //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        $sheet->setCellValue('A1', 'REKAPITULASI CAPAIAN DISIPLIN/ KEHADIRAN KERJA');
        $sheet->mergeCells('A1:AB1');

        $sheet->setCellValue('B3', 'PERANGKAT DAERAH');
        $sheet->mergeCells('B3:C3');
        $sheet->setCellValue('D3', ':');
        $sheet->setCellValue('E3', $data['satuan_kerja'])->mergeCells('E3:AB3');
        
        $sheet->setCellValue('B4', 'KEADAAN BULAN');
        $sheet->mergeCells('B4:C4');
        $sheet->setCellValue('D4', ':');
        $sheet->setCellValue('E4', $startDate.' s/d '.$endDate)->mergeCells('E4:AB4');

        $sheet->getStyle('A1:AB10')->getAlignment()->setHorizontal('center');
        
        $sheet->getStyle('A1:AB1')->getFont()->setSize(16);
        $sheet->getStyle('A3:AB4')->getFont()->setSize(12);
        
        $sheet->getColumnDimension('B')->setWidth(6);
        $sheet->getColumnDimension('C')->setWidth(37);
        $sheet->getColumnDimension('D')->setWidth(7);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(8);
        $sheet->getColumnDimension('G')->setWidth(8);
        $sheet->getColumnDimension('H')->setWidth(5);
        $sheet->getColumnDimension('Y')->setWidth(11);
        $sheet->getColumnDimension('Z')->setWidth(11);
        $sheet->getColumnDimension('AA')->setWidth(13);
        $sheet->getColumnDimension('AB')->setWidth(16);

        // konten
        $sheet->setCellValue('B6', 'No')->mergeCells('B6:B10');
        
        $sheet->setCellValue('C6', 'NAMA/NIP')->mergeCells('C6:C10');
        
        $sheet->setCellValue('D6', 'JML HARI KERJA')->mergeCells('D6:D10');
        
        $sheet->setCellValue('E6', 'KEHADIRAN KERJA')->mergeCells('E6:X6');
        $sheet->setCellValue('Y6', 'JUMLAH TIDAK HADIR APEL/UPACARA')->mergeCells('Y6:Y10');
        $sheet->setCellValue('Z6', 'JUMLAH POTONGAN/TIDAK APEL/UPACARA')->mergeCells('Z6:Z10');
        $sheet->setCellValue('AA6', 'JUMLAH PEMOTONGAN KEHADIRAN')->mergeCells('AA6:AA10');
        $sheet->setCellValue('AB6', 'PERSENTASE PEMOTONGAN TUNJANGAN KEHADIRAN (40%)')->mergeCells('AB6:AB10');


        $sheet->setCellValue('E7', 'JUMLAH KEHADIRAN KERJA')->mergeCells('E7:E10');
        $sheet->setCellValue('F7', 'TANPA KETERANGAN')->mergeCells('F7:H7');
        $sheet->setCellValue('F8', 'JUMLAH HARI TANPA KETERANGAN')->mergeCells('F8:F10');
        $sheet->setCellValue('G8', 'POTONGAN / HARI')->mergeCells('G8:H10');

        $sheet->setCellValue('I7', 'KETERLAMBATAN MASUK KERJA')->mergeCells('I7:P7');
        $sheet->setCellValue('J8', 'WAKTU TMK (MENIT)')->mergeCells('J8:P8');
        $sheet->setCellValue('Q7', 'CEPAT PULANG KERJA')->mergeCells('Q7:X7');
        $sheet->setCellValue('Q8', 'WAKTU CPK (MENIT)')->mergeCells('Q8:X8');

        $sheet->setCellValue('I9', '1-30'.PHP_EOL.'M')->mergeCells('I9:I10');
        $sheet->setCellValue('J9', 'JML'.PHP_EOL.'POT')->mergeCells('J9:J10');
        $sheet->setCellValue('K9', '31-60'.PHP_EOL.'M')->mergeCells('K9:K10');
        $sheet->setCellValue('L9', 'JML'.PHP_EOL.'POT')->mergeCells('L9:L10');
        $sheet->setCellValue('M9', '60-90'.PHP_EOL.'M')->mergeCells('M9:M10');
        $sheet->setCellValue('N9', 'JML'.PHP_EOL.'POT')->mergeCells('N9:N10');
        $sheet->setCellValue('O9', '91'.PHP_EOL.'Keatas')->mergeCells('O9:O10');
        $sheet->setCellValue('P9', 'JML'.PHP_EOL.'POT')->mergeCells('P9:P10');
        
        $sheet->setCellValue('Q9', '1-30'.PHP_EOL.'M')->mergeCells('Q9:Q10');
        $sheet->setCellValue('R9', 'JML'.PHP_EOL.'POT')->mergeCells('R9:R10');
        $sheet->setCellValue('S9', '31-60'.PHP_EOL.'M')->mergeCells('S9:S10');
        $sheet->setCellValue('T9', 'JML'.PHP_EOL.'POT')->mergeCells('T9:T10');
        $sheet->setCellValue('U9', '60-90'.PHP_EOL.'M')->mergeCells('U9:U10');
        $sheet->setCellValue('V9', 'JML'.PHP_EOL.'POT')->mergeCells('V9:V10');
        $sheet->setCellValue('W9', '91'.PHP_EOL.'Keatas')->mergeCells('W9:W10');
        $sheet->setCellValue('X9', 'JML'.PHP_EOL.'POT')->mergeCells('X9:X10');
        
        


        $cell = 11;

        // $jml_hari_kerja = [];
        foreach($data['pegawai'] as $i => $val){
            $sheet->getRowDimension($cell)->setRowHeight(30);
            $selisih_waktu = 0;
            $jml_hari_kerja = [];
            $kmk_30 = [];
            $kmk_60 = [];
            $kmk_90 = [];
            $kmk_90_keatas = [];
            $cpk_30 = [];
            $cpk_60 = [];
            $cpk_90 = [];
            $cpk_90_keatas = [];
            $jml_tanpa_keterangan = 0;
            $sheet->setCellValue('B' . $cell, $i+1);
            $sheet->setCellValue('C' . $cell, $val[0]['pegawai']['nama'].' '.PHP_EOL.' '.$val[0]['pegawai']['nip']);
            $sheet->setCellValue('D' . $cell, $data['hari_kerja']);
            foreach($val as $t => $v){
                if (isset($v['status'])) {
                    if ($v['status'] == 'hadir') {
                      
                        if($v['jenis'] == 'checkin'){
                            
                            $selisih_waktu = $this->konvertWaktu('checkin',$v['waktu_absen']);
                        
                            if ($selisih_waktu >= 1 && $selisih_waktu <= 30) {
                                $kmk_30[] = $selisih_waktu;
                            }elseif($selisih_waktu >= 31 && $selisih_waktu <= 60){
                                $kmk_60[] =  $selisih_waktu;
                            }elseif($selisih_waktu >= 61 && $selisih_waktu <= 90){
                                $kmk_90[] =  $selisih_waktu;
                            }elseif($selisih_waktu >= 91){
                                $kmk_90_keatas[] =  $selisih_waktu;
                            }
                        }else{
                            $jml_hari_kerja[] = $v['id'];
                            $selisih_waktu = $this->konvertWaktu('checkout',$v['waktu_absen']);
                        
                            if ($selisih_waktu >= 1 && $selisih_waktu <= 30) {
                                $cpk_30[] = $selisih_waktu;
                            }elseif($selisih_waktu >= 31 && $selisih_waktu <= 60){
                                $cpk_60[] =  $selisih_waktu;
                            }elseif($selisih_waktu >= 61 && $selisih_waktu <= 90){
                                $cpk_90[] =  $selisih_waktu;
                            }elseif($selisih_waktu >= 91){
                                $cpk_90_keatas[] =  $selisih_waktu;
                            }
                        }
                   
                    }
                }
            }

            $jml_tanpa_keterangan = $data['hari_kerja'] - count($jml_hari_kerja);

        
            $sheet->setCellValue('E' . $cell, count($jml_hari_kerja));
            $sheet->setCellValue('F' . $cell, $jml_tanpa_keterangan);
            $sheet->setCellValue('G' . $cell, $jml_tanpa_keterangan * 3); 
            $sheet->setCellValue('H' . $cell, '%');
            $sheet->setCellValue('I' . $cell, count($kmk_30)); 
            $sheet->setCellValue('J' . $cell, count($kmk_30) * 0.5);
            $sheet->setCellValue('K' . $cell, count($kmk_60));
            $sheet->setCellValue('L' . $cell, count($kmk_60) * 1); 
            $sheet->setCellValue('M' . $cell, count($kmk_90)); 
            $sheet->setCellValue('N' . $cell, count($kmk_90) * 1.25);
            $sheet->setCellValue('O' . $cell, count($kmk_90_keatas)); 
            $sheet->setCellValue('P' . $cell, count($kmk_90_keatas) * 1.5);
            $sheet->setCellValue('Q' . $cell, count($cpk_30));
            $sheet->setCellValue('R' . $cell, count($cpk_30) * 0.5);
            $sheet->setCellValue('S' . $cell, count($cpk_60)); 
            $sheet->setCellValue('T' . $cell, count($cpk_60) * 1);
            $sheet->setCellValue('U' . $cell, count($cpk_90));
            $sheet->setCellValue('V' . $cell, count($cpk_90) * 1.25);
            $sheet->setCellValue('W' . $cell, count($cpk_90_keatas)); 
            $sheet->setCellValue('X' . $cell, count($cpk_90_keatas) * 1.5); 
            $sheet->setCellValue('Y' . $cell, 0); 
            $sheet->setCellValue('Z' . $cell, 0); 
            

            $jml_potongan_kehadiran = ($jml_tanpa_keterangan * 3) + (count($kmk_30)*0.5) + (count($kmk_60)) + (count($kmk_90)*1.25) + (count($kmk_90_keatas)*1.5) + (count($cpk_30)*0.5) + (count($cpk_60)) + (count($cpk_90)*1.25) + count($cpk_90_keatas) * 1.5;

            $persentase_pemotongan_tunjangan = $jml_potongan_kehadiran * 0.4;

            $sheet->setCellValue('AA' . $cell, $jml_potongan_kehadiran);
            $sheet->setCellValue('AB' . $cell, $persentase_pemotongan_tunjangan);
            $cell++;
        }

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];
       
        $sheet->getStyle('B6:AB' . $cell)->applyFromArray($border);
        $sheet->getStyle('A:AB')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A:AB')->getAlignment()->setVertical('center');
        $sheet->getStyle('C7:C'. $cell)->getAlignment()->setHorizontal('rigth');
        $sheet->getStyle('A3:AB4')->getAlignment()->setHorizontal('rigth');

        
        
        

        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan_rekapitulasi_daftar_hadir'.$data['satuan_kerja'].'.xlsx"');
        }else{
            $spreadsheet->getActiveSheet()->getHeaderFooter()
            ->setOddHeader('&C&H' . url()->current());
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddFooter('&L&B &RPage &P of &N');
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            header('Content-Type: application/pdf');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
        }

        $writer->save('php://output');

     
    }

    public function konvertWaktu($params,$waktu){
        $diff = '';
        $selisih_waktu = '';
        $menit = 0;
        if ($params == 'checkin') {
            $waktu_tetap_absen = strtotime('08:00:00');
            $waktu_absen = strtotime($waktu); 
            $diff = $waktu_absen - $waktu_tetap_absen;
        }else{
            $waktu_tetap_absen = strtotime('16:00:00');
            $waktu_absen = strtotime($waktu); 
            $diff = $waktu_tetap_absen - $waktu_absen;
            // return $diff;
        }

        if ($diff > 0) {
            // $jam = floor($diff/3600);
            // $selisih_waktu = $diff%3600;
            $menit = floor($diff/60);
        }else{
            $diff = 0;
        }

        

        return $menit;
    }

}
