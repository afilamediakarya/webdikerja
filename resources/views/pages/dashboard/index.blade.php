@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('content')
<!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Dashboard</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <!-- <ul class="breadcrumb breadcrumb-transparent breadcrumb-line font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="" class="text-muted">Crud</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="" class="text-muted">Datatables.net</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="" class="text-muted">Advanced</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="" class="text-muted">Row Grouping</a>
                        </li>
                    </ul> -->
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <!--begin::Actions-->
                <!-- <a href="#" class="btn btn-light-primary font-weight-bolder btn-sm">Actions</a>s -->
                <!--end::Actions-->
                <!--begin::Dropdown-->
                
                <!--end::Dropdown-->
            </div>
            <!--end::Toolbar-->
        </div>
    </div>
<!--end::Subheader-->

<!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xxl-6">
                    <!--begin::Mixed Widget 1-->
                    <div class="card card-custom bg-gray-100 card-stretch gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0 bg-primary py-5">
                            <h3 class="card-title font-weight-bolder text-white">Info SKP</h3>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body p-0 position-relative overflow-hidden">
                            <div class="card-rounded-bottom bg-primary py-8">
                            </div>
                            <!--begin::Stats-->
                            <div class="card-spacer mt-n25">
                                <!--begin::Row-->
                                
                                <div class="row m-0">
                                    <div class="col bg-white px-6 py-8 rounded-xl mr-3 mb-7">
                                        <a href="#" class="text-dark font-weight-bold font-size-lg">SKP</a>
                                        <div class="align-items-end d-flex h-100 justify-content-between w-100">
                                            <p class="font-size-h1 mb-0"> {{$data['jumlah_skp']}} <small class="text-muted font-size-sm">Data</small> </p>
                                            <span class="align-items-end d-block svg-icon svg-icon-3x svg-icon-warning text-right">
                                                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <rect fill="#000000" opacity="0.3" x="17" y="4" width="3" height="13" rx="1.5"/>
                                                        <rect fill="#000000" opacity="0.3" x="12" y="9" width="3" height="8" rx="1.5"/>
                                                        <path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero"/>
                                                        <rect fill="#000000" opacity="0.3" x="7" y="11" width="3" height="6" rx="1.5"/>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col bg-white px-6 py-8 rounded-xl ml-3 mb-7">
                                        <a href="#" class="text-dark font-weight-bold font-size-lg">SKP Terealisasi</a>
                                        <div class="align-items-end d-flex h-100 justify-content-between w-100">
                                            <p class="font-size-h1 mb-0"> 0 <small class="text-muted font-size-sm">Data</small> </p>
                                            <span class="align-items-end d-block svg-icon svg-icon-3x svg-icon-warning text-right">
                                                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <rect fill="#000000" opacity="0.3" x="2" y="3" width="20" height="18" rx="2"/>
                                                        <path d="M9.9486833,13.3162278 C9.81256925,13.7245699 9.43043041,14 9,14 L5,14 C4.44771525,14 4,13.5522847 4,13 C4,12.4477153 4.44771525,12 5,12 L8.27924078,12 L10.0513167,6.68377223 C10.367686,5.73466443 11.7274983,5.78688777 11.9701425,6.75746437 L13.8145063,14.1349195 L14.6055728,12.5527864 C14.7749648,12.2140024 15.1212279,12 15.5,12 L19,12 C19.5522847,12 20,12.4477153 20,13 C20,13.5522847 19.5522847,14 19,14 L16.118034,14 L14.3944272,17.4472136 C13.9792313,18.2776054 12.7550291,18.143222 12.5298575,17.2425356 L10.8627389,10.5740611 L9.9486833,13.3162278 Z" fill="#000000" fill-rule="nonzero"/>
                                                        <circle fill="#000000" opacity="0.3" cx="19" cy="6" r="1"/>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="row m-0">
                                    <div class="col bg-white px-6 py-8 rounded-xl mr-3 mb-7">
                                        <a href="#" class="text-dark font-weight-bold font-size-lg">Aktivitas</a>
                                        <div class="align-items-end d-flex h-100 justify-content-between w-100">
                                            <p class="font-size-h1 mb-0"> {{$data['aktivitas']}} <small class="text-muted font-size-sm">Data</small> </p>
                                            <span class="align-items-end d-block svg-icon svg-icon-3x svg-icon-warning text-right">
                                                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <rect fill="#000000" x="2" y="5" width="19" height="4" rx="1"/>
                                                        <rect fill="#000000" opacity="0.3" x="2" y="11" width="19" height="10" rx="1"/>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col bg-white px-6 py-8 rounded-xl ml-3 mb-7">
                                        <a href="#" class="text-dark font-weight-bold font-size-lg">Pegawai yang Dinilai</a>
                                        <div class="align-items-end d-flex h-100 justify-content-between w-100">
                                            <p class="font-size-h1 mb-0"> {{$data['pegawai_diniai']}} <small class="text-muted font-size-sm">Data</small> </p>
                                            <span class="align-items-end d-block svg-icon svg-icon-3x svg-icon-warning text-right">
                                                <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Media/Equalizer.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                                        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                        <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Stats-->
                        <div class="resize-triggers"><div class="expand-trigger"><div style="width: 464px; height: 248px;"></div></div><div class="contract-trigger"></div></div></div>
                        <!--end::Body-->
                    </div>
                    <!--end::Mixed Widget 1-->
                </div>
                
                <div class="col-lg-6 col-xxl-6 order-1 order-xxl-2">
                    <!--begin::List Widget 3-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bolder text-dark">Informasi TPP</h3>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-2">
                            <!--begin::Item-->
                            <div class="d-flex align-items-center justify-content-between pb-5 mb-5 border-bottom">
                                <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                    <span class="text-muted">Besaran TPP</span>
                                </div>
                                <div class="font-weight-bold">
                                    <span class="text-dark">Rp. {{$data['informasi_tpp']['besaran_tpp']}}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between pb-5 mb-5 border-bottom">
                                <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                    <span class="text-muted">Tunjangan Prestasi Kerja (60%)</span>
                                </div>
                                <div class="font-weight-bold">
                                    <span class="text-dark">Rp.0</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between pb-5 mb-5 border-bottom">
                                <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                    <span class="text-muted">Tunjangan Kehadiran Kerja (40%)</span>
                                </div>
                                <div class="font-weight-bold">
                                    <span class="text-dark">Rp.0</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between pb-5 mb-5 border-bottom">
                                <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                    <span class="text-muted">Potongan (JKN + Pph21)</span>
                                </div>
                                <div class="font-weight-bold">
                                    <span class="text-dark">Rp.0</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-10 border-b-1">
                                <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                    <span class="text-muted">Total TPP yang diterima</span>
                                </div>
                                <div class="font-weight-bolder">
                                    <span class="text-dark">Rp.0</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::List Widget 3-->
                </div>

                <div class="col-lg-6 col-xxl-6 order-1 order-xxl-2">
                    <!--begin::List Widget 3-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bolder text-dark">Informasi Pegawai</h3>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-2">
                            <!--begin::Item-->
                            <div class="d-flex align-items-center justify-content-between pb-5 mb-5 border-bottom">
                                <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                    <span class="text-muted">Nama</span>
                                </div>
                                <div class="font-weight-bold max-w-70 text-righ">
                                    <span class="text-dark">{{$data['informasi_pegawai']['nama']}}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between pb-5 mb-5 border-bottom">
                                <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                    <span class="text-muted">NIP</span>
                                </div>
                                <div class="font-weight-bold max-w-70 text-righ">
                                    <span class="text-dark">{{$data['informasi_pegawai']['nip']}}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between pb-5 mb-5 border-bottom">
                                <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                    <span class="text-muted">Pangkat / Gol Ruang</span>
                                </div>
                                <div class="font-weight-bold max-w-70 text-righ">
                                    <span class="text-dark">
                                        @if($data['informasi_pegawai']['pangkat'] != null)
                                            {{$data['informasi_pegawai']['pangkat']}}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between pb-5 mb-5 border-bottom">
                                <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                    <span class="text-muted">Jabatan</span>
                                </div>
                                <div class="font-weight-bold max-w-70 text-righ">
                                    <span class="text-dark">
                                        @if($data['informasi_pegawai']['jabatan'] != null)
                                            {{$data['informasi_pegawai']['jabatan']}}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-10">
                                <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                    <span class="text-muted">Instansi</span>
                                </div>
                                <div class="font-weight-bold max-w-70 text-right">
                                    <span class="text-dark">{{$data['informasi_pegawai']['Instansi']}}</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::List Widget 3-->
                </div>

                <div class="col-lg-6 col-xxl-6 order-1 order-xxl-2">
                    <!--begin::List Widget 3-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bolder text-dark">Informasi Penilai</h3>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-2">
                            <!--begin::Item-->
                            <div class="d-flex align-items-center justify-content-between pb-5 mb-5 border-bottom">
                                <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                    <span class="text-muted">Nama</span>
                                </div>
                                <div class="font-weight-bold max-w-70 text-righ">
                                    @if($data['informasi_penilai'] !== NULL)
                                         <span class="text-dark">{{$data['informasi_penilai']['nama']}}</span>
                                    @else
                                        <span class="text-dark">-</span>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between pb-5 mb-5 border-bottom">
                                <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                    <span class="text-muted">NIP</span>
                                </div>
                                <div class="font-weight-bold max-w-70 text-righ">
                                   @if($data['informasi_penilai'] !== null)
                                   <span class="text-dark">{{$data['informasi_penilai']['nip']}}</span>
                                   @else
                                   <span class="text-dark">-</span>
                                   @endif
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between pb-5 mb-5 border-bottom">
                                <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                    <span class="text-muted">Pangkat / Gol Ruang</span>
                                </div>
                                <div class="font-weight-bold max-w-70 text-righ">
                                    <span class="text-dark">
                                         @if($data['informasi_penilai'] !== NULL)
                                         @if($data['informasi_penilai']['pangkat'] != null)
                                            {{$data['informasi_penilai']['pangkat']}}
                                        @else
                                            -
                                        @endif
                                         @endif
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between pb-5 mb-5 border-bottom">
                                <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                    <span class="text-muted">Jabatan</span>
                                </div>
                                <div class="font-weight-bold max-w-70 text-righ">
                                    <span class="text-dark">
                                        @if($data['informasi_penilai'] != null)
                                        @if($data['informasi_penilai']['jabatan'] != null)
                                            {{$data['informasi_penilai']['jabatan']}}
                                        @else
                                            -
                                        @endif
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-10">
                                <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                    <span class="text-muted">Instansi</span>
                                </div>
                                <div class="font-weight-bold max-w-70 text-right">
                                    <span class="text-dark">
                                        @if($data['informasi_penilai'] !== null)
                                            {{$data['informasi_penilai']['Instansi']}}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::List Widget 3-->
                </div>

                <div class="col-lg-12 col-xxl-12 order-1 order-xxl-2">
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bolder text-dark">Pegawai yang dinilai</h3>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        
                        <div class="card-body pt-2">
                        
                        <div class="col-md-2 mb-2">
                            <div id="bulan_selectt"></div>
                        </div>
                        
                        <table class="table table-borderless table-head-bg" id="kt_datatable" style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Jabatan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
