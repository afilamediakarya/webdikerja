<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;

class PegawaiController extends Controller
{
    //

    public function index(Request $request)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        if ($request->ajax()) {
            $response = Http::withToken($token)->get($url . "/pegawai/list");
            $data = $response->json();
            return $data;
        }

        $page_title = 'Pegawai';
        $page_description = 'Daftar Pegawai';
        $breadcumb = ['Daftar Pegawai'];
        $pangkat = Http::withToken($token)->get($url . "/pegawai/get-option-pangkat-golongan")->collect();
        $agama = Http::withToken($token)->get($url . "/pegawai/get-option-agama")->collect();
        $status_kawin = Http::withToken($token)->get($url . "/pegawai/get-option-status-kawin")->collect();
        $pendidikan = Http::withToken($token)->get($url . "/pegawai/get-option-pendidikan-terakhir")->collect();
        $status_pegawai = Http::withToken($token)->get($url . "/pegawai/get-option-status-pegawai")->collect();
        $eselon = Http::withToken($token)->get($url . "/pegawai/get-option-status-eselon")->collect();
        $jabatan_data = Http::withToken($token)->get($url . "/jabatan/list")->collect();
        $role = session()->get('user.role');

        $jabatan = collect($jabatan_data['data'])->filter(function ($item) use ($request) {
            // if($item['id'] == $request->session()->get('user_details.id_satuan_kerja')){
            if ($item['id_satuan_kerja'] == '1') {
                return $item;
            }
        })->values();
        // dd($jabatan);

        if ($role == 'super_admin') {
            $datadinas = Http::withToken($token)->get($url . "/satuan_kerja/list");
            $dinas = $datadinas->collect('data');
        } else {
            $dinas = session()->get('user_details.id_satuan_kerja');
            // $datadinas = Http::withToken($token)->get($url . "/satuan_kerja/show/" . session()->get('user.current.pegawai.id_satuan_kerja'));
            // $dinas = $datadinas->collect('data');
        }

