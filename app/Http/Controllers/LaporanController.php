<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Http;
use Session;
use \Illuminate\Support\Facades\Auth;

use App\Models\jabatan;

setlocale(LC_ALL, 'IND');

class LaporanController extends Controller
{
    //
    public function absen($TypeRole)
    {
        $page_title = 'Laporan';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Absen'];

        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $current = session()->get('user.current');

        if ($TypeRole == 'super_admin') {
            $data = Http::withToken($token)->get($url . "/satuan_kerja/list");
            $satuan_kerja = $data['data'];
        } else {
            $data = Http::withToken($token)->get($url . "/satuan_kerja/byAdminOpd");
            $satuan_kerja = $data['data'];
        }
        // return $satuan_kerja;
        return view('pages.laporan.absen', compact('page_title', 'page_description', 'breadcumb', 'TypeRole', 'satuan_kerja','current'));
    }

    public function kinerja()
    {
        $page_title = 'Laporan';
        $page_description = 'Laporan Kinerja Pegawai';
        $breadcumb = ['Kinerja'];

        $url = env('API_URL');
        $token = session()->get('user.access_token');

        $level = session()->get('user');
        $type = request('type');
        $getDataDinas = array();

        if ($level['current']['role'] == 'super_admin') {
            $dataDinas = Http::withToken($token)->get($url . "/satuan_kerja/list");
            $getDataDinas = $dataDinas['data'];
        }

        $id_pegawai = session()->get('user.current.id_pegawai');
     
        return view('pages.laporan.kinerja', compact('page_title', 'page_description', 'breadcumb','getDataDinas','level','type','id_pegawai'));
    }

    public function skp(Request $request)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');

        $page_title = 'Laporan';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['SKP'];
        $type = request('type');

        $level = session()->get('user.role');
        $id_pegawai = session()->get('user.current.id_pegawai');
        $pegawai = Http::withToken($token)->get($url . "/jabatan/pegawaiBySatuanKerja")->collect();

        if ($level == 'super_admin') {
            $dataDinas = Http::withToken($token)->get($url . "/satuan_kerja/list");
            $getDataDinas = $dataDinas['data'];
            return view('pages.laporan.skp', compact('page_title', 'page_description', 'breadcumb', 'level', 'pegawai', 'id_pegawai', 'getDataDinas','type'));
        }