<!--end::Entry-->
@endsection

@section('script')
    <script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script>
            "use strict";  
        let bulan = '';

        $('#bulan_selectt').html(`<select id="bulan_select" class="form-control">
                <option selected disabled>Pilih Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>`);

            $('#bulan_select').on('change',function () {
                bulan = $(this).val();
            })

        function reviewSkp(type,id_pegawai) {
            if (bulan !== '') {
                window.location.href = `/penilaian/realisasi/realisasi/${id_pegawai}/${bulan}`;    
            }else{
                swal.fire({
                    text: "Silahkan pilih bulan terlebih dahulu.",
                    icon: "warning",
                });
            }
            
        }
        // reviewSkp = () =>{
        //     alert('dsfsdf');
        // }

        var dataRow = function() {

        var init = function() {
            var table = $('#kt_datatable');

            table.DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']],
                processing:true,
                ajax: "/get_data/penilaian/realisasi",
                columns:[{ 
                        data : null, 
                        render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                        }  
                    },{
                        data:'nama'
                    },{
                        data:'nip'
                    },{
                        data:'jenis_jabatan'
                    },{
                        data:'status',
                    },{
                        data:null,
                    }
                ],
                columnDefs: [
                    {
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        render: function(data) {
                            if (data.status == 'Selesai') {
                                return `<button type="button" class="btn btn-secondary" disabled>Review Skp</button>`
                            }else{
                                return `<a href="javascript:;" onClick="reviewSkp('realisasi','${data.id_pegawai}')" role="button" class="btn btn-primary">Review Skp</a>`;
                            }
                            
                        },
                    }, {
                        targets: 4,
                        title: 'Status',
                        orderable: false,
                        render: function(data) {
                            if (data == 'Belum Review') {
                                return `<a href="javascript:;" class="btn btn-light-danger btn-sm">${data}</a>`;
                            }else if(data == 'Belum Sesuai'){
                                return `<a href="javascript:;" class="btn btn-light-warning btn-sm">${data}</a>`;
                            }else if(data == 'Selesai'){
                                return `<a href="javascript:;" class="btn btn-light-success btn-sm">${data}</a>`;
                            }
                        },
                    }
                ],
            });

        };

        var destroy = function(){
            var table = $('#kt_datatable').DataTable();
            table.destroy();
        }

        return {
            init: function() {
                init();
            },
            destroy:function(){
                destroy();
            }

        };

        }();

        jQuery(document).ready(function() {
            dataRow.init();
            // KTDatatablesAdvancedRowGrouping.init();
        });
    </script>
@endsection