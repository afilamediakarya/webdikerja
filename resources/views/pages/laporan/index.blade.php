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
                            @for ($i=1; $i<=15; $i++)
                            <tr>
                                <td>1</td>
                                <td>Andi Puang Petta</td>
                                <td>198609262015051001</td>
                                <td>Kepala Dinas</td>
                                <td>2</td>
                                <td nowrap="nowrap">
                                    <button type="button" class="btn btn-primary">Review SKP</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Andi Petta Baji</td>
                                <td>198609262015051001</td>
                                <td>Kepala Dinas</td>
                                <td>3</td>
                                <td nowrap="nowrap">
                                    <button type="button" class="btn btn-primary">Review SKP</button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Andi Puang Petta Baji</td>
                                <td>198609262015051001</td>
                                <td>Kepala Dinas</td>
                                <td>1</td>
                                <td nowrap="nowrap">
                                    <button type="button" class="btn btn-primary">Review SKP</button>
                                </td>
                            </tr>
                            @endfor
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
        var KTDatatablesAdvancedRowGrouping = function() {

            var init = function() {
                var table = $('#kt_datatable');

                // begin first table
                table.DataTable({
                    responsive: true,
                    pageLength: 15,
                    // ordering:false,
                    // rowGroup: {
                    //     dataSrc: [ 2, 1 ]
                    // },
                    order: [[1, 'asc']],
                    drawCallback: function(settings) {
                        var api = this.api();
                        var rows = api.rows({page: 'current'}).nodes();
                        var last = null;

                        api.column(1, {page: 'current'}).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before(
                                    '<tr class="bg-white"><td colspan="6">' + group + '</td></tr>',
                                );
                                last = group;
                            }
                        });
                    },
                    columnDefs: [
                        // {
                        //     // hide columns by index number
                        //     targets: [1, 2],
                        //     visible: false,
                        // },
                        // {
                        //     targets: -1,
                        //     title: 'Actions',
                        //     orderable: false,
                        //     render: function(data, type, full, meta) {
                        //         return '\
                        //             <div class="dropdown dropdown-inline">\
                        //                 <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown">\
                        //                     <i class="la la-cog"></i>\
                        //                 </a>\
                        //                 <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">\
                        //                     <ul class="nav nav-hoverable flex-column">\
                        //                         <li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-edit"></i><span class="nav-text">Edit Details</span></a></li>\
                        //                         <li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-leaf"></i><span class="nav-text">Update Status</span></a></li>\
                        //                         <li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-print"></i><span class="nav-text">Print</span></a></li>\
                        //                     </ul>\
                        //                 </div>\
                        //             </div>\
                        //             <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Edit details">\
                        //                 Ubah\
                        //             </a>\
                        //             <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Delete">\
                        //                 Hapus\
                        //             </a>\
                        //         ';
                        //     },
                        // },
                        {
                            targets: 4,
                            render: function(data, type, full, meta) {
                                var status = {
                                    1: {'title': 'Belum Review', 'class': ' label-light-warning'},
                                    2: {'title': 'Belum Selesai', 'class': ' label-light-danger'},
                                    3: {'title': 'Selesai', 'class': ' label-light-success'},
                                };
                                if (typeof status[data] === 'undefined') {
                                    return data;
                                }
                                return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title + '</span>';
                            },
                        },
                        // {
                        //     targets: 9,
                        //     render: function(data, type, full, meta) {
                        //         var status = {
                        //             1: {'title': 'Online', 'state': 'danger'},
                        //             2: {'title': 'Retail', 'state': 'primary'},
                        //             3: {'title': 'Direct', 'state': 'success'},
                        //         };
                        //         if (typeof status[data] === 'undefined') {
                        //             return data;
                        //         }
                        //         return '<span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
                        //             '<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span>';
                        //     },
                        // },
                    ],
                });
            };

            return {

                //main function to initiate the module
                init: function() {
                    init();
                },

            };

        }();

        jQuery(document).ready(function() {
            KTDatatablesAdvancedRowGrouping.init();
        });

    </script>
@endsection