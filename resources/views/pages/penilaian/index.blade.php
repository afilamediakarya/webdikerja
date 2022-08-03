@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection




@section('content')

<!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            
            <!--begin::Card-->
            <div class="card card-custom">
                
                <div class="card-body">
                    @if($type == 'realisasi')
                    <select id="bulan_" class="form-control" style="position: relative;bottom: 11px;width: 12rem;">
                        <option selected disabled> Pilih bulan </option>
                        <option value="0">Tahunan</option>
                        @foreach($nama_bulan as $in => $month)
                            <option value="{{$in+1}}" @if($in+1 == date('m')) selected @endif>{{$month}}</option>
                        @endforeach
                    </select>
                    @endif
                    <!--begin: Datatable-->
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
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
<!--end::Entry-->

@endsection



@section('script')
    <script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script>
          "use strict";
        let type = {!! json_encode($type) !!};  

        function reviewSkp(type,id_pegawai) {
            if (bulan !== '') {
                // window.location.href = `/penilaian/realisasi/${type}/${id_pegawai}/${bulan}`;   
                window.location.href = `/penilaian-create?type=skp&id_pegawai=${id_pegawai}` 
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

            // begin first table
           
            if (type == 'skp') {
                table.DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']],
                processing:true,
                ajax: "/get_data/penilaian/"+type,
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
                        data:'nama_jabatan'
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
                                return `<a href="/penilaian-create?type=${type}&id_pegawai=${data.id_pegawai}" role="button" class="btn btn-primary">Review Skp</a>`;
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
            } else {
                table.DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']],
                processing:true,
                ajax: `/get_data/penilaian/${type}`,
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
                        data:'nama_jabatan'
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
                                return `<button type="button" class="btn btn-secondary" disabled>Review Realisasi</button>`
                            }else{
                                return `<a href="/penilaian-create?type=${type}&id_pegawai=${data.id_pegawai}&bulan=${$('#bulan_').val()}" role="button" class="btn btn-primary">Review Realisasi</a>`;
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
            }

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