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
        //return $res;
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
            ->setTitle('Laporan SKP Kepala')
            ->setSubject('Laporan SKP Kepala')
            ->setDescription('Laporan SKP Kepala')
            ->setKeywords('pdf php')
            ->setCategory('LAPORAN SKP Kepala');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        
        $sheet->getRowDimension(1)->setRowHeight(17);
        $sheet->getRowDimension(2)->setRowHeight(17);
        $sheet->getRowDimension(3)->setRowHeight(7);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        // //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        $sheet->setCellValue('A1', 'SASARAN KINERJA PEGAWAI (SKP)')->mergeCells('A1:F1');
        $sheet->setCellValue('A2', 'PEJABAT PIMPINAN TINGGI DAN PIMPINAN UNIT KERJA MANDIRI')->mergeCells('A2:F2');

        $sheet->setCellValue('A4', 'PERIODE PENILAIAN')->mergeCells('A4:F4');
        $sheet->setCellValue('A5', $data['pegawai_dinilai']['nama_satuan_kerja'])->mergeCells('A5:C5');
        $sheet->setCellValue('D5', "PERIODENYA PERIODENYA PERIODENYA ")->mergeCells('D5:F5');

        $sheet->setCellValue('A6', 'PEGAWAI YANG DINILAI')->mergeCells('A6:C6');
        $sheet->setCellValue('D6', 'PEJABAT PENILAI PEKERJA')->mergeCells('D6:F6');

        $sheet->setCellValue('A7', 'Nama')->mergeCells('A7:B7');
        $sheet->setCellValue('C7', $data['pegawai_dinilai']['nama'])->mergeCells('C7:C7');
        $sheet->setCellValue('A8', 'NIP')->mergeCells('A8:B8');
        $sheet->setCellValue('C8', "'".$data['pegawai_dinilai']['nip'])->mergeCells('C8:C8');
        $sheet->setCellValue('A9', 'Pangkat / Gol Ruang')->mergeCells('A9:B9');
        $sheet->setCellValue('C9', $data['pegawai_dinilai']['golongan'])->mergeCells('C9:C9');
        $sheet->setCellValue('A10', 'Jabatan')->mergeCells('A10:B10');
        $sheet->setCellValue('C10', $data['pegawai_dinilai']['nama_jabatan'])->mergeCells('C10:C10');
        $sheet->setCellValue('A11', 'Unit kerja')->mergeCells('A11:B11');
        $sheet->setCellValue('C11', $data['pegawai_dinilai']['nama_satuan_kerja'])->mergeCells('C11:C11');

        $sheet->setCellValue('D7', 'Nama');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('E7', $data['atasan']['nama'])->mergeCells('E7:F7');
        } else {
            $sheet->setCellValue('E7', '-')->mergeCells('E7:F7');
        }
        $sheet->setCellValue('D8', 'NIP');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('E8', "'".$data['atasan']['nip'])->mergeCells('E8:F8');
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

        $sheet->setCellValue('A12', 'No')->mergeCells('A12:A12');
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->setCellValue('B12', 'RENCANA KINERJA')->mergeCells('B12:C12');
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->setCellValue('D12', 'INDIKATOR KINERJA INDIVIDU')->mergeCells('D12:E12');
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->setCellValue('F12', 'TARGET')->mergeCells('F12:F12');
        $sheet->getColumnDimension('F')->setWidth(20);

        $sheet->getStyle('A1:A2')->getFont()->setSize(12);
        $sheet->getStyle('A:F')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A6:F12')->getFont()->setBold(true);
        $sheet->getStyle('A4:F11')->getAlignment()->setVertical('center')->setHorizontal('left');
        $sheet->getStyle('D4:F5')->getAlignment()->setVertical('center')->setHorizontal('right');
        $sheet->getStyle('A6:F6')->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A1:A2')->getAlignment()->setVertical('center')->setHorizontal('center');

        
        $cell = 13;
        if (isset($data['skp']['utama'])) {
            $sheet->setCellValue('B'.$cell, 'A. KINERJA UTAMA')->mergeCells('B'.$cell.':F'.$cell);
            $sheet->getStyle('B'.$cell.':F'.$cell)->getFont()->setBold(true);
            $cell++;
            foreach ( $data['skp']['utama'] as $index => $value ){
                $sheet->setCellValue('A' . $cell, $index+1);
                $sheet->setCellValue('B' . $cell, $value['rencana_kerja'])->mergeCells('B' . $cell .':C'. $cell);
                foreach ($value['aspek_skp'] as $k => $v) {
                    $sheet->setCellValue('D' . $cell, $v['iki'])->mergeCells('D' . $cell .':E'. $cell);
                    
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
        if (isset($data['skp']['tambahan'])) {
            $sheet->setCellValue('B'.$cell, 'B. KINERJA TAMBAHAN')->mergeCells('B'.$cell.':F'.$cell);
            $sheet->getStyle('B'.$cell.':F'.$cell)->getFont()->setBold(true);
            $cell++;
            foreach ( $data['skp']['tambahan'] as $index => $value ){
                $sheet->setCellValue('A' . $cell, $index+1);
                $sheet->setCellValue('B' . $cell, $value['rencana_kerja'])->mergeCells('B' . $cell .':C'. $cell);
                foreach ($value['aspek_skp'] as $k => $v) {
                    $sheet->setCellValue('D' . $cell, $v['iki'])->mergeCells('D' . $cell .':E'. $cell);
                    
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
        
 
        $sheet->getStyle('A12:F'.$cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('B13:E'.$cell)->getAlignment()->setVertical('center')->setHorizontal('left');
        //$sheet->getStyle('A14:E'.$cell)->getAlignment()->setVertical('center')->setHorizontal('left');

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];
       
        $sheet->getStyle('A6:F' . $cell)->applyFromArray($border);
   
        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan SKP '.$data['pegawai_dinilai']['nama'].'.xlsx"');
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
            ->setTitle('Laporan SKP ')
            ->setSubject('Laporan SKP ')
            ->setDescription('Laporan SKP ')
            ->setKeywords('pdf php')
            ->setCategory('LAPORAN SKP');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
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

        $sheet->getStyle('A:L')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A:L')->getAlignment()->setVertical('top')->setHorizontal('left');

        $sheet->setCellValue('A1', 'SASARAN KINERJA PEGAWAI (SKP)')->mergeCells('A1:H1');
        $sheet->setCellValue('A2', 'PEJABAT ADMINISTRATOR PENGAWAS DAN FUNGSIONAL')->mergeCells('A2:H2');
        
        $sheet->setCellValue('A4', 'PERIODE PENILAIAN')->mergeCells('A4:H4');
        $sheet->setCellValue('A5', $data['pegawai_dinilai']['nama_satuan_kerja'])->mergeCells('A5:D5');
        $sheet->setCellValue('E5', "PERIODENYA PERIODENYA PERIODENYA ")->mergeCells('E5:H5');

        $sheet->setCellValue('A6', 'PEGAWAI YANG DINILAI')->mergeCells('A6:D6');
        $sheet->setCellValue('E6', 'PEJABAT PENILAI PEKERJA')->mergeCells('E6:H6');
        

        $sheet->setCellValue('A7', 'Nama')->mergeCells('A7:B7');
        $sheet->setCellValue('C7', $data['pegawai_dinilai']['nama'])->mergeCells('C7:D7');
        $sheet->setCellValue('A8', 'NIP')->mergeCells('A8:B8');
        $sheet->setCellValue('C8', "'".$data['pegawai_dinilai']['nip'])->mergeCells('C8:D8');
        $sheet->setCellValue('A9', 'Pangkat / Gol Ruang')->mergeCells('A9:B9');
        $sheet->setCellValue('C9', $data['pegawai_dinilai']['golongan'])->mergeCells('C9:D9');
        $sheet->setCellValue('A10', 'Jabatan')->mergeCells('A10:B10');
        $sheet->setCellValue('C10', $data['pegawai_dinilai']['nama_jabatan'])->mergeCells('C10:D10');
        $sheet->setCellValue('A11', 'Unit kerja')->mergeCells('A11:B11');
        $sheet->setCellValue('C11', $data['pegawai_dinilai']['nama_satuan_kerja'])->mergeCells('C11:D11');
        
        
        $sheet->setCellValue('E7', 'Nama')->mergeCells('E7:F7');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('G7', $data['atasan']['nama'])->mergeCells('G7:H7');
        } else {
            $sheet->setCellValue('G7', '-')->mergeCells('E7:H7');
        }
        $sheet->setCellValue('E8', 'NIP')->mergeCells('E8:F8');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('G8', "'".$data['atasan']['nip'])->mergeCells('G8:H8');
        } else {
            $sheet->setCellValue('G8', '-')->mergeCells('G8:H8');
        }
        $sheet->setCellValue('E9', 'Pangkat / Gol Ruang')->mergeCells('E9:F9');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('G9', $data['atasan']['golongan'])->mergeCells('G9:H9');
        } else {
            $sheet->setCellValue('G9', '-')->mergeCells('G9:H9');
        }
        $sheet->setCellValue('E10', 'Jabatan')->mergeCells('E10:F10');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('G10', $data['atasan']['nama_jabatan'])->mergeCells('G10:H10');
        } else {
            $sheet->setCellValue('G10', '-')->mergeCells('G10:H10');
        } 
        $sheet->setCellValue('E11', 'Unit kerja')->mergeCells('E11:F11');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('G11', $data['atasan']['nama_satuan_kerja'])->mergeCells('G11:H11');
        } else {
            $sheet->setCellValue('G11', '-')->mergeCells('G11:H11');
        } 


        $sheet->setCellValue('A12', 'No')->mergeCells('A12:A12');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B12', 'RENCANA KINERJA ATASAN LANGSUNG')->mergeCells('B12:C12');
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->setCellValue('D12', 'RENCANA KINERJA')->mergeCells('D12:D12');
        $sheet->getColumnDimension('D')->setWidth(45);


        $sheet->setCellValue('E12', 'ASPEK')->mergeCells('E12:E12');
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->setCellValue('F12', 'INDIKATOR KINERJA INDIVIDU')->mergeCells('F12:G12');
        $sheet->getColumnDimension('F')->setWidth(5);
        $sheet->getColumnDimension('G')->setWidth(40);
        $sheet->setCellValue('H12', 'TARGET')->mergeCells('H12:G12');
        $sheet->getColumnDimension('H')->setWidth(25);


        

        $cell = 13;
        //UTAMA
        
        if(isset($data['skp']['utama'])){
        foreach ( $data['skp']['utama'] as $index => $value ){
                $sheet->setCellValue('B'.$cell, 'A. KINERJA UTAMA')->mergeCells('B'.$cell.':H'.$cell);
                $sheet->getStyle('B'.$cell.':H'.$cell)->getFont()->setBold(true);
                $cell++;
                if(isset($value['atasan']['rencana_kerja'])){
                    $sheet->setCellValue('B' . $cell, $value['atasan']['rencana_kerja'])->mergeCells('B'.$cell.':C'.($cell+2));
                }else{
                    $sheet->setCellValue('B' . ($cell-3), '')->mergeCells('B'.($cell-3).':C'.($cell-1));
                }
                foreach ($value['skp_child'] as $key => $res) {
                    $sheet->setCellValue('D' . $cell, $res['rencana_kerja'])->mergeCells('D'.$cell.':D'.($cell+2));
                    foreach ($res['aspek_skp'] as $k => $v) {
                        $sheet->getStyle('E'. $cell.':E'. $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
                        $sheet->setCellValue('E' . $cell, $v['aspek_skp']);
                        $sheet->setCellValue('F' . $cell, $v['iki'])->mergeCells('F'.$cell.':G'.$cell);
                        foreach ($v['target_skp'] as $mk => $rr) {
                            if ($rr['bulan'] ==  $bulan) {
                                $sheet->getStyle('H'. $cell.':H'. $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
                                $sheet->setCellValue('H' . $cell, $rr['target'].' '.$v['satuan']);
                            }
                        }
                        $cell++; 
                    }
                    $sheet->setCellValue('A' . ($cell-3), $key+1)->mergeCells('A'.($cell-3).':A'.($cell-1));
                    if (!$key==0)
                    $sheet->setCellValue('B' . ($cell-3), '')->mergeCells('B'.($cell-3).':C'.($cell-1)); 
                }         
            }
        }
        else{
            $sheet->setCellValue('A'.$cell, 'Data masih kosong')->mergeCells('A'.$cell.':H'.$cell);
        }


        // TAMBAHAN
        if(isset($data['skp']['tambahan'])){
        $sheet->setCellValue('B'.$cell, 'A. KINERJA TAMBAHAN')->mergeCells('B'.$cell.':H'.$cell);
        $sheet->getStyle('B'.$cell.':H'.$cell)->getFont()->setBold(true);
        $cell++;
            foreach ($data['skp']['tambahan'] as $keyy => $values) {
                $sheet->setCellValue('A' . $cell, $index+1)->mergeCells('A'.$cell.':A'.($cell+2));
                $sheet->setCellValue('B' . $cell, ' ')->mergeCells('B'.$cell.':C'.($cell+2));
                $sheet->setCellValue('D' . $cell, $values['rencana_kerja'])->mergeCells('D'.$cell.':D'.($cell+2));
                foreach ($values['aspek_skp'] as $k => $v) {
                    $sheet->getStyle('E'. $cell.':E'. $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
                    $sheet->setCellValue('E' . $cell, $v['aspek_skp'])->mergeCells('E'.$cell.':E'.($cell+2));
                    $sheet->setCellValue('F' . $cell, $v['iki'])->mergeCells('F'.$cell.':G'.$cell);
                    
                    foreach ($v['target_skp'] as $mk => $rr) {
                        if ($rr['bulan'] ==  $bulan) {
                            $sheet->getStyle('H'. $cell.':H'. $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
                            $sheet->setCellValue('H' . $cell, $rr['target'].' '.$v['satuan']);
                        }
                    }
                    $cell++;  
                }
                $sheet->setCellValue('A' . ($cell-3), $keyy+1)->mergeCells('A'.($cell-3).':A'.($cell-1));
                if (!$keyy==0)
                $sheet->setCellValue('B' . ($cell-3), '')->mergeCells('B'.($cell-3).':C'.($cell-1)); 
            }
        }
        else{
            $sheet->setCellValue('A'.$cell, 'Data masih kosong')->mergeCells('B'.$cell.':H'.$cell);
        }
        

        

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];
       
        $sheet->getStyle('A6:H' . $cell)->applyFromArray($border);

        $sheet->getStyle('A1:H2')->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A1:H2')->getFont()->setSize(12);
        $sheet->getStyle('A6:H6')->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A6:H6')->getFont()->setBold(true);
        $sheet->getStyle('A7:H7')->getFont()->setBold(true);
        $sheet->getStyle('A12:H12')->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A12:H12')->getFont()->setBold(true);
        $sheet->getStyle('E4:H5')->getAlignment()->setVertical('center')->setHorizontal('right');

   
        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan SKP '.$data['pegawai_dinilai']['nama'].'.xlsx"');
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
            ->setTitle('Laporan Penilaian SKP Kepala')
            ->setSubject('Laporan Penilaian SKP Kepala')
            ->setDescription('Laporan Penilaian SKP Kepala')
            ->setKeywords('pdf php')
            ->setCategory('LAPORAN Penilaian SKP KEPALA');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(1)->setRowHeight(17);
        $sheet->getRowDimension(2)->setRowHeight(17);
        $sheet->getRowDimension(3)->setRowHeight(7);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(true);

        // //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        $sheet->setCellValue('A1', 'PENILAIAN SASARAN KINERJA PEGAWAI (SKP)')->mergeCells('A1:J1');
        $sheet->setCellValue('A2', 'PEJABAT PIMPINAN TINGGI DAN PIMPINAN UNIT KERJA MANDIRI')->mergeCells('A2:J2');
        
        $sheet->setCellValue('A4', 'PERIODE PENILAIAN')->mergeCells('A4:J4');
        $sheet->setCellValue('A5', $data['pegawai_dinilai']['nama_satuan_kerja'])->mergeCells('A5:C5');
        $sheet->setCellValue('D5', "PERIODENYA PERIODENYA PERIODENYA ")->mergeCells('D5:J5');

        $sheet->setCellValue('A6', 'PEGAWAI YANG DINILAI')->mergeCells('A6:C6');
        $sheet->setCellValue('D6', 'PEJABAT PENILAI PEKERJA')->mergeCells('D6:J6');
        

        $sheet->setCellValue('A7', 'Nama')->mergeCells('A7:B7');
        $sheet->setCellValue('C7', $data['pegawai_dinilai']['nama'])->mergeCells('C7:C7');
        $sheet->setCellValue('A8', 'NIP')->mergeCells('A8:B8');
        $sheet->setCellValue('C8', "'".$data['pegawai_dinilai']['nip'])->mergeCells('C8:C8');
        $sheet->setCellValue('A9', 'Pangkat / Gol Ruang')->mergeCells('A9:B9');
        $sheet->setCellValue('C9', $data['pegawai_dinilai']['golongan'])->mergeCells('C9:C9');
        $sheet->setCellValue('A10', 'Jabatan')->mergeCells('A10:B10');
        $sheet->setCellValue('C10', $data['pegawai_dinilai']['nama_jabatan'])->mergeCells('C10:C10');
        $sheet->setCellValue('A11', 'Unit kerja')->mergeCells('A11:B11');
        $sheet->setCellValue('C11', $data['pegawai_dinilai']['nama_satuan_kerja'])->mergeCells('C11:C11');

        
        $sheet->setCellValue('D7', 'Nama')->mergeCells('D7:E7');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('F7', $data['atasan']['nama'])->mergeCells('F7:J7');
        } else {
            $sheet->setCellValue('F7', '-')->mergeCells('F7:J7');
        }
        $sheet->setCellValue('D8', 'NIP')->mergeCells('D8:E8');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('F8', "'".$data['atasan']['nip'])->mergeCells('F8:J8');
        } else {
            $sheet->setCellValue('F8', '-')->mergeCells('F8:J8');
        }
        $sheet->setCellValue('D9', 'Pangkat / Gol Ruang')->mergeCells('D9:E9');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('F9', $data['atasan']['golongan'])->mergeCells('F9:J9');
        } else {
            $sheet->setCellValue('F9', '-')->mergeCells('F9:J9');
        } 
        $sheet->setCellValue('D10', 'Jabatan')->mergeCells('D10:E10');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('F10', $data['atasan']['nama_jabatan'])->mergeCells('F10:J10');
        } else {
            $sheet->setCellValue('F10', '-')->mergeCells('F10:J10');
        } 
        $sheet->setCellValue('D11', 'Unit kerja')->mergeCells('D11:E11');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('F11', $data['atasan']['nama_satuan_kerja'])->mergeCells('F11:J11');
        } else {
            $sheet->setCellValue('F11', '-')->mergeCells('F11:J11');
        } 

        $sheet->setCellValue('A12', 'No.')->mergeCells('A12:A12');
        $sheet->getColumnDimension('A')->setWidth(7);
        $sheet->setCellValue('B12', 'Rencana Kinerja')->mergeCells('B12:B12');
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->setCellValue('C12', 'Indikator Kinerja Individu')->mergeCells('C12:C12');
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->setCellValue('D12', 'Target')->mergeCells('D12:D12');
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->setCellValue('E12', 'Realisasi')->mergeCells('E12:E12');
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->setCellValue('F12', 'Single Rate')->mergeCells('F12:F12');
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->setCellValue('G12', 'Capaian IKI')->mergeCells('G12:G12');
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->setCellValue('H12', 'Kategori Capaian')->mergeCells('H12:H12');
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->setCellValue('I12', 'Nilai Capaian IKI')->mergeCells('I12:I12');
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->setCellValue('J12', 'Nilai Timbang')->mergeCells('J12:J12');
        $sheet->getColumnDimension('J')->setWidth(12);
        
        $sheet->getStyle('A1:J2')->getFont()->setSize(12);
        $sheet->getStyle('A:J')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A6:J12')->getFont()->setBold(true);
        $sheet->getStyle('A4:J11')->getAlignment()->setVertical('center')->setHorizontal('left');
        $sheet->getStyle('D4:J5')->getAlignment()->setVertical('center')->setHorizontal('right');
        $sheet->getStyle('A6:J6')->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A1:A2')->getAlignment()->setVertical('center')->setHorizontal('center');
        
        


        $cell = 13;
        $nilai_utama=0;
        $nilai_tambahan=0;
        //TAMBAHAN
        if (isset($data['skp']['utama'])) {
            $sheet->setCellValue('B'.$cell, 'A. KINERJA UTAMA')->mergeCells('B'.$cell.':J'.$cell);
            $sheet->getStyle('B'.$cell.':J'.$cell)->getFont()->setBold(true);
            $cell++;
            $jumlah_data= 0;
            $sum_nilai_iki = 0;
            foreach ( $data['skp']['utama'] as $index => $value ){
            $sheet->setCellValue('A' . $cell, $index+1);
            $sheet->setCellValue('B' . $cell, $value['rencana_kerja']);
            
                    foreach ($value['aspek_skp'] as $k => $v) {
                        $sheet->setCellValue('C' . $cell, $v['iki']);
                        foreach ($v['target_skp'] as $mk => $rr) {
                            $kategori_ = '';
                            if ($rr['bulan'] ==  $bulan) {
                                $sheet->setCellValue('D' . $cell, $rr['target'].' '.$v['satuan']);
                                $sheet->setCellValue('E' . $cell, $v['realisasi_skp'][$mk]['realisasi_bulanan'].' '.$v['satuan']);
                                $single_rate = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;
                                
                                $sheet->setCellValue('F' . $cell, round($single_rate,0) .' %');
                                if ($single_rate > 110) {
                                    $sheet->setCellValue('G' . $cell, '110');
                                    $sheet->setCellValue('H' . $cell, 'Sangat Baik');
                                    $nilai_iki=110+((120-110)/(110-101))*(110-101);
                                    $sheet->setCellValue('I' . $cell, round($nilai_iki,1));
                                }elseif($single_rate >= 101 && $single_rate <= 110){
                                    $sheet->setCellValue('G' . $cell, round($single_rate,0) .' %');
                                    $sheet->setCellValue('H' . $cell, 'Sangat Baik');
                                    $nilai_iki=110+((120-110)/(110-101))*($single_rate-101);
                                    $sheet->setCellValue('I' . $cell, round($nilai_iki,1));
                                }elseif($single_rate == 100){
                                    $sheet->setCellValue('G' . $cell, round($single_rate,0) .' %');
                                    $sheet->setCellValue('H' . $cell, 'Baik');
                                    $nilai_iki=109;
                                    $sheet->setCellValue('I' . $cell, round($nilai_iki,1));
                                }elseif($single_rate >= 80 && $single_rate <= 99){
                                    $sheet->setCellValue('G' . $cell, round($single_rate,0) .' %');
                                    $sheet->setCellValue('H' . $cell, 'Cukup');
                                    $nilai_iki=70+((89-70)/(99-80))*($single_rate-80);
                                    $sheet->setCellValue('I' . $cell, round($nilai_iki,1));
                                }elseif($single_rate >= 60 && $single_rate <= 79){
                                    $sheet->setCellValue('G' . $cell, round($single_rate,0) .' %');
                                    $sheet->setCellValue('H' . $cell, 'Kurang');
                                    $nilai_iki=50+((69-50)/(79-60))*($single_rate-60);
                                    $sheet->setCellValue('I' . $cell, round($nilai_iki,1));
                                }elseif($single_rate >= 0 && $single_rate <= 79){
                                    $sheet->setCellValue('G' . $cell, round($single_rate,0) .' %');
                                    $sheet->setCellValue('H' . $cell, 'Sangat Kurang');
                                    $nilai_iki=(49/59)*$single_rate;
                                    $sheet->setCellValue('I' . $cell, round($nilai_iki,1));
                                } 
                                //$sheet->setCellValue('J13', round($nilai_iki,1).' %' )->mergeCells('J13:J13');
                                $sum_nilai_iki += $nilai_iki; 
                                $jumlah_data++;     
                            }
                        }
                    }      
                $sheet->setCellValue('J'.($cell-$jumlah_data-1), $nilai_utama=round($sum_nilai_iki/$jumlah_data,1) )->mergeCells('J'.($cell-$jumlah_data-1).':J'. $cell);
                $cell++;
        }
        }
        
        //TAMBAHAN
        if (isset($data['skp']['tambahan'])) {
            $cell++;
            $sheet->setCellValue('B'.$cell, 'B. KINERJA TAMBAHAN')->mergeCells('B'.$cell.':J'.$cell);
            $sheet->getStyle('B'.$cell.':J'.$cell)->getFont()->setBold(true);
            $cell++;
            $total_tambahan = 0;
            foreach ( $data['skp']['tambahan'] as $index => $value ){
                $sheet->setCellValue('A' . $cell, $index+1);
                $sheet->setCellValue('B' . $cell, $value['rencana_kerja']);
                
                        foreach ($value['aspek_skp'] as $k => $v) {
                            $sheet->setCellValue('C' . $cell, $v['iki']);
                            foreach ($v['target_skp'] as $mk => $rr) {
                                $kategori_ = '';
                                if ($rr['bulan'] ==  $bulan) {
                                    $sheet->setCellValue('D' . $cell, $rr['target'].' '.$v['satuan']);
                                    $sheet->setCellValue('E' . $cell, $v['realisasi_skp'][$mk]['realisasi_bulanan'].' '.$v['satuan']);
                                    $single_rate = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;
                                    
                                    
                                    $sheet->setCellValue('F' . $cell, round($single_rate,0) .' %');
                                    if ($single_rate > 110) {
                                        $sheet->setCellValue('G' . $cell, '110');
                                        $sheet->setCellValue('H' . $cell, 'Sangat Baik');
                                        $nilai_iki=110+((120-110)/(110-101))*(110-101);
                                        $sheet->setCellValue('I' . $cell, round($nilai_iki,1));
                                    }elseif($single_rate >= 101 && $single_rate <= 110){
                                        $sheet->setCellValue('G' . $cell, round($single_rate,0) .' %');
                                        $sheet->setCellValue('H' . $cell, 'Sangat Baik');
                                        $nilai_iki=110+((120-110)/(110-101))*($single_rate-101);
                                        $sheet->setCellValue('I' . $cell, round($nilai_iki,1));
                                    }elseif($single_rate == 100){
                                        $sheet->setCellValue('G' . $cell, round($single_rate,0) .' %');
                                        $sheet->setCellValue('H' . $cell, 'Baik');
                                        $nilai_iki=109;
                                        $sheet->setCellValue('I' . $cell, round($nilai_iki,1));
                                    }elseif($single_rate >= 80 && $single_rate <= 99){
                                        $sheet->setCellValue('G' . $cell, round($single_rate,0) .' %');
                                        $sheet->setCellValue('H' . $cell, 'Cukup');
                                        $nilai_iki=70+((89-70)/(99-80))*($single_rate-80);
                                        $sheet->setCellValue('I' . $cell, round($nilai_iki,1));
                                    }elseif($single_rate >= 60 && $single_rate <= 79){
                                        $sheet->setCellValue('G' . $cell, round($single_rate,0) .' %');
                                        $sheet->setCellValue('H' . $cell, 'Kurang');
                                        $nilai_iki=50+((69-50)/(79-60))*($single_rate-60);
                                        $sheet->setCellValue('I' . $cell, round($nilai_iki,1));
                                    }elseif($single_rate >= 0 && $single_rate <= 79){
                                        $sheet->setCellValue('G' . $cell, round($single_rate,0) .' %');
                                        $sheet->setCellValue('H' . $cell, 'Sangat Kurang');
                                        $nilai_iki=(49/59)*$single_rate;
                                        $sheet->setCellValue('I' . $cell, round($nilai_iki,1));
                                    } 

                                    if ($nilai_iki > 110) {
                                        $sheet->setCellValue('J' . $cell, '2.4');
                                        $total_tambahan+=2.4;
                                    }elseif($nilai_iki >= 101 && $nilai_iki <= 110){
                                        $sheet->setCellValue('J' . $cell, '1.6');
                                        $total_tambahan+=1.6;
                                    }elseif($nilai_iki == 100){
                                        $sheet->setCellValue('J' . $cell, '1.0');
                                        $total_tambahan+=1.0;
                                    }elseif($nilai_iki >= 80 && $nilai_iki <= 99){
                                        $sheet->setCellValue('J' . $cell, '0.5');
                                        $total_tambahan+=0.5;
                                    }elseif($nilai_iki >= 60 && $nilai_iki <= 79){
                                        $sheet->setCellValue('J' . $cell, '0.3');
                                        $total_tambahan+=0.3;
                                    }elseif($nilai_iki >= 0 && $nilai_iki <= 79){
                                        $sheet->setCellValue('J' . $cell, '0.1');
                                        $total_tambahan+=0.1;
                                    } 
                                }
                            }
                            $cell++; 
                        }      
                }
                $sheet->getStyle('F'.$cell.':J'.($cell+1))->getAlignment()->setVertical('top')->setHorizontal('center');
                $sheet->getStyle('B'.$cell.':J'.($cell+1))->getAlignment()->setVertical('top')->setHorizontal('right');
                $sheet->getStyle('B'.$cell.':J'.($cell+1))->getFont()->setBold(true);
                $sheet->setCellValue('B' . $cell, 'NILAI KINERJA TAMBAHAN')->mergeCells('B'.$cell.':I'.$cell);
                $sheet->setCellValue('J' . $cell, $nilai_tambahan=$total_tambahan);
                $cell++;
            }
            $sheet->setCellValue('B' . $cell, 'NILAI SKP')->mergeCells('B'.$cell.':I'.$cell);
            $sheet->setCellValue('J' . $cell, $nilai_utama+$nilai_tambahan);

        
        $sheet->getStyle('A12:J'.$cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('B13:C'.$cell)->getAlignment()->setVertical('center')->setHorizontal('left');
        

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];
        
        $sheet->getStyle('A6:J' . $cell)->applyFromArray($border);
        
   
        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan Penilaian SKP '.$data['pegawai_dinilai']['nama'].'.xlsx"');
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
            ->setTitle('Laporan Penilaian SKP')
            ->setSubject('Laporan Penilaian SKP')
            ->setDescription('Laporan Penilaian SKP')
            ->setKeywords('pdf php')
            ->setCategory('LAPORAN PENILAIAN SKP');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
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

        $sheet->getStyle('A:L')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A:L')->getAlignment()->setVertical('top')->setHorizontal('left');
        
        $sheet->setCellValue('A1', 'PENILAIAN SASARAN KINERJA PEGAWAI (SKP)')->mergeCells('A1:L1');
        $sheet->setCellValue('A2', 'PEJABAT ADMINISTRATOR PENGAWAS & FUNGSIONAL')->mergeCells('A2:L2');
        
        $sheet->setCellValue('F4', 'PERIODE PENILAIAN')->mergeCells('F4:L4');
        $sheet->setCellValue('A5', $data['pegawai_dinilai']['nama_satuan_kerja'])->mergeCells('A5:E5');
        $sheet->setCellValue('F5', "PERIODENYA PERIODENYA PERIODENYA ")->mergeCells('F5:L5');

        $sheet->setCellValue('A6', 'PEGAWAI YANG DINILAI')->mergeCells('A6:E6');
        $sheet->setCellValue('F6', 'PEJABAT PENILAI PEKERJA')->mergeCells('F6:L6');

        $sheet->setCellValue('A7', 'Nama')->mergeCells('A7:B7');
        $sheet->setCellValue('C7', $data['pegawai_dinilai']['nama'])->mergeCells('C7:E7');
        $sheet->setCellValue('A8', 'NIP')->mergeCells('A8:B8');
        $sheet->setCellValue('C8', "'".$data['pegawai_dinilai']['nip'])->mergeCells('C8:E8');
        $sheet->setCellValue('A9', 'Pangkat / Gol Ruang')->mergeCells('A9:B9');
        $sheet->setCellValue('C9', $data['pegawai_dinilai']['golongan'])->mergeCells('C9:E9');
        $sheet->setCellValue('A10', 'Jabatan')->mergeCells('A10:B10');
        $sheet->setCellValue('C10', $data['pegawai_dinilai']['nama_jabatan'])->mergeCells('C10:E10');
        $sheet->setCellValue('A11', 'Unit kerja')->mergeCells('A11:B11');
        $sheet->setCellValue('C11', $data['pegawai_dinilai']['nama_satuan_kerja'])->mergeCells('C11:E11');

        $sheet->setCellValue('F7', 'Nama')->mergeCells('F7:G7');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('H7', $data['atasan']['nama'])->mergeCells('H7:L7');
        } else {
            $sheet->setCellValue('H7', '-')->mergeCells('H7:L7');
        }
        $sheet->setCellValue('F8', 'NIP')->mergeCells('F8:G8');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('H8', "'".$data['atasan']['nip'])->mergeCells('H8:L8');
        } else {
            $sheet->setCellValue('H8', '-')->mergeCells('H8:L8');
        }
        $sheet->setCellValue('F9', 'Pangkat / Gol Ruang')->mergeCells('F9:G9');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('H9', $data['atasan']['golongan'])->mergeCells('H9:L9');
        } else {
            $sheet->setCellValue('H9', '-')->mergeCells('H9:L9');
        } 
        $sheet->setCellValue('F10', 'Jabatan')->mergeCells('F10:G10');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('H10', $data['atasan']['nama_jabatan'])->mergeCells('H10:L10');
        } else {
            $sheet->setCellValue('H10', '-')->mergeCells('H10:L10');
        } 
        $sheet->setCellValue('F11', 'Unit kerja')->mergeCells('F11:G11');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('H11', $data['atasan']['nama_satuan_kerja'])->mergeCells('H11:L11');
        } else {
            $sheet->setCellValue('H11', '-')->mergeCells('H11:L11');
        } 
        

        $sheet->setCellValue('A12', 'No')->mergeCells('A12:A13');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B12', 'Rencana Kinerja Atasan Langsung')->mergeCells('B12:B13');
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->setCellValue('C12', 'Rencana Kinerja')->mergeCells('C12:C13');
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->setCellValue('D12', 'Aspek')->mergeCells('D12:D13');
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->setCellValue('E12', 'Indikator Kinerja Individu')->mergeCells('E12:E13');
        $sheet->getColumnDimension('E')->setWidth(40);

        $sheet->setCellValue('F12', 'Target')->mergeCells('F12:F13');
        $sheet->getColumnDimension('F')->setWidth(17);
        $sheet->setCellValue('G12', 'Realisasi')->mergeCells('G12:G13');
        $sheet->getColumnDimension('G')->setWidth(17);
        $sheet->setCellValue('H12', 'Capaian IKI')->mergeCells('H12:H13');
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->setCellValue('I12', 'Kategori Capaian IKI')->mergeCells('I12:I13');
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->setCellValue('J12', 'Capaian Rencana Kinerja')->mergeCells('J12:K12');
        $sheet->setCellValue('J13', 'Kategori');
        $sheet->getColumnDimension('J')->setWidth(12);
        $sheet->setCellValue('K13', 'Nilai');
        $sheet->getColumnDimension('K')->setWidth(12);
        $sheet->setCellValue('L12', 'Nilai Timnbang')->mergeCells('L12:L13');
        $sheet->getColumnDimension('L')->setWidth(12);

        
        $cell = 14;
        $nilai_utama=0;
        $nilai_tambahan=0;
        //$data_column = $data['skp']['utama'];
        //UTAMA
        if (isset($data['skp']['utama'])) {
        $sheet->setCellValue('B'.$cell, 'A. KINERJA UTAMA')->mergeCells('B'.$cell.':K'.$cell);
        $sheet->getStyle('B'.$cell.':K'.$cell)->getFont()->setBold(true);
        $cell++;
        $total_utama=0;
        $data_utama=1;
        foreach ( $data['skp']['utama'] as $index => $value ){
            $data_utama++;
            $sheet->setCellValue('A' . $cell, $index);
            if(isset($value['atasan']['rencana_kerja'])){
                $sheet->setCellValue('B' . $cell, $value['atasan']['rencana_kerja'])->mergeCells('B'.$cell.':B'.($cell+2));
            }else{
                $sheet->setCellValue('B' . $cell, '');
            }
            
            foreach ($value['skp_child'] as $key => $res) {
                
                $sheet->setCellValue('C' . $cell, $res['rencana_kerja'])->mergeCells('C'.$cell.':C'.($cell+2));
                $sum_capaian = 0;
                foreach ($res['aspek_skp'] as $k => $v) {
                    $sheet->getStyle('D'.$cell.':D'.$cell)->getAlignment()->setVertical('top')->setHorizontal('center');
                    $sheet->getStyle('F'.$cell.':L'.$cell)->getAlignment()->setVertical('top')->setHorizontal('center');
                    $sheet->setCellValue('D' . $cell, $v['aspek_skp']);
                    $sheet->setCellValue('E' . $cell, $v['iki']);
                    foreach ($v['target_skp'] as $mk => $rr) {
                        $kategori_ = '';
                        if ($rr['bulan'] ==  $bulan) {
                            $sheet->setCellValue('F' . $cell, $rr['target'].' '.$v['satuan']);
                            $sheet->setCellValue('G' . $cell, $v['realisasi_skp'][$mk]['realisasi_bulanan'].' '.$v['satuan']);
                            $capaian_iki = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;

                                if($capaian_iki >= 101){
                                    $sheet->setCellValue('H' . $cell, round($capaian_iki,0) .' %');
                                    $sheet->setCellValue('I' . $cell, 'Sangat Baik');
                                    $nilai_iki=16;
                                }elseif($capaian_iki == 100){
                                    $sheet->setCellValue('H' . $cell, round($capaian_iki,0) .' %');
                                    $sheet->setCellValue('I' . $cell, 'Baik');
                                    $nilai_iki=13;
                                }elseif($capaian_iki >= 80 && $capaian_iki <= 99){
                                    $sheet->setCellValue('H' . $cell, round($capaian_iki,0) .' %');
                                    $sheet->setCellValue('I' . $cell, 'Cukup');
                                    $nilai_iki=8;
                                }elseif($capaian_iki >= 60 && $capaian_iki <= 79){
                                    $sheet->setCellValue('H' . $cell, round($capaian_iki,0) .' %');
                                    $sheet->setCellValue('I' . $cell, 'Kurang');
                                    $nilai_iki=3;
                                }elseif($capaian_iki >= 0 && $capaian_iki <= 79){
                                    $sheet->setCellValue('H' . $cell, round($capaian_iki,0) .' %');
                                    $sheet->setCellValue('I' . $cell, 'Sangat Kurang');
                                    $nilai_iki=1;
                                } 
                                $sum_capaian += $nilai_iki; 
                        }
                    }
                    $cell++;
                     
                }
                    if($sum_capaian >= 42){
                        $sheet->setCellValue('J' . ($cell-3), 'Sangat Baik')->mergeCells('J'.($cell-3).':J'.($cell-1));
                        $sheet->setCellValue('K' . ($cell-3), '120 %')->mergeCells('K'.($cell-3).':K'.($cell-1));
                        $sheet->setCellValue('L' . ($cell-3), '120.0')->mergeCells('L'.($cell-3).':L'.($cell-1));
                        $total_utama+=120;
                    }elseif($sum_capaian >= 34){
                        $sheet->setCellValue('J' . ($cell-3), 'Baik')->mergeCells('J'.($cell-3).':J'.($cell-1));
                        $sheet->setCellValue('K' . ($cell-3), '100 %')->mergeCells('K'.($cell-3).':K'.($cell-1));
                        $sheet->setCellValue('L' . ($cell-3), '100')->mergeCells('L'.($cell-3).':L'.($cell-1));
                        $total_utama+=100;
                    }elseif($sum_capaian >= 19){
                        $sheet->setCellValue('J' . ($cell-3), 'Cukup')->mergeCells('J'.($cell-3).':J'.($cell-1));
                        $sheet->setCellValue('K' . ($cell-3), '80 %')->mergeCells('K'.($cell-3).':K'.($cell-1));
                        $sheet->setCellValue('L' . ($cell-3), '80.0')->mergeCells('L'.($cell-3).':L'.($cell-1));
                        $total_utama+=80;
                    }elseif($sum_capaian >= 7){
                        $sheet->setCellValue('J' . ($cell-3), 'Kurang')->mergeCells('J'.($cell-3).':J'.($cell-1));
                        $sheet->setCellValue('K' . ($cell-3), '60 %')->mergeCells('K'.($cell-3).':K'.($cell-1));
                        $sheet->setCellValue('L' . ($cell-3), '60.0')->mergeCells('L'.($cell-3).':L'.($cell-1));
                        $total_utama+=60;
                    }elseif($sum_capaian >= 3){
                        $sheet->setCellValue('J' . ($cell-3), 'Sangat Kurang')->mergeCells('J'.($cell-3).':J'.($cell-1));
                        $sheet->setCellValue('K' . ($cell-3), '25 %')->mergeCells('K'.($cell-3).':K'.($cell-1));
                        $sheet->setCellValue('L' . ($cell-3), '25.0')->mergeCells('L'.($cell-3).':L'.($cell-1));
                        $total_utama+=25;
                    }
                    elseif($sum_capaian >= 0){
                        $sheet->setCellValue('J' . ($cell-3), 'Sangat Kurang')->mergeCells('J'.($cell-3).':J'.($cell-1));
                        $sheet->setCellValue('K' . ($cell-3), '25 %')->mergeCells('K'.($cell-3).':K'.($cell-1));
                        $sheet->setCellValue('L' . ($cell-3), '25.0')->mergeCells('L'.($cell-3).':L'.($cell-1));
                        $total_utama+=25;
                    }
                
                $sheet->setCellValue('A' . ($cell-3), $key+1)->mergeCells('A'.($cell-3).':A'.($cell-1));
                if (!$key==0)
                $sheet->setCellValue('B' . ($cell-3), '')->mergeCells('B'.($cell-3).':B'.($cell-1)); 
            }
            $cell++;
            $sheet->getStyle('B'.$cell.':K'.$cell)->getAlignment()->setVertical('top')->setHorizontal('right');
            $sheet->getStyle('L'.$cell)->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->getStyle('B'.$cell.':L'.$cell)->getFont()->setBold(true);
            $sheet->setCellValue('B' . $cell, 'NILAI KINERJA UTAMA')->mergeCells('B'.$cell.':K'.$cell);
            $sheet->setCellValue('L' . $cell, $nilai_utama=$total_utama/$data_utama);
        }
       }
        
       else{
            $sheet->setCellValue('A'.$cell, 'Data masih kosong')->mergeCells('A'.$cell.':L'.$cell);
        }

       // TAMBAHAN
       if(isset($data['skp']['tambahan'])){
        $cell++;
        $sheet->setCellValue('B'.$cell, 'B. KINERJA TAMBAHAN')->mergeCells('B'.$cell.':K'.$cell);
        $sheet->getStyle('B'.$cell.':K'.$cell)->getFont()->setBold(true);
        $cell++;
            $total_tambahan=0;
            foreach ($data['skp']['tambahan'] as $keyy => $values) {
                $sheet->setCellValue('A' . $cell, $index+1)->mergeCells('A'.$cell.':A'.($cell+2));
                $sheet->setCellValue('B' . $cell, ' ')->mergeCells('B'.$cell.':B'.($cell+2));
                $sheet->setCellValue('C' . $cell, $values['rencana_kerja'])->mergeCells('C'.$cell.':C'.($cell+2));
                $sum_capaian = 0;
                foreach ($values['aspek_skp'] as $k => $v) {
                    $sheet->getStyle('D'.$cell.':D'.$cell)->getAlignment()->setVertical('top')->setHorizontal('center');
                    $sheet->getStyle('F'.$cell.':L'.$cell)->getAlignment()->setVertical('top')->setHorizontal('center');
                    $sheet->setCellValue('D' . $cell, $v['aspek_skp'])->mergeCells('D'.$cell.':D'.$cell);
                    $sheet->setCellValue('E' . $cell, $v['iki'])->mergeCells('E'.$cell.':E'.$cell);
                    
                    foreach ($v['target_skp'] as $mk => $rr) {
                        if ($rr['bulan'] ==  $bulan) {
                            $sheet->setCellValue('F' . $cell, $rr['target'].' '.$v['satuan']);
                            $sheet->setCellValue('G' . $cell, $v['realisasi_skp'][$mk]['realisasi_bulanan'].' '.$v['satuan']);
                            $capaian_iki = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;

                                if($capaian_iki >= 101){
                                    $sheet->setCellValue('H' . $cell, round($capaian_iki,0) .' %');
                                    $sheet->setCellValue('I' . $cell, 'Sangat Baik');
                                    $nilai_iki=16;
                                }elseif($capaian_iki == 100){
                                    $sheet->setCellValue('H' . $cell, round($capaian_iki,0) .' %');
                                    $sheet->setCellValue('I' . $cell, 'Baik');
                                    $nilai_iki=13;
                                }elseif($capaian_iki >= 80 && $capaian_iki <= 99){
                                    $sheet->setCellValue('H' . $cell, round($capaian_iki,0) .' %');
                                    $sheet->setCellValue('I' . $cell, 'Cukup');
                                    $nilai_iki=8;
                                }elseif($capaian_iki >= 60 && $capaian_iki <= 79){
                                    $sheet->setCellValue('H' . $cell, round($capaian_iki,0) .' %');
                                    $sheet->setCellValue('I' . $cell, 'Kurang');
                                    $nilai_iki=3;
                                }elseif($capaian_iki >= 0 && $capaian_iki <= 79){
                                    $sheet->setCellValue('H' . $cell, round($capaian_iki,0) .' %');
                                    $sheet->setCellValue('I' . $cell, 'Sangat Kurang');
                                    $nilai_iki=1;
                                } 
                                $sum_capaian += $nilai_iki; 
                        }
                    }
                    $cell++;  
                }
                if($sum_capaian >= 42){
                    $sheet->setCellValue('J' . ($cell-3), 'Sangat Baik')->mergeCells('J'.($cell-3).':J'.($cell-1));
                    $sheet->setCellValue('K' . ($cell-3), '120')->mergeCells('K'.($cell-3).':K'.($cell-1));
                    $sheet->setCellValue('L' . ($cell-3), '2.4')->mergeCells('L'.($cell-3).':L'.($cell-1));
                    $total_tambahan+=2.4;
                }elseif($sum_capaian >= 34){
                    $sheet->setCellValue('J' . ($cell-3), 'Baik')->mergeCells('J'.($cell-3).':J'.($cell-1));
                    $sheet->setCellValue('K' . ($cell-3), '100')->mergeCells('K'.($cell-3).':K'.($cell-1));
                    $sheet->setCellValue('L' . ($cell-3), '1.6')->mergeCells('L'.($cell-3).':L'.($cell-1));
                    $total_tambahan+=1.6;
                }elseif($sum_capaian >= 19){
                    $sheet->setCellValue('J' . ($cell-3), 'Cukup')->mergeCells('J'.($cell-3).':J'.($cell-1));
                    $sheet->setCellValue('K' . ($cell-3), '80')->mergeCells('K'.($cell-3).':K'.($cell-1));
                    $sheet->setCellValue('L' . ($cell-3), '1')->mergeCells('L'.($cell-3).':L'.($cell-1));
                    $total_tambahan+=1;
                }elseif($sum_capaian >= 7){
                    $sheet->setCellValue('J' . ($cell-3), 'Kurang')->mergeCells('J'.($cell-3).':J'.($cell-1));
                    $sheet->setCellValue('K' . ($cell-3), '60 %')->mergeCells('K'.($cell-3).':K'.($cell-1));
                    $sheet->setCellValue('L' . ($cell-3), '0.5')->mergeCells('L'.($cell-3).':L'.($cell-1));
                    $total_tambahan+=0.5;
                }elseif($sum_capaian >= 3){
                    $sheet->setCellValue('J' . ($cell-3), 'Sangat Kurang')->mergeCells('J'.($cell-3).':J'.($cell-1));
                    $sheet->setCellValue('K' . ($cell-3), '25')->mergeCells('K'.($cell-3).':K'.($cell-1));
                    $sheet->setCellValue('L' . ($cell-3), '0.1')->mergeCells('L'.($cell-3).':L'.($cell-1));
                    $total_tambahan+=0.1;
                }
                elseif($sum_capaian >= 0){
                    $sheet->setCellValue('J' . ($cell-3), 'Sangat Kurang')->mergeCells('J'.($cell-3).':J'.($cell-1));
                    $sheet->setCellValue('K' . ($cell-3), '25')->mergeCells('K'.($cell-3).':K'.($cell-1));
                    $sheet->setCellValue('L' . ($cell-3), '0.1')->mergeCells('L'.($cell-3).':L'.($cell-1));
                    $total_tambahan+=0.1;
                }

                $sheet->setCellValue('A' . ($cell-3), $keyy+1)->mergeCells('A'.($cell-3).':A'.($cell-1));
                if (!$keyy==0)
                $sheet->setCellValue('B' . ($cell-3), '')->mergeCells('B'.($cell-3).':B'.($cell-1)); 
            }
            $cell++;
            $sheet->getStyle('F'.$cell.':L'.($cell+1))->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->getStyle('B'.$cell.':K'.($cell+1))->getAlignment()->setVertical('top')->setHorizontal('right');
            $sheet->getStyle('B'.$cell.':L'.($cell+1))->getFont()->setBold(true);
            $sheet->setCellValue('B' . $cell, 'NILAI KINERJA TAMBAHAN')->mergeCells('B'.$cell.':K'.$cell);
            $sheet->setCellValue('L' . $cell, $nilai_tambahan=$total_tambahan);
            $cell++;
            
        }
        else{
            $sheet->setCellValue('A'.$cell, 'Data masih kosong')->mergeCells('A'.$cell.':L'.$cell);
        }
        //if(isset($nilai_utama))
        $sheet->setCellValue('B' . $cell, 'NILAI SKP')->mergeCells('B'.$cell.':K'.$cell);
        $sheet->setCellValue('L' . $cell, $nilai_utama+$nilai_tambahan);
        

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];
       
        $sheet->getStyle('A6:L' . $cell)->applyFromArray($border);
        
        
        
        
        $sheet->getStyle('A1:L2')->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A1:L2')->getFont()->setSize(12);
        $sheet->getStyle('A6:L6')->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A6:L6')->getFont()->setBold(true);
        $sheet->getStyle('A7:L7')->getFont()->setBold(true);
        $sheet->getStyle('A12:L13')->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A12:L13')->getFont()->setBold(true);
        $sheet->getStyle('F4:H5')->getAlignment()->setVertical('center')->setHorizontal('right');

        
       

   
        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan Penilaian SKP '.$data['pegawai_dinilai']['nama'].'.xlsx"');
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
        //$sheet->setCellValue('A4', $startDate.' s/d '.$endDate)->mergeCells('A4:G4');
        $sheet->getStyle('A1:G4')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:G4')->getFont()->setSize(14);

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
            header('Content-Disposition: attachment;filename="Laporan Absen'.$data['data']['pegawai']['nama'].'.xlsx"');
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
        
        $sheet->setCellValue('B4', 'PERIODE');
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
            header('Content-Disposition: attachment;filename="Laporan Absen'.$data['satuan_kerja'].'.xlsx"');
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

    public function bankom($role_page)
    {
        
        $page_title = 'Laporan';
        $page_description = 'Daftar Laporan Bankom';
        $breadcumb = ['Bankom'];

        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $role = session()->get('user.role');
        $satker = session()->get('user.current.pegawai.id_satuan_kerja');
        $idPegawai = session()->get('user.current.pegawai.id');
        $pegawaiBysatker = Http::withToken($token)->get($url."/pegawai/BySatuanKerja/".$satker);
        $pegawaiBysatker_ = $pegawaiBysatker->json();

        // return $satker_;

        return view('pages.laporan.bankom', compact('page_title', 'page_description','breadcumb','pegawaiBysatker_','role','role_page','idPegawai'));
    }

    public function getDataBankom($type,$tahun,$id_pegawai){
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $satker = session()->get('user.current.pegawai.id_satuan_kerja');
        $data = Http::withToken($token)->get($url."/bankom/laporan/".$type.'/'.$satker.'/'.$tahun.'/'.$id_pegawai);
        return $data->json();
    }

    public function exportbankom($tahun,$type,$id_pegawai){
       
        if ($id_pegawai == 'semua') {
            $data = $this->getDataBankom('rekap',$tahun,$id_pegawai);
        
            return $this->laporanRekap($data,$type,$tahun);
        }else{
            $data = $this->getDataBankom('pegawai',$tahun,$id_pegawai);
           
    
            return $this->laporanByPegawai($data,$type,$tahun);
        }
    }

    public function laporanRekap($data,$type,$tahun){
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('BKPSDM BULUKUMBA')
            ->setLastModifiedBy('BKPSDM BULUKUMBA')
            ->setTitle('Laporan Rekapitulasi Data Pengembangan Kompentensi')
            ->setSubject('Laporan Rekapitulasi Data Pengembangan Kompentensi')
            ->setDescription('Laporan Rekapitulasi Data Pengembangan Kompentensi')
            ->setKeywords('pdf php')
            ->setCategory('LAPORAN Rekapitulasi Pengembangan Kompetensi');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(3)->setRowHeight(17);
        $sheet->getRowDimension(4)->setRowHeight(24);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        // //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        $sheet->setCellValue('A1', 'REKAPITULASI DATA PENGEMBANGAN KOMPETENSI')->mergeCells('A1:G1');
        $sheet->setCellValue('A2', 'TAHUN '.$tahun)->mergeCells('A2:G2');
        
        $sheet->getStyle('A:G')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:G4')->getFont()->setBold(true);
        $sheet->getStyle('A:L')->getAlignment()->setVertical('center')->setHorizontal('center');

        // HEADER
        $sheet->setCellValue('A4', 'No');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B4', 'Nama Pegawai');
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->setCellValue('C4', 'Nama Pelatihan');
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->setCellValue('D4', 'Jenis Pelatihan');
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->setCellValue('E4', 'Waktu Pelaksanaan');
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->setCellValue('F4', 'JP');
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->setCellValue('G4', 'Total JP');
        $sheet->getColumnDimension('G')->setWidth(15);
        $cell = 5;


        foreach ($data as $key => $value) {
            
            $total_jp = 0;
            $jumlah_data=0;
            foreach ($value['bankom'] as $x => $y) {
                $jumlah_data++;
                $total_jp += $y['jumlah_jp'];
                $sheet->setCellValue('C'.$cell, $y['nama_pelatihan']);
                $sheet->setCellValue('D'.$cell, $y['jenis_pelatihan']);
                $sheet->setCellValue('E'.$cell, $y['waktu_awal'].' s/d '.$y['waktu_akhir']);
                $sheet->setCellValue('F'.$cell, $y['jumlah_jp']);
                $cell++;
            }
            $sheet->setCellValue('A'.($cell-$jumlah_data), $key+1)->mergeCells('A'.($cell-$jumlah_data).':A'.($cell-1));
            $sheet->setCellValue('B'.($cell-$jumlah_data), $value['nama'])->mergeCells('B'.($cell-$jumlah_data).':B'.($cell-1));
            $sheet->setCellValue('G'.($cell-$jumlah_data), $total_jp)->mergeCells('G'.($cell-$jumlah_data).':G'.($cell-1));
            $sheet->getStyle('G'.($cell-$jumlah_data))->getFont()->setBold(true);
        }

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A4:G' . $cell)->applyFromArray($border);
        $sheet->getStyle('A1:G'.$cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('B5:C'.$cell)->getAlignment()->setVertical('center')->setHorizontal('left');

        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan Rekapitulasi Pengembangan Kompetensi.xlsx"');
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

    public function laporanByPegawai($data,$type,$tahun){
      
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('BKPSDM BULUKUMBA')
            ->setLastModifiedBy('BKPSDM BULUKUMBA')
            ->setTitle('Laporan Rekapitulasi Data Pengembangan Kompentensi')
            ->setSubject('Laporan Rekapitulasi Data Pengembangan Kompentensi')
            ->setDescription('Laporan Rekapitulasi Data Pengembangan Kompentensi')
            ->setKeywords('pdf php')
            ->setCategory('LAPORAN Rekapitulasi Pengembangan Kompetensi');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(3)->setRowHeight(17);
        $sheet->getRowDimension(4)->setRowHeight(24);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        // //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        $sheet->setCellValue('A1', 'DATA PENGEMBANGAN KOMPETENSI')->mergeCells('A1:F1');
        $sheet->setCellValue('A2', 'TAHUN '.$tahun)->mergeCells('A2:F2');
        
        $sheet->getStyle('A:F')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:F4')->getFont()->setBold(true);
        $sheet->getStyle('A:F')->getAlignment()->setVertical('center')->setHorizontal('center');

        // HEADER
        $sheet->setCellValue('A4', 'No');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B4', 'Nama Pelatihan');
        $sheet->getColumnDimension('B')->setWidth(60);
        $sheet->setCellValue('C4', 'Jenis Pelatihan');
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->setCellValue('D4', 'Waktu Pelaksanaan');
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->setCellValue('E4', 'JP');
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->setCellValue('F4', 'Total JP');
        $sheet->getColumnDimension('F')->setWidth(15);
        $cell = 5;
        $jumlah_data=0;
        $total_jp = 0;
        foreach ($data as $key => $y) {
            $jumlah_data++;
            $total_jp += $y['jumlah_jp'];
            $sheet->setCellValue('A'.$cell, $key+1);
            $sheet->setCellValue('B'.$cell, $y['nama_pelatihan']);
            $sheet->setCellValue('C'.$cell, $y['jenis_pelatihan']);
            $sheet->setCellValue('D'.$cell, $y['waktu_awal'].' s/d '.$y['waktu_akhir']);
            $sheet->setCellValue('E'.$cell, $y['jumlah_jp']);
            $cell++;
        }
        $sheet->setCellValue('F'.($cell-$jumlah_data), $total_jp)->mergeCells('F'.($cell-$jumlah_data).':F'.($cell-1));
        $sheet->getStyle('F'.($cell-$jumlah_data))->getFont()->setBold(true);
        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A4:F' . $cell)->applyFromArray($border);
        $sheet->getStyle('A1:F'.$cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('B5:B'.$cell)->getAlignment()->setVertical('center')->setHorizontal('left');
        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan Rekapitulasi Pengembangan Kompetensi.xlsx"');
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


}
