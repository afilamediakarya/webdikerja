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

    public function getSkp(){
      
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $data = Http::withToken($token)->get($url."/laporan/skp");
        return $data['data'];
    }

    public function exportLaporanSkp($jenis,$type,$bulan){
        if ($jenis == 'skp') {

            $data = $this->getSkp(); 
            return $this->exportSkp($data,$bulan,$type);  
        }else{
            return 'realisasi';
        }
    }

    public function exportSkp($data,$bulan,$type){
     
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('AFILA')
            ->setLastModifiedBy('AFILA')
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
        $sum_capaian = 0;
        foreach ( $data['skp'] as $index => $value ){
            $sheet->setCellValue('A' . $cell, $index+1);
            $sheet->setCellValue('B' . $cell, $value['atasan']['rencana_kerja']);
            foreach ($value['skp_child'] as $key => $res) {
                $sheet->setCellValue('C' . $cell, $res['rencana_kerja']);
                foreach ($res['aspek_skp'] as $k => $v) {
                   
                    $sheet->setCellValue('D' . $cell, $v['aspek_skp']);
                    $sheet->setCellValue('E' . $cell, $v['iki']);
                   
                    foreach ($v['target_skp'] as $mk => $rr) {
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

                            
                        }
                        
                        // if ($v['realisasi_skp'][$mk]['bulan'] ==  $bulan) {
                            
                        //     $sheet->setCellValue('H' . $cell, $v['realisasi_skp'][$mk]['realisasi_bulanan'].' '.$v['satuan']);
                        // }
                    }
                    

                    $cell++;  
                }
            }
            $sheet->setCellValue('K' . $cell, $sum_capaian);
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
        // $sheet->getStyle('B5:B6')->getAlignment()->setVertical('center')->setHorizontal('center');
        // $sheet->getStyle('C5:C6')->getAlignment()->setVertical('center')->setHorizontal('center');
        // $sheet->getStyle('D5:E5')->getAlignment()->setVertical('center')->setHorizontal('center');
        // $sheet->getStyle('F5:G5')->getAlignment()->setVertical('center')->setHorizontal('center');
        // $sheet->getStyle('D6:G6')->getAlignment()->setHorizontal('center');

        // $sheet->getStyle('A10:G'.$cell)->getAlignment()->setVertical('center')->setHorizontal('center');

   
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

        $spreadsheet->getProperties()->setCreator('AFILA')
            ->setLastModifiedBy('AFILA')
            ->setTitle('Laporan Rekapitulasi Absen Pegawai')
            ->setSubject('Laporan Rekapitulasi Absen Pegawai')
            ->setDescription('Laporan Rekapitulasi Absen Pegawai')
            ->setKeywords('pdf php')
            ->setCategory('LAPORAN ABSEN');
        $sheet = $spreadsheet->getActiveSheet();
        if ($orientation == 'mobile') {
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
        }else{
            $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        }

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

        $sheet->setCellValue('A1', 'Laporan Rekapitulasi Absen Pegawai');
        $sheet->setCellValue('A2', ''.$data['data']['pegawai']['satuan_kerja']['nama_satuan_kerja']);
        $sheet->setCellValue('A3',  $data['data']['pegawai']['nama'].'/ '.$data['data']['pegawai']['nip']);
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');
        $sheet->mergeCells('A3:G3');
        
        $sheet->getStyle('A1')->getFont()->setSize(14);

        $sheet->setCellValue('A4', 'Jumlah hari kerja : '.$data['data']['jml_hari_kerja'])->mergeCells('A4:B4');
        $sheet->setCellValue('A5', 'Kehadiran kerja : '.$data['data']['kehadiran'])->mergeCells('A5:B5');
        $sheet->setCellValue('A6', 'Tanpa keterangan : '.$data['data']['tanpa_keterangan'])->mergeCells('A6:B6');
        $sheet->setCellValue('A7', 'Jumlah potongan kehadiran : '.$data['data']['potongan_kehadiran'])->mergeCells('A7:B7');
        $sheet->setCellValue('A8', 'Persentase pemotongan : '.$data['data']['persentase_pemotongan'])->mergeCells('A8:B8');

        $sheet->setCellValue('A10', 'No')->mergeCells('A10:A11');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B10', 'Tanggal')->mergeCells('B10:B11');
        $sheet->getColumnDimension('B')->setWidth(32);
        $sheet->setCellValue('C10', 'Status Absen')->mergeCells('C10:C11');
        $sheet->getColumnDimension('C')->setWidth(32);
        $sheet->setCellValue('D10', 'Masuk')->mergeCells('D10:E10');
        $sheet->setCellValue('D10', 'Waktu');
        $sheet->getColumnDimension('D')->setWidth(32);
        $sheet->setCellValue('E11', 'Keterangan');
        $sheet->getColumnDimension('E')->setWidth(32);
        $sheet->setCellValue('F10', 'Keluar')->mergeCells('F10:G10');
        $sheet->setCellValue('F11', 'Waktu');
        $sheet->getColumnDimension('F')->setWidth(32);
        $sheet->setCellValue('G11', 'Keterangan');
        $sheet->getColumnDimension('G')->setWidth(32);

        $sheet->getStyle('A:G')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A10:G11')->getFont()->setBold(true);
        $cell = 12;


        foreach ( $data['data']['data_absen'] as $index => $value ){
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
       
        $sheet->getStyle('A10:G' . $cell)->applyFromArray($border);



        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2:G2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A3:G3')->getAlignment()->setHorizontal('center');

        // $sheet->getStyle('A5:A6')->getAlignment()->setVertical('center')->setHorizontal('center');
        // $sheet->getStyle('B5:B6')->getAlignment()->setVertical('center')->setHorizontal('center');
        // $sheet->getStyle('C5:C6')->getAlignment()->setVertical('center')->setHorizontal('center');
        // $sheet->getStyle('D5:E5')->getAlignment()->setVertical('center')->setHorizontal('center');
        // $sheet->getStyle('F5:G5')->getAlignment()->setVertical('center')->setHorizontal('center');
        // $sheet->getStyle('D6:G6')->getAlignment()->setHorizontal('center');

        $sheet->getStyle('A10:G'.$cell)->getAlignment()->setVertical('center')->setHorizontal('center');

   
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

        $spreadsheet->getProperties()->setCreator('AFILA')
            ->setLastModifiedBy('AFILA')
            ->setTitle('Laporan Rekapitulasi Absen Pegawai')
            ->setSubject('Laporan Rekapitulasi Absen Pegawai')
            ->setDescription('Laporan Rekapitulasi Absen Pegawai')
            ->setKeywords('pdf php')
            ->setCategory('LAPORAN ABSEN');
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

        $sheet->setCellValue('B2', 'REKAPITULASI CAPAIAN DISIPLIN/ KEHADIRAN KERJA');
        $sheet->mergeCells('B2:AC2');

        $sheet->setCellValue('B4', 'PERANGKAT DAERAH');
        $sheet->mergeCells('B4:C4');
        $sheet->setCellValue('D4', ':');
        $sheet->setCellValue('E4', $data['satuan_kerja'])->mergeCells('E4:F4');
        
        $sheet->setCellValue('B5', 'KEADAAN BULAN');
        $sheet->mergeCells('B5:C5');
        $sheet->setCellValue('D5', ':');
        $sheet->setCellValue('E5', $startDate.' s/d '.$endDate)->mergeCells('E5:F5');
        
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(10);

        $sheet->getStyle('B2:AC2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('D4')->getAlignment()->setHorizontal('center');
        

        // konten
        $sheet->setCellValue('B7', 'No')->mergeCells('B7:B12');
        $sheet->getColumnDimension('B')->setWidth(5);
        $sheet->setCellValue('C7', 'NAMA/NIP')->mergeCells('C7:C12');
        $sheet->getColumnDimension('C')->setWidth(35);
        $sheet->setCellValue('D7', 'JML HARI KERJA')->mergeCells('D7:D12');
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->setCellValue('E7', 'KEHADIRAN KERJA')->mergeCells('E7:Y7');
        $sheet->setCellValue('E8', 'JUMLAH KEHADIRAN KERJA')->mergeCells('E8:E12');
        $sheet->setCellValue('F8', 'TANPA KETERANGAN')->mergeCells('F8:H8');
        $sheet->setCellValue('F9', 'JUMLAH HARI TANPA KETERANGAN')->mergeCells('F9:F12');
        // $sheet->setCellValue('G10', 'KEHADIRAN KERJA')->mergeCells('G10:G12');
        $sheet->setCellValue('G9', 'POTONGAN / HARI')->mergeCells('G9:H12');
        $sheet->setCellValue('I8', 'KETERLAMBATAN MASUK KERJA')->mergeCells('I8:P8');
        $sheet->setCellValue('J9', 'WAKTU TMK (MENIT)')->mergeCells('J9:P9');
        $sheet->setCellValue('I10', '1-30');
        $sheet->setCellValue('I11', 'M')->mergeCells('I11:I12');
        
        $sheet->setCellValue('J10', 'JML');
        $sheet->setCellValue('J11', 'POT')->mergeCells('J11:J12');
        
        $sheet->setCellValue('K10', '31-60');
        $sheet->setCellValue('K11', 'M')->mergeCells('K11:K12');
        
        $sheet->setCellValue('L10', 'JML');
        $sheet->setCellValue('L11', 'M')->mergeCells('L11:L12');
        
        $sheet->setCellValue('M10', '61-90');
        $sheet->setCellValue('M11', 'POT')->mergeCells('M11:M12');
        
        $sheet->setCellValue('N10', 'JML');
        $sheet->setCellValue('N11', 'POT')->mergeCells('N11:N12');
        
        $sheet->setCellValue('O10', '91');
        $sheet->setCellValue('O11', 'KEATAS')->mergeCells('O11:O12');
        
        $sheet->setCellValue('P10', 'JML');
        $sheet->setCellValue('P11', 'POT')->mergeCells('P11:P12');

        $sheet->setCellValue('R8', 'CEPAT PULANG KERJA')->mergeCells('R8:X8');
        $sheet->setCellValue('R9', 'WAKTU CPK (MENIT)')->mergeCells('R9:X9');

        $sheet->setCellValue('Q10', '1-30');
        $sheet->setCellValue('Q11', 'M')->mergeCells('Q11:Q12');
        
        $sheet->setCellValue('R10', 'JML');
        $sheet->setCellValue('R11', 'POT')->mergeCells('R11:R12');
        
        $sheet->setCellValue('S10', '31-60');
        $sheet->setCellValue('S11', 'M')->mergeCells('S11:S12');
        
        $sheet->setCellValue('T10', 'JML');
        $sheet->setCellValue('T11', 'POT')->mergeCells('T11:T12');
        
        $sheet->setCellValue('U10', '61-90');
        $sheet->setCellValue('U11', 'M')->mergeCells('U11:U12');
        
        $sheet->setCellValue('V10', 'JML');
        $sheet->setCellValue('V11', 'POT')->mergeCells('V11:V12');

        $sheet->setCellValue('W10', '91');
        $sheet->setCellValue('W11', 'KEATAS')->mergeCells('W11:W12');
    
        $sheet->setCellValue('X10', 'JML');
        $sheet->setCellValue('X11', 'POT')->mergeCells('X11:X12');

        $sheet->setCellValue('Y8', 'JUMLAH TIDAK HADIR APEL/UPACARA')->mergeCells('Y8:Y12');
        $sheet->setCellValue('Z8', 'JUMLAH POTONGAN/  TIDAK APEL/UPACARA')->mergeCells('Z8:Z12');
        $sheet->setCellValue('AA7', 'JUMLAH PEMOTONGAN KEHADIRAN')->mergeCells('AA7:AA12');
        $sheet->setCellValue('AB7', 'PERSENTASE PEMOTONGAN TUNJANGAN KEHADIRAN (40%)')->mergeCells('AB7:AB12');


        $cell = 13;

        // $jml_hari_kerja = [];
        foreach($data['pegawai'] as $i => $val){
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
            $sheet->setCellValue('C' . $cell, $val[0]['pegawai']['nama'].' / '.$val[0]['pegawai']['nip']);
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
            $sheet->setCellValue('Y' . $cell, 0); 
            $sheet->setCellValue('Z' . $cell, 0); 
            $sheet->setCellValue('X' . $cell, count($cpk_90_keatas) * 1.5); 

            $jml_potongan_kehadiran = ($jml_tanpa_keterangan * 3) + (count($kmk_30)) + (count($kmk_60)) + (count($kmk_90)) + (count($kmk_90_keatas)) + (count($cpk_30)) + (count($cpk_60)) + (count($cpk_90)) + count($cpk_90_keatas) * 1.5;

            $persentase_pemotongan_tunjangan = ($jml_potongan_kehadiran / 100) * 0.4;

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
       
        $sheet->getStyle('B7:AB' . $cell)->applyFromArray($border);
        $sheet->getStyle('E7:AB'. $cell)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('F8:I8')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('J8:Q8')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('R:Y')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('J:Q')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B:D')->getAlignment()->setVertical('center')->setHorizontal('center');

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
        if ($params == 'checkin') {
            $waktu_tetap_absen = strtotime('08:00:00');
            $waktu_absen = strtotime($waktu); 
            $diff = $waktu_absen - $waktu_tetap_absen;
        }else{
            $waktu_tetap_absen = strtotime('17:00:00');
            $waktu_absen = strtotime($waktu); 
            $diff = $waktu_tetap_absen - $waktu_absen;
        }

        $jam = floor($diff/(60*60));
        $menit = $diff - $jam * (60*60);
        $selisih_waktu = floor($menit/60);

        return $selisih_waktu;
    }

}
