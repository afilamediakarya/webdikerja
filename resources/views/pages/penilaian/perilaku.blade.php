@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('button')
    <a href="{{url('skp/tambah')}}" class="btn btn-primary font-weight-bolder">
        <span class="svg-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        Tambah SKP
    </a>
@endsection


@section('content')

<!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            
            <!--begin::Card-->
            <div class="card card-custom">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-head-bg table-borderless table-vertical-center">
                            <thead>
                                <tr class="text-left text-capitalize">
                                    <th style="min-width: 50px" class="pl-7">
                                        no.
                                    </th>
                                    <th style="min-width: 100px">Aspek perilaku kerja</th>
                                    <th style="min-width: 100px">level yang diperoleh</th>
                                    <th style="min-width: 100px">nilai</th>
                                    <th style="min-width: 130px">Status</th>
                                    <th style="min-width: 80px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Orientasi Pelayanan</td>
                                    <td>5,00</td>
                                    <td>109</td>
                                    <td><span class="label label-lg font-weight-bold label-light-primary label-inline">Belum Review</span></td>
                                    <td><a href="#" type="button" class="btn btn-primary">Nilai Perilaku</a></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Komitmen</td>
                                    <td>5,00</td>
                                    <td>109</td>
                                    <td><span class="label label-lg font-weight-bold label-light-primary label-inline">Belum Review</span></td>
                                    <td><a href="#" type="button" class="btn btn-primary">Nilai Perilaku</a></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Inisiatif Kerja</td>
                                    <td>5,00</td>
                                    <td>109</td>
                                    <td><span class="label label-lg font-weight-bold label-light-primary label-inline">Belum Review</span></td>
                                    <td><a href="#" type="button" class="btn btn-primary">Nilai Perilaku</a></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Kerjasama</td>
                                    <td>5,00</td>
                                    <td>109</td>
                                    <td><span class="label label-lg font-weight-bold label-light-primary label-inline">Belum Review</span></td>
                                    <td><a href="#" type="button" class="btn btn-primary">Nilai Perilaku</a></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Kepemimpinan</td>
                                    <td>5,00</td>
                                    <td>109</td>
                                    <td><span class="label label-lg font-weight-bold label-light-primary label-inline">Belum Review</span></td>
                                    <td><a href="#" type="button" class="btn btn-primary">Nilai Perilaku</a></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="bg-secondary"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">Nilai Akhir</span></td>
                                    <td class="bg-secondary"><span class="text-dark-75 font-weight-bolder d-block font-size-lg">105</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                    pageLength: 25,
                    ordering:false,
                    // rowGroup: {
                    //     dataSrc: [ 2, 1 ]
                    // },
                    // order: [[2, 'asc']],
                    drawCallback: function(settings) {
                        var api = this.api();
                        var rows = api.rows({page: 'current'}).nodes();
                        var last = null;

                        api.column(1, {page: 'current'}).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before(
                                    '<tr class="bg-white"><td>A</td><td colspan="7">' + group + '</td></tr>',
                                );
                                last = group;
                            }
                        });
                        api.column(2, {page: 'current'}).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before(
                                    '<tr class="bg-secondary"><td>A.1</td> <td colspan="7">' + group + '</td></tr>',
                                );
                                last = group;
                            }
                        });
                        api.column(3, {page: 'current'}).data().each(function(group, i) {
                            if (last !== group) {
                                    $(rows).eq(i).children('td:eq(1)').addClass('align-baseline').attr('rowspan', '3')
                                    $(rows).eq(i).children('td:eq(0)').attr('rowspan', '3')
                                    $(rows).eq(i).children('td:last-child').attr('rowspan', '3')
                                last = group;
                            }else{
                                $(rows).eq(i).children('td:eq(1)').remove()
                                $(rows).eq(i).children('td:eq(0)').remove()
                                $(rows).eq(i).children('td:last-child').remove()

                            }
                        });
                    },
                    columnDefs: [
                        {
                            // hide columns by index number
                            targets: [1, 2],
                            visible: false,
                        },
                        {
                            targets: -1,
                            title: 'Actions',
                            orderable: false,
                            render: function(data, type, full, meta) {
                                return '\
                                <div class="form">\
                                    <div class="form-group">\
                                        <label>Inline radios</label>\
                                        <div class="radio-inline">\
                                            <label class="radio">\
                                            <input type="radio" name="radios2" />\
                                            <span></span>Sesuai</label>\
                                            <label class="radio">\
                                            <input type="radio" name="radios2" />\
                                            <span></span>Tidak</label>\
                                        </div>\
                                        <span class="form-text text-danger">Error Alert</span>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="exampleTextarea">Rencana Kerja \
                                        <span class="text-danger">*</span></label>\
                                        <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>\
                                    </div>\
                                </div>\
                                ';
                            },
                        },
                        // {
                        //     targets: 8,
                        //     render: function(data, type, full, meta) {
                        //         var status = {
                        //             1: {'title': 'Pending', 'class': 'label-light-primary'},
                        //             2: {'title': 'Delivered', 'class': ' label-light-danger'},
                        //             3: {'title': 'Canceled', 'class': ' label-light-primary'},
                        //             4: {'title': 'Success', 'class': ' label-light-success'},
                        //             5: {'title': 'Info', 'class': ' label-light-info'},
                        //             6: {'title': 'Danger', 'class': ' label-light-danger'},
                        //             7: {'title': 'Warning', 'class': ' label-light-warning'},
                        //         };
                        //         if (typeof status[data] === 'undefined') {
                        //             return data;
                        //         }
                        //         return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title + '</span>';
                        //     },
                        // },
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