        return view('pages.admin.pegawai.index', compact('page_title', 'page_description', 'breadcumb', 'dinas', 'pangkat', 'agama', 'status_kawin', 'pendidikan', 'status_pegawai', 'eselon', 'jabatan', 'jabatan_data', 'role'));
    }

    public function pegawaiBySatuankerja(Request $request)
    {
        $id_satuan_kerja = request('id_satuan_kerja');
        $jenis_kelamin = request('jenis_kelamin');
        $status_pernikahan = request('status_pernikahan');
        $agama = request('agama');
        $pendidikan = request('pendidikan');
        $gol_pangkat = request('gol_pangkat');

        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $data = array();

        $data = Http::withToken($token)->get($url . "/pegawai/listBySatuanKerja?id_satuan_kerja=$id_satuan_kerja&jenis_kelamin=$jenis_kelamin&status_pernikahan=$status_pernikahan&agama=$agama&pendidikan=$pendidikan&gol_pangkat=$gol_pangkat");

        return $data;
    }

    public function exportPegawai(Request $request)
    {
        $id_satuan_kerja = request('id_satuan_kerja');
        $jenis_kelamin = request('jenis_kelamin');
        $status_pernikahan = request('status_pernikahan');
        $agama = request('agama');
        $pendidikan = request('pendidikan');
        $gol_pangkat = request('gol_pangkat');

        $type = request('type');

        $url = env('API_URL');
        $token = session()->get('user.access_token');
        $data = array();
        $result = [];

        $data = Http::withToken($token)->get($url . "/pegawai/listBySatuanKerja?id_satuan_kerja=$id_satuan_kerja&jenis_kelamin=$jenis_kelamin&status_pernikahan=$status_pernikahan&agama=$agama&pendidikan=$pendidikan&gol_pangkat=$gol_pangkat");

        if ($id_satuan_kerja !== 'semua') {
            $satuan_kerja = $data['data'][0]['nama_satuan_kerja'];
        } else {
            $satuan_kerja = "Semua Unit Kerja";
        }


        $result = [
            'satuan_kerja' => $satuan_kerja,
            'jenis_kelamin' => $jenis_kelamin,
            'status_pernikahan' => $status_pernikahan,
            'agama' => $agama,
            'pendidikan' => $pendidikan,
            'gol_pangkat' => $gol_pangkat,
            'data' => $data['data'],
        ];

        return $this->printExportPegawai($result, $type);
    }

    public function printExportPegawai($result, $type)
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('BKPSDM BULUKUMBA')
            ->setLastModifiedBy('BKPSDM BULUKUMBA')
            ->setTitle('Laporan Daftar Pegawai')
            ->setSubject('Laporan Daftar Pegawai')
            ->setDescription('Laporan Daftar Pegawai')
            ->setKeywords('pdf php')
            ->setCategory('LAPORAN Daftar Pegawai');
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

        $sheet->setCellValue('A1', 'LAPORAN DAFTAR PEGAWAI')->mergeCells('A1:Q1');

        $sheet->setCellValue('A3', 'Unit Kerja')->mergeCells('A3:B3');
        $sheet->setCellValue('C3', ': ' . ucwords($result['satuan_kerja']))->mergeCells('C3:I3');
        $sheet->setCellValue('A4', 'Jenis Kelamin')->mergeCells('A4:B4');
        $sheet->setCellValue('C4', ': ' . ucwords($result['jenis_kelamin']))->mergeCells('C4:C4');
        $sheet->setCellValue('A5', 'Status Pernikahan')->mergeCells('A5:B5');
        $sheet->setCellValue('C5', ': ' . ucwords($result['status_pernikahan']))->mergeCells('C5:C5');
        $sheet->setCellValue('A6', 'Agama')->mergeCells('A6:B6');
        $sheet->setCellValue('C6', ': ' . ucwords($result['agama']))->mergeCells('C6:C6');
        $sheet->setCellValue('A7', 'Pendidikan')->mergeCells('A7:B7');
        $sheet->setCellValue('C7', ': ' . ucwords($result['pendidikan']))->mergeCells('C7:C7');
        $sheet->setCellValue('A8', 'Pangkat/Gol. Ruang')->mergeCells('A8:B8');
        $sheet->setCellValue('C8', ': ' . ucwords($result['gol_pangkat']))->mergeCells('C8:C8');


        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('P')->setWidth(30);

        $sheet->setCellValue('A9', 'NO.');
        $sheet->setCellValue('B9', 'NAMA')->mergeCells('B9:C9');
        $sheet->setCellValue('D9', 'NIP')->mergeCells('D9:E9');
        $sheet->setCellValue('F9', 'PANGKAT/GOL. RUANG')->mergeCells('F9:G9');
        $sheet->setCellValue('H9', 'TIPE JABATAN')->mergeCells('H9:I9');
        $sheet->setCellValue('J9', 'JENIS JABATAN')->mergeCells('J9:K9');
        $sheet->setCellValue('L9', 'AGAMA')->mergeCells('L9:M9');
        $sheet->setCellValue('N9', 'JENIS KELAMIN')->mergeCells('N9:O9');
        $sheet->setCellValue('P9', 'UNIT KERJA')->mergeCells('P9:Q9');


        $sheet->getStyle('A1')->getFont()->setSize(12);
        $sheet->getStyle('A1:Q8')->getFont()->setBold(true);
        $sheet->getStyle('A9:Q9')->getFont()->setBold(true);
        $sheet->getStyle('A1:Q1')->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A9:Q9')->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('A:Q')->getAlignment()->setWrapText(true);


        $cell = 10;

        if (count($result['data']) > 0) {

            foreach ($result['data'] as $key => $value) {
                $sheet->setCellValue('A' . $cell, $key + 1);
                $sheet->setCellValue('B' . $cell, $value['nama'])->mergeCells('B' . $cell . ':C' . $cell);
                $sheet->setCellValue('D' . $cell, "'" . $value['nip'])->mergeCells('D' . $cell . ':E' . $cell);
                $sheet->setCellValue('F' . $cell, $value['golongan'])->mergeCells('F' . $cell . ':G' . $cell);
                $sheet->setCellValue('H' . $cell, ucwords(strtolower($value['nama_jabatan'])))->mergeCells('H' . $cell . ':I' . $cell);
                $sheet->setCellValue('J' . $cell, $value['jenis_jabatan'])->mergeCells('J' . $cell . ':K' . $cell);
                $sheet->setCellValue('L' . $cell, ucwords(strtolower($value['agama'])))->mergeCells('L' . $cell . ':M' . $cell);
                $sheet->setCellValue('N' . $cell, ucwords(strtolower($value['jenis_kelamin'])))->mergeCells('N' . $cell . ':O' . $cell);
                $sheet->setCellValue('P' . $cell, $value['nama_satuan_kerja'])->mergeCells('P' . $cell . ':Q' . $cell);
                $cell++;
            }
        }


        $sheet->getStyle('A10:Q' . $cell)->getAlignment()->setVertical('center')->setHorizontal('center');
        $sheet->getStyle('B10:C' . $cell)->getAlignment()->setVertical('center')->setHorizontal('left');
        $sheet->getStyle('H10:I' . $cell)->getAlignment()->setVertical('center')->setHorizontal('left');
        $sheet->getStyle('P10:Q' . $cell)->getAlignment()->setVertical('center')->setHorizontal('left');

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A9:Q' . $cell)->applyFromArray($border);

        if ($type == 'excel') {
            // Untuk download 
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan Daftar Pegawai "' . ucwords($result['satuan_kerja']) . '".xlsx"');
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

    public function store(Request $request)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $data = $request->all();
        // return $data;
        if ($request->tempat_lahir != null && $request->tgl_lahir != null) {
            $data['tempat_tanggal_lahir'] = $request->tempat_lahir . ',' . $request->tgl_lahir;
        }
        $filtered = array_filter(
            $data,
            function ($key) {
                if (!in_array($key, ['_token', 'id'])) {
                    return $key;
                };
            },
            ARRAY_FILTER_USE_KEY
        );

        // return $filtered;

        $response = Http::withToken($token)->post($url . "/pegawai/store", $filtered);
        if ($response->successful()) {
            $data = $response->object();
            if (isset($data->status)) {
                return response()->json([
                    'success' => 'Berhasil Menambah Data',
                    'data' => $response->json()
                ]);
            } else {
                return response()->json(['invalid' => $response->json()]);
            }
        } else {
            return response()->json(['failed' => $response->json()]);
        }
    }

    public function show(Request $request, $id)
    {
        // return $id;
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->get($url . "/pegawai/show/" . $id);
        if ($response->successful()) {
            return array('success' => true, 'data' => $response->object()->data);
        } else {
            return response()->json(['failed' => $response->json()]);
        }
    }

    public function update(Request $request, $id)
    {
        // return $id;
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $data = $request->all();
        // return $data;
        // if ($request->tempat_lahir != null && $request->tgl_lahir != null) {
        //     $data['tempat_tanggal_lahir'] = $request->tempat_lahir.','.$request->tgl_lahir;
        // }
        $filtered = array_filter(
            $data,
            function ($key) {
                if (!in_array($key, ['_token', 'id'])) {
                    return $key;
                };
            },
            ARRAY_FILTER_USE_KEY
        );

        // $d

        $response = Http::withToken($token)->post($url . "/pegawai/update/" . $id, $filtered);
        if ($response->successful()) {
            $data = $response->object();
            if (isset($data->status)) {
                return response()->json([
                    'success' => 'Berhasil Menambah Data',
                    'data' => $response->json()
                ]);
            } else {
                return response()->json(['invalid' => $response->json()]);
            }
        } else {
            return $response->body();
            return response()->json(['failed' => $response->body()]);
        }
    }

    public function delete(Request $request, $id)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->delete($url . "/pegawai/delete/" . $id);
        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => $response->json()
            ]);
        }

        return response()->json(['error' => true]);
    }

    public function reset_password(Request $request, $id)
    {
        $url = env('API_URL');
        $token = $request->session()->get('user.access_token');
        $response = Http::withToken($token)->post($url . "/pegawai/reset-password/" . $id);

        // return $response;
        if ($response->successful()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => true]);
    }
}