        return view('pages.laporan.skp', compact('page_title', 'page_description', 'breadcumb', 'level', 'pegawai', 'id_pegawai','type'));
    }

    public function export_kinerja(){
        $url = env('API_URL');
        $tipe = request('tipe');
        $level = session()->get('user.role');
        $bulan = request('bulan');
        $tahun = session('tahun_penganggaran');
        $nama_bulan = request('nama_bulan');
        $dinas = request('dinas');
        $nama_dinas = request('nama_dinas');

        $token = session()->get('user.access_token');
        $data = array();
        $fungsi = '';

        if ($tipe == 'pegawai') {
            // return 'tes1';
            $data_kinerja_pegawai = Http::withToken($token)->get($url . "/laporan/kinerja?bulan=".$bulan);
            $data = $data_kinerja_pegawai->json();
        }else{
            //   return $dinas;
            $data_kinerja_rekap = Http::withToken($token)->get($url . "/laporan/kinerjaByOpd?bulan=".$bulan.'&satuan_kerja='.$dinas);
            $data = $data_kinerja_rekap->json();
        }


        $fungsi = 'export_kinerja_'.$tipe;
        // return $data;
        return $this->{$fungsi}($tipe,$data,$tahun,$nama_bulan,$nama_dinas);

    }

    // kinerja Pegawai
    public function export_kinerja_pegawai($tipe,$data,$tahun,$nama_bulan,$nama_dinas){
   
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()->setCreator('BKPSDM BULUKUMBA')
            ->setLastModifiedBy('BKPSDM BULUKUMBA')
            ->setTitle('Laporan Pembayaran TPP')
            ->setSubject('Laporan Pembayaran TPP')
            ->setDescription('Laporan Pembayaran TPP')
            ->setKeywords('pdf php')
            ->setCategory('LAPORAN Pembayaran TPP');
        $sheet = $spreadsheet->getActiveSheet();
        // $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

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


        

        $sheet->setCellValue('A1', 'LAPORAN KINERJA PEGAWAI (AKTIVITAS)')->mergeCells('A1:F1');
        $sheet->setCellValue('A2', $nama_bulan)->mergeCells('A2:F2');

        $spreadsheet->getActiveSheet()->getStyle('A1:D4')->getFont()->setBold(true);


        $sheet->setCellValue('A4', 'PEGAWAI YANG DINILAI')->mergeCells('A4:C4');
        $sheet->setCellValue('D4', 'PEJABAT PENILAI')->mergeCells('D4:F4');

        $sheet->setCellValue('A5', 'Nama')->mergeCells('A5:B5');
        $sheet->setCellValue('C5', $data['pegawai_dinilai']['nama']);

        $sheet->setCellValue('D5', 'Nama');
        $sheet->setCellValue('E5', $data['pegawai_penilai']['nama'])->mergeCells('E5:F5');

        $sheet->setCellValue('A6', 'NIP')->mergeCells('A6:B6');
        $sheet->setCellValue('C6', "'" .$data['pegawai_dinilai']['nip']);

        $sheet->setCellValue('D6', 'NIP');
        $sheet->setCellValue('E6', "'".$data['pegawai_penilai']['nip'])->mergeCells('E6:F6');

        $golongan_pegawai = '';
        $golongan_atasan = '';

        $data['pegawai_dinilai']['golongan'] !== null ? $golongan_pegawai = $data['pegawai_dinilai']['golongan'] : $golongan_pegawai = '-';
        $data['pegawai_dinilai']['golongan'] !== null ? $golongan_atasan = $data['pegawai_dinilai']['golongan'] : $golongan_atasan = '-';

        $sheet->setCellValue('A7', 'Pangkat / Gol Ruang')->mergeCells('A7:B7');
        $sheet->setCellValue('C7', $golongan_pegawai);

        $sheet->setCellValue('D7', 'Pangkat / Gol Ruang');
        $sheet->setCellValue('E7', $golongan_atasan)->mergeCells('E7:F7');

        $sheet->setCellValue('A8', 'Jabatan')->mergeCells('A8:B8');
        $sheet->setCellValue('C8', $data['pegawai_dinilai']['jabatan']);

        $sheet->setCellValue('D8', 'Jabatan');
        $sheet->setCellValue('E8', $data['pegawai_penilai']['jabatan'])->mergeCells('E8:F8');

        $sheet->setCellValue('A9', 'Unit kerja')->mergeCells('A9:B9');
        $sheet->setCellValue('C9', $data['pegawai_dinilai']['unit_kerja']);

        $sheet->setCellValue('D9', 'Unit kerja');
        $sheet->setCellValue('E9', $data['pegawai_penilai']['unit_kerja'])->mergeCells('E9:F9');


        $border_header = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A4:F9')->applyFromArray($border_header);
        $sheet->setCellValue('A10', ' ');

        $sheet->setCellValue('A12', 'No');
        $sheet->setCellValue('B12', 'Sasaran Kinerja & Aktivitas')->mergeCells('B12:D12');
        $sheet->setCellValue('E12', 'Output');
        $sheet->setCellValue('F12', 'Waktu (Menit)');

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(15);

        $cell = 13;

        $capaian_prod_kinerja = 0;
      
        foreach ($data['kinerja'] as $key => $value) {
            // return count($value['aktivitas']);
            if (count($value['aktivitas']) > 0) {
                $sheet->setCellValue('A' . $cell, $key+1);
                $sheet->setCellValue('B'. $cell,  $value['rencana_kerja'])->mergeCells('B'.$cell.':D'.$cell);

                $cell++;

                $index1 = $key+1;
                $index2 = 0;

                foreach ($value['aktivitas'] as $k => $v) {
                    $index2 = $k+1;
                    $capaian_prod_kinerja += $v['waktu'];
                    $sheet->setCellValue('A' . $cell, $index1.'.'.$index2);
                    $sheet->setCellValue('B'. $cell,  $v['nama_aktivitas'])->mergeCells('B'.$cell.':D'.$cell);
                    $sheet->setCellValue('E' . $cell, $v['hasil'].' '.$v['satuan']);
                    $sheet->setCellValue('F' . $cell, $v['waktu']);
                            $sheet->getStyle('F'.$cell)->getAlignment()->setHorizontal('center');
                            $sheet->getStyle('E'.$cell)->getAlignment()->setHorizontal('center');
                    $cell++;
                }
               
            }

          
        }

    
        $target_produktivitas_kerja = 0;
        $nilai_produktivitas_kerja = 0;

        if ($data['pegawai_dinilai']['waktu'] !== null) {
            $target_produktivitas_kerja = $data['pegawai_dinilai']['waktu'];
        }

       if ($capaian_prod_kinerja > 0 || $target_produktivitas_kerja > 0) {
         $nilai_produktivitas_kerja = ($capaian_prod_kinerja / $target_produktivitas_kerja) * 100;
       }

    

        for ($i=0; $i < 3 ; $i++) { 
            if ($i == 0) {
                $sheet->setCellValue('B'.$cell, 'Capaian Produktivitas Kerja (Menit)')->mergeCells('B'.$cell.':E'.$cell);
                $sheet->setCellValue('F'.$cell, $capaian_prod_kinerja); 
                        $sheet->getStyle('F'.$cell)->getAlignment()->setHorizontal('center');
            }elseif ($i == 1) {
                $sheet->setCellValue('B'.$cell, 'Target Produktivitas Kerja (Menit)')->mergeCells('B'.$cell.':E'.$cell); 
                $sheet->setCellValue('F'.$cell, $target_produktivitas_kerja); 
                        $sheet->getStyle('F'.$cell)->getAlignment()->setHorizontal('center');
            }else{
                $sheet->setCellValue('B'.$cell, 'Nilai Produktifitas Kerja (%)')->mergeCells('B'.$cell.':E'.$cell);  
                $sheet->setCellValue('F'.$cell, round($nilai_produktivitas_kerja,2)); 
                        $sheet->getStyle('F'.$cell)->getAlignment()->setHorizontal('center');
            }
            $spreadsheet->getActiveSheet()->getStyle('F'.$cell.':F'.$cell)->getFont()->setBold(true);
            $cell++;
        }



        // $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        // $sheet->getStyle('A'.$cell)->getAlignment()->setHorizontal('center');

        // $sheet->getStyle('F'.$cell.':F' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        // $sheet->getStyle('F'.$cell.':F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->getStyle('B7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $border_row = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A12:F'.$cell)->applyFromArray($border_row);


        $sheet->getStyle('A1:F' . $cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A5:F10')->getAlignment()->setVertical('center')->setHorizontal('left');
        $sheet->getStyle('B13:B' . $cell)->getAlignment()->setVertical('center')->setHorizontal('left');


        if ($tipe == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Daftar Laporan TPP"' . $data['satuan_kerja'] . ' Bulan ' . ucwords(date('F Y', mktime(0, 0, 0, $bulan + 1, 0))) . ' .xlsx"');
        } else {
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
    // end kinerje pegawai

    // rekaptulasi kinerja
    public function export_kinerja_rekapitulasi($tipe,$data,$tahun,$nama_bulan,$nama_dinas){
    
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('BKPSDM BULUKUMBA')
            ->setLastModifiedBy('BKPSDM BULUKUMBA')
            ->setTitle('Laporan Rekapitulasi Kinerja')
            ->setSubject('Laporan Rekapitulasi Kinerja')
            ->setDescription('Laporan Rekapitulasi Kinerja')
            ->setKeywords('pdf php')
            ->setCategory('Laporan Rekapitulasi Kinerja');
        $sheet = $spreadsheet->getActiveSheet();
            //  $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

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

        $sheet->setCellValue('A1', 'REKAPITULASI CAPAIAN PRODUKTIFITAS KERJA (AKTIVITAS)')->mergeCells('A1:G1');
        $sheet->setCellValue('A2', 'DINAS '.strtoupper($nama_dinas))->mergeCells('A2:G2');

        $sheet->getStyle('A4:G4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('E1F5FE');

        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Nama / NIP / Pangkat Golongan')->getColumnDimension('B')->setWidth(40);
        $sheet->setCellValue('C4', 'Nama Jabatan')->getColumnDimension('C')->setWidth(50);
        $sheet->setCellValue('D4', 'Target Menit');
        $sheet->setCellValue('E4', 'Capaian Menit');
        $sheet->setCellValue('F4', 'Nilai Kinerja (%) ');
        $sheet->setCellValue('G4', 'Keterangan');

        $cell = 5;
        $no = 1;
        $golongan = '';
        $target_nilai = 0;
        $capaian_menit = 0;
        $nilai_kinerja = 0;
        $keterangan = '';
        $pegawai_ttd = array();
        foreach ($data as $key => $value) {
            $value['golongan'] !== null ? $golongan = $value['golongan'] : $golongan = '';
            count($value['aktivitas']) > 0 ? $capaian_menit = $value['aktivitas'][0]['count'] : $capaian_menit = 0;
            $value['target_waktu'] !== null ? $target_nilai = $value['target_waktu'] : $target_nilai = 0;

            if ($value['kelas_jabatan'] == 1 || $value['kelas_jabatan'] == 3 || $value['kelas_jabatan'] == 15) {
                $nilai_kinerja = 100;
            }else{
                if ($capaian_menit > 0 || $target_nilai > 0) {
                    $nilai_kinerja = ( $capaian_menit / $target_nilai ) * 100;
                }else {
                    $nilai_kinerja = 0;
                }
            }

            if ($value['level'] == 2 || $value['level'] == 1) {
                // return $value['nama_jabatan'];
                
                if (str_contains(strtoupper($value['nama_jabatan']), 'KEPALA DINAS') || str_contains(strtoupper($value['nama_jabatan']), 'SEKERTARIS DAERAH')) {
                    $pegawai_ttd['nama_jabatan'] = $value['nama_jabatan'].' '.$nama_dinas;
                    $pegawai_ttd['golongan'] = $value['golongan'];
                    $pegawai_ttd['nip'] = $value['nip'];
                    $pegawai_ttd['nama'] = $value['nama'];
                }  
            }

            // return $pegawai_ttd;

            $nilai_kinerja < 50 ? $keterangan = 'TMS' : $keterangan = 'MS';

            $sheet->setCellValue('A' . $cell, $no++);
            $sheet->setCellValue('B' . $cell, $value['nama'] . PHP_EOL .$value['nip'].PHP_EOL.$golongan);
            $sheet->setCellValue('C' . $cell, $value['nama_jabatan']);
            $sheet->setCellValue('D' . $cell, $target_nilai);
            $sheet->setCellValue('E' . $cell, $capaian_menit);
            $sheet->setCellValue('F' . $cell, round($nilai_kinerja,2));

            if ($nilai_kinerja < 50 ) {
                $sheet->getStyle('G' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('F44336');
                
             }else{
                $sheet->getStyle('G' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('00E676');
             }

            $sheet->setCellValue('G' . $cell, $keterangan);
            $cell++;
            
        }

          $border_row = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];
        $sheet->getStyle('A4:G'.$cell)->applyFromArray($border_row);

        $sheet->getStyle('D5:D' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FFECB3');
        $sheet->getStyle('E5:E' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FFF9D4');
        $sheet->getStyle('F5:F' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('00E676');
        

        $sheet->getStyle('A:G')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A:G')->getAlignment()->setVertical('center');
        $sheet->getStyle('B5:B' . $cell)->getAlignment()->setHorizontal('rigth');
        $sheet->getStyle('C5:C' . $cell)->getAlignment()->setHorizontal('rigth');
        //$sheet->getStyle('A3:G')->getAlignment()->setHorizontal('rigth');
        

        $cell++;

            if (count($pegawai_ttd) > 0) {
                $sheet->setCellValue('D' . ++$cell, 'Kabupaten Bulukumba ' . date('d/m/Y'))->mergeCells('D' . $cell . ':G' . $cell);
                $sheet->getStyle('D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->setCellValue('D' . ++$cell, $pegawai_ttd['nama_jabatan'])->mergeCells('D' . $cell . ':G' . $cell);
                $sheet->getStyle('D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $cell = $cell + 3;
                $sheet->setCellValue('D' . ++$cell, $pegawai_ttd['nama'])->mergeCells('D' . $cell . ':G' . $cell);
                $sheet->getStyle('D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->setCellValue('D' . ++$cell, 'Pangkat/Golongan : '.$pegawai_ttd['golongan'] )->mergeCells('D' . $cell . ':G' . $cell);
                $sheet->getStyle('D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->setCellValue('D' . ++$cell, 'NIP : '.$pegawai_ttd['nip'])->mergeCells('D' . $cell . ':G' . $cell);
                $sheet->getStyle('D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            }

        if ($tipe == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Daftar Laporan TPP"' . $data['satuan_kerja'] . ' Bulan ' . ucwords(date('F Y', mktime(0, 0, 0, $bulan + 1, 0))) . ' .xlsx"');
        } else {
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
    //end kinerja rekapitulasi

    /*
    REKAP TPP
    */
    public function tpp($TypeRole)
    {
        $page_title = 'Laporan';
        $page_description = 'Daftar Pembayaran TPP Pegawai';
        $breadcumb = ['TPP'];

        $url = env('API_URL');
        $token = session()->get('user.access_token');

        if ($TypeRole == 'super_admin') {
            $data = Http::withToken($token)->get($url . "/satuan_kerja/list");
            $satuan_kerja = $data['data'];
        } else {
            $data = Http::withToken($token)->get($url . "/satuan_kerja/byAdminOpd");
            $satuan_kerja = $data['data'];
        }
        // return $satuan_kerja;
        return view('pages.laporan.tpp', compact('page_title', 'page_description', 'breadcumb', 'TypeRole', 'satuan_kerja'));
    }

    public function exportRekapTpp($params)
    {
        $val = json_decode($params);

        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $data = array();
        $response = '';
        $response = Http::withToken($token)->get($url . "/laporan-rekapitulasi-tpp/admin-opd?satuan_kerja=$val->satuanKerja&bulan=$val->month");

        $data = $response['data'];

        return $this->printRekapTpp($data, $val->month, $val->type);
    }

    public function printRekapTpp($data, $bulan, $type)
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('BKPSDM BULUKUMBA')
            ->setLastModifiedBy('BKPSDM BULUKUMBA')
            ->setTitle('Laporan Pembayaran TPP')
            ->setSubject('Laporan Pembayaran TPP')
            ->setDescription('Laporan Pembayaran TPP')
            ->setKeywords('pdf php')
            ->setCategory('LAPORAN Pembayaran TPP');
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

        $tahun = ""  . session('tahun_penganggaran') . "-" . $bulan . "";
        if ($bulan != '0') {

            $periode = date("01", strtotime($tahun)) . ' ' . strftime('%B', mktime(0, 0, 0, $bulan + 1, 0)) . ' s/d ' . date("t", strtotime($tahun)) . ' ' . strftime('%B %Y', mktime(0, 0, 0, $bulan + 1, 0, (int)session('tahun_penganggaran')));
        } else {
            $periode = "Tahun " . session('tahun_penganggaran');
        }

        $sheet->setCellValue('A1', 'LAPORAN PEMBAYARAN TAMBAHAN PENGAHASILAN PEGAWAI')->mergeCells('A1:U1');
        //$sheet->setCellValue('A2', 'OPD ' . strtoupper($data['satuan_kerja']))->mergeCells('A2:U2');
        $sheet->setCellValue('A2', 'OPD ........')->mergeCells('A2:U2');
        $sheet->setCellValue('A3', '' . strtoupper(date('F Y', mktime(0, 0, 0, $bulan + 1, 0))))->mergeCells('A3:U3');

        $sheet->getStyle('A5:V8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('E1F5FE');


        $sheet->setCellValue('A5', 'NO.')->mergeCells('A5:A7');
        $sheet->setCellValue('B5', 'NAMA & NIP')->mergeCells('B5:B7');
        $sheet->setCellValue('C5', 'GOL.')->mergeCells('C5:C7');
        $sheet->setCellValue('D5', 'JABATAN')->mergeCells('D5:D7');
        $sheet->setCellValue('E5', 'JENIS JABATAN SESUAI PERBUB TPP')->mergeCells('E5:E7');
        $sheet->setCellValue('F5', 'KELAS JABATAN')->mergeCells('F5:F7');
        $sheet->setCellValue('G5', 'PAGU TPP')->mergeCells('G5:G7');
        $sheet->setCellValue('H5', 'BESARAN TPP')->mergeCells('H5:N5');
        $sheet->setCellValue('H6', 'KINERJA 60%')->mergeCells('H6:J6');
        $sheet->setCellValue('K6', 'KEHADIRAN 40%')->mergeCells('K6:N6');
        $sheet->setCellValue('H7', 'KINERJA MAKS' . PHP_EOL .'(Rp)');
        $sheet->setCellValue('I7', 'CAPAIAN KINERJA ' . PHP_EOL .'(%)');
        $sheet->setCellValue('J7', 'NILAI KINERJA ' . PHP_EOL .'(Rp)');
        $sheet->setCellValue('K7', 'KEHADIRAN MAKS ' . PHP_EOL .'(Rp)');
        $sheet->setCellValue('L7', 'POTONGAN KEHADIRAN' . PHP_EOL .'(%)');
        $sheet->setCellValue('M7', 'POTONGAN KEHADIRAN' . PHP_EOL .'(Rp)');
        $sheet->setCellValue('N7', 'NILAI KEHADIRAN ' . PHP_EOL .'(Rp)');
        $sheet->setCellValue('O5', 'BPJS 1%')->mergeCells('O5:O7');
        $sheet->setCellValue('P5', 'TPP BRUTO')->mergeCells('P5:P7');
        $sheet->setCellValue('Q5', 'PPH PSL 21')->mergeCells('Q5:Q7');
        $sheet->setCellValue('R5', 'TPP NETTO')->mergeCells('R5:R7');
        $sheet->setCellValue('S5', 'NILAI BRUTO SPM')->mergeCells('S5:S7');
        $sheet->setCellValue('T5', 'NO. REK')->mergeCells('T5:T7');
        $sheet->setCellValue('U5', 'IURAN 4% (DIBAYAR OLEH PEMDA)')->mergeCells('U5:U7');
        $sheet->setCellValue('V5', 'KETERANGAN')->mergeCells('V5:V7');

             $sheet->setCellValue('A8', 'A');
            $sheet->setCellValue('B8', 'B');
            $sheet->setCellValue('C8', 'C');
            $sheet->setCellValue('D8', 'D');
            $sheet->setCellValue('E8', 'E');
            $sheet->setCellValue('F8', 'F');
            $sheet->setCellValue('G8', 'G');
            $sheet->setCellValue('H8', 'H');
            $sheet->setCellValue('I8', 'I');
            $sheet->setCellValue('J8', 'J');
            $sheet->setCellValue('K8', 'K');
            $sheet->setCellValue('L8', 'L');
            $sheet->setCellValue('M8', 'M');
            $sheet->setCellValue('N8', 'N');
            $sheet->setCellValue('O8', 'O');
            $sheet->setCellValue('P8', 'P');
            $sheet->setCellValue('Q8', 'Q');
            $sheet->setCellValue('R8', 'R');
            $sheet->setCellValue('S8', 'S');
            $sheet->setCellValue('T8', 'T');
            $sheet->setCellValue('U8', 'U');
            $sheet->setCellValue('V8', 'V');

        // $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(35);
        // $sheet->getColumnDimension('D')->setWidth(20);
        // $sheet->getColumnDimension('E')->setWidth(20);
        // $sheet->getColumnDimension('G')->setWidth(15);
        // $sheet->getColumnDimension('H')->setWidth(5);
        // $sheet->getColumnDimension('I')->setWidth(5);
        // $sheet->getColumnDimension('J')->setWidth(5);
        // $sheet->getColumnDimension('K')->setWidth(5);
        // $sheet->getColumnDimension('L')->setWidth(5);
        // $sheet->getColumnDimension('M')->setWidth(5);
        // $sheet->getColumnDimension('N')->setWidth(5);
        // $sheet->getColumnDimension('O')->setWidth(10);
        // $sheet->getColumnDimension('P')->setWidth(10);
        // $sheet->getColumnDimension('Q')->setWidth(10);
        // $sheet->getColumnDimension('R')->setWidth(10);
        // $sheet->getColumnDimension('S')->setWidth(15);

        $sheet->getStyle('A1:A3')->getFont()->setSize(12);
        $sheet->getStyle('A:V')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:A3')->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A5:V8')->getFont()->setBold(true);
        $sheet->getStyle('A5:V8')->getAlignment()->setVertical('center')->setHorizontal('center');

        $cell = 9;
        $jmlPaguTpp = 0;
        $jmlNilaiKinerja = 0;
        $jmlNilaiKehadiran = 0;
        $jmlBpjs = 0;
        $jmlTppBruto = 0;
        $jmlPphPsl = 0;
        $jmlTppNetto = 0;
        $jmlBrutoSpm = 0;
        $jmlIuran = 0;
        $nilaiKinerjaByAktivitas = 0;


        // new variabel
        $capaian_prod = 0;
        $target_prod = 0;
        $nilaiKinerja = 0;
        $nilai_kinerja = 0;
        $keterangan = '';
        $kelas_jabatan = '';
        $golongan = '';
        foreach ($data['list_pegawai'] as $key => $value) {
            // return $value;
            // $nilaiKinerjaByAktivitas = $value beddu
            //return explode("/",$value['golongan']);

            $value['golongan'] !== null ? $golongan = explode("/",$value['golongan'])[1] : $golongan = '-';

            $value['get_kinerja']['count'] !== null ? $capaian_prod = $value['get_kinerja']['count'] : $capaian_prod = 0;

            $value['target_waktu'] !== null ? $target_prod = $value['target_waktu'] : $target_prod = 0;
             
            if ($capaian_prod > 0 || $target_prod > 0) {
                $nilaiKinerjaByAktivitas = ($capaian_prod / $target_prod) * 100;
            }else {
                  if ($value['kelas_jabatan'] == 1 || $value['kelas_jabatan'] == 3 || $value['kelas_jabatan'] == 15) {
                $nilaiKinerjaByAktivitas = 100;
            }else{
                $nilaiKinerjaByAktivitas = 0;
            }
                
            }

          

            $sheet->setCellValue('A' . $cell, $key + 1);
            $sheet->setCellValue('B' . $cell, $value['nama'] . PHP_EOL . "'" . $value['nip']);
            $sheet->setCellValue('C' . $cell, $golongan);
            $sheet->setCellValue('D' . $cell, $value['nama_jabatan']);
            $sheet->setCellValue('E' . $cell, $value['jenis_jabatan']);
            // kelas jabatan
            $value['kelas_jabatan'] !== null ? $kelas_jabatan = $value['kelas_jabatan'] : $kelas_jabatan = '-';
            $sheet->setCellValue('F' . $cell, $kelas_jabatan);
            $sheet->setCellValue('G' . $cell, number_format($value['nilai_jabatan']));

            

           $nilaiKinerjaByAktivitas <= 50 ? $nilai_kinerja = 0 : $nilai_kinerja = $value['nilai_jabatan']* 60/100; 

            $sheet->setCellValue('H' . $cell, number_format($nilai_kinerja));
            $sheet->setCellValue('I' . $cell, round($nilaiKinerjaByAktivitas,2));

            // $nilaiKinerja = (60 * $value['nilai_jabatan'] / 100) * ($value['total_kinerja'] / 120);
            $nilaiKinerja = $nilaiKinerjaByAktivitas * $nilai_kinerja / 100;
            $sheet->setCellValue('J' . $cell, number_format($nilaiKinerja));

            $persentaseKehadiran = 40 * $value['nilai_jabatan'] / 100;
            $sheet->setCellValue('K' . $cell, number_format($persentaseKehadiran));
            $sheet->setCellValue('L' . $cell, $value['persentase_pemotongan']);

            $nilaiKehadiran = $persentaseKehadiran * $value['persentase_pemotongan'] / 100;
            $sheet->setCellValue('M' . $cell, number_format($nilaiKehadiran));

            $jumlahKehadiran = $persentaseKehadiran - $nilaiKehadiran;
            $sheet->setCellValue('N' . $cell, number_format($jumlahKehadiran));

            $bpjs = 1 * $value['nilai_jabatan'] / 100;
            $sheet->setCellValue('O' . $cell, number_format($bpjs));

            $tppBruto = $nilaiKinerja + $jumlahKehadiran - $bpjs;
            $sheet->setCellValue('P' . $cell, number_format($tppBruto));

            // $golongan = $value['golongan'];
                if (strstr( $golongan, 'IV' )) {
                 $pphPsl = 15 * $tppBruto / 100;
                }elseif (strstr( $golongan, 'III' )) {
                        $pphPsl = 5 * $tppBruto / 100;
                }else{
                    $pphPsl = 0;
                }
          

           

            $sheet->setCellValue('Q' . $cell, number_format($pphPsl) );

            $tppNetto = $tppBruto - $pphPsl;
            $sheet->setCellValue('R' . $cell, number_format($tppNetto));

            $iuran = 4 * $value['nilai_jabatan'] / 100;
            $brutoSpm = $nilaiKinerja + $jumlahKehadiran + $iuran;
            $sheet->setCellValue('S' . $cell, number_format($brutoSpm));

            // norek
            $sheet->setCellValue('T' . $cell, '-');

            $sheet->setCellValue('U' . $cell, number_format($iuran));


           $nilaiKinerjaByAktivitas <= 50 && $value['jumlah_alpa'] > 3 ? $keterangan = 'TMS'  : $keterangan = 'MS'; 
            $sheet->setCellValue('V'.$cell, $keterangan);
            if ($keterangan == 'TMS') {
                $sheet->getStyle('V' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('F44336');
                
             }else{
                $sheet->getStyle('V' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('00E676');
             }

            // JUMLAH
            $jmlPaguTpp += $value['nilai_jabatan'];
            $jmlNilaiKinerja += $nilaiKinerja;
            $jmlNilaiKehadiran += $jumlahKehadiran;
            $jmlBpjs += $bpjs;
            $jmlTppBruto += $tppBruto;
            $jmlPphPsl += $pphPsl;
            $jmlTppNetto += $tppNetto;
            $jmlBrutoSpm += $brutoSpm;
            $jmlIuran += $iuran;

            $cell++;
        }

        $sheet->setCellValue('A' . $cell, "JUMLAH")->mergeCells('A' . $cell . ':F' . $cell);
        $sheet->setCellValue('G' . $cell, number_format($jmlPaguTpp));
        $sheet->setCellValue('J' . $cell, number_format($jmlNilaiKinerja));
        $sheet->setCellValue('N' . $cell, number_format($jmlNilaiKehadiran));
        $sheet->setCellValue('O' . $cell, number_format($jmlBpjs));
        $sheet->setCellValue('P' . $cell, number_format($jmlTppBruto));
        $sheet->setCellValue('Q' . $cell, number_format($jmlPphPsl));
        $sheet->setCellValue('R' . $cell, number_format($jmlTppNetto));
        $sheet->setCellValue('S' . $cell, number_format($jmlBrutoSpm));
        $sheet->setCellValue('U' . $cell, number_format($jmlIuran));

        $sheet->getStyle('G9:G' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('B2DFDB');
        $sheet->getStyle('H9:J' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FFECB3');
        $sheet->getStyle('K9:N' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FFF9C4');
        $sheet->getStyle('P9:P' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FFCDD2');
        $sheet->getStyle('R9:R' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('00E676');
        $sheet->getStyle('S9:S' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('B3E5FC');
        //$sheet->getStyle('AB6:AB10')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('00E676');


        $sheet->getStyle('A9:U' . $cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('B9:B' . $cell)->getAlignment()->setVertical('center')->setHorizontal('left');
        $sheet->getStyle('D9:D' . $cell)->getAlignment()->setVertical('center')->setHorizontal('left');
        $sheet->getStyle('G9:G' . $cell)->getAlignment()->setVertical('center')->setHorizontal('right');
        $sheet->getStyle('H9:H' . $cell)->getAlignment()->setVertical('center')->setHorizontal('right');
        $sheet->getStyle('J9:K' . $cell)->getAlignment()->setVertical('center')->setHorizontal('right');
        $sheet->getStyle('M9:U' . $cell)->getAlignment()->setVertical('center')->setHorizontal('right');
        $sheet->getStyle('T9:T' . $cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('V9:V' . $cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        
        $sheet->getStyle('A' . $cell . ':U' . $cell)->getFont()->setBold(true);

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A5:V' . $cell)->applyFromArray($border);

        $cell++;
        $sheet->setCellValue('B' . $cell, '')->mergeCells('B' . $cell . ':U' . $cell);

        $tgl_cetak = date("t", strtotime($tahun)) . ' ' . strftime('%B %Y', mktime(0, 0, 0, $bulan + 1, 0, (int)session('tahun_penganggaran')));

        $sheet->setCellValue('S' . ++$cell, 'Bulukumba, ' . $tgl_cetak)->mergeCells('S' . $cell . ':U' . $cell);
        $sheet->getStyle('E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $cell = $cell + 2;
        $sheet->setCellValue('C' . $cell, 'KEPALA OPD')->mergeCells('C' . $cell . ':D' . $cell);
        $sheet->setCellValue('I' . $cell, 'BENDAHARA PENGELUARAN')->mergeCells('I' . $cell . ':L' . $cell);
        $sheet->setCellValue('R' . $cell, 'NAMA PEMBUAT DAFTAR')->mergeCells('R' . $cell . ':T' . $cell);
        $sheet->getStyle('C' . $cell . ':S' . $cell)->getAlignment()->setVertical('center')->setHorizontal('center');


        $cell = $cell + 3;
        $sheet->setCellValue('C' . $cell, 'NAMA KEPALA OPD')->mergeCells('C' . $cell . ':D' . $cell);
        $sheet->setCellValue('I' . $cell, 'NAMA BENDAHARA')->mergeCells('I' . $cell . ':L' . $cell);
        $sheet->setCellValue('R' . $cell, 'NAMA PEMBUAT DAFTAR')->mergeCells('R' . $cell . ':T' . $cell);
        $sheet->getStyle('C' . $cell . ':S' . $cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('C' . $cell . ':S' . $cell)->getFont()->setUnderline(true);;

        $cell++;
        $sheet->setCellValue('C' . $cell, 'GOLONGAN JABATAN')->mergeCells('C' . $cell . ':D' . $cell);
        $sheet->setCellValue('C' . $cell, 'NIP')->mergeCells('C' . $cell . ':D' . $cell);
        $sheet->getStyle('C' . $cell . ':S' . $cell)->getAlignment()->setVertical('center')->setHorizontal('center');



        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Daftar Laporan TPP"' . $data['satuan_kerja'] . ' Bulan ' . ucwords(date('F Y', mktime(0, 0, 0, $bulan + 1, 0))) . ' .xlsx"');
        } else {
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


    public function aktivitas()
    {
        $page_title = 'Laporan';
        $page_description = 'Daftar Sasaran Kinerja Pegawai';
        $breadcumb = ['Aktivitas'];


        return view('pages.laporan.aktivitas', compact('page_title', 'page_description', 'breadcumb'));
    }

    public function getRekapPegawai($params1, $params2,$pegawai)
    {

        $url = env('API_URL');
        $token = session()->get('user.access_token');

        $response = Http::withToken($token)->get($url . "/laporan-rekapitulasi-absen/rekapByUser/" . $params1 . "/" . $params2 .'?pegawai='.$pegawai);

        if ($response->successful() && isset($response->object()->data)) {
            return $response->json();
        } else {
            return 'err';
        }
    }

    public function getRekappegawaiByOpd($params1, $params2, $satuan_kerja)
    {
        // return $params1;
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $response = '';

        if (!is_null($satuan_kerja)) {
            $response = Http::withToken($token)->get($url . "/laporan-rekapitulasi-absen/rekapByOpd/" . $params1 . "/" . $params2 . '/' . $satuan_kerja);
        } else {
            $response = Http::withToken($token)->get($url . "/laporan-rekapitulasi-absen/rekapByOpd/" . $params1 . "/" . $params2 . '/0');
        }

        if ($response->successful()) {
            return $response->json();
        } else {
            return 'err';
        }
    }

    public function exportRekapAbsen($params)
    {
        $pegawai = request('pegawai');
        $val = json_decode($params);
        $perangkat_daerah = request('perangkat_daerah');

        if ($val->role == 'pegawai') {
            $data = $this->getRekapPegawai($val->startDate, $val->endDate,$pegawai);
            $this->exportrekapPegawai($data, $val->type, 'desktop');
        } else if ($val->role == 'rekapitulasi') {
            $data = $this->getRekappegawaiByOpd($val->startDate, $val->endDate, $val->satuanKerja);
            return $this->exportrekapOpd($data, $val->type, $val->startDate, $val->endDate, $perangkat_daerah);
        }
    }

    public function checkLevel($id_pegawai)
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        // $level = session()->get('user.level_jabatan');
        $level = Http::withToken($token)->get($url . "/laporan/skp/cekLevel/" . $id_pegawai);
        return $level;
    }

    public function getSkp($level, $bulan, $id_pegawai)
    {

        $url = env('API_URL');
        $token = session()->get('user.access_token');
        // $data = Http::withToken($token)->get($url . "/laporan/skp/" . $level);
        $data = Http::withToken($token)->get($url . "/laporan/skp/" . $level . "/" . $bulan . "/" . $id_pegawai);
        return $data;
    }


    // Rekapitulasi skp Satuan Kerja

    public function getRekapSkp($bulan)
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        // $data = Http::withToken($token)->get($url . "/laporan/skp/" . $level);
        // $data = Http::withToken($token)->get($url . "/laporan/skp/rekapitulasi/" . $bulan);
        $data =  (request('dinas') !== null) ? Http::withToken($token)->get($url . "/laporan/skp/rekapitulasi/$bulan?dinas=" . request('dinas')) : Http::withToken($token)->get($url . "/laporan/skp/rekapitulasi/" . $bulan);
        return $data;
    }

    public function exportRekapSkp($jenis, $type, $bulan)
    {
        $res = [];
        $data = $this->getRekapSkp($bulan);
        // return $data;
        if ($data['status'] == true) {
            $res = $data['data'];
        }

        return $this->laporanRekapSkp($res, $bulan, $type);
    }

    public function laporanRekapSkp($data, $bulan, $type)
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('BKPSDM BULUKUMBA')
            ->setLastModifiedBy('BKPSDM BULUKUMBA')
            ->setTitle('Laporan Rekapitulasi SKP Satuan Kerja')
            ->setSubject('Laporan Rekapitulasi SKP Satuan Kerja')
            ->setDescription('Laporan Rekapitulasi SKP Satuan Kerja')
            ->setKeywords('pdf php')
            ->setCategory('Laporan Rekapitulasi SKP Satuan Kerja');
        $sheet = $spreadsheet->getActiveSheet();
        // $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);

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

        $sheet->setCellValue('A1', 'REKAPITULASI CAPAIAN PRODUKTIVITAS KERJA (SKP)')->mergeCells('A1:L1');
        $sheet->setCellValue('A2', 'PERANGKAT DAERAH')->mergeCells('A2:B2');
        $sheet->setCellValue('C2', ': ' . $data['satuan_kerja']['nama_satuan_kerja'])->mergeCells('C2:K2');

        $sheet->setCellValue('A3', 'PERIODE PENILAIAN')->mergeCells('A3:B3');
        $tahun = ""  . session('tahun_penganggaran') . "-" . $bulan . "";
        $periode = date("01", strtotime($tahun)) . ' s/d ' . date("t", strtotime($tahun)) . ' ' . strftime('%B %Y', mktime(0, 0, 0, $bulan + 1, 0, (int)session('tahun_penganggaran')));
        $sheet->setCellValue('C3', ': ' . $periode)->mergeCells('C3:K3');

        // $sheet->setCellValue('A4', 'No')->mergeCells('A4:A4');
        // $sheet->getColumnDimension('A')->setWidth(8);
        // $sheet->setCellValue('B4', 'Nama / NIP / Pangkat Golongan')->mergeCells('B4:C4');
        // $sheet->getColumnDimension('B')->setWidth(1);
        // $sheet->getColumnDimension('C')->setWidth(30);
        // $sheet->setCellValue('D4', 'Nama Jabatan');
        // $sheet->getColumnDimension('D')->setWidth(30);
        // $sheet->setCellValue('E4', 'Jumlah Pemangku');
        // $sheet->getColumnDimension('E')->setWidth(5);
        // $sheet->setCellValue('F4', 'Unit Kerja Eselon II');
        // $sheet->getColumnDimension('F')->setWidth(20);
        // $sheet->setCellValue('G4', 'Unit Kerja Eselon III');
        // $sheet->getColumnDimension('G')->setWidth(20);
        // $sheet->setCellValue('H4', 'Unit Kerja Eselon IV');
        // $sheet->getColumnDimension('H')->setWidth(20);
        // $sheet->setCellValue('I4', 'Kelas');
        // $sheet->getColumnDimension('I')->setWidth(5);
        // $sheet->setCellValue('J4', 'Nilai SKP Bulanan');
        // $sheet->getColumnDimension('J')->setWidth(5);
        // $sheet->setCellValue('K4', 'Status');
        // $sheet->getColumnDimension('K')->setWidth(10);
        // $sheet->setCellValue('L4', 'Keterangan');
        // $sheet->getColumnDimension('L')->setWidth(5);

        $sheet->setCellValue('A4', 'No')->mergeCells('A4:A4');
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->setCellValue('B4', 'Nama / NIP / Pangkat Golongan')->mergeCells('B4:C4');
        $sheet->getColumnDimension('B')->setWidth(1);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->setCellValue('D4', 'Nama Jabatan');
        $sheet->getColumnDimension('D')->setWidth(50);
        $sheet->setCellValue('E4', 'Nilai SKP Bulanan');
        $sheet->getColumnDimension('E')->setWidth(10);

        $cell = 4;

        // $sheet->getStyle('A1')->getFont()->setSize(12);
        // $sheet->getStyle('A:L')->getAlignment()->setWrapText(true);
        // $sheet->getStyle('A4:L4')->getFont()->setBold(true);
        // $sheet->getStyle('A4:L4')->getAlignment()->setVertical('center')->setHorizontal('center');
        // $sheet->getStyle('A5:A' . (count($data['list_pegawai']) + $cell))->getAlignment()->setVertical('center')->setHorizontal('center');
        // $sheet->getStyle('D5:D' . (count($data['list_pegawai']) + $cell))->getAlignment()->setVertical('center');
        // $sheet->getStyle('J5:J' . (count($data['list_pegawai']) + $cell))->getAlignment()->setVertical('center')->setHorizontal('center');
        // $sheet->getStyle('A1')->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A1')->getFont()->setSize(12);
        $sheet->getStyle('A:E')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A4:E4')->getFont()->setBold(true);
        $sheet->getStyle('A4:E4')->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A5:A' . (count($data['list_pegawai']) + $cell))->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('B5:B' . (count($data['list_pegawai']) + $cell))->getAlignment()->setVertical('center');
        $sheet->getStyle('C5:C' . (count($data['list_pegawai']) + $cell))->getAlignment()->setVertical('center');
        $sheet->getStyle('D5:D' . (count($data['list_pegawai']) + $cell))->getAlignment()->setVertical('center');
        $sheet->getStyle('E5:E' . (count($data['list_pegawai']) + $cell))->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A1')->getAlignment()->setVertical('center')->setHorizontal('center');

        // return $data;

        foreach ($data['list_pegawai'] as $index => $value) {
            $cell++;

            $sheet->setCellValue('A' . $cell, $index + 1);
            $sheet->setCellValue('B' . $cell, $value['nama'] . ' / ' . $value['nip'] . ' / ' . $value['golongan'])->mergeCells('B' . $cell . ':C' . $cell);
            $sheet->setCellValue('D' . $cell, $value['nama_jabatan']);

            // level if kepala 
            if ($value['level'] == 1 || $value['level'] == 2) {

                $total_tambahan = 0;

                // cek if isset skp_utama
                if (isset($value['skp_utama'])) {

                    $jumlah_data = 0;
                    $sum_nilai_iki = 0;
                    $single_rate = 0;
                    foreach ($value['skp_utama'] as $key => $val) {

                        foreach ($val['aspek_skp'] as $k => $v) {

                            foreach ($v['target_skp'] as $mk => $rr) {
                                $kategori_ = '';
                                if ($rr['bulan'] ==  $bulan) {

                                    if ($rr['target'] > 0) {
                                        $single_rate = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;
                                    }

                                    if ($single_rate > 110) {
                                        $nilai_iki = 110 + ((120 - 110) / (110 - 101)) * (110 - 101);
                                    } elseif ($single_rate >= 101 && $single_rate <= 110) {
                                        $nilai_iki = 110 + ((120 - 110) / (110 - 101)) * ($single_rate - 101);
                                    } elseif ($single_rate == 100) {
                                        $nilai_iki = 109;
                                    } elseif ($single_rate >= 80 && $single_rate <= 99) {
                                        $nilai_iki = 70 + ((89 - 70) / (99 - 80)) * ($single_rate - 80);
                                    } elseif ($single_rate >= 60 && $single_rate <= 79) {
                                        $nilai_iki = 50 + ((69 - 50) / (79 - 60)) * ($single_rate - 60);
                                    } elseif ($single_rate >= 0 && $single_rate <= 79) {
                                        $nilai_iki = (49 / 59) * $single_rate;
                                    }
                                    //$sheet->setCellValue('J13', round($nilai_iki,1).' %' )->mergeCells('J13:J13');
                                    $sum_nilai_iki += $nilai_iki;
                                    $jumlah_data++;
                                }
                            }
                        }
                    }

                    if ($sum_nilai_iki != 0 && $jumlah_data != 0) {
                        $nilai_utama = round($sum_nilai_iki / $jumlah_data, 1);
                    } else {
                        $nilai_utama = 0;
                    }
                } else {
                    $nilai_utama = 0;
                }

                // cek if isset skp_tambahan
                if (isset($value['skp_tambahan'])) {

                    $total_tambahan = 0;

                    foreach ($value['skp_tambahan'] as $key => $val) {

                        foreach ($val['aspek_skp'] as $k => $v) {

                            foreach ($v['target_skp'] as $mk => $rr) {
                                $kategori_ = '';
                                if ($rr['bulan'] ==  $bulan) {

                                    $single_rate = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;

                                    if ($single_rate > 110) {
                                        $nilai_iki = 110 + ((120 - 110) / (110 - 101)) * (110 - 101);
                                    } elseif ($single_rate >= 101 && $single_rate <= 110) {
                                        $nilai_iki = 110 + ((120 - 110) / (110 - 101)) * ($single_rate - 101);
                                    } elseif ($single_rate == 100) {
                                        $nilai_iki = 109;
                                    } elseif ($single_rate >= 80 && $single_rate <= 99) {
                                        $nilai_iki = 70 + ((89 - 70) / (99 - 80)) * ($single_rate - 80);
                                    } elseif ($single_rate >= 60 && $single_rate <= 79) {
                                        $nilai_iki = 50 + ((69 - 50) / (79 - 60)) * ($single_rate - 60);
                                    } elseif ($single_rate >= 0 && $single_rate <= 79) {
                                        $nilai_iki = (49 / 59) * $single_rate;
                                    }

                                    if ($nilai_iki > 110) {
                                        $total_tambahan += 2.4;
                                    } elseif ($nilai_iki >= 101 && $nilai_iki <= 110) {
                                        $total_tambahan += 1.6;
                                    } elseif ($nilai_iki == 100) {
                                        $total_tambahan += 1.0;
                                    } elseif ($nilai_iki >= 80 && $nilai_iki <= 99) {
                                        $total_tambahan += 0.5;
                                    } elseif ($nilai_iki >= 60 && $nilai_iki <= 79) {
                                        $total_tambahan += 0.3;
                                    } elseif ($nilai_iki >= 0 && $nilai_iki <= 79) {
                                        $total_tambahan += 0.1;
                                    }
                                }
                            }
                        }
                    }

                    $nilai_tambahan = $total_tambahan;
                } else {
                    $nilai_tambahan = 0;
                }
            } else {
                // level if pegawai

                $nilai_utama = 0;
                $nilai_tambahan = 0;

                // cek if isset skp_utama
                if (isset($value['skp_utama'])) {
                    $total_utama = 0;
                    $data_utama = 0;
                    $index_data = 0;

                    foreach ($value['skp_utama'] as $key => $val) {

                        $index_data++;
                        $data_utama++;

                        $sum_capaian = 0;
                        $capaian_iki = 0;

                        foreach ($val['aspek_skp'] as $k => $v) {

                            foreach ($v['target_skp'] as $mk => $rr) {

                                $kategori_ = '';
                                if ($rr['bulan'] ==  $bulan) {
                                    // set capaian_iki based realisasi / target
                                    if ($rr['target'] > 0) {
                                        $capaian_iki = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;
                                    }
                                    

                                    // set nilai_iki based capaian_iki
                                    if ($capaian_iki >= 101) {
                                        $nilai_iki = 16;
                                    } elseif ($capaian_iki == 100) {
                                        $nilai_iki = 13;
                                    } elseif ($capaian_iki >= 80 && $capaian_iki <= 99) {
                                        $nilai_iki = 8;
                                    } elseif ($capaian_iki >= 60 && $capaian_iki <= 79) {
                                        $nilai_iki = 3;
                                    } elseif ($capaian_iki >= 0 && $capaian_iki <= 79) {
                                        $nilai_iki = 1;
                                    }
                                    $sum_capaian += $nilai_iki;
                                }
                            }
                        }

                        // set total_utama based sum_capaian
                        if ($sum_capaian > 42) {
                            $total_utama += 120;
                        } elseif ($sum_capaian >= 34) {
                            $total_utama += 100;
                        } elseif ($sum_capaian >= 19) {
                            $total_utama += 80;
                        } elseif ($sum_capaian >= 7) {
                            $total_utama += 60;
                        } elseif ($sum_capaian >= 3) {
                            $total_utama += 25;
                        } elseif ($sum_capaian >= 0) {
                            $total_utama += 25;
                        }
                    }

                    // cek if total_utama & data_utama != 0
                    if ($total_utama != 0 && $data_utama != 0) {
                        $nilai_utama = round($total_utama / $data_utama, 1);
                    } else {
                        $nilai_utama = 0;
                    }
                } else {
                    $nilai_utama = 0;
                }

                // cek if isset skp_tambahan
                if (isset($value['skp_tambahan'])) {

                    $total_tambahan = 0;

                    foreach ($value['skp_tambahan'] as $key => $val) {

                        $sum_capaian = 0;
                        $capaian_iki = 0;
                        foreach ($val['aspek_skp'] as $k => $v) {

                            foreach ($v['target_skp'] as $mk => $rr) {
                                if ($rr['bulan'] ==  $bulan) {

                                    if ($rr['target'] > 0) {
                                        $capaian_iki = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;
                                    }

                                    if ($capaian_iki >= 101) {
                                        $nilai_iki = 16;
                                    } elseif ($capaian_iki == 100) {
                                        $nilai_iki = 13;
                                    } elseif ($capaian_iki >= 80 && $capaian_iki <= 99) {
                                        $nilai_iki = 8;
                                    } elseif ($capaian_iki >= 60 && $capaian_iki <= 79) {
                                        $nilai_iki = 3;
                                    } elseif ($capaian_iki >= 0 && $capaian_iki <= 79) {
                                        $nilai_iki = 1;
                                    }
                                    $sum_capaian += $nilai_iki;
                                }
                            }
                        }

                        if ($sum_capaian >= 42) {
                            $total_tambahan += 2.4;
                        } elseif ($sum_capaian >= 34) {
                            $total_tambahan += 1.6;
                        } elseif ($sum_capaian >= 19) {
                            $total_tambahan += 1;
                        } elseif ($sum_capaian >= 7) {
                            $total_tambahan += 0.5;
                        } elseif ($sum_capaian >= 3) {
                            $total_tambahan += 0.1;
                        } elseif ($sum_capaian >= 0) {
                            $total_tambahan += 0.1;
                        }
                    }

                    $nilai_tambahan = $total_tambahan;
                } else {
                    $nilai_tambahan = 0;
                }
            }

            $total_nilai = round($nilai_utama + $nilai_tambahan, 1);
            // $sheet->setCellValue('J' . $cell, $total_nilai);
            $sheet->setCellValue('E' . $cell, $total_nilai);
        }

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        // $sheet->getStyle('A4:L' . $cell)->applyFromArray($border);
        $sheet->getStyle('A4:E' . $cell)->applyFromArray($border);

        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan SKP ' . $data['satuan_kerja']['nama_satuan_kerja'] . '.xlsx"');
        } else {
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

    // Rekapitulasi skp Satuan Kerja

    public function exportLaporanSkp($jenis, $type, $bulan, $id_pegawai)
    {

        $level = $this->checkLevel($id_pegawai);
        $res = [];

        // return $level['messages_'];
        if (isset($level['messages_'])) {
            return $level['messages_'];
        } else {
            if ($level['level_jabatan'] == 1 || $level['level_jabatan'] == 2) {
                $level = 'kepala';
            } else {
                $level = 'pegawai';
            }
        }

        // $data = $this->getSkp($level);
        $data = $this->getSkp($level, $bulan, $id_pegawai);

        if ($data['status'] == true) {
            $res = $data['data'];
        }
        if ($jenis == 'skp') {

            if ($level == 'pegawai') {
                return $this->exportSkp($res, $bulan, $type, $level);
            } else {
                return $this->exportKepala($res, $bulan, $type, $level);
            }
        } else {
            if ($level == 'pegawai') {
                return $this->exportRealisasi($res, $bulan, $type, $level);
            } else {
                return $this->exportRealisasiKepala($res, $bulan, $type, $level);
            }
        }
    }

    public function exportKepala($data, $bulan, $type, $level)
    {
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

        $tahun = ""  . session('tahun_penganggaran') . "-" . $bulan . "";
        if ($bulan != '0') {

            $periode = date("01", strtotime($tahun)) . ' ' . strftime('%B', mktime(0, 0, 0, $bulan + 1, 0)) . ' s/d ' . date("t", strtotime($tahun)) . ' ' . strftime('%B %Y', mktime(0, 0, 0, $bulan + 1, 0, (int)session('tahun_penganggaran')));
        } else {
            $periode = "Tahun " . session('tahun_penganggaran');
        }
        $sheet->setCellValue('D5', $periode)->mergeCells('D5:F5');

        $sheet->setCellValue('A6', 'PEGAWAI YANG DINILAI')->mergeCells('A6:C6');
        $sheet->setCellValue('D6', 'PEJABAT PENILAI PEKERJA')->mergeCells('D6:F6');

        $sheet->setCellValue('A7', 'Nama')->mergeCells('A7:B7');
        $sheet->setCellValue('C7', $data['pegawai_dinilai']['nama'])->mergeCells('C7:C7');
        $sheet->setCellValue('A8', 'NIP')->mergeCells('A8:B8');
        $sheet->setCellValue('C8', "'" . $data['pegawai_dinilai']['nip'])->mergeCells('C8:C8');
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
            $sheet->setCellValue('E8', "'" . $data['atasan']['nip'])->mergeCells('E8:F8');
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
        if (count($data['skp']['utama'])) {
            $sheet->setCellValue('B' . $cell, 'A. KINERJA UTAMA')->mergeCells('B' . $cell . ':F' . $cell);
            $sheet->getStyle('B' . $cell . ':F' . $cell)->getFont()->setBold(true);
            $cell++;
            // return $data;
            foreach ($data['skp']['utama'] as $index => $value) {

                // print rencana_kerja
                $sheet->setCellValue('A' . $cell, $index + 1)->mergeCells('A' . $cell . ':A' . ($cell + count($value['aspek_skp']) - 1));
                $sheet->setCellValue('B' . $cell, $value['rencana_kerja'])->mergeCells('B' . $cell . ':C' . ($cell + count($value['aspek_skp']) - 1));

                foreach ($value['aspek_skp'] as $k => $v) {
                    $sheet->setCellValue('D' . $cell, $v['iki'])->mergeCells('D' . $cell . ':E' . $cell);

                    foreach ($v['target_skp'] as $mk => $rr) {
                        $sum_capaian = 0;
                        $kategori_ = '';
                        if ($rr['bulan'] ==  $bulan) {
                            $capaian_iki = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;
                            $sum_capaian += $capaian_iki;
                            $sheet->setCellValue('F' . $cell, $rr['target'] . ' ' . $v['satuan']);
                        }
                    }
                    $cell++;
                }
            }
        } else {
            $sheet->setCellValue('B' . $cell, 'A. KINERJA UTAMA')->mergeCells('B' . $cell . ':F' . $cell);
            $sheet->getStyle('B' . $cell . ':F' . $cell)->getFont()->setBold(true);
            $cell++;
            $sheet->setCellValue('A' . $cell, 1);
            $sheet->setCellValue('B' . $cell, '-')->mergeCells('B' . $cell . ':C' . $cell);
            $sheet->setCellValue('D' . $cell, '-')->mergeCells('D' . $cell . ':E' . $cell);
            $sheet->setCellValue('F' . $cell, '-');
            $cell++;
        }

        // TAMBAHAN
        // return count($data['skp']['tambahan']);
        if (count($data['skp']['tambahan']) > 0) {
            $sheet->setCellValue('B' . $cell, 'B. KINERJA TAMBAHAN')->mergeCells('B' . $cell . ':F' . $cell);
            $sheet->getStyle('B' . $cell . ':F' . $cell)->getFont()->setBold(true);
            $cell++;
            foreach ($data['skp']['tambahan'] as $index => $value) {
                $sheet->setCellValue('A' . $cell, $index + 1);
                $sheet->setCellValue('B' . $cell, $value['rencana_kerja'])->mergeCells('B' . $cell . ':C' . $cell);
                foreach ($value['aspek_skp'] as $k => $v) {
                    $sheet->setCellValue('D' . $cell, $v['iki'])->mergeCells('D' . $cell . ':E' . $cell);

                    foreach ($v['target_skp'] as $mk => $rr) {
                        $sum_capaian = 0;
                        $kategori_ = '';
                        if ($rr['bulan'] ==  $bulan) {
                            $capaian_iki = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;
                            $sum_capaian += $capaian_iki;
                            $sheet->setCellValue('F' . $cell, $rr['target'] . ' ' . $v['satuan']);
                        }
                    }


                    $cell++;
                }
            }
        } else {
            $sheet->setCellValue('B' . $cell, 'B. KINERJA TAMBAHAN')->mergeCells('B' . $cell . ':F' . $cell);
            $sheet->getStyle('B' . $cell . ':F' . $cell)->getFont()->setBold(true);
            $cell++;
            $sheet->setCellValue('A' . $cell, 1);
            $sheet->setCellValue('B' . $cell, '-')->mergeCells('B' . $cell . ':C' . $cell);
            $sheet->setCellValue('D' . $cell, '-')->mergeCells('D' . $cell . ':E' . $cell);
            $sheet->setCellValue('F' . $cell, '-');
        }
        // if (count($data['skp']['tambahan']) <= 0) {
        // }


        $sheet->getStyle('A12:F' . $cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('B13:E' . $cell)->getAlignment()->setVertical('center')->setHorizontal('left');
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

        $cell++;
        $sheet->setCellValue('B' . $cell, '')->mergeCells('B' . $cell . ':F' . $cell);

        $tgl_cetak = date("t", strtotime($tahun)) . ' ' . strftime('%B %Y', mktime(0, 0, 0, $bulan + 1, 0, (int)session('tahun_penganggaran')));

        $sheet->setCellValue('E' . ++$cell, 'Bulukumba, ' . $tgl_cetak)->mergeCells('E' . $cell . ':F' . $cell);
        $sheet->getStyle('E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('E' . ++$cell, 'Pejabat Penilai Kinerja')->mergeCells('E' . $cell . ':F' . $cell);
        $sheet->getStyle('E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $cell = $cell + 3;
        $sheet->setCellValue('E' . ++$cell, $data['atasan']['nama'])->mergeCells('E' . $cell . ':F' . $cell);
        $sheet->getStyle('E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('E' . ++$cell, $data['atasan']['nip'])->mergeCells('E' . $cell . ':F' . $cell);
        $sheet->getStyle('E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan SKP ' . $data['pegawai_dinilai']['nama'] . '.xlsx"');
        } else {
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

    public function exportSkp($data, $bulan, $type, $level)
    {
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

        $tahun = ""  . session('tahun_penganggaran') . "-" . $bulan . "";
        if ($bulan != '0') {

            $periode = date("01", strtotime($tahun)) . ' ' . strftime('%B', mktime(0, 0, 0, $bulan + 1, 0)) . ' s/d ' . date("t", strtotime($tahun)) . ' ' . strftime('%B %Y', mktime(0, 0, 0, $bulan + 1, 0, (int)session('tahun_penganggaran')));
        } else {
            $periode = "Tahun " . session('tahun_penganggaran');
        }
        $sheet->setCellValue('E5', $periode)->mergeCells('E5:H5');

        $sheet->setCellValue('A6', 'PEGAWAI YANG DINILAI')->mergeCells('A6:D6');
        $sheet->setCellValue('E6', 'PEJABAT PENILAI PEKERJA')->mergeCells('E6:H6');


        $sheet->setCellValue('A7', 'Nama')->mergeCells('A7:B7');
        $sheet->setCellValue('C7', $data['pegawai_dinilai']['nama'])->mergeCells('C7:D7');
        $sheet->setCellValue('A8', 'NIP')->mergeCells('A8:B8');
        $sheet->setCellValue('C8', "'" . $data['pegawai_dinilai']['nip'])->mergeCells('C8:D8');
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
            $sheet->setCellValue('G8', "'" . $data['atasan']['nip'])->mergeCells('G8:H8');
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
        $sheet->setCellValue('H12', 'TARGET')->mergeCells('H12:H12');
        $sheet->getColumnDimension('H')->setWidth(25);




        $cell = 13;
        $number = 1;
        //UTAMA

        // return isset($data['skp']['utama']);
        if (isset($data['skp']['utama'])) {
            $sheet->setCellValue('B' . $cell, 'A. KINERJA UTAMA')->mergeCells('B' . $cell . ':H' . $cell);
            $sheet->getStyle('B' . $cell . ':H' . $cell)->getFont()->setBold(true);
            $cell++;
            foreach ($data['skp']['utama'] as $index => $value) {
                // return $value;
                if (isset($value['atasan']['rencana_kerja'])) {
                    $sheet->setCellValue('B' . $cell, $value['atasan']['rencana_kerja'])->mergeCells('B' . $cell . ':C' . ($cell + 2));
                } else {
                    $sheet->setCellValue('B' . ($cell - 3), '')->mergeCells('B' . ($cell - 3) . ':C' . ($cell - 1));
                }
                foreach ($value['skp_child'] as $key => $res) {
                    $sheet->setCellValue('D' . $cell, $res['rencana_kerja'])->mergeCells('D' . $cell . ':D' . ($cell + 2));
                    foreach ($res['aspek_skp'] as $k => $v) {
                        $sheet->getStyle('E' . $cell . ':E' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
                        $sheet->setCellValue('E' . $cell, $v['aspek_skp']);
                        $sheet->setCellValue('F' . $cell, $v['iki'])->mergeCells('F' . $cell . ':G' . $cell);
                        foreach ($v['target_skp'] as $mk => $rr) {
                            if ($rr['bulan'] ==  $bulan) {
                                $sheet->getStyle('H' . $cell . ':H' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
                                $sheet->setCellValue('H' . $cell, $rr['target'] . ' ' . $v['satuan']);
                            }
                        }
                        $cell++;
                    }
                    if (!$key == 0)
                        $sheet->setCellValue('B' . ($cell - 3), '')->mergeCells('B' . ($cell - 3) . ':C' . ($cell - 1));
                    $sheet->setCellValue('A' . ($cell - 3), $number)->mergeCells('A' . ($cell - 3) . ':A' . ($cell - 1));
                    $number++;
                    // $sheet->setCellValue('A' . ($cell - 3), $key + 1)->mergeCells('A' . ($cell - 3) . ':A' . ($cell - 1));
                    // return $key;
                    // } else {
                    //     $sheet->setCellValue('A' . ($cell - 3), $index + $key + 1)->mergeCells('A' . ($cell - 3) . ':A' . ($cell - 1));
                    // }
                }
            }
        } else {
            $sheet->setCellValue('B' . $cell, 'A. KINERJA UTAMA')->mergeCells('B' . $cell . ':H' . $cell);
            $sheet->getStyle('B' . $cell . ':H' . $cell)->getFont()->setBold(true);
            $cell++;
            $sheet->setCellValue('B' . $cell, '-')->mergeCells('B' . $cell . ':C' . $cell);
            $sheet->setCellValue('D' . $cell, '-')->mergeCells('D' . $cell . ':D' . ($cell + 2));
            $sheet->getStyle('E' . $cell . ':E' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->setCellValue('E' . $cell, '-');
            $sheet->setCellValue('F' . $cell, '-')->mergeCells('F' . $cell . ':G' . $cell);
            $sheet->getStyle('H' . $cell . ':H' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->setCellValue('H' . $cell, '-');
            $sheet->setCellValue('A' . $cell, 1)->mergeCells('A' . $cell . ':A' . ($cell - 1));
            $cell++;
        }


        // TAMBAHAN
        if (isset($data['skp']['tambahan'])) {
            $sheet->setCellValue('B' . $cell, 'B. KINERJA TAMBAHAN')->mergeCells('B' . $cell . ':H' . $cell);
            $sheet->getStyle('B' . $cell . ':H' . $cell)->getFont()->setBold(true);
            $cell++;
            foreach ($data['skp']['tambahan'] as $keyy => $values) {
                $sheet->setCellValue('A' . $cell, $keyy + 1)->mergeCells('A' . $cell . ':A' . ($cell + 2));
                $sheet->setCellValue('B' . $cell, ' ')->mergeCells('B' . $cell . ':C' . ($cell + 2));
                $sheet->setCellValue('D' . $cell, $values['rencana_kerja'])->mergeCells('D' . $cell . ':D' . ($cell + 2));
                foreach ($values['aspek_skp'] as $k => $v) {
                    $sheet->getStyle('E' . $cell . ':E' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
                    // $sheet->setCellValue('E' . $cell, $v['aspek_skp'])->mergeCells('E' . $cell . ':E' . ($cell + 2));
                    $sheet->setCellValue('E' . $cell, $v['aspek_skp']);
                    $sheet->setCellValue('F' . $cell, $v['iki'])->mergeCells('F' . $cell . ':G' . $cell);

                    foreach ($v['target_skp'] as $mk => $rr) {
                        if ($rr['bulan'] ==  $bulan) {
                            $sheet->getStyle('H' . $cell . ':H' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
                            $sheet->setCellValue('H' . $cell, $rr['target'] . ' ' . $v['satuan']);
                        }
                    }
                    $cell++;
                }
                $sheet->setCellValue('A' . ($cell - 3), $keyy + 1)->mergeCells('A' . ($cell - 3) . ':A' . ($cell - 1));
                if (!$keyy == 0)
                    $sheet->setCellValue('B' . ($cell - 3), '')->mergeCells('B' . ($cell - 3) . ':C' . ($cell - 1));
            }
        } else {
            $sheet->setCellValue('B' . $cell, 'B. KINERJA TAMBAHAN')->mergeCells('B' . $cell . ':H' . $cell);
            $sheet->getStyle('B' . $cell . ':H' . $cell)->getFont()->setBold(true);
            $cell++;
            $sheet->setCellValue('B' . $cell, '-')->mergeCells('B' . $cell . ':C' . $cell);
            $sheet->setCellValue('D' . $cell, '-')->mergeCells('D' . $cell . ':D' . ($cell));
            $sheet->getStyle('E' . $cell . ':E' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->setCellValue('E' . $cell, '-');
            $sheet->setCellValue('F' . $cell, '-')->mergeCells('F' . $cell . ':G' . $cell);
            $sheet->getStyle('H' . $cell . ':H' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->setCellValue('H' . $cell, '-');
            $sheet->setCellValue('A' . $cell, 1)->mergeCells('A' . $cell . ':A' . ($cell - 1));
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

        $cell++;
        $sheet->setCellValue('B' . $cell, '')->mergeCells('B' . $cell . ':F' . $cell);

        $tgl_cetak = date("t", strtotime($tahun)) . ' ' . strftime('%B %Y', mktime(0, 0, 0, $bulan + 1, 0, (int)session('tahun_penganggaran')));

        $sheet->setCellValue('G' . ++$cell, 'Bulukumba, ' . $tgl_cetak)->mergeCells('G' . $cell . ':K' . $cell);
        $sheet->getStyle('G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('G' . ++$cell, 'Pejabat Penilai Kinerja')->mergeCells('G' . $cell . ':K' . $cell);
        $sheet->getStyle('G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $cell = $cell + 3;
        $sheet->setCellValue('G' . ++$cell, $data['atasan']['nama'])->mergeCells('G' . $cell . ':K' . $cell);
        $sheet->getStyle('G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('G' . ++$cell, $data['atasan']['nip'])->mergeCells('G' . $cell . ':K' . $cell);
        $sheet->getStyle('G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

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
            header('Content-Disposition: attachment;filename="Laporan SKP ' . $data['pegawai_dinilai']['nama'] . '.xlsx"');
        } else {
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

    public function exportRealisasiKepala($data, $bulan, $type, $level)
    {
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

        $tahun = ""  . session('tahun_penganggaran') . "-" . $bulan . "";
        if ($bulan != '0') {

            $periode = date("01", strtotime($tahun)) . ' ' . strftime('%B', mktime(0, 0, 0, $bulan + 1, 0)) . ' s/d ' . date("t", strtotime($tahun)) . ' ' . strftime('%B %Y', mktime(0, 0, 0, $bulan + 1, 0, (int)session('tahun_penganggaran')));
        } else {
            $periode = "Tahun " . session('tahun_penganggaran');
        }
        $sheet->setCellValue('D5', $periode)->mergeCells('D5:J5');

        $sheet->setCellValue('A6', 'PEGAWAI YANG DINILAI')->mergeCells('A6:C6');
        $sheet->setCellValue('D6', 'PEJABAT PENILAI PEKERJA')->mergeCells('D6:J6');


        $sheet->setCellValue('A7', 'Nama')->mergeCells('A7:B7');
        $sheet->setCellValue('C7', $data['pegawai_dinilai']['nama'])->mergeCells('C7:C7');
        $sheet->setCellValue('A8', 'NIP')->mergeCells('A8:B8');
        $sheet->setCellValue('C8', "'" . $data['pegawai_dinilai']['nip'])->mergeCells('C8:C8');
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
            $sheet->setCellValue('F8', "'" . $data['atasan']['nip'])->mergeCells('F8:J8');
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
        $nilai_utama = 0;
        $nilai_tambahan = 0;
        //UTAMA
        if (count($data['skp']['utama'])) {
            $sheet->setCellValue('B' . $cell, 'A. KINERJA UTAMA')->mergeCells('B' . $cell . ':J' . $cell);
            $sheet->getStyle('B' . $cell . ':J' . $cell)->getFont()->setBold(true);
            $cell++;
            $jumlah_data = 0;
            $sum_nilai_iki = 0;
            foreach ($data['skp']['utama'] as $index => $value) {
                $sheet->getStyle('A' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
                $sheet->setCellValue('A' . $cell, $index + 1)->mergeCells('A' . $cell . ':A' . ($cell + count($value['aspek_skp']) - 1));
                // return $cell + count($value['aspek_skp']) - 1;
                // return $value;
                $sheet->setCellValue('B' . $cell, $value['rencana_kerja'])->mergeCells('B' . $cell . ':B' . ($cell + count($value['aspek_skp']) - 1));

                foreach ($value['aspek_skp'] as $k => $v) {
                    $sheet->setCellValue('C' . $cell, $v['iki']);
                    foreach ($v['target_skp'] as $mk => $rr) {
                        $kategori_ = '';
                        if ($rr['bulan'] ==  $bulan) {
                            $sheet->setCellValue('D' . $cell, $rr['target'] . ' ' . $v['satuan']);
                            $sheet->setCellValue('E' . $cell, $v['realisasi_skp'][$mk]['realisasi_bulanan'] . ' ' . $v['satuan']);
                            $single_rate = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;

                            $sheet->setCellValue('F' . $cell, round($single_rate, 0) . ' %');
                            if ($single_rate > 110) {
                                $sheet->setCellValue('G' . $cell, '110 %');
                                $sheet->setCellValue('H' . $cell, 'Sangat Baik');
                                $nilai_iki = 110 + ((120 - 110) / (110 - 101)) * (110 - 101);
                                $sheet->setCellValue('I' . $cell, round($nilai_iki, 1));
                            } elseif ($single_rate >= 101 && $single_rate <= 110) {
                                $sheet->setCellValue('G' . $cell, round($single_rate, 0) . ' %');
                                $sheet->setCellValue('H' . $cell, 'Sangat Baik');
                                $nilai_iki = 110 + ((120 - 110) / (110 - 101)) * ($single_rate - 101);
                                $sheet->setCellValue('I' . $cell, round($nilai_iki, 1));
                            } elseif ($single_rate == 100) {
                                $sheet->setCellValue('G' . $cell, round($single_rate, 0) . ' %');
                                $sheet->setCellValue('H' . $cell, 'Baik');
                                $nilai_iki = 109;
                                $sheet->setCellValue('I' . $cell, round($nilai_iki, 1));
                            } elseif ($single_rate >= 80 && $single_rate <= 99) {
                                $sheet->setCellValue('G' . $cell, round($single_rate, 0) . ' %');
                                $sheet->setCellValue('H' . $cell, 'Cukup');
                                $nilai_iki = 70 + ((89 - 70) / (99 - 80)) * ($single_rate - 80);
                                $sheet->setCellValue('I' . $cell, round($nilai_iki, 1));
                            } elseif ($single_rate >= 60 && $single_rate <= 79) {
                                $sheet->setCellValue('G' . $cell, round($single_rate, 0) . ' %');
                                $sheet->setCellValue('H' . $cell, 'Kurang');
                                $nilai_iki = 50 + ((69 - 50) / (79 - 60)) * ($single_rate - 60);
                                $sheet->setCellValue('I' . $cell, round($nilai_iki, 1));
                            } elseif ($single_rate >= 0 && $single_rate <= 79) {
                                $sheet->setCellValue('G' . $cell, round($single_rate, 0) . ' %');
                                $sheet->setCellValue('H' . $cell, 'Sangat Kurang');
                                $nilai_iki = (49 / 59) * $single_rate;
                                $sheet->setCellValue('I' . $cell, round($nilai_iki, 1));
                            }
                            //$sheet->setCellValue('J13', round($nilai_iki,1).' %' )->mergeCells('J13:J13');
                            $sum_nilai_iki += $nilai_iki;
                            $jumlah_data++;
                        }
                    }
                    $sheet->setCellValue('J' . ($cell - $jumlah_data - 1), '');
                    $cell++;
                }
            }

            $sheet->getStyle('B' . $cell . ':I' . $cell)->getAlignment()->setVertical('top')->setHorizontal('right');
            $sheet->getStyle('J' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->getStyle('B' . $cell . ':J' . $cell)->getFont()->setBold(true);
            // $cell++;
            $sheet->setCellValue('B' . $cell, 'NILAI KINERJA UTAMA')->mergeCells('B' . $cell . ':I' . $cell);
            $sheet->setCellValue('J' . $cell, $nilai_utama = round($sum_nilai_iki / $jumlah_data, 1));
            $cell++;
        } else {
            $sheet->setCellValue('B' . $cell, 'A. KINERJA UTAMA')->mergeCells('B' . $cell . ':J' . $cell);
            $sheet->getStyle('B' . $cell . ':J' . $cell)->getFont()->setBold(true);
            $cell++;
            $sheet->getStyle('A' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->setCellValue('A' . $cell, 1);
            $sheet->setCellValue('B' . $cell, '-');
            $sheet->setCellValue('C' . $cell, '-');
            $sheet->setCellValue('D' . $cell, '-');
            $sheet->setCellValue('E' . $cell, '-');
            $sheet->setCellValue('G' . $cell, '-');
            $sheet->setCellValue('H' . $cell, '-');
            $sheet->setCellValue('I' . $cell, '-');
            $sheet->setCellValue('J' . $cell, '-')->mergeCells('J' . $cell . ':J' . $cell);
            $cell++;

            $sheet->getStyle('B' . $cell . ':I' . $cell)->getAlignment()->setVertical('top')->setHorizontal('right');
            $sheet->getStyle('J' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->getStyle('B' . $cell . ':J' . $cell)->getFont()->setBold(true);
            $sheet->setCellValue('B' . $cell, 'NILAI KINERJA UTAMA')->mergeCells('B' . $cell . ':I' . $cell);
            $sheet->setCellValue('J' . $cell, 0);
            $cell++;
        }

        //TAMBAHAN
        if (count($data['skp']['tambahan'])) {
            $cell++;
            $sheet->setCellValue('B' . $cell, 'B. KINERJA TAMBAHAN')->mergeCells('B' . $cell . ':J' . $cell);
            $sheet->getStyle('B' . $cell . ':J' . $cell)->getFont()->setBold(true);
            $cell++;
            $total_tambahan = 0;
            foreach ($data['skp']['tambahan'] as $index => $value) {
                $sheet->setCellValue('A' . $cell, $index + 1);
                $sheet->setCellValue('B' . $cell, $value['rencana_kerja']);

                foreach ($value['aspek_skp'] as $k => $v) {
                    $sheet->setCellValue('C' . $cell, $v['iki']);
                    foreach ($v['target_skp'] as $mk => $rr) {
                        $kategori_ = '';
                        if ($rr['bulan'] ==  $bulan) {
                            $sheet->setCellValue('D' . $cell, $rr['target'] . ' ' . $v['satuan']);
                            $sheet->setCellValue('E' . $cell, $v['realisasi_skp'][$mk]['realisasi_bulanan'] . ' ' . $v['satuan']);
                            $single_rate = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;


                            $sheet->setCellValue('F' . $cell, round($single_rate, 0) . ' %');
                            if ($single_rate > 110) {
                                $sheet->setCellValue('G' . $cell, '110');
                                $sheet->setCellValue('H' . $cell, 'Sangat Baik');
                                $nilai_iki = 110 + ((120 - 110) / (110 - 101)) * (110 - 101);
                                $sheet->setCellValue('I' . $cell, round($nilai_iki, 1));
                            } elseif ($single_rate >= 101 && $single_rate <= 110) {
                                $sheet->setCellValue('G' . $cell, round($single_rate, 0) . ' %');
                                $sheet->setCellValue('H' . $cell, 'Sangat Baik');
                                $nilai_iki = 110 + ((120 - 110) / (110 - 101)) * ($single_rate - 101);
                                $sheet->setCellValue('I' . $cell, round($nilai_iki, 1));
                            } elseif ($single_rate == 100) {
                                $sheet->setCellValue('G' . $cell, round($single_rate, 0) . ' %');
                                $sheet->setCellValue('H' . $cell, 'Baik');
                                $nilai_iki = 109;
                                $sheet->setCellValue('I' . $cell, round($nilai_iki, 1));
                            } elseif ($single_rate >= 80 && $single_rate <= 99) {
                                $sheet->setCellValue('G' . $cell, round($single_rate, 0) . ' %');
                                $sheet->setCellValue('H' . $cell, 'Cukup');
                                $nilai_iki = 70 + ((89 - 70) / (99 - 80)) * ($single_rate - 80);
                                $sheet->setCellValue('I' . $cell, round($nilai_iki, 1));
                            } elseif ($single_rate >= 60 && $single_rate <= 79) {
                                $sheet->setCellValue('G' . $cell, round($single_rate, 0) . ' %');
                                $sheet->setCellValue('H' . $cell, 'Kurang');
                                $nilai_iki = 50 + ((69 - 50) / (79 - 60)) * ($single_rate - 60);
                                $sheet->setCellValue('I' . $cell, round($nilai_iki, 1));
                            } elseif ($single_rate >= 0 && $single_rate <= 79) {
                                $sheet->setCellValue('G' . $cell, round($single_rate, 0) . ' %');
                                $sheet->setCellValue('H' . $cell, 'Sangat Kurang');
                                $nilai_iki = (49 / 59) * $single_rate;
                                $sheet->setCellValue('I' . $cell, round($nilai_iki, 1));
                            }

                            if ($nilai_iki > 110) {
                                $sheet->setCellValue('J' . $cell, '2.4');
                                $total_tambahan += 2.4;
                            } elseif ($nilai_iki >= 101 && $nilai_iki <= 110) {
                                $sheet->setCellValue('J' . $cell, '1.6');
                                $total_tambahan += 1.6;
                            } elseif ($nilai_iki == 100) {
                                $sheet->setCellValue('J' . $cell, '1.0');
                                $total_tambahan += 1.0;
                            } elseif ($nilai_iki >= 80 && $nilai_iki <= 99) {
                                $sheet->setCellValue('J' . $cell, '0.5');
                                $total_tambahan += 0.5;
                            } elseif ($nilai_iki >= 60 && $nilai_iki <= 79) {
                                $sheet->setCellValue('J' . $cell, '0.3');
                                $total_tambahan += 0.3;
                            } elseif ($nilai_iki >= 0 && $nilai_iki <= 79) {
                                $sheet->setCellValue('J' . $cell, '0.1');
                                $total_tambahan += 0.1;
                            }
                        }
                    }
                    $cell++;
                }
            }
            $sheet->getStyle('B' . $cell . ':J' . ($cell + 1))->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->getStyle('I' . ($cell + 1))->getAlignment()->setVertical('top')->setHorizontal('right');
            $sheet->getStyle('B' . $cell . ':J' . ($cell + 1))->getFont()->setBold(true);
            $sheet->setCellValue('B' . $cell, 'NILAI KINERJA TAMBAHAN')->mergeCells('B' . $cell . ':I' . $cell);
            $sheet->setCellValue('J' . $cell, $nilai_tambahan = $total_tambahan);
            $cell++;
        } else {
            $sheet->setCellValue('B' . $cell, 'B. KINERJA TAMBAHAN')->mergeCells('B' . $cell . ':J' . $cell);
            $sheet->getStyle('B' . $cell . ':J' . $cell)->getFont()->setBold(true);
            $cell++;
            $sheet->getStyle('A' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->setCellValue('A' . $cell, 1);
            $sheet->setCellValue('B' . $cell, '-');
            $sheet->setCellValue('C' . $cell, '-');
            $sheet->setCellValue('D' . $cell, '-');
            $sheet->setCellValue('E' . $cell, '-');
            $sheet->setCellValue('G' . $cell, '-');
            $sheet->setCellValue('H' . $cell, '-');
            $sheet->setCellValue('I' . $cell, '-');
            $sheet->setCellValue('J' . $cell, '-')->mergeCells('J' . $cell . ':J' . $cell);
            $cell++;

            $sheet->getStyle('B' . $cell . ':I' . $cell)->getAlignment()->setVertical('top')->setHorizontal('right');
            $sheet->getStyle('J' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->getStyle('B' . $cell . ':J' . $cell)->getFont()->setBold(true);
            $sheet->setCellValue('B' . $cell, 'NILAI KINERJA TAMBAHAN')->mergeCells('B' . $cell . ':I' . $cell);
            $sheet->setCellValue('J' . $cell, 0);
            $cell++;
        }

        $sheet->getStyle('B' . $cell . ':I' . $cell)->getAlignment()->setVertical('top')->setHorizontal('right');
        $sheet->getStyle('J' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
        $sheet->getStyle('B' . $cell . ':J' . $cell)->getFont()->setBold(true);
        $sheet->setCellValue('B' . $cell, 'NILAI SKP')->mergeCells('B' . $cell . ':I' . $cell);
        $sheet->setCellValue('J' . $cell, $nilai_utama + $nilai_tambahan);
        $cell++;

        $sheet->getStyle('A12:J' . $cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('B13:C' . $cell)->getAlignment()->setVertical('center')->setHorizontal('left');


        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A6:J' . $cell)->applyFromArray($border);

        $cell++;
        $sheet->setCellValue('B' . $cell, '')->mergeCells('B' . $cell . ':K' . $cell);

        $tgl_cetak = date("t", strtotime($tahun)) . ' ' . strftime('%B %Y', mktime(0, 0, 0, $bulan + 1, 0, (int)session('tahun_penganggaran')));

        $sheet->setCellValue('H' . ++$cell, 'Bulukumba, ' . $tgl_cetak)->mergeCells('H' . $cell . ':K' . $cell);
        $sheet->getStyle('H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('H' . ++$cell, 'Pejabat Penilai Kinerja')->mergeCells('H' . $cell . ':K' . $cell);
        $sheet->getStyle('H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $cell = $cell + 3;
        $sheet->setCellValue('H' . ++$cell, $data['atasan']['nama'])->mergeCells('H' . $cell . ':K' . $cell);
        $sheet->getStyle('H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('H' . ++$cell, $data['atasan']['nip'])->mergeCells('H' . $cell . ':K' . $cell);
        $sheet->getStyle('H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan Penilaian SKP ' . $data['pegawai_dinilai']['nama'] . '.xlsx"');
        } else {
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

    public function exportRealisasi($data, $bulan, $type, $level)
    {

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

        $tahun = ""  . session('tahun_penganggaran') . "-" . $bulan . "";
        if ($bulan != '0') {

            $periode = date("01", strtotime($tahun)) . ' ' . strftime('%B', mktime(0, 0, 0, $bulan + 1, 0)) . ' s/d ' . date("t", strtotime($tahun)) . ' ' . strftime('%B %Y', mktime(0, 0, 0, $bulan + 1, 0, (int)session('tahun_penganggaran')));
        } else {
            $periode = "Tahun " . session('tahun_penganggaran');
        }
        $sheet->setCellValue('F5', $periode)->mergeCells('F5:L5');

        $sheet->setCellValue('A6', 'PEGAWAI YANG DINILAI')->mergeCells('A6:E6');
        $sheet->setCellValue('F6', 'PEJABAT PENILAI PEKERJA')->mergeCells('F6:L6');

        $sheet->setCellValue('A7', 'Nama')->mergeCells('A7:B7');
        $sheet->setCellValue('C7', $data['pegawai_dinilai']['nama'])->mergeCells('C7:E7');
        $sheet->setCellValue('A8', 'NIP')->mergeCells('A8:B8');
        $sheet->setCellValue('C8', "'" . $data['pegawai_dinilai']['nip'])->mergeCells('C8:E8');
        $sheet->setCellValue('A9', 'Pangkat / Gol Ruang')->mergeCells('A9:B9');
        $sheet->setCellValue('C9', $data['pegawai_dinilai']['golongan'])->mergeCells('C9:E9');
        $sheet->setCellValue('A10', 'Jabatan')->mergeCells('A10:B10');
        $sheet->setCellValue('C10', $data['pegawai_dinilai']['nama_jabatan'])->mergeCells('C10:E10');
        $sheet->setCellValue('A11', 'Unit kerja')->mergeCells('A11:B11');
        $sheet->setCellValue('C11', $data['pegawai_dinilai']['nama_satuan_kerja'])->mergeCells('C11:E11');

        // return $data;
        $sheet->setCellValue('F7', 'Nama')->mergeCells('F7:G7');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('H7', $data['atasan']['nama'])->mergeCells('H7:L7');
        } else {
            $sheet->setCellValue('H7', '-')->mergeCells('H7:L7');
        }
        $sheet->setCellValue('F8', 'NIP')->mergeCells('F8:G8');
        if ($data['atasan'] != "") {
            $sheet->setCellValue('H8', "'" . $data['atasan']['nip'])->mergeCells('H8:L8');
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
        $sheet->setCellValue('L12', 'Nilai Timbang')->mergeCells('L12:L13');
        $sheet->getColumnDimension('L')->setWidth(12);


        $cell = 14;
        $nilai_utama = 0;
        $nilai_tambahan = 0;

        //UTAMA ATASAN
        if (isset($data['skp']['utama'])) {
            $sheet->setCellValue('A' . $cell, 'A. KINERJA UTAMA')->mergeCells('A' . $cell . ':K' . $cell);
            $sheet->getStyle('A' . $cell . ':K' . $cell)->getFont()->setBold(true);
            $cell++;
            $total_utama = 0;
            $data_utama = 0;
            $index_data = 0;
            foreach ($data['skp']['utama'] as $index => $value) {

                $sheet->setCellValue('A' . $cell, $index);
                if (isset($value['atasan']['rencana_kerja'])) {
                    $sheet->setCellValue('B' . $cell, $value['atasan']['rencana_kerja'])->mergeCells('B' . $cell . ':B' . ($cell + 2));
                } else {
                    $sheet->setCellValue('B' . $cell, '');
                }

                foreach ($value['skp_child'] as $key => $res) {
                    $index_data++;
                    $data_utama++;
                    $sheet->setCellValue('C' . $cell, $res['rencana_kerja'])->mergeCells('C' . $cell . ':C' . ($cell + 2));
                    $sum_capaian = 0;
                    foreach ($res['aspek_skp'] as $k => $v) {
                        $sheet->getStyle('D' . $cell . ':D' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
                        $sheet->getStyle('F' . $cell . ':L' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
                        $sheet->setCellValue('D' . $cell, $v['aspek_skp']);
                        $sheet->setCellValue('E' . $cell, $v['iki']);
                        foreach ($v['target_skp'] as $mk => $rr) {

                            $kategori_ = '';
                            if ($rr['bulan'] ==  $bulan) {
                                $sheet->setCellValue('F' . $cell, $rr['target'] . ' ' . $v['satuan']);
                                $sheet->setCellValue('G' . $cell, $v['realisasi_skp'][$mk]['realisasi_bulanan'] . ' ' . $v['satuan']);

                                $capaian_iki = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;

                                // return $capaian_iki;

                                if ($capaian_iki > 100) {
                                    $sheet->setCellValue('H' . $cell, round($capaian_iki, 0) . ' %');
                                    $sheet->setCellValue('I' . $cell, 'Sangat Baik');
                                    $nilai_iki = 16;
                                } elseif ($capaian_iki == 100) {
                                    $sheet->setCellValue('H' . $cell, round($capaian_iki, 0) . ' %');
                                    $sheet->setCellValue('I' . $cell, 'Baik');
                                    $nilai_iki = 13;
                                } elseif ($capaian_iki >= 80 && $capaian_iki <= 99) {
                                    $sheet->setCellValue('H' . $cell, round($capaian_iki, 0) . ' %');
                                    $sheet->setCellValue('I' . $cell, 'Cukup');
                                    $nilai_iki = 8;
                                } elseif ($capaian_iki >= 60 && $capaian_iki <= 79) {
                                    $sheet->setCellValue('H' . $cell, round($capaian_iki, 0) . ' %');
                                    $sheet->setCellValue('I' . $cell, 'Kurang');
                                    $nilai_iki = 3;
                                } elseif ($capaian_iki >= 0 && $capaian_iki <= 59) {
                                    $sheet->setCellValue('H' . $cell, round($capaian_iki, 0) . ' %');
                                    $sheet->setCellValue('I' . $cell, 'Sangat Kurang');
                                    $nilai_iki = 1;
                                }
                                $sum_capaian += $nilai_iki;
                            }
                        }
                        $cell++;
                    }
                    if ($sum_capaian > 42) {
                        $sheet->setCellValue('J' . ($cell - 3), 'Sangat Baik')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
                        $sheet->setCellValue('K' . ($cell - 3), '120 %')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
                        $sheet->setCellValue('L' . ($cell - 3), '120.0')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
                        $total_utama += 120;
                    } elseif ($sum_capaian >= 34) {
                        $sheet->setCellValue('J' . ($cell - 3), 'Baik')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
                        $sheet->setCellValue('K' . ($cell - 3), '100 %')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
                        $sheet->setCellValue('L' . ($cell - 3), '100')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
                        $total_utama += 100;
                    } elseif ($sum_capaian >= 19) {
                        $sheet->setCellValue('J' . ($cell - 3), 'Cukup')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
                        $sheet->setCellValue('K' . ($cell - 3), '80 %')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
                        $sheet->setCellValue('L' . ($cell - 3), '80.0')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
                        $total_utama += 80;
                    } elseif ($sum_capaian >= 7) {
                        $sheet->setCellValue('J' . ($cell - 3), 'Kurang')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
                        $sheet->setCellValue('K' . ($cell - 3), '60 %')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
                        $sheet->setCellValue('L' . ($cell - 3), '60.0')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
                        $total_utama += 60;
                    } elseif ($sum_capaian >= 3) {
                        $sheet->setCellValue('J' . ($cell - 3), 'Sangat Kurang')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
                        $sheet->setCellValue('K' . ($cell - 3), '25 %')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
                        $sheet->setCellValue('L' . ($cell - 3), '25.0')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
                        $total_utama += 25;
                    } elseif ($sum_capaian >= 0) {
                        $sheet->setCellValue('J' . ($cell - 3), 'Sangat Kurang')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
                        $sheet->setCellValue('K' . ($cell - 3), '25 %')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
                        $sheet->setCellValue('L' . ($cell - 3), '25.0')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
                        $total_utama += 25;
                    }

                    $sheet->setCellValue('A' . ($cell - 3), $index_data)->mergeCells('A' . ($cell - 3) . ':A' . ($cell - 1));
                    if (!$key == 0)
                        $sheet->setCellValue('B' . ($cell - 3), '')->mergeCells('B' . ($cell - 3) . ':B' . ($cell - 1));
                }
                $cell++;
            }

            $sheet->getStyle('B' . $cell . ':K' . $cell)->getAlignment()->setVertical('top')->setHorizontal('right');
            $sheet->getStyle('L' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->getStyle('B' . $cell . ':L' . $cell)->getFont()->setBold(true);
            $sheet->setCellValue('B' . $cell, 'NILAI KINERJA UTAMA')->mergeCells('B' . $cell . ':K' . $cell);
            // $sheet->setCellValue('L' . $cell, $nilai_utama = $total_utama / $data_utama);
            $sheet->setCellValue('L' . $cell, $nilai_utama = round($total_utama / $data_utama, 1));
            $cell++;
        } else {
            $nilai_utama = 0;
            $sheet->setCellValue('A' . $cell, 'A. KINERJA UTAMA')->mergeCells('A' . $cell . ':K' . $cell);
            $sheet->getStyle('A' . $cell . ':K' . $cell)->getFont()->setBold(true);
            $cell++;
            $sheet->setCellValue('A' . $cell, 1);
            $sheet->setCellValue('B' . $cell, '-');
            $sheet->setCellValue('C' . $cell, '-')->mergeCells('C' . $cell . ':C' . $cell);

            $sheet->getStyle('D' . $cell . ':D' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->getStyle('F' . $cell . ':L' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->setCellValue('D' . $cell, '-');
            $sheet->setCellValue('E' . $cell, '-');

            $sheet->setCellValue('F' . $cell, '-');
            $sheet->setCellValue('G' . $cell, '-');

            $sheet->setCellValue('H' . $cell, '-');
            $sheet->setCellValue('I' . $cell, '-');

            $sheet->setCellValue('J' . $cell, '-')->mergeCells('J' . $cell . ':J' . $cell);
            $sheet->setCellValue('K' . $cell, '-')->mergeCells('K' . $cell . ':K' . $cell);
            $sheet->setCellValue('L' . $cell, '-')->mergeCells('L' . $cell . ':L' . $cell);

            $cell++;
            $sheet->getStyle('B' . $cell . ':K' . $cell)->getAlignment()->setVertical('top')->setHorizontal('right');
            $sheet->getStyle('L' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->getStyle('B' . $cell . ':L' . $cell)->getFont()->setBold(true);
            $sheet->setCellValue('B' . $cell, 'NILAI KINERJA UTAMA')->mergeCells('B' . $cell . ':K' . $cell);
            $sheet->setCellValue('L' . $cell, 0);
            $cell++;
        }

        // UTAMA OLD
        // if (isset($data['skp']['utama'])) {
        //     $cell++;
        //     $sheet->setCellValue('B' . $cell, 'A. KINERJA UTAMA')->mergeCells('B' . $cell . ':K' . $cell);
        //     $sheet->getStyle('B' . $cell . ':K' . $cell)->getFont()->setBold(true);
        //     $cell++;
        //     $total_tambahan = 0;
        //     foreach ($data['skp']['utama'] as $keyy => $values) {
        //         $sheet->setCellValue('A' . $cell, $keyy + 1)->mergeCells('A' . $cell . ':A' . ($cell + 2));
        //         $sheet->setCellValue('B' . $cell, ' ')->mergeCells('B' . $cell . ':B' . ($cell + 2));
        //         $sheet->setCellValue('C' . $cell, $values['rencana_kerja'])->mergeCells('C' . $cell . ':C' . ($cell + 2));
        //         $sum_capaian = 0;
        //         foreach ($values['aspek_skp'] as $k => $v) {
        //             $sheet->getStyle('D' . $cell . ':D' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
        //             $sheet->getStyle('F' . $cell . ':L' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
        //             $sheet->setCellValue('D' . $cell, $v['aspek_skp'])->mergeCells('D' . $cell . ':D' . $cell);
        //             $sheet->setCellValue('E' . $cell, $v['iki'])->mergeCells('E' . $cell . ':E' . $cell);

        //             foreach ($v['target_skp'] as $mk => $rr) {
        //                 if ($rr['bulan'] ==  $bulan) {
        //                     $sheet->setCellValue('F' . $cell, $rr['target'] . ' ' . $v['satuan']);
        //                     $sheet->setCellValue('G' . $cell, $v['realisasi_skp'][$mk]['realisasi_bulanan'] . ' ' . $v['satuan']);
        //                     $capaian_iki = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;

        //                     if ($capaian_iki >= 101) {
        //                         $sheet->setCellValue('H' . $cell, round($capaian_iki, 0) . ' %');
        //                         $sheet->setCellValue('I' . $cell, 'Sangat Baik');
        //                         $nilai_iki = 16;
        //                     } elseif ($capaian_iki == 100) {
        //                         $sheet->setCellValue('H' . $cell, round($capaian_iki, 0) . ' %');
        //                         $sheet->setCellValue('I' . $cell, 'Baik');
        //                         $nilai_iki = 13;
        //                     } elseif ($capaian_iki >= 80 && $capaian_iki <= 99) {
        //                         $sheet->setCellValue('H' . $cell, round($capaian_iki, 0) . ' %');
        //                         $sheet->setCellValue('I' . $cell, 'Cukup');
        //                         $nilai_iki = 8;
        //                     } elseif ($capaian_iki >= 60 && $capaian_iki <= 79) {
        //                         $sheet->setCellValue('H' . $cell, round($capaian_iki, 0) . ' %');
        //                         $sheet->setCellValue('I' . $cell, 'Kurang');
        //                         $nilai_iki = 3;
        //                     } elseif ($capaian_iki >= 0 && $capaian_iki <= 79) {
        //                         $sheet->setCellValue('H' . $cell, round($capaian_iki, 0) . ' %');
        //                         $sheet->setCellValue('I' . $cell, 'Sangat Kurang');
        //                         $nilai_iki = 1;
        //                     }
        //                     $sum_capaian += $nilai_iki;
        //                 }
        //             }
        //             $cell++;
        //         }
        //         if ($sum_capaian >= 42) {
        //             $sheet->setCellValue('J' . ($cell - 3), 'Sangat Baik')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
        //             $sheet->setCellValue('K' . ($cell - 3), '120')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
        //             $sheet->setCellValue('L' . ($cell - 3), '2.4')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
        //             $total_tambahan += 2.4;
        //         } elseif ($sum_capaian >= 34) {
        //             $sheet->setCellValue('J' . ($cell - 3), 'Baik')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
        //             $sheet->setCellValue('K' . ($cell - 3), '100')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
        //             $sheet->setCellValue('L' . ($cell - 3), '1.6')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
        //             $total_tambahan += 1.6;
        //         } elseif ($sum_capaian >= 19) {
        //             $sheet->setCellValue('J' . ($cell - 3), 'Cukup')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
        //             $sheet->setCellValue('K' . ($cell - 3), '80')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
        //             $sheet->setCellValue('L' . ($cell - 3), '1')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
        //             $total_tambahan += 1;
        //         } elseif ($sum_capaian >= 7) {
        //             $sheet->setCellValue('J' . ($cell - 3), 'Kurang')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
        //             $sheet->setCellValue('K' . ($cell - 3), '60 %')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
        //             $sheet->setCellValue('L' . ($cell - 3), '0.5')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
        //             $total_tambahan += 0.5;
        //         } elseif ($sum_capaian >= 3) {
        //             $sheet->setCellValue('J' . ($cell - 3), 'Sangat Kurang')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
        //             $sheet->setCellValue('K' . ($cell - 3), '25')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
        //             $sheet->setCellValue('L' . ($cell - 3), '0.1')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
        //             $total_tambahan += 0.1;
        //         } elseif ($sum_capaian >= 0) {
        //             $sheet->setCellValue('J' . ($cell - 3), 'Sangat Kurang')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
        //             $sheet->setCellValue('K' . ($cell - 3), '25')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
        //             $sheet->setCellValue('L' . ($cell - 3), '0.1')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
        //             $total_tambahan += 0.1;
        //         }

        //         $sheet->setCellValue('A' . ($cell - 3), $keyy + 1)->mergeCells('A' . ($cell - 3) . ':A' . ($cell - 1));
        //         if (
        //             !$keyy == 0
        //         )
        //             $sheet->setCellValue('B' . ($cell - 3), '')->mergeCells('B' . ($cell - 3) . ':B' . ($cell - 1));
        //     }
        //     $cell++;
        //     $sheet->getStyle('F' . $cell . ':L' . ($cell + 1))->getAlignment()->setVertical('top')->setHorizontal('center');
        //     $sheet->getStyle('B' . $cell . ':K' . ($cell + 1))->getAlignment()->setVertical('top')->setHorizontal('right');
        //     $sheet->getStyle('B' . $cell . ':L' . ($cell + 1))->getFont()->setBold(true);
        //     $sheet->setCellValue('B' . $cell, 'NILAI KINERJA UTAMA')->mergeCells('B' . $cell . ':K' . $cell);
        //     $sheet->setCellValue('L' . $cell, $nilai_utama = $total_tambahan);
        //     $cell++;
        // } else {
        //     $sheet->setCellValue('A' . $cell, 'Data masih kosong')->mergeCells('A' . $cell . ':L' . $cell);
        // }
        // return $cell;
        // TAMBAHAN
        if (isset($data['skp']['tambahan'])) {
            $cell++;
            $sheet->setCellValue('A' . $cell, 'B. KINERJA TAMBAHAN')->mergeCells('A' . $cell . ':K' . $cell);
            $sheet->getStyle('A' . $cell . ':K' . $cell)->getFont()->setBold(true);

            $total_tambahan = 0;
            foreach ($data['skp']['tambahan'] as $keyy => $values) {
                $cell++;
                $sheet->setCellValue('A' . $cell, $keyy + 1)->mergeCells('A' . $cell . ':A' . ($cell + 2));
                $sheet->setCellValue('B' . $cell, ' ')->mergeCells('B' . $cell . ':B' . ($cell + 2));
                $sheet->setCellValue('C' . $cell, $values['rencana_kerja'])->mergeCells('C' . $cell . ':C' . ($cell + 2));
                $sum_capaian = 0;
                foreach ($values['aspek_skp'] as $k => $v) {
                    $sheet->getStyle('D' . $cell . ':D' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
                    $sheet->getStyle('F' . $cell . ':L' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
                    $sheet->setCellValue('D' . $cell, $v['aspek_skp'])->mergeCells('D' . $cell . ':D' . $cell);
                    $sheet->setCellValue('E' . $cell, $v['iki'])->mergeCells('E' . $cell . ':E' . $cell);

                    foreach ($v['target_skp'] as $mk => $rr) {
                        if ($rr['bulan'] ==  $bulan) {
                            $sheet->setCellValue('F' . $cell, $rr['target'] . ' ' . $v['satuan']);
                            $sheet->setCellValue('G' . $cell, $v['realisasi_skp'][$mk]['realisasi_bulanan'] . ' ' . $v['satuan']);
                            $capaian_iki = ($v['realisasi_skp'][$mk]['realisasi_bulanan'] / $rr['target']) * 100;

                            if ($capaian_iki >= 101) {
                                $sheet->setCellValue('H' . $cell, round($capaian_iki, 0) . ' %');
                                $sheet->setCellValue('I' . $cell, 'Sangat Baik');
                                $nilai_iki = 16;
                            } elseif ($capaian_iki == 100) {
                                $sheet->setCellValue('H' . $cell, round($capaian_iki, 0) . ' %');
                                $sheet->setCellValue('I' . $cell, 'Baik');
                                $nilai_iki = 13;
                            } elseif ($capaian_iki >= 80 && $capaian_iki <= 99) {
                                $sheet->setCellValue('H' . $cell, round($capaian_iki, 0) . ' %');
                                $sheet->setCellValue('I' . $cell, 'Cukup');
                                $nilai_iki = 8;
                            } elseif ($capaian_iki >= 60 && $capaian_iki <= 79) {
                                $sheet->setCellValue('H' . $cell, round($capaian_iki, 0) . ' %');
                                $sheet->setCellValue('I' . $cell, 'Kurang');
                                $nilai_iki = 3;
                            } elseif ($capaian_iki >= 0 && $capaian_iki <= 79) {
                                $sheet->setCellValue('H' . $cell, round($capaian_iki, 0) . ' %');
                                $sheet->setCellValue('I' . $cell, 'Sangat Kurang');
                                $nilai_iki = 1;
                            }
                            $sum_capaian += $nilai_iki;
                        }
                    }
                    $cell++;
                }
                if ($sum_capaian >= 42) {
                    $sheet->setCellValue('J' . ($cell - 3), 'Sangat Baik')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
                    $sheet->setCellValue('K' . ($cell - 3), '120')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
                    $sheet->setCellValue('L' . ($cell - 3), '2.4')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
                    $total_tambahan += 2.4;
                } elseif ($sum_capaian >= 34) {
                    $sheet->setCellValue('J' . ($cell - 3), 'Baik')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
                    $sheet->setCellValue('K' . ($cell - 3), '100')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
                    $sheet->setCellValue('L' . ($cell - 3), '1.6')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
                    $total_tambahan += 1.6;
                } elseif ($sum_capaian >= 19) {
                    $sheet->setCellValue('J' . ($cell - 3), 'Cukup')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
                    $sheet->setCellValue('K' . ($cell - 3), '80')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
                    $sheet->setCellValue('L' . ($cell - 3), '1')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
                    $total_tambahan += 1;
                } elseif ($sum_capaian >= 7) {
                    $sheet->setCellValue('J' . ($cell - 3), 'Kurang')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
                    $sheet->setCellValue('K' . ($cell - 3), '60 %')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
                    $sheet->setCellValue('L' . ($cell - 3), '0.5')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
                    $total_tambahan += 0.5;
                } elseif ($sum_capaian >= 3) {
                    $sheet->setCellValue('J' . ($cell - 3), 'Sangat Kurang')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
                    $sheet->setCellValue('K' . ($cell - 3), '25')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
                    $sheet->setCellValue('L' . ($cell - 3), '0.1')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
                    $total_tambahan += 0.1;
                } elseif ($sum_capaian >= 0) {
                    $sheet->setCellValue('J' . ($cell - 3), 'Sangat Kurang')->mergeCells('J' . ($cell - 3) . ':J' . ($cell - 1));
                    $sheet->setCellValue('K' . ($cell - 3), '25')->mergeCells('K' . ($cell - 3) . ':K' . ($cell - 1));
                    $sheet->setCellValue('L' . ($cell - 3), '0.1')->mergeCells('L' . ($cell - 3) . ':L' . ($cell - 1));
                    $total_tambahan += 0.1;
                }

                $sheet->setCellValue('A' . ($cell - 3), $keyy + 1)->mergeCells('A' . ($cell - 3) . ':A' . ($cell - 1));
                if (!$keyy == 0)
                    $sheet->setCellValue('B' . ($cell - 3), '')->mergeCells('B' . ($cell - 3) . ':B' . ($cell - 1));
                $cell++;
            }

            $sheet->getStyle('F' . $cell . ':L' . ($cell + 1))->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->getStyle('B' . $cell . ':K' . ($cell + 1))->getAlignment()->setVertical('top')->setHorizontal('right');
            $sheet->getStyle('B' . $cell . ':L' . ($cell + 1))->getFont()->setBold(true);
            $sheet->setCellValue('B' . $cell, 'NILAI KINERJA TAMBAHAN')->mergeCells('B' . $cell . ':K' . $cell);
            $sheet->setCellValue('L' . $cell, $nilai_tambahan = $total_tambahan);
        } else {

            $sheet->setCellValue('A' . $cell, 'B. KINERJA TAMBAHAN')->mergeCells('A' . $cell . ':L' . $cell);
            $sheet->getStyle('A' . $cell . ':K' . $cell)->getFont()->setBold(true);
            $cell++;
            $sheet->setCellValue('A' . $cell, 1);
            $sheet->setCellValue('B' . $cell, '-');
            $sheet->setCellValue('C' . $cell, '-')->mergeCells('C' . $cell . ':C' . $cell);

            $sheet->getStyle('D' . $cell . ':D' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->getStyle('F' . $cell . ':L' . $cell)->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->setCellValue('D' . $cell, '-');
            $sheet->setCellValue('E' . $cell, '-');

            $sheet->setCellValue('F' . $cell, '-');
            $sheet->setCellValue('G' . $cell, '-');

            $sheet->setCellValue('H' . $cell, '-');
            $sheet->setCellValue('I' . $cell, '-');

            $sheet->setCellValue('J' . $cell, '-')->mergeCells('J' . $cell . ':J' . $cell);
            $sheet->setCellValue('K' . $cell, '-')->mergeCells('K' . $cell . ':K' . $cell);
            $sheet->setCellValue('L' . $cell, '-')->mergeCells('L' . $cell . ':L' . $cell);

            $cell++;
            $sheet->getStyle('F' . $cell . ':L' . ($cell + 1))->getAlignment()->setVertical('top')->setHorizontal('center');
            $sheet->getStyle('B' . $cell . ':K' . ($cell + 1))->getAlignment()->setVertical('top')->setHorizontal('right');
            $sheet->getStyle('B' . $cell . ':L' . ($cell + 1))->getFont()->setBold(true);
            $sheet->setCellValue('B' . $cell, 'NILAI KINERJA TAMBAHAN')->mergeCells('B' . $cell . ':K' . $cell);
            $sheet->setCellValue('L' . $cell, 0);
        }

        $cell++;
        $sheet->getStyle('F' . $cell . ':L' . ($cell + 1))->getAlignment()->setVertical('top')->setHorizontal('center');
        $sheet->getStyle('B' . $cell . ':K' . ($cell + 1))->getAlignment()->setVertical('top')->setHorizontal('right');
        $sheet->getStyle('B' . $cell . ':L' . ($cell + 1))->getFont()->setBold(true);
        $sheet->setCellValue('B' . $cell, 'NILAI SKP')->mergeCells('B' . $cell . ':K' . $cell);
        $sheet->setCellValue('L' . $cell, $nilai_utama + $nilai_tambahan);


        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A6:L' . $cell)->applyFromArray($border);
        $cell++;
        $sheet->setCellValue('B' . $cell, '
        ')->mergeCells('B' . $cell . ':K' . $cell);

        $tgl_cetak = date("t", strtotime($tahun)) . ' ' . strftime('%B %Y', mktime(0, 0, 0, $bulan + 1, 0, (int)session('tahun_penganggaran')));

        $sheet->setCellValue('H' . ++$cell, 'Bulukumba, ' . $tgl_cetak)->mergeCells('H' . $cell . ':K' . $cell);
        $sheet->getStyle('H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('H' . ++$cell, 'Pejabat Penilai Kinerja')->mergeCells('H' . $cell . ':K' . $cell);
        $sheet->getStyle('H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $cell = $cell + 3;
        $sheet->setCellValue('H' . ++$cell, $data['atasan']['nama'])->mergeCells('H' . $cell . ':K' . $cell);
        $sheet->getStyle('H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('H' . ++$cell, $data['atasan']['nip'])->mergeCells('H' . $cell . ':K' . $cell);
        $sheet->getStyle('H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);



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
            header('Content-Disposition: attachment;filename="Laporan Penilaian SKP ' . $data['pegawai_dinilai']['nama'] . '.xlsx"');
        } else {
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

    public function viewexportRekapAbsen($params1, $params2, $idpegawai)
    {

        // return $params1;

        $url = env('API_URL');
        $token = session()->get('user.access_token');

        $response = Http::withToken($token)->get($url . "/" . "view-rekapByUser/" . $params1 . "/" . $params2 . "/" . $idpegawai);

        if ($response->successful() && isset($response->object()->data)) {
            $data = $response->json();
            $this->exportrekapPegawai($data, 'pdf', 'mobile');
        } else {
            return 'err';
        }
        // $data = $this->getRekapPegawai($val->startDate,$val->endDate); 

    }

    public function exportrekapPegawai($data, $type, $orientation)
    {
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
        $sheet->setCellValue('A2', '' . $data['data']['pegawai']['satuan_kerja']['nama_satuan_kerja'])->mergeCells('A2:G2');
        $sheet->setCellValue('A3',  $data['data']['pegawai']['nama'] . '/ ' . $data['data']['pegawai']['nip'])->mergeCells('A3:G3');
        //$sheet->setCellValue('A4', $startDate.' s/d '.$endDate)->mergeCells('A4:G4');
        $sheet->getStyle('A1:G4')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:G4')->getFont()->setSize(14);


      

        $sheet->setCellValue('A10', ' ')->mergeCells('A10:G10');

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

        // return $data;

        foreach ($data['data']['data_absen'] as $index => $value) {
            $sheet->getRowDimension($cell)->setRowHeight(30);
            $sheet->setCellValue('A' . $cell, $index + 1);
            $sheet->setCellValue('B' . $cell, $value['tanggal']);

            if (isset($value['data_tanggal'])) {
                if (isset($value['data_tanggal'][0])) {
                    $sheet->setCellValue('C' . $cell, $value['data_tanggal'][0]['status_absen']);

                    foreach ($value['data_tanggal'] as $k => $v) {
                        if ($v['jenis'] == 'checkin') {
                            $sheet->setCellValue('D' . $cell, $value['data_tanggal'][$k]['waktu_absen']);
                            $sheet->setCellValue('E' . $cell, $value['data_tanggal'][$k]['keterangan']);
                        } else {
                            $sheet->setCellValue('F' . $cell, $value['data_tanggal'][$k]['waktu_absen']);
                            $sheet->setCellValue('G' . $cell, $value['data_tanggal'][$k]['keterangan']);
                        }
                    }
                } else {

                    if (isset($value['data_tanggal']['status_absen'])) {
                        $sheet->setCellValue('C' . $cell, $value['data_tanggal']['status_absen']);
                    } else {
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


    
                
        // $sheet->setCellValue('A'.$cell++, 'Jumlah hari kerja')->mergeCells('A'.$cell++.':B'.$cell++);
        // $sheet->setCellValue('C5', ': ' . $data['data']['jml_hari_kerja'])->mergeCells('C5:G5');
        // $sheet->setCellValue('A6', 'Kehadiran kerja')->mergeCells('A6:B6');
        // $sheet->setCellValue('C6', ': ' . $data['data']['kehadiran'])->mergeCells('C6:G6');
        // $sheet->setCellValue('A7', 'Tanpa keterangan')->mergeCells('A7:B7');
        // $sheet->setCellValue('C7', ': ' . $data['data']['tanpa_keterangan'])->mergeCells('C7:G7');
        // $sheet->setCellValue('A8', 'Jumlah potongan kehadiran')->mergeCells('A8:B8');
        // $sheet->setCellValue('C8', ': ' . $data['data']['potongan_kehadiran'])->mergeCells('C8:G8');
        // $sheet->setCellValue('A9', 'Persentase pemotongan')->mergeCells('A9:B9');
        // $sheet->setCellValue('C9', ': ' . $data['data']['persentase_pemotongan'])->mergeCells('C9:G9');

        $sheet->getStyle('A5:G9')->getFont()->setSize(12);

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A11:G' . $cell)->applyFromArray($border);
        $sheet->getStyle('A11:G' . $cell)->getAlignment()->setVertical('center')->setHorizontal('center');

        $cell++;

        $cell = $cell + 2;
        $sheet->setCellValue('A'.$cell, 'Jumlah hari kerja')->mergeCells('A'.$cell.':B'.$cell);     
        $sheet->setCellValue('C'.$cell, ': ' . $data['data']['jml_hari_kerja']); 
        $cell = $cell + 1;
        $sheet->setCellValue('A'.$cell, 'Kehadiran kerja')->mergeCells('A'.$cell.':B'.$cell);     
        $sheet->setCellValue('C'.$cell, ': ' . $data['data']['kehadiran']);
        $cell = $cell + 1;
        $sheet->setCellValue('A'.$cell, 'Tanpa keterangan')->mergeCells('A'.$cell.':B'.$cell);
        $sheet->setCellValue('C'.$cell, ': ' . $data['data']['tanpa_keterangan']);
        $cell = $cell + 1;
        $sheet->setCellValue('A'.$cell, 'Potongan tanpa keterangan')->mergeCells('A'.$cell.':B'.$cell);
        $sheet->setCellValue('C'.$cell, ': ' . $data['data']['potongan_tanpa_keterangan']);
        $cell = $cell + 1;
        $sheet->setCellValue('A'.$cell, 'Potongan masuk kerja')->mergeCells('A'.$cell.':B'.$cell);
        $sheet->setCellValue('C'.$cell, ': ' . $data['data']['potongan_masuk_kerja']);
        $cell = $cell + 1;
        $sheet->setCellValue('A'.$cell, 'Potongan pulang kerja')->mergeCells('A'.$cell.':B'.$cell);
        $sheet->setCellValue('C'.$cell, ': ' . $data['data']['potongan_pulang_kerja']);
        $cell = $cell + 1;
        $sheet->setCellValue('A'.$cell, 'Potongan apel')->mergeCells('A'.$cell.':B'.$cell);
        $sheet->setCellValue('C'.$cell, ': ' . $data['data']['potongan_apel']);
               $cell = $cell + 1;
        $sheet->setCellValue('A'.$cell, 'Total potongan')->mergeCells('A'.$cell.':B'.$cell);
        $sheet->setCellValue('C'.$cell, ': ' . $data['data']['jml_potongan_kehadiran_kerja']);
        // abdillah

              // $cell_bottom = $cell+1;
        //         // return $cell;
        
        // for ($cl=0; $cl < 1; $cl++) { 
        //     $sheet->setCellValue('A'.$cl, 'Jumlah hari kerja')->mergeCells('A'.$cl++.':B'.$cell++);         
        // }    


        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan Absen' . $data['data']['pegawai']['nama'] . '.xlsx"');
        } else {
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

    public function exportrekapOpd($data, $type, $startDate, $endDate, $perangkat_daerah)
    {
        // return $data;
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

        $sheet->setCellValue('A1', 'REKAPITULASI CAPAIAN DISIPLIN / KEHADIRAN KERJA');
        $sheet->mergeCells('A1:AB1');

        $sheet->setCellValue('A3', 'PERANGKAT DAERAH');
        $sheet->mergeCells('A3:B3');
        $sheet->setCellValue('C3', ': ');
        $sheet->setCellValue('D3', $perangkat_daerah)->mergeCells('D3:AB3');

        $sheet->setCellValue('A4', 'PERIODE');
        $sheet->mergeCells('A4:B4');
        $sheet->setCellValue('C4', ':');
        $sheet->setCellValue('D4', $startDate . ' s/d ' . $endDate)->mergeCells('D4:AB4');

        $sheet->setCellValue('A5', ' ');

        
        
        $sheet->getStyle('A1:AB1')->getFont()->setSize(16);
        $sheet->getStyle('A3:AB4')->getFont()->setSize(12);

        $sheet->getColumnDimension('B')->setWidth(35);
       

        $sheet->getStyle('A6:AB10')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('E1F5FE');

        // konten
        $sheet->setCellValue('A6', 'No')->mergeCells('A6:A10');
        $sheet->setCellValue('B6', 'NAMA/NIP')->mergeCells('B6:B10');
        $sheet->setCellValue('C6', 'JML HARI KERJA')->mergeCells('C6:C10');
        $sheet->setCellValue('D6', 'KEHADIRAN KERJA')->mergeCells('D6:AB6');
        $sheet->setCellValue('AA7', 'TOTAL POTONGAN KEHADIRAN KERJA')->mergeCells('AA7:AA10');
        $sheet->setCellValue('AB7', 'KETERANGAN')->mergeCells('AB7:AB10');

        $sheet->setCellValue('D7', 'JUMLAH KEHADIRAN KERJA')->mergeCells('D7:D10');
        $sheet->setCellValue('E7', 'TANPA KETERANGAN')->mergeCells('E7:F7');
        $sheet->setCellValue('E8', 'JUMLAH HARI TANPA KETERANGAN')->mergeCells('E8:E10');
        $sheet->setCellValue('F8', 'POTONGAN (%)')->mergeCells('F8:F10');

        $sheet->setCellValue('G7', 'KETERLAMBATAN MASUK KERJA')->mergeCells('G7:O7');
        $sheet->setCellValue('G8', 'WAKTU TMK (MENIT)')->mergeCells('G8:N8');
        $sheet->setCellValue('O8', 'POTONGAN (%)')->mergeCells('O8:O10');

        $sheet->setCellValue('P7', 'CEPAT PULANG KERJA')->mergeCells('P7:X7');
        $sheet->setCellValue('P8', 'WAKTU CPK (MENIT)')->mergeCells('P8:W8');
        $sheet->setCellValue('X8', 'POTONGAN (%)')->mergeCells('X8:X10');

        $sheet->setCellValue('Y7', 'APEL / UPACARA')->mergeCells('Y7:Z7');
        $sheet->setCellValue('Y8', 'JUMLAH TIDAK HADIR APEL/ UPACARA')->mergeCells('Y8:Y10');
        $sheet->setCellValue('Z8', 'TOTAL POTONGAN (%)')->mergeCells('Z8:Z10');

    

        $sheet->setCellValue('G9', '1-30' . PHP_EOL . 'M')->mergeCells('G9:H10');
        $sheet->setCellValue('H9', 'JML' . PHP_EOL . 'POT')->mergeCells('H9:H10');
        $sheet->setCellValue('I9', '31-60' . PHP_EOL . 'M')->mergeCells('I9:I10');
        $sheet->setCellValue('J9', 'JML' . PHP_EOL . 'POT')->mergeCells('J9:J10');
        $sheet->setCellValue('K9', '60-90' . PHP_EOL . 'M')->mergeCells('K9:K10');
        $sheet->setCellValue('L9', 'JML' . PHP_EOL . 'POT')->mergeCells('L9:L10');
        $sheet->setCellValue('M9', '91' . PHP_EOL . 'Keatas')->mergeCells('M9:M10');
        $sheet->setCellValue('N9', 'JML' . PHP_EOL . 'POT')->mergeCells('N9:N10');

        $sheet->setCellValue('P9', '1-30' . PHP_EOL . 'M')->mergeCells('P9:P10');
        $sheet->setCellValue('Q9', 'JML' . PHP_EOL . 'POT')->mergeCells('Q9:Q10');
        $sheet->setCellValue('R9', '31-60' . PHP_EOL . 'M')->mergeCells('R9:R10');
        $sheet->setCellValue('S9', 'JML' . PHP_EOL . 'POT')->mergeCells('S9:S10');
        $sheet->setCellValue('T9', '60-90' . PHP_EOL . 'M')->mergeCells('T9:T10');
        $sheet->setCellValue('U9', 'JML' . PHP_EOL . 'POT')->mergeCells('U9:U10');
        $sheet->setCellValue('V9', '91' . PHP_EOL . 'Keatas')->mergeCells('V9:V10');
        $sheet->setCellValue('W9', 'JML' . PHP_EOL . 'POT')->mergeCells('W9:W10');

        $cell = 11;

        $jumlah_tidak_hadir_apel= 0;
        $total_potongan_apel = 0;
        $jml_potongan_kehadiran_kerja = 0;

        foreach ($data['pegawai'] as $i => $val) {        
            $total_potongan_persen_keterlambatan = 0;
             $total_potongan_persen_pulang_kerja = 0;
     

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
            $date_val = array();
            $jml_tanpa_keterangan = 0;
            $keterangan = '';
            $nums = 0;
            
            $sheet->setCellValue('A' . $cell, $i + 1);
            $sheet->setCellValue('B' . $cell, $val[0]['pegawai']['nama'] . ' ' . PHP_EOL . ' ' . $val[0]['pegawai']['nip']);
            $sheet->setCellValue('C' . $cell, $data['hari_kerja']);
            foreach ($val as $t => $v) {
        
                  $count_absen = 0;
                  if (isset($v['jumlah_apel'])) {
                                //    return ((int)$data['count_monday'] - (int)$v['jumlah_apel']);
                   $jumlah_tidak_hadir_apel = ((int)$data['count_monday'] - (int)$v['jumlah_apel']); 
                //    $jumlah_tidak_hadir_apel -= 1;
                  }


                //   return $jumlah_tidak_hadir_apel;
                
                if (isset($v['status'])) {
                    $count_absen = array_count_values(array_column($val, 'tanggal_absen'))[$v['tanggal_absen']];
                    if ($count_absen == 1) {
                        $cpk_90_keatas[] =  $v['status'];
                    }
                    // if ($v['status'] == 'hadir') {
                    array_push($date_val, $v['tanggal_absen']);
                    $tes = [];
                    if ($v['jenis'] == 'checkin') {
                        $jml_hari_kerja[] = $v['id'];
                        $selisih_waktu = $this->konvertWaktu('checkin', $v['waktu_absen']);

                        $tes[] = $selisih_waktu;


                        if ($selisih_waktu >= 1 && $selisih_waktu <= 30) {
                            $kmk_30[] = $selisih_waktu;
                        } elseif ($selisih_waktu >= 31 && $selisih_waktu <= 60) {
                            $kmk_60[] =  $selisih_waktu;
                        } elseif ($selisih_waktu >= 61 && $selisih_waktu <= 90) {
                            $kmk_90[] =  $selisih_waktu;
                        } elseif ($selisih_waktu >= 91) {
                            $kmk_90_keatas[] =  $selisih_waktu;
                        }
                    } else {

                        $selisih_waktu = $this->konvertWaktu('checkout', $v['waktu_absen']);

                        if ($selisih_waktu >= 1 && $selisih_waktu <= 30) {
                            $cpk_30[] = $selisih_waktu;
                        } elseif ($selisih_waktu >= 31 && $selisih_waktu <= 60) {
                            $cpk_60[] =  $selisih_waktu;
                        } elseif ($selisih_waktu >= 61 && $selisih_waktu <= 90) {
                            $cpk_90[] =  $selisih_waktu;
                        } elseif ($selisih_waktu >= 91) {
                            $cpk_90_keatas[] =  $selisih_waktu;
                        }
                    }
                    // }
                }
            }
            foreach ($data['range'] as $k => $vv) {
                if (in_array($vv, $date_val) == false) {
                    $jml_tanpa_keterangan += $nums + 1;
                }
            }

            $sheet->setCellValue('D' . $cell, count($jml_hari_kerja));
            $sheet->setCellValue('E' . $cell, $jml_tanpa_keterangan);
            $sheet->setCellValue('F' . $cell, $jml_tanpa_keterangan * 3);

            $total_potongan_persen_keterlambatan = (count($kmk_30) * 0.5) + (count($kmk_60) * 1) + (count($kmk_90) * 1.25) + (count($kmk_90_keatas) * 1.5);
            $total_potongan_persen_pulang_kerja = (count($cpk_30) * 0.5) + (count($cpk_60) * 1) + (count($cpk_90) * 1.25) + (count($cpk_90_keatas) * 1.5);

            $sheet->setCellValue('G' . $cell, count($kmk_30));
            $sheet->setCellValue('H' . $cell, count($kmk_30) * 0.5);
            $sheet->setCellValue('I' . $cell, count($kmk_60));
            $sheet->setCellValue('J' . $cell, count($kmk_60) * 1);
            $sheet->setCellValue('K' . $cell, count($kmk_90));
            $sheet->setCellValue('L' . $cell, count($kmk_90) * 1.25);
            $sheet->setCellValue('M' . $cell, count($kmk_90_keatas));
            $sheet->setCellValue('N' . $cell, count($kmk_90_keatas) * 1.5);
            $sheet->setCellValue('O' . $cell, $total_potongan_persen_keterlambatan);

            $sheet->setCellValue('P' . $cell, count($cpk_30));
            $sheet->setCellValue('Q' . $cell, count($cpk_30) * 0.5);
            $sheet->setCellValue('R' . $cell, count($cpk_60));
            $sheet->setCellValue('S' . $cell, count($cpk_60) * 1);
            $sheet->setCellValue('T' . $cell, count($cpk_90));
            $sheet->setCellValue('U' . $cell, count($cpk_90) * 1.25);
            $sheet->setCellValue('V' . $cell, count($cpk_90_keatas));
            $sheet->setCellValue('W' . $cell, count($cpk_90_keatas) * 1.5);

            $sheet->setCellValue('X' . $cell, $total_potongan_persen_pulang_kerja);
            $sheet->setCellValue('Y' . $cell, $jumlah_tidak_hadir_apel);
            $total_potongan_apel = $jumlah_tidak_hadir_apel * 2;
            $sheet->setCellValue('Z' . $cell, $total_potongan_apel );

            $jml_potongan_kehadiran_kerja = ($jml_tanpa_keterangan * 3) + $total_potongan_persen_keterlambatan + $total_potongan_persen_pulang_kerja + $total_potongan_apel;

            $jml_tanpa_keterangan > 3 ? $keterangan = 'TMS' : $keterangan = 'MS';

             $sheet->setCellValue('AA' . $cell, $jml_potongan_kehadiran_kerja );
             $sheet->setCellValue('AB' . $cell, $keterangan);

             if ($keterangan == 'TMS') {
                $sheet->getStyle('AB' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('F44336');
                
             }else{
                $sheet->getStyle('AB' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('00E676');
             }


            // $sheet->setCellValue('Y' . $cell, 0);
            // $sheet->setCellValue('Z' . $cell, 0);

            // if ($v['pegawai']['nip'] == '198305172001121003') {
            //     return count($kmk_30);
            //      return ($jml_tanpa_keterangan * 3) .' || '.  (count($kmk_30) * 0.5) .' || '. (count($kmk_60)) .' || '.  (count($kmk_90) * 1.25) .' || '. (count($kmk_90_keatas) * 1.5) .' || '. (count($cpk_30) * 0.5) .' || '. (count($cpk_60)) .' || '. (count($cpk_90) * 1.25) .' || '. (count($cpk_90_keatas) * 1.5);
            // }

       
            $jml_potongan_kehadiran = ($jml_tanpa_keterangan * 3) + (count($kmk_30) * 0.5) + (count($kmk_60)) + (count($kmk_90) * 1.25) + (count($kmk_90_keatas) * 1.5) + (count($cpk_30) * 0.5) + (count($cpk_60)) + (count($cpk_90) * 1.25) + count($cpk_90_keatas) * 1.5;

            $persentase_pemotongan_tunjangan = $jml_potongan_kehadiran * 0.4;

            // $sheet->setCellValue('AA' . $cell, $jml_potongan_kehadiran);
            // $sheet->setCellValue('AB' . $cell, $persentase_pemotongan_tunjangan);
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

        $sheet->getStyle('D7:D' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('B2DFDB');
        $sheet->getStyle('E7:F' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FFCDD2');
        $sheet->getStyle('G7:O' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FFECB3');
        $sheet->getStyle('P7:X' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FFF9C4');
        $sheet->getStyle('Y7:Z' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('B3E5FC');
        $sheet->getStyle('AA11:AA' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('00E676');
        //$sheet->getStyle('AB6:AB10')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('00E676');

        $sheet->getStyle('A6:AB' . $cell)->applyFromArray($border);
        $sheet->getStyle('A:AB')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A:AB')->getAlignment()->setVertical('center');
        $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal('rigth');
        $sheet->getStyle('A3:AB4')->getAlignment()->setHorizontal('rigth');

        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan Absen' . $data['satuan_kerja'] . '.xlsx"');
        } else {
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

    public function konvertWaktu($params, $waktu)
    {
        $diff = '';
        $selisih_waktu = '';
        $menit = 0;
        if ($params == 'checkin') {
            $waktu_tetap_absen = strtotime('08:00:00');
            $waktu_absen = strtotime($waktu);
            $diff = $waktu_absen - $waktu_tetap_absen;
        } else {
            $waktu_tetap_absen = strtotime('16:00:00');
            $waktu_absen = strtotime($waktu);
            $diff = $waktu_tetap_absen - $waktu_absen;
            // return $diff;
        }

        if ($diff > 0) {
            // $jam = floor($diff/3600);
            // $selisih_waktu = $diff%3600;
            $menit = floor($diff / 60);
        } else {
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
        $pegawaiBysatker = Http::withToken($token)->get($url . "/pegawai/BySatuanKerja/" . $satker);
        $pegawaiBysatker_ = $pegawaiBysatker->json();

        // return $satker_;

        return view('pages.laporan.bankom', compact('page_title', 'page_description', 'breadcumb', 'pegawaiBysatker_', 'role', 'role_page', 'idPegawai'));
    }

    public function getDataBankom($type, $tahun, $id_pegawai)
    {
        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $satker = session()->get('user.current.pegawai.id_satuan_kerja');
        $data = Http::withToken($token)->get($url . "/bankom/laporan/" . $type . '/' . $satker . '/' . $tahun . '/' . $id_pegawai);
        return $data->json();
    }

    public function exportbankom($tahun, $type, $id_pegawai)
    {

        if ($id_pegawai == 'semua') {
            $data = $this->getDataBankom('rekap', $tahun, $id_pegawai);

            return $this->laporanRekap($data, $type, $tahun);
        } else {
            $data = $this->getDataBankom('pegawai', $tahun, $id_pegawai);


            return $this->laporanByPegawai($data, $type, $tahun);
        }
    }

    public function laporanRekap($data, $type, $tahun)
    {
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
        $sheet->setCellValue('A2', 'TAHUN ' . $tahun)->mergeCells('A2:G2');

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
            $jumlah_data = 0;
            foreach ($value['bankom'] as $x => $y) {
                $jumlah_data++;
                $total_jp += $y['jumlah_jp'];
                $sheet->setCellValue('C' . $cell, $y['nama_pelatihan']);
                $sheet->setCellValue('D' . $cell, $y['jenis_pelatihan']);
                $sheet->setCellValue('E' . $cell, $y['waktu_awal'] . ' s/d ' . $y['waktu_akhir']);
                $sheet->setCellValue('F' . $cell, $y['jumlah_jp']);
                $cell++;
            }
            $sheet->setCellValue('A' . ($cell - $jumlah_data), $key + 1)->mergeCells('A' . ($cell - $jumlah_data) . ':A' . ($cell - 1));
            $sheet->setCellValue('B' . ($cell - $jumlah_data), $value['nama'])->mergeCells('B' . ($cell - $jumlah_data) . ':B' . ($cell - 1));
            $sheet->setCellValue('G' . ($cell - $jumlah_data), $total_jp)->mergeCells('G' . ($cell - $jumlah_data) . ':G' . ($cell - 1));
            $sheet->getStyle('G' . ($cell - $jumlah_data))->getFont()->setBold(true);
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
        $sheet->getStyle('A1:G' . $cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('B5:C' . $cell)->getAlignment()->setVertical('center')->setHorizontal('left');

        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan Rekapitulasi Pengembangan Kompetensi.xlsx"');
        } else {
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

    public function laporanByPegawai($data, $type, $tahun)
    {

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
        $sheet->setCellValue('A2', 'TAHUN ' . $tahun)->mergeCells('A2:F2');

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
        $jumlah_data = 0;
        $total_jp = 0;
        foreach ($data as $key => $y) {
            $jumlah_data++;
            $total_jp += $y['jumlah_jp'];
            $sheet->setCellValue('A' . $cell, $key + 1);
            $sheet->setCellValue('B' . $cell, $y['nama_pelatihan']);
            $sheet->setCellValue('C' . $cell, $y['jenis_pelatihan']);
            $sheet->setCellValue('D' . $cell, $y['waktu_awal'] . ' s/d ' . $y['waktu_akhir']);
            $sheet->setCellValue('E' . $cell, $y['jumlah_jp']);
            $cell++;
        }
        $sheet->setCellValue('F' . ($cell - $jumlah_data), $total_jp)->mergeCells('F' . ($cell - $jumlah_data) . ':F' . ($cell - 1));
        $sheet->getStyle('F' . ($cell - $jumlah_data))->getFont()->setBold(true);
        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A4:F' . $cell)->applyFromArray($border);
        $sheet->getStyle('A1:F' . $cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('B5:B' . $cell)->getAlignment()->setVertical('center')->setHorizontal('left');
        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan Rekapitulasi Pengembangan Kompetensi.xlsx"');
        } else {
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
