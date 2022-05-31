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
                    <div class="col-md-3">
                        <div class="col bg-white px-6 py-8 rounded-xl ml-3 mb-7">
                            <a href="#" class="text-dark font-weight-bold font-size-lg">Jumlah SKP</a>
                            <div class="align-items-end d-flex h-100 justify-content-between w-100">
                                <p class="font-size-h1 mb-0"> 31 <small class="text-muted font-size-sm">Data</small> </p>
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
                    <div class="col-md-3">
                        <div class="col bg-white px-6 py-8 rounded-xl ml-3 mb-7">
                            <a href="#" class="text-dark font-weight-bold font-size-lg">Jumlah Realisasi</a>
                            <div class="align-items-end d-flex h-100 justify-content-between w-100">
                                <p class="font-size-h1 mb-0"> 31 <small class="text-muted font-size-sm">Data</small> </p>
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
                    <div class="col-md-3">
                        <div class="col bg-white px-6 py-8 rounded-xl ml-3 mb-7">
                            <a href="#" class="text-dark font-weight-bold font-size-lg">Jumlah Aktifitas</a>
                            <div class="align-items-end d-flex h-100 justify-content-between w-100">
                                <p class="font-size-h1 mb-0"> 31 <small class="text-muted font-size-sm">Data</small> </p>
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
                    <div class="col-md-3">
                        <div class="col bg-white px-6 py-8 rounded-xl ml-3 mb-7">
                            <a href="#" class="text-dark font-weight-bold font-size-lg">Jumlah Pegawai</a>
                            <div class="align-items-end d-flex h-100 justify-content-between w-100">
                                <p class="font-size-h1 mb-0"> 31 <small class="text-muted font-size-sm">Data</small> </p>
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
                </div>
            <div class="row">
              
                

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