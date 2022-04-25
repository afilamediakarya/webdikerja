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
                    <!--begin: Datatable-->
                    <table class="table table-borderless table-head-bg" id="kt_datatable" style="margin-top: 13px !important">
                        <thead>
                            <tr>
                            <th>No.</th>
                                    <th>Rencana Kerja</th>
                                    <th>Aspek</th>
                                    <th nowrap="nowrap">Indikator Kinerja Individu</th>
                                    <th>Target</th>
                                    <th>Satuan</th>
                                    <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                                @php
                                    $inc_letter = 'A';
                                    $no = 0;
                                @endphp
                                @foreach($skp as $key => $value)
                                    <tr style="background:#f2f2f2">
                                        <td>{{$inc_letter++}}.</td>
                                        <td colspan="6">{{$value['atasan']['rencana_kerja']}}</td>  
                                    <tr>

                                    @foreach($value['skp_child'] as $k => $v)
                                        @foreach($v['aspek_skp'] as $i => $l)
                                        <tr>
                                        
                                            @if($i == 0)
                                            <td>{{$no+1}}.</td>
                                            <td>{{$v['rencana_kerja']}}</td>
                                            @else
                                            <td></td>
                                            <td></td>
                                            @endif
                                            <td>{{$l['aspek_skp']}}</td>
                                            <td>{{$l['iki']}}</td>                                       
                                            @php
                                                $num = 0;
                                                foreach($l['target_skp'] as $f => $b){
                                                    $num =+ $b['target'];
                                                }
                                            @endphp
                                            <td>{{$num}}</td>
                                            <td>{{$l['satuan']}}</td>
                                            @if($i == 0)
                                            <td rowspan="3">
                                                        <div class="form-group">
                                                            <label>Kesesuaian Skp</label>
                                                            <div class="radio-inline">
                                                                <label class="radio">
                                                                <input type="radio" value="ya" name="kesesuaian[{{$key}}]" />
                                                                <span></span>Sesuai</label>
                                                                <label class="radio">
                                                                <input type="radio" value="tidak" name="kesesuaian[{{$key}}]" />
                                                                <span></span>Tidak</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="keterangan">Keterangan</label>
                                                            <textarea name="keterangan[{{$key}}]" class="form-control form-control-solid" id="keterangan"  rows="5"></textarea>
                                                        </div>
                                            </td>
                                            @else
                                            <td></td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    @php
                                                $no++;
                                    @endphp
                                    @endforeach
                                @endforeach    
                            </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>

                <div class="card-footer border-0">
                    <button type="reset" class="btn btn-outline-primary mr-2">Batal</button>
                    <button type="reset" class="btn btn-primary">Simpan</button>
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