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
        var dataRow = function() {

        var init = function() {
            var table = $('#kt_datatable');

            // begin first table
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
                        data:'jabatan'
                    },{
                        data:'status',
                    },{
                        data:'id_skp',
                    }
                ],
                columnDefs: [
                    {
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        render: function(data) {
                            return `
                                <a href="/penilaian/${type}/${data}" role="button" class="btn btn-primary">Review Skp</a>\
                            `;
                        },
                    }, {
                        targets: 4,
                        title: 'Status',
                        orderable: false,
                        render: function(data) {
                            if (data == 'Belum Review') {
                                return `<a href="javascript:;" class="btn btn-light-warning btn-sm">${data}</a>`;
                            }else{
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