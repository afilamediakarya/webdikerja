@extends('layout.app')

@section('style')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .file {
            visibility: hidden;
            position: absolute;
        }
    </style>
@endsection



@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">

            <div class="col-md">

                <div class="row">
                    <div class="col-md-2">
                        <div class="card card-custom col-md" style="padding-left: 0px;padding-right: 0px;">
                            <div class="card-body" style="padding: 0px;">
                                <div id="kt_aside_menu_profile" class="col-md h-600px" data-menu-vertical="1"
                                    data-menu-scroll="1" data-menu-dropdown-timeout="500"
                                    style="padding-left: 0px; padding-right: 2px;">
                                    <ul class="nav nav-tabs nav-pills flex-row border-0 flex-md-column fs-6 pl-0"
                                        id="myTab" role="tablist">
                                        <li class="nav-item w-100 me-0 mr-0">
                                            <a class="nav-link w-100 btn btn-flex btn-active-light-success text-left active pl-2"
                                                id="personal-data-tab" data-toggle="tab" href="#personal-data"
                                                role="tab" aria-controls="personal-data" aria-selected="true">Data
                                                Pribadi</a>
                                        </li>
                                        <li class="nav-item w-100 me-0 mr-0">
                                            <a class="nav-link w-100 btn btn-flex btn-active-light-info text-left pl-2"
                                                id="pendidikan-tab" data-toggle="tab" href="#pendidikan" role="tab"
                                                aria-controls="pendidikan" aria-selected="false">Riwayat
                                                Pendidikan Formal</a>
                                        </li>
                                        <li class="nav-item w-100 me-0 mr-0">
                                            <a class="nav-link w-100 btn btn-flex btn-active-light-danger text-left pl-2"
                                                id="pendidikan-non-formal-tab" data-toggle="tab"
                                                href="#pendidikan_nonformal" role="tab"
                                                aria-controls="pendidikan-non-formal" aria-selected="false">Riwayat
                                                Pendidikan Non Formal</a>
                                        </li>
                                        <li class="nav-item w-100 me-0 mr-0">
                                            <a class="nav-link w-100 btn btn-flex btn-active-light-success text-left pl-2"
                                                id="kepangkatan-tab" data-toggle="tab" href="#kepangkatan" role="tab"
                                                aria-controls="kepangkatan" aria-selected="false">Riwayat
                                                Kepangkatan</a>
                                        </li>
                                        <li class="nav-item w-100 me-0 mr-0">
                                            <a class="nav-link w-100 btn btn-flex btn-active-light-success text-left pl-2"
                                                id="jabatan-tab" data-toggle="tab" href="#jabatan" role="tab"
                                                aria-controls="jabatan" aria-selected="false">Riwayat
                                                Jabatan</a>
                                        </li>
                                        {{-- <li class="nav-item w-100 me-0">
                                            <a class="nav-link w-100 btn btn-flex btn-active-light-success text-left"
                                                id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                                aria-controls="contact" aria-selected="false">Catatan
                                                Hukdis</a>
                                        </li>
                                        <li class="nav-item w-100 me-0">
                                            <a class="nav-link w-100 btn btn-flex btn-active-light-success text-left"
                                                id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                                aria-controls="contact" aria-selected="false">Riwayat Diklat
                                                Struktural</a>
                                        </li>
                                        <li class="nav-item w-100 me-0">
                                            <a class="nav-link w-100 btn btn-flex btn-active-light-success text-left"
                                                id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                                aria-controls="contact" aria-selected="false">Riwayat Diklat
                                                Fungsional</a>
                                        </li>
                                        <li class="nav-item w-100 me-0">
                                            <a class="nav-link w-100 btn btn-flex btn-active-light-success text-left"
                                                id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                                aria-controls="contact" aria-selected="false">Riwayat Diklat
                                                Teknis</a>
                                        </li>
                                        <li class="nav-item w-100 me-0">
                                            <a class="nav-link w-100 btn btn-flex btn-active-light-success text-left"
                                                id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                                aria-controls="contact" aria-selected="false">Riwayat
                                                Penghargaan</a>
                                        </li>
                                        <li class="nav-item w-100 me-0">
                                            <a class="nav-link w-100 btn btn-flex btn-active-light-success text-left"
                                                id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                                aria-controls="contact" aria-selected="false">Istri/Suami</a>
                                        </li>
                                        <li class="nav-item w-100 me-0">
                                            <a class="nav-link w-100 btn btn-flex btn-active-light-success text-left"
                                                id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                                aria-controls="contact" aria-selected="false">Anak</a>
                                        </li>
                                        <li class="nav-item w-100 me-0">
                                            <a class="nav-link w-100 btn btn-flex btn-active-light-success text-left"
                                                id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                                aria-controls="contact" aria-selected="false">Orang
                                                Tua</a>
                                        </li>
                                        <li class="nav-item w-100 me-0">
                                            <a class="nav-link w-100 btn btn-flex btn-active-light-success text-left"
                                                id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                                aria-controls="contact" aria-selected="false">Saudara</a>
                                        </li>
                                        <li class="nav-item w-100 me-0">
                                            <a class="nav-link w-100 btn btn-flex btn-active-light-success text-left"
                                                id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                                aria-controls="contact" aria-selected="false">Riwayat
                                                Tambahan</a>
                                        </li>
                                        <li class="nav-item w-100 me-0">
                                            <a class="nav-link w-100 btn btn-flex btn-active-light-success text-left"
                                                id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                                aria-controls="contact" aria-selected="false">File
                                                Pegawai</a>
                                        </li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-3 -->
                    <div class="col-md-10">
                        <div class="tab-content" id="myTabContent">

                            {{-- Begin Personal data --}}
                            <div class="tab-pane fade show active ml-3" id="personal-data" role="tabpanel"
                                aria-labelledby="personal-data-tab">
                                <div class="row mb-3">
                                    <div class="card card-custom col-md">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2 class="card-label">Data Pribadi</h2>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="container" style="height: 480px;">

                                                <div class="d-flex align-items-center">

                                                    <div class="image">
                                                        <img src="{{ asset('media/svg/avatars/001-boy.svg') }}"
                                                            class="img-thumbnail rounded" width="150"
                                                            style="margin-left: -13px">
                                                    </div>

                                                    <div class="ml-3 w-100 d-flex flex-column">
                                                        <h4 class="mb-0 mt-0">{{ $personalData['nama'] }}</h4>
                                                        <span>NIP : {{ $personalData['nip'] }}</span>
                                                        <span>{{ $personalData['nama_jabatan'] }}</span>
                                                        <span>{{ $personalData['nama_satuan_kerja'] }}</span>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <table class="table table-striped table-row-bordered gy-5 gs-7"
                                                            id="" style="margin-top: 13px !important">

                                                            <tr>
                                                                <th>Tempat, Tanggal lahir</th>
                                                                <td>{{ $personalData['tempat_lahir'] }},
                                                                    {{ date('d-m-Y', strtotime($personalData['tanggal_lahir'])) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Jenis Kelamin</th>
                                                                <td>{{ $personalData['jenis_kelamin'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Status Pernikahan</th>
                                                                <td>{{ $personalData['status_perkawinan'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Agama</th>
                                                                <td>{{ $personalData['agama'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Pendidikan</th>
                                                                <td>{{ $personalData['pendidikan'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Jurusan</th>
                                                                <td>{{ $personalData['jurusan'] }}</td>
                                                            </tr>
                                                            <tbody>


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <table class="table table-striped table-row-bordered gy-5 gs-7"
                                                            id="" style="margin-top: 13px !important">
                                                            <tr>
                                                                <th>Tahun Lulus</th>
                                                                <td>{{ $personalData['lulus_pendidikan'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Pendidikan Struktural</th>
                                                                <td>{{ $personalData['pendidikan_struktural'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tahun Lulus Pendidikan Struktural</th>
                                                                <td>{{ $personalData['lulus_pendidikan_struktural'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Golongan Pangkat</th>
                                                                <td>{{ $personalData['golongan'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>TMT Golongan</th>
                                                                <td>{{ date('d-m-Y', strtotime($personalData['tmt_golongan'])) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>TMT Pegawai</th>
                                                                <td>{{ date('d-m-Y', strtotime($personalData['tmt_pegawai'])) }}
                                                                </td>
                                                            </tr>
                                                            <tbody>


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-striped table-row-bordered gy-5 gs-7" id=""
                                            style="margin-top: 13px !important">

                                            <tr>
                                                <th>Tempat, Tanggal lahir</th>
                                                <td>{{ $personalData['tempat_lahir'] }},
                                                    {{ date('d-m-Y', strtotime($personalData['tanggal_lahir'])) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Jenis Kelamin</th>
                                                <td>{{ $personalData['jenis_kelamin'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status Pernikahan</th>
                                                <td>{{ $personalData['status_perkawinan'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Agama</th>
                                                <td>{{ $personalData['agama'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Pendidikan</th>
                                                <td>{{ $personalData['pendidikan'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Jurusan</th>
                                                <td>{{ $personalData['jurusan'] }}</td>
                                            </tr>
                                            <tbody>


                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-striped table-row-bordered gy-5 gs-7" id=""
                                            style="margin-top: 13px !important">
                                            <tr>
                                                <th>Tahun Lulus</th>
                                                <td>{{ $personalData['lulus_pendidikan'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Pendidikan Struktural</th>
                                                <td>{{ $personalData['pendidikan_struktural'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tahun Lulus Pendidikan Struktural</th>
                                                <td>{{ $personalData['lulus_pendidikan_struktural'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Golongan Pangkat</th>
                                                <td>{{ $personalData['golongan'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>TMT Golongan</th>
                                                <td>{{ date('d-m-Y', strtotime($personalData['tmt_golongan'])) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>TMT Pegawai</th>
                                                <td>{{ date('d-m-Y', strtotime($personalData['tmt_pegawai'])) }}
                                                </td>
                                            </tr>
                                            <tbody>


                                            </tbody>
                                        </table>
                                    </div>
                                </div> --}}
                            </div>
                            {{-- Begin Personal data --}}

                            {{-- Begin pendidikan formal --}}
                            <div class="tab-pane fade show ml-3" id="pendidikan" role="tabpanel"
                                aria-labelledby="profile-tab">
                                <div class="row mb-3">

                                    <div class="card card-custom col-md">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h3 class="card-label">Riwayat Pendidikan Formal</h3>
                                            </div>
                                            <div class="card-toolbar">
                                                <button {{-- onclick="PanelForm.action('show','submit')" --}} class="btn btn-primary font-weight-bolder"
                                                    id="formal_button">
                                                    <span class="svg-icon">
                                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect fill="#000000" x="4" y="11"
                                                                    width="16" height="2" rx="1" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) "
                                                                    x="4" y="11" width="16"
                                                                    height="2" rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    Tambah Data
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body" style="height: 530px;">
                                            <table class="table table-striped table-row-bordered gy-5 gs-7"
                                                id="table-pendidikan-formal" style="margin-top: 13px !important">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">Tingkat Pendidikan</th>
                                                        <th rowspan="2">Fakultas</th>
                                                        <th rowspan="2">Jurusan</th>
                                                        <th colspan="3">STTB/Ijazah</th>
                                                        <th colspan="2">Sekolah/Perguruan Tinggi</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Nomor</th>
                                                        <th>Tanggal</th>
                                                        <th>Nama Kepala Sekolah/Rektor</th>
                                                        <th>Nama</th>
                                                        <th>Lokasi (Kab./Kota)</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{-- End pendidikan formal --}}

                            {{-- Begin pendidikan non-formal --}}
                            <div class="tab-pane fade show ml-3" id="pendidikan_nonformal" role="tabpanel"
                                aria-labelledby="profile-tab">
                                <div class="row mb-3">

                                    <div class="card card-custom col-md">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h3 class="card-label">Riwayat Pendidikan Non Formal</h3>
                                            </div>
                                            <div class="card-toolbar">
                                                <button {{-- onclick="KTLayoutDemoPanelForm.action('show','submit')" --}} class="btn btn-primary font-weight-bolder"
                                                    id="nonformal_button">
                                                    <span class="svg-icon">
                                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect fill="#000000" x="4" y="11"
                                                                    width="16" height="2" rx="1" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) "
                                                                    x="4" y="11" width="16"
                                                                    height="2" rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    Tambah Data
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body" style="height: 530px;">
                                            <table class="table table-striped table-row-bordered gy-5 gs-7"
                                                id="table_nonformal" style="margin-top: 13px !important">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">Nama Kursus/Seminar/Lokakarya</th>
                                                        <th colspan="2">Tanggal</th>
                                                        <th colspan="3">Ijazah/Tanda Lulus/Surat Keterangan</th>
                                                        <th rowspan="2">Instansi Penyelenggara</th>
                                                        <th rowspan="2">Tempat</th>
                                                        <th rowspan="2">Action</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Mulai</th>
                                                        <th>Selesai</th>
                                                        <th>Nomor</th>
                                                        <th>Tanggal</th>
                                                        <th>Nama Pejabat</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{-- End pendidikan non-formal --}}

                            {{-- Begin kepangkatan --}}
                            <div class="tab-pane fade show ml-3" id="kepangkatan" role="tabpanel"
                                aria-labelledby="profile-tab">
                                <div class="row mb-3">

                                    <div class="card card-custom col-md">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h3 class="card-label">Riwayat Kepangkatan</h3>
                                            </div>
                                            <div class="card-toolbar">
                                                <button {{-- onclick="KTLayoutDemoPanelForm.action('show','submit')" --}} class="btn btn-primary font-weight-bolder"
                                                    id="kepangkatan_button">
                                                    <span class="svg-icon">
                                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect fill="#000000" x="4" y="11"
                                                                    width="16" height="2" rx="1" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) "
                                                                    x="4" y="11" width="16"
                                                                    height="2" rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    Tambah Data
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body" style="height: 530px;">
                                            <table class="table table-striped table-row-bordered gy-5 gs-7"
                                                id="table_kepangkatan" style="margin-top: 13px !important">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">Gol. Ruang</th>
                                                        <th colspan="3">Masa Kerja</th>
                                                        <th colspan="3">Surat Keputusan</th>
                                                        <th rowspan="2">TMT</th>
                                                        <th rowspan="2">Unit Kerja</th>
                                                        <th rowspan="2">Action</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Tahun</th>
                                                        <th>Bulan</th>
                                                        <th>Gaji Pokok</th>
                                                        <th>Nomor</th>
                                                        <th>Tanggal</th>
                                                        <th>Jabatan Penandatanganan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{-- End kepangkatan --}}

                            {{-- Begin jabatan --}}
                            <div class="tab-pane fade show ml-3" id="jabatan" role="tabpanel"
                                aria-labelledby="profile-tab">
                                <div class="row mb-3">

                                    <div class="card card-custom col-md">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h3 class="card-label">Riwayat Jabatan</h3>
                                            </div>
                                            <div class="card-toolbar">
                                                <button {{-- onclick="KTLayoutDemoPanelForm.action('show','submit')" --}} class="btn btn-primary font-weight-bolder"
                                                    id="jabatan_button">
                                                    <span class="svg-icon">
                                                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect fill="#000000" x="4" y="11"
                                                                    width="16" height="2" rx="1" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) "
                                                                    x="4" y="11" width="16"
                                                                    height="2" rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    Tambah Data
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body" style="height: 530px;">
                                            <table class="table table-striped table-row-bordered gy-5 gs-7"
                                                id="table_jabatan" style="margin-top: 13px !important">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">Nama Jabatan</th>
                                                        <th colspan="4">Surat Keputusan</th>
                                                        <th rowspan="2">TMT</th>
                                                        <th rowspan="2">Unit Kerja</th>
                                                        <th rowspan="2">Action</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Gol. Ruang</th>
                                                        <th>Nomor</th>
                                                        <th>Tanggal</th>
                                                        <th>Pejabat Penandatanganan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{-- End kepangkatan --}}

                        </div>
                    </div>
                    <!-- /.col-md-9 -->
                </div>

            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection

@section('side-form')
    {{-- side form pendidikan formal --}}
    <div id="formal_create" class="offcanvas offcanvas-right p-10">
        <!--begin::Header-->
        <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
            <h3 class="font-weight-bold m-0">Tambah Pendidikan Formal<h3>
                    <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="side_form_close">
                        <i class="ki ki-close icon-xs text-muted"></i>
                    </a>
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="offcanvas-content pr-5 mr-n5">
            <form class="form formal_form" id="formal_form" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" />
                <input type="hidden" name="id_pegawai" value="{{ $personalData['id'] }}" />
                <input type="hidden" name="jenis_pendidikan" value="formal" />
                <input type="hidden" name="document" />

                <div class="form-group">
                    <label>Tingkat Pendidikan</label>
                    <select class="form-control form-control-solid" type="text" id="id_pendidikan"
                        name="id_pendidikan">
                        <option disabled selected> Pilih Tingkat Pendidikan </option>
                        @foreach ($listPendidikan as $key => $value)
                            <option value="{{ $value['id'] }}">{{ $value['nama_pendidikan'] }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Fakultas</label>
                    <small class="">Isi dengan tanda -, jika tingkat pendidikan tidak mempunyai
                        fakultas</small>
                    <input class="form-control form-control-solid" type="text" name="fakultas" value="-" />
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Jurusan</label>
                    <small class="">Isi dengan tanda -, jika tingkat pendidikan tidak mempunyai
                        fakultas</small>
                    <input class="form-control form-control-solid" type="text" name="jurusan" value="-" />
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Nomor Ijazah</label>
                    <input class="form-control form-control-solid" type="text" name="nomor_ijazah" />
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Tanggal Ijazah Ijazah</label>
                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" id="tanggal_ijazah"
                        name="tanggal_ijazah">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Nama Kepala Sekolah/Rektor</label>
                    <input class="form-control form-control-solid" type="text" name="nama_kepala_sekolah" />
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Nama Sekolah/Perguruan Tinggi</label>
                    <input class="form-control form-control-solid" type="text" name="nama_sekolah" />
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Alamat Sekolah/Perguruan Tinggi</label>
                    <input class="form-control form-control-solid" type="text" name="alamat_sekolah" />
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Foto Ijzah</label>
                    <input class="form-control" type="file" id="foto_ijazah" name="foto_ijazah">
                    <div class="invalid-feedback"></div>

                    <div class="ml-2 col-sm-6">
                        <img src="" id="document_formal" class="mt-3 img-thumbnail">
                    </div>

                </div>

                <div class="separator separator-dashed mt-8 mb-5"></div>
                <div class="">
                    <button type="reset" class="btn btn-outline-primary mr-2 btn-cancel">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>

            <!--begin::Separator-->
            <!--end::Separator-->
        </div>
        <!--end::Content-->
    </div>

    {{-- side form pendidikan non formal --}}
    <div id="nonformal_create" class="offcanvas offcanvas-right p-10">
        <!--begin::Header-->
        <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
            <h3 class="font-weight-bold m-0">Tambah Pendidikan Non Formal<h3>
                    <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="side_form_close">
                        <i class="ki ki-close icon-xs text-muted"></i>
                    </a>
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="offcanvas-content pr-5 mr-n5">
            <form class="form nonformal_form" id="nonformal_form" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" />
                <input type="hidden" name="id_pegawai" value="{{ $personalData['id'] }}" />
                <input type="hidden" name="jenis_pendidikan" value="nonformal" />
                <input type="hidden" name="document" />

                <div class="form-group">
                    <label>Nama Kursus/Seminar/Lokakarya</label>
                    <input class="form-control form-control-solid" type="text" name="nama_kursus" />
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="tanggal_mulai">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Tanggal Akhir</label>
                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="tanggal_akhir">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Nomor Ijazah</label>
                    <input class="form-control form-control-solid" type="text" name="nomor_ijazah" />
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Tanggal Ijazah</label>
                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="tanggal_ijazah">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Nama Pejabat</label>
                    <input class="form-control form-control-solid" type="text" name="nama_pejabat" />
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Instansi Penyelenggara</label>
                    <input class="form-control form-control-solid" type="text" name="instansi_penyelenggara" />
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Tempat</label>
                    <input class="form-control form-control-solid" type="text" name="tempat" />
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Document Ijazah/Sertifikat/Lainnya</label>
                    <input class="form-control" type="file" id="foto_ijazah" name="foto_ijazah">
                    <div class="invalid-feedback"></div>

                    <div class="ml-2 col-sm-6">
                        <img src="" id="document_nonformal" class="mt-3 img-thumbnail">
                    </div>

                </div>

                <div class="separator separator-dashed mt-8 mb-5"></div>
                <div class="">
                    <button type="reset" class="btn btn-outline-primary mr-2 btn-cancel">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>

            <!--begin::Separator-->
            <!--end::Separator-->
        </div>
        <!--end::Content-->
    </div>

    {{-- side form kepangkatan --}}
    <div id="kepangkatan_create" class="offcanvas offcanvas-right p-10">
        <!--begin::Header-->
        <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
            <h3 class="font-weight-bold m-0">Tambah Kepangkatan<h3>
                    <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="side_form_close">
                        <i class="ki ki-close icon-xs text-muted"></i>
                    </a>
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="offcanvas-content pr-5 mr-n5">
            <form class="form" id="kepangkatan_form" class="kepangkatan_form" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" />
                <input type="hidden" name="id_pegawai" value="{{ $personalData['id'] }}" />
                <input type="hidden" name="document" />

                <div class="form-group">
                    <label>Gol. Ruang</label>
                    <select class="form-control form-control-solid" type="text" id="id_golongan" name="id_golongan">
                        <option disabled selected> Pilih Gol. Ruang </option>
                        @foreach ($listGolongan as $key => $value)
                            <option value="{{ $value['id'] }}">{{ $value['nama_golongan'] }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Tahun</label>
                    <div class="input-group date">
                        <input type="text" class="form-control" readonly id="tahun_kerja" name="tahun_kerja" />
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar-check-o"></i>
                            </span>
                        </div>
                    </div>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Bulan</label>
                    <div class="input-group date">
                        <input type="text" class="form-control" readonly id="bulan_kerja" name="bulan_kerja" />
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar-check-o"></i>
                            </span>
                        </div>
                    </div>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Gaji Pokok</label>
                    <input type='text' class="form-control" id="gaji_pokok" name="gaji_pokok" type="text" />
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Nomor SK</label>
                    <input class="form-control form-control-solid" type="text" name="nomor_sk" />
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Tanggal SK</label>
                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" id="tanggal_sk"
                        name="tanggal_sk">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Pejabat Penandatanganan</label>
                    <input class="form-control form-control-solid" type="text" name="nama_pejabat" />
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>TMT</label>
                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" id="tmt"
                        name="tmt">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Unit Kerja</label>
                    <select class="form-control form-control-solid" type="text" id="id_satuan_kerja"
                        name="id_satuan_kerja">
                        <option disabled selected> Pilih Unit Kerja </option>
                        @foreach ($listUnitkerja as $key => $value)
                            <option value="{{ $value['id'] }}">{{ $value['nama_satuan_kerja'] }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Document</label>
                    <input class="form-control" type="file" id="sk_pangkat" name="sk_pangkat">
                    <div class="invalid-feedback"></div>

                    <div class="ml-2 col-sm-6">
                        <img src="" id="document_kepangkatan" class="mt-3 img-thumbnail">
                    </div>

                </div>

                <div class="separator separator-dashed mt-8 mb-5"></div>
                <div class="">
                    <button type="reset" class="btn btn-outline-primary mr-2 btn-cancel">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>

            <!--begin::Separator-->
            <!--end::Separator-->
        </div>
        <!--end::Content-->
    </div>

    {{-- side form jabatan --}}
    <div id="jabatan_create" class="offcanvas offcanvas-right p-10">
        <!--begin::Header-->
        <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
            <h3 class="font-weight-bold m-0">Tambah Jabatan<h3>
                    <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="side_form_close">
                        <i class="ki ki-close icon-xs text-muted"></i>
                    </a>
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="offcanvas-content pr-5 mr-n5">
            <form class="form" id="jabatan_form" class="jabatan_form" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" />
                <input type="hidden" name="id_pegawai" value="{{ $personalData['id'] }}" />
                <input type="hidden" name="document" />

                <div class="form-group">
                    <label>Nama Jabatan</label>
                    <input class="form-control form-control-solid" type="text" name="nama_jabatan" />
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Gol. Ruang</label>
                    <select class="form-control form-control-solid" type="text" id="id_golongan" name="id_golongan">
                        <option disabled selected> Pilih Gol. Ruang </option>
                        @foreach ($listGolongan as $key => $value)
                            <option value="{{ $value['id'] }}">{{ $value['nama_golongan'] }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Nomor SK</label>
                    <input class="form-control form-control-solid" type="text" name="nomor_sk" />
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Tanggal SK</label>
                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" id="tanggal_sk"
                        name="tanggal_sk">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Pejabat Penandatanganan</label>
                    <input class="form-control form-control-solid" type="text" name="nama_pejabat" />
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>TMT</label>
                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control" id="tmt"
                        name="tmt">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Unit Kerja</label>
                    <select class="form-control form-control-solid" type="text" id="id_satuan_kerja"
                        name="id_satuan_kerja">
                        <option disabled selected> Pilih Unit Kerja </option>
                        @foreach ($listUnitkerja as $key => $value)
                            <option value="{{ $value['id'] }}">{{ $value['nama_satuan_kerja'] }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label>Document</label>
                    <input class="form-control" type="file" id="sk_jabatan" name="sk_jabatan">
                    <div class="invalid-feedback"></div>

                    <div class="ml-2 col-sm-6">
                        <img src="" id="document_jabatan" class="mt-3 img-thumbnail">
                    </div>

                </div>

                <div class="separator separator-dashed mt-8 mb-5"></div>
                <div class="">
                    <button type="reset" class="btn btn-outline-primary mr-2 btn-cancel">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>

            <!--begin::Separator-->
            <!--end::Separator-->
        </div>
        <!--end::Content-->
    </div>
@endsection


@section('script')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="//cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script>
    <script>
        "use strict";

        var PanelForm = function() {
            // Private properties
            var _element;
            var _offcanvasObject;
            var _form;

            // Private functions
            var _init = function() {
                var header = KTUtil.find(_element, '.offcanvas-header');
                var content = KTUtil.find(_element, '.offcanvas-content');

                _offcanvasObject = new KTOffcanvas(_element, {
                    overlay: true,
                    baseClass: 'offcanvas',
                    placement: 'right',
                    closeBy: 'side_form_close',
                    toggleBy: ''
                });

                KTUtil.scrollInit(content, {
                    disableForMobile: true,
                    resetHeightOnDestroy: true,
                    handleWindowResize: true,
                    height: function() {
                        var height = parseInt(KTUtil.getViewPort().height);

                        if (header) {
                            height = height - parseInt(KTUtil.actualHeight(header));
                            height = height - parseInt(KTUtil.css(header, 'marginTop'));
                            height = height - parseInt(KTUtil.css(header, 'marginBottom'));
                        }

                        if (content) {
                            height = height - parseInt(KTUtil.css(content, 'marginTop'));
                            height = height - parseInt(KTUtil.css(content, 'marginBottom'));
                        }

                        height = height - parseInt(KTUtil.css(_element, 'paddingTop'));
                        height = height - parseInt(KTUtil.css(_element, 'paddingBottom'));

                        height = height - 2;

                        return height;
                    }
                });
            }

            // Public methods
            return {
                init: function(id) {
                    // console.log($(`#${id}`));
                    // console.log($(`#${id}`).find('form'));
                    _form = $(`#${id}`).find('form');
                    _element = KTUtil.getById(id);

                    if (!_element) {
                        return;
                    }

                    // Initialize
                    _init();
                },

                action: function(data, type = null) {
                    if (data == 'show') {
                        _form[0].reset();
                        $("input").removeClass('is-invalid');
                        $("select").removeClass('is-invalid');
                        $("textarea").removeClass('is-invalid');
                        _offcanvasObject.show();
                    } else if (data == 'hide') {
                        _offcanvasObject.hide();
                    }
                    _form.attr('data-type', type);

                },
                getElement: function() {
                    return _element;
                }
            };
        }();

        var inputFile = function(id) {

            return {
                init: function(id) {
                    $('input[type="file"]').change(function(e) {
                        var fileName = e.target.files[0].name;
                        $("#file").val(fileName);

                        var reader = new FileReader();
                        reader.onload = function(e) {
                            // get loaded data and render thumbnail.
                            document.getElementById(id).src = e.target.result;
                        };
                        // read the image file as a data URL.
                        reader.readAsDataURL(this.files[0]);
                    });
                },
            }


        }();

        var dataRow = function() {
            var init = function() {
                let table = $('#table-pendidikan-formal');
                table.DataTable({
                    dom: 'tr',
                    processing: true,
                    scrollY: "300px",
                    scrollX: true,
                    scrollCollapse: true,
                    // order: [
                    //     [0, 'asc']
                    // ],
                    ajax: "{{ route('list-pendidikan-formal') }}",
                    columns: [{
                            data: 'nama_pendidikan'
                        },
                        {
                            data: 'fakultas'
                        },
                        {
                            data: 'jurusan'
                        },
                        {
                            data: 'nomor_ijazah'
                        },
                        {
                            data: 'tanggal_ijazah',
                            render: function(data, type, row) {
                                if (type === "sort" || type === "type") {
                                    return data;
                                }
                                return moment(data).format("MM-DD-YYYY");
                            }
                        },
                        {
                            data: 'nama_kepala_sekolah'
                        },
                        {
                            data: 'nama_sekolah'
                        },
                        {
                            data: 'alamat_sekolah'
                        },
                        {
                            data: 'id'
                        }
                    ],
                    columnDefs: [{
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        width: '10rem',
                        class: "wrapok",
                        render: function(data, type, row, full, meta) {
                            return `
                        <a role="button" href="javascript:;" type="button" data-id="${row.id}" class="btn btn-warning btn-sm formal_update">Ubah</a>
                        <button type="button" class="btn btn-danger btn-sm btn-delete formal_delete" data-id="${row.id}">Hapus</button>
                        `;
                        },
                    }],
                });

            };

            var destroy = function() {
                var table = $('#table-pendidikan-formal').DataTable();
                table.destroy();
            };

            return {
                init: function() {
                    init();
                },
                destroy: function() {
                    destroy();
                }

            };
        }();

        var dataRowNonformal = function() {
            var init = function() {
                let table = $('#table_nonformal');
                table.DataTable({
                    dom: 'tr',
                    processing: true,
                    scrollY: "300px",
                    scrollX: true,
                    scrollCollapse: true,
                    // order: [
                    //     [0, 'asc']
                    // ],
                    ajax: "{{ route('list-pendidikan-nonformal') }}",
                    columns: [{
                            data: 'nama_kursus'
                        },
                        {
                            data: 'tanggal_mulai',
                            render: function(data, type, row) {
                                if (type === "sort" || type === "type") {
                                    return data;
                                }
                                return moment(data).format("MM-DD-YYYY");
                            }
                        },
                        {
                            data: 'tanggal_akhir',
                            render: function(data, type, row) {
                                if (type === "sort" || type === "type") {
                                    return data;
                                }
                                return moment(data).format("MM-DD-YYYY");
                            }
                        },
                        {
                            data: 'nomor_ijazah'
                        },
                        {
                            data: 'tanggal_ijazah',
                            render: function(data, type, row) {
                                if (type === "sort" || type === "type") {
                                    return data;
                                }
                                return moment(data).format("MM-DD-YYYY");
                            }
                        },
                        {
                            data: 'nama_pejabat'
                        },
                        {
                            data: 'instansi_penyelenggara'
                        },
                        {
                            data: 'tempat'
                        },
                        {
                            data: 'id'
                        }
                    ],
                    columnDefs: [{
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        width: '10rem',
                        class: "wrapok",
                        render: function(data, type, row, full, meta) {
                            return `
                        <a role="button" href="javascript:;" type="button" data-id="${row.id}" class="btn btn-warning btn-sm nonformal_update">Ubah</a>
                        <button type="button" class="btn btn-danger btn-sm btn-delete nonformal_delete" data-id="${row.id}">Hapus</button>
                        `;
                        },
                    }],
                });

            };

            var destroy = function() {
                var table = $('#table_nonformal').DataTable();
                table.destroy();
            };

            return {
                init: function() {
                    init();
                },
                destroy: function() {
                    destroy();
                }

            };
        }();

        var dataRowKepangkatan = function() {
            var init = function() {
                let table = $('#table_kepangkatan');
                table.DataTable({
                    dom: 'tr',
                    processing: true,
                    scrollY: "300px",
                    scrollX: true,
                    scrollCollapse: true,
                    // order: [
                    //     [0, 'asc']
                    // ],
                    ajax: "{{ route('list-kepangkatan') }}",
                    columns: [{
                            data: 'nama_golongan'
                        },
                        {
                            data: 'tahun_kerja'
                        },
                        {
                            data: 'bulan_kerja',
                            render: function(data, type, row) {
                                var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei',
                                    'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
                                    'November', 'Desember'
                                ];
                                return months[data - 1];
                            }
                        },
                        {
                            data: 'gaji_pokok',
                            render: function(data, type, row) {
                                return 'Rp.' + data.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g,
                                    "$1,");
                            }
                        },
                        {
                            data: 'nomor_sk'
                        },
                        {
                            data: 'tanggal_sk',
                            render: function(data, type, row) {
                                if (type === "sort" || type === "type") {
                                    return data;
                                }
                                return moment(data).format("MM-DD-YYYY");
                            }
                        },
                        {
                            data: 'nama_pejabat'
                        },
                        {
                            data: 'tmt',
                            render: function(data, type, row) {
                                if (type === "sort" || type === "type") {
                                    return data;
                                }
                                return moment(data).format("MM-DD-YYYY");
                            }
                        },
                        {
                            data: 'nama_satuan_kerja'
                        },
                        {
                            data: 'id'
                        }
                    ],
                    columnDefs: [{
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        width: '10rem',
                        class: "wrapok",
                        render: function(data, type, row, full, meta) {
                            return `
                        <a role="button" href="javascript:;" type="button" data-id="${row.id}" class="btn btn-warning btn-sm kepangkatan_update">Ubah</a>
                        <button type="button" class="btn btn-danger btn-sm btn-delete kepangkatan_delete" data-id="${row.id}">Hapus</button>
                        `;
                        },
                    }],
                });

            };

            var destroy = function() {
                var table = $('#table_kepangkatan').DataTable();
                table.destroy();
            };

            return {
                init: function() {
                    init();
                },
                destroy: function() {
                    destroy();
                }

            };
        }();

        var dataRowJabatan = function() {
            var init = function() {
                let table = $('#table_jabatan');
                table.DataTable({
                    dom: 'tr',
                    processing: true,
                    scrollY: "300px",
                    scrollX: true,
                    scrollCollapse: true,
                    // order: [
                    //     [0, 'asc']
                    // ],
                    ajax: "{{ route('list-jabatan') }}",
                    columns: [{
                            data: 'nama_jabatan'
                        },
                        {
                            data: 'nama_golongan'
                        },
                        {
                            data: 'nomor_sk'
                        },
                        {
                            data: 'tanggal_sk',
                            render: function(data, type, row) {
                                if (type === "sort" || type === "type") {
                                    return data;
                                }
                                return moment(data).format("MM-DD-YYYY");
                            }
                        },
                        {
                            data: 'nama_pejabat'
                        },
                        {
                            data: 'tmt',
                            render: function(data, type, row) {
                                if (type === "sort" || type === "type") {
                                    return data;
                                }
                                return moment(data).format("MM-DD-YYYY");
                            }
                        },
                        {
                            data: 'nama_satuan_kerja'
                        },
                        {
                            data: 'id'
                        }
                    ],
                    columnDefs: [{
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        width: '10rem',
                        class: "wrapok",
                        render: function(data, type, row, full, meta) {
                            return `
                        <a role="button" href="javascript:;" type="button" data-id="${row.id}" class="btn btn-warning btn-sm jabatan_update">Ubah</a>
                        <button type="button" class="btn btn-danger btn-sm btn-delete jabatan_delete" data-id="${row.id}">Hapus</button>
                        `;
                        },
                    }],
                });

            };

            var destroy = function() {
                var table = $('#table_jabatan').DataTable();
                table.destroy();
            };

            return {
                init: function() {
                    init();
                },
                destroy: function() {
                    destroy();
                }

            };
        }();

        // trigger button add data
        $(document).on('click', '#formal_button', function() {
            PanelForm.init('formal_create');
            PanelForm.action('show', 'submit');
            $('#document_formal').attr("src", null);
            inputFile.init('document_formal');
        });
        $(document).on('click', '#nonformal_button', function() {
            PanelForm.init('nonformal_create');
            PanelForm.action('show', 'submit');
            $('#document_nonformal').attr("src", null);
            inputFile.init('document_nonformal');
        });
        $(document).on('click', '#kepangkatan_button', function() {
            PanelForm.init('kepangkatan_create');
            PanelForm.action('show', 'submit');
            $('#document_kepangkatan').attr("src", null);
            inputFile.init('document_kepangkatan');
        });
        $(document).on('click', '#jabatan_button', function() {
            PanelForm.init('jabatan_create');
            PanelForm.action('show', 'submit');
            $('#document_jabatan').attr("src", null);
            inputFile.init('document_jabatan');
        });
        // end trigger button add data


        // process pendidikan formal
        $(document).on('submit', "#formal_form[data-type='submit']", function(e) {
            e.preventDefault();

            var form = document.querySelector('form');
            var formData = new FormData(this);

            AxiosCall.add_pendidikan_formal("{{ route('add-pendidikan-formal') }}", formData,
                "#formal_form");
        });
        $(document).on('click', '.formal_update', function() {

            PanelForm.init('formal_create');
            PanelForm.action('show', 'update');
            var key = $(this).data('id');
            console.log(key);

            $.ajax({
                url: `profile/pendidikan-formal/${key}`,
                method: "GET",
                success: function(data) {
                    let result = JSON.parse(data);

                    if (result.status) {
                        var res = result.data;

                        $.each(res, function(key, value) {

                            $("select[name='" + key + "']").val(value);
                            $("input[name='" + key + "']").val(value);
                            $(`#${key}`).attr("src",
                                `{{ asset('storage/${value}') }}`);
                        });
                    }
                }
            });
        })
        $(document).on('submit', "#formal_form[data-type='update']", function(e) {
            e.preventDefault();
            console.log($(this));

            var _id = $("input[name='id']").val();
            var form = document.querySelector('form');
            var formData = new FormData(this);

            AxiosCall.update_pendidikan_formal("{{ route('update-pendidikan-formal') }}", formData,
                "#formal_form");
        });
        $(document).on('click', '.formal_delete', function(e) {
            e.preventDefault()
            let id = $(this).attr('data-id');
            console.log(id);
            Swal.fire({
                title: 'Apakah kamu yakin akan menghapus data ini ?',
                text: "Data akan di hapus permanen",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/profile/delete-pendidikan-formal/${id}`,
                        type: 'POST',
                        data: {
                            '_method': 'DELETE',
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // let res = JSON.parse(response);
                            // console.log(res);
                            if (response.status !== false) {
                                Swal.fire('Deleted!',
                                        'Data berhasil dihapus.',
                                        'success')
                                    .then(function() {
                                        dataRow.destroy();
                                        dataRow.init();
                                    });
                            } else {
                                swal.fire({
                                    title: "Failed!",
                                    text: `${res.message}`,
                                    icon: "warning",
                                });
                            }
                        }
                    })
                }
            })
        });

        // process pendidikan nonformal
        $(document).on('submit', "#nonformal_form[data-type='submit']", function(e) {
            e.preventDefault();

            var form = document.querySelector('form');
            var formData = new FormData(this);

            AxiosCall.add_pendidikan_nonformal("{{ route('add-pendidikan-nonformal') }}", formData,
                "#nonformal_form");
        });
        $(document).on('click', '.nonformal_update', function() {

            PanelForm.init('nonformal_create');
            PanelForm.action('show', 'update');
            var key = $(this).data('id');
            console.log(key);

            $.ajax({
                url: `profile/pendidikan-nonformal/${key}`,
                method: "GET",
                success: function(data) {
                    let result = JSON.parse(data);

                    if (result.status) {
                        var res = result.data;

                        $.each(res, function(key, value) {
                            console.log(key + " | " + value);
                            console.log($(`#${key}`));
                            $("select[name='" + key + "']").val(value);
                            $("input[name='" + key + "']").val(value);
                            $(`#${key}`).attr("src",
                                `{{ asset('storage/${value}') }}`);
                        });
                    }
                }
            });
        });
        $(document).on('submit', "#nonformal_form[data-type='update']", function(e) {
            e.preventDefault();
            console.log($(this));

            var _id = $("input[name='id']").val();
            var form = document.querySelector('form');
            var formData = new FormData(this);

            AxiosCall.update_pendidikan_nonformal("{{ route('update-pendidikan-nonformal') }}", formData,
                "#nonformal_form");
        });
        $(document).on('click', '.nonformal_delete', function(e) {
            e.preventDefault()
            let id = $(this).attr('data-id');
            console.log(id);
            Swal.fire({
                title: 'Apakah kamu yakin akan menghapus data ini ?',
                text: "Data akan di hapus permanen",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/profile/delete-pendidikan-nonformal/${id}`,
                        type: 'POST',
                        data: {
                            '_method': 'DELETE',
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // let res = JSON.parse(response);
                            // console.log(res);
                            if (response.status !== false) {
                                Swal.fire('Deleted!',
                                        'Data berhasil dihapus.',
                                        'success')
                                    .then(function() {
                                        dataRowNonformal.destroy();
                                        dataRowNonformal.init();
                                    });
                            } else {
                                swal.fire({
                                    title: "Failed!",
                                    text: `${res.message}`,
                                    icon: "warning",
                                });
                            }
                        }
                    })
                }
            })
        });

        // kepangkatan
        $(document).on('submit', "#kepangkatan_form[data-type='submit']", function(e) {
            e.preventDefault();

            var form = document.querySelector('form');
            var formData = new FormData(this);

            AxiosCall.add_kepangkatan("{{ route('add-kepangkatan') }}", formData,
                "#kepangkatan_form");
        });
        $(document).on('click', '.kepangkatan_update', function() {

            PanelForm.init('kepangkatan_create');
            PanelForm.action('show', 'update');
            var key = $(this).data('id');
            console.log(key);

            $.ajax({
                url: `profile/kepangkatan/${key}`,
                method: "GET",
                success: function(data) {
                    let result = JSON.parse(data);

                    if (result.status) {
                        var res = result.data;

                        $.each(res, function(key, value) {
                            $("select[name='" + key + "']").val(value);
                            if (key == 'bulan_kerja') {
                                var months = ['January', 'February', 'March', 'April', 'May',
                                    'June', 'July', 'August', 'September', 'October',
                                    'November', 'December'
                                ];
                                value = months[value - 1];
                                $("input[name='bulan__kerja']").val("value");
                            }
                            $("input[name='" + key + "']").val(value);
                            $(`#${key}`).attr("src",
                                `{{ asset('storage/${value}') }}`);
                        });
                    }
                }
            });
        });
        $(document).on('submit', "#kepangkatan_form[data-type='update']", function(e) {
            e.preventDefault();
            console.log($(this));

            var _id = $("input[name='id']").val();
            var form = document.querySelector('form');
            var formData = new FormData(this);

            AxiosCall.update_kepangkatan("{{ route('update-kepangkatan') }}", formData,
                "#kepangkatan_form");
        });
        $(document).on('click', '.kepangkatan_delete', function(e) {
            e.preventDefault()
            let id = $(this).attr('data-id');
            console.log(id);
            Swal.fire({
                title: 'Apakah kamu yakin akan menghapus data ini ?',
                text: "Data akan di hapus permanen",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/profile/delete-kepangkatan/${id}`,
                        type: 'POST',
                        data: {
                            '_method': 'DELETE',
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // let res = JSON.parse(response);
                            // console.log(res);
                            if (response.status !== false) {
                                Swal.fire('Deleted!',
                                        'Data berhasil dihapus.',
                                        'success')
                                    .then(function() {
                                        dataRowKepangkatan.destroy();
                                        dataRowKepangkatan.init();
                                    });
                            } else {
                                swal.fire({
                                    title: "Failed!",
                                    text: `${res.message}`,
                                    icon: "warning",
                                });
                            }
                        }
                    })
                }
            })
        });

        // jabatan
        $(document).on('submit', "#jabatan_form[data-type='submit']", function(e) {
            e.preventDefault();

            var form = document.querySelector('form');
            var formData = new FormData(this);

            AxiosCall.add_jabatan("{{ route('add-jabatan') }}", formData,
                "#jabatan_form");
        });
        $(document).on('click', '.jabatan_update', function() {

            PanelForm.init('jabatan_create');
            PanelForm.action('show', 'update');
            var key = $(this).data('id');
            console.log(key);

            $.ajax({
                url: `profile/jabatan/${key}`,
                method: "GET",
                success: function(data) {
                    let result = JSON.parse(data);

                    if (result.status) {
                        var res = result.data;

                        $.each(res, function(key, value) {
                            $("select[name='" + key + "']").val(value);
                            $("input[name='" + key + "']").val(value);
                            $(`#${key}`).attr("src",
                                `{{ asset('storage/${value}') }}`);
                        });
                    }
                }
            });
        });
        $(document).on('submit', "#jabatan_form[data-type='update']", function(e) {
            e.preventDefault();
            console.log($(this));

            var _id = $("input[name='id']").val();
            var form = document.querySelector('form');
            var formData = new FormData(this);

            AxiosCall.update_jabatan("{{ route('update-riwayat-jabatan') }}", formData,
                "#jabatan_form");
        });
        $(document).on('click', '.jabatan_delete', function(e) {
            e.preventDefault()
            let id = $(this).attr('data-id');
            console.log(id);
            Swal.fire({
                title: 'Apakah kamu yakin akan menghapus data ini ?',
                text: "Data akan di hapus permanen",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/profile/delete-jabatan/${id}`,
                        type: 'POST',
                        data: {
                            '_method': 'DELETE',
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // let res = JSON.parse(response);
                            // console.log(res);
                            if (response.status !== false) {
                                Swal.fire('Deleted!',
                                        'Data berhasil dihapus.',
                                        'success')
                                    .then(function() {
                                        dataRowJabatan.destroy();
                                        dataRowJabatan.init();
                                    });
                            } else {
                                swal.fire({
                                    title: "Failed!",
                                    text: `${res.message}`,
                                    icon: "warning",
                                });
                            }
                        }
                    })
                }
            })
        });



        jQuery(document).ready(function() {

            KTLayoutAsideMenu.init('kt_aside_menu_profile');
            var avatar1 = new KTImageInput('kt_image_1');
            dataRow.init();
            dataRowNonformal.init();
            dataRowKepangkatan.init();
            dataRowJabatan.init();

            $('#tahun_kerja').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true,
            });

            $('#bulan_kerja').datepicker({
                format: "MM",
                value: "mm",
                viewMode: "months",
                minViewMode: "months",
                autoclose: true,
            });

            $("#gaji_pokok").inputmask('RP. 999.999.999', {
                numericInput: true
            });

            $('#pendidikan-tab').click(function() {
                dataRow.destroy();
                dataRow.init();
            });
            $('#pendidikan-non-formal-tab').click(function() {
                dataRowNonformal.destroy();
                dataRowNonformal.init();
            });
            $('#kepangkatan-tab').click(function() {
                dataRowKepangkatan.destroy();
                dataRowKepangkatan.init();
            });
            $('#jabatan-tab').click(function() {
                dataRowJabatan.destroy();
                dataRowJabatan.init();
            });


        });
    </script>
@endsection
