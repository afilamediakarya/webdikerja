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


{{-- @section('button')
    <button onclick="Panel.action('show','submit')" class="btn btn-primary font-weight-bolder" id="side_form_open">
        <span class="svg-icon">
            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                    <rect fill="#000000" opacity="0.3"
                        transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) "
                        x="4" y="11" width="16" height="2" rx="1" />
                </g>
            </svg>
            <!--end::Svg Icon-->
        </span>
        Tambah Data
    </button>
@endsection --}}


@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">

            <div class="col-md">
                <!--begin::Card-->
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <div class="row">
                            <div id="kt_aside_menu_profile" class="col-md-2 h-550px" data-menu-vertical="1"
                                data-menu-scroll="1" data-menu-dropdown-timeout="500">
                                <ul class="nav nav-tabs nav-pills flex-row border-0 flex-md-column fs-6" id="myTab"
                                    role="tablist">
                                    <li class="nav-item w-100 me-0">
                                        <a class="nav-link w-100 btn btn-flex btn-active-light-success text-left active"
                                            id="personal-data-tab" data-toggle="tab" href="#personal-data" role="tab"
                                            aria-controls="personal-data" aria-selected="true">Data Pribadi</a>
                                    </li>
                                    <li class="nav-item w-100 me-0">
                                        <a class="nav-link w-100 btn btn-flex btn-active-light-info text-left"
                                            id="pendidikan-tab" data-toggle="tab" href="#pendidikan" role="tab"
                                            aria-controls="pendidikan" aria-selected="false">Riwayat
                                            Pendidikan Formal</a>
                                    </li>
                                    <li class="nav-item w-100 me-0">
                                        <a class="nav-link w-100 btn btn-flex btn-active-light-danger text-left"
                                            id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                            aria-controls="contact" aria-selected="false">Riwayat
                                            Pendidikan Non Formal</a>
                                    </li>
                                    <li class="nav-item w-100 me-0">
                                        <a class="nav-link w-100 btn btn-flex btn-active-light-success text-left"
                                            id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                            aria-controls="contact" aria-selected="false">Riwayat
                                            Kepangkatan</a>
                                    </li>
                                    <li class="nav-item w-100 me-0">
                                        <a class="nav-link w-100 btn btn-flex btn-active-light-success text-left"
                                            id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                            aria-controls="contact" aria-selected="false">Riwayat
                                            Jabatan</a>
                                    </li>
                                    <li class="nav-item w-100 me-0">
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
                                    </li>
                                </ul>
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
                                                    <div class="container">

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

                                                    </div>
                                                </div>
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
                                                        <button onclick="Panel.action('show','submit')"
                                                            class="btn btn-primary font-weight-bolder"
                                                            id="side_form_open">
                                                            <span class="svg-icon">
                                                                <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px" height="24px" viewBox="0 0 24 24"
                                                                    version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <rect fill="#000000" x="4"
                                                                            y="11" width="16" height="2"
                                                                            rx="1" />
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
                                            </div>

                                        </div>
                                        <table class="table table-striped table-row-bordered gy-5 gs-7"
                                            id="table-pendidikan-formal" style="margin-top: 13px !important">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">No.</th>
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
                                    {{-- End pendidikan formal --}}

                                    {{-- Begin pendidikan non-formal --}}
                                    <div class="tab-pane fade" id="contact" role="tabpanel"
                                        aria-labelledby="contact-tab">
                                        <h2>Contact</h2>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque, eveniet
                                            earum. Sed accusantium eligendi molestiae quo hic velit nobis et, tempora
                                            placeat ratione rem blanditiis voluptates vel ipsam? Facilis, earum!</p>

                                    </div>
                                    {{-- End pendidikan non-formal --}}
                                </div>
                            </div>
                            <!-- /.col-md-9 -->
                        </div>
                    </div>
                    <!--end::Card-->
                </div>

            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    @endsection

    @section('side-form')
        <div id="pendidikan-formal" class="offcanvas offcanvas-right p-10">
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
                <form class="form" id="createForm" enctype="multipart/form-data">
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
                            <img src="" id="document" class="mt-3 img-thumbnail">
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

            var dataRow = function() {
                var init = function() {
                    let table = $('#table-pendidikan-formal');
                    table.DataTable({
                        dom: 'tr',
                        processing: true,
                        scrollY: "300px",
                        scrollX: true,
                        scrollCollapse: true,
                        order: [
                            [0, 'asc']
                        ],
                        ajax: "{{ route('list-pendidikan-formal') }}",
                        columns: [{
                                data: null,
                                render: function(data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                }
                            },
                            {
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
                                data: 'tanggal_ijazah'
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
                                <a role="button" href="javascript:;" type="button" data-id="${row.id}" class="btn btn-warning btn-sm button-update">Ubah</a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="${row.id}">Hapus</button>
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

            // clear img document preview
            $(document).on('click', '#side_form_open', function() {
                $('#document').attr("src", null);
            });

            // add pendidikan
            $(document).on('submit', "#createForm[data-type='submit']", function(e) {
                e.preventDefault();

                var form = document.querySelector('form');
                var formData = new FormData(this);

                AxiosCall.add_pendidikan_formal("{{ route('add-pendidikan-formal') }}", formData,
                    "#createForm");
            });

            // edit
            $(document).on('click', '.button-update', function() {

                Panel.action('show', 'update');
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
                                $(`#${key}`).attr("src", `{{ asset('storage/${value}') }}`);
                            });
                        }
                    }
                });
            })

            // update
            $(document).on('submit', "#createForm[data-type='update']", function(e) {
                e.preventDefault();
                var _id = $("input[name='id']").val();
                var form = document.querySelector('form');
                var formData = new FormData(this);

                AxiosCall.update_pendidikan_formal("{{ route('update-pendidikan-formal') }}", formData,
                    "#createForm");
            });

            $(document).on('click', '.btn-delete', function(e) {
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
            })

            jQuery(document).ready(function() {

                Panel.init('pendidikan-formal');
                KTLayoutAsideMenu.init('kt_aside_menu_profile');
                var avatar1 = new KTImageInput('kt_image_1');
                dataRow.init();

                // $('#id_pendidikan').select2();

                $('#pendidikan-tab').click(function() {
                    dataRow.destroy();
                    dataRow.init();
                })

                $('input[type="file"]').change(function(e) {
                    var fileName = e.target.files[0].name;
                    $("#file").val(fileName);

                    var reader = new FileReader();
                    reader.onload = function(e) {
                        // get loaded data and render thumbnail.
                        document.getElementById("document").src = e.target.result;
                    };
                    // read the image file as a data URL.
                    reader.readAsDataURL(this.files[0]);
                });

            });
        </script>
    @endsection
