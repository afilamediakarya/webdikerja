@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('button')
    <a href="javascrip:;" class="btn btn-primary font-weight-bolder" id="kt_quick_user_toggle">
        <span class="svg-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        Tambah FAQ
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
                                <th>No</th>
                                <th>Nama</th>
                                <th>Satuan Kerja</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i=1; $i<=15; $i++)
                            <tr>
                                <td>1</td>
                                <td>Jenny Wilson</td>
                                <td>Badan Kepegawaian & Pengembangan Sumber Daya Manusia</td>
                                <td>1</td>
                                <td nowrap="nowrap">
                                    <a href="" type="button" class="btn btn-secondary">ubah</a>
                                    <a href="" type="button" class="btn btn-danger">Hapus</a>
                                </td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Besse Kambu</td>
                                <td>Badan Kepegawaian & Pengembangan Sumber Daya Manusia</td>
                                <td>0</td>
                                <td nowrap="nowrap">
                                    <a href="" type="button" class="btn btn-secondary">ubah</a>
                                    <a href="" type="button" class="btn btn-danger">Hapus</a>
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

@section('side-form')
        <div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
			<!--begin::Header-->
			<div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
				<h3 class="font-weight-bold m-0">Tambah FAQ<h3>
				<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
					<i class="ki ki-close icon-xs text-muted"></i>
				</a>
			</div>
			<!--end::Header-->
			<!--begin::Content-->
			<div class="offcanvas-content pr-5 mr-n5">
                <form class="form">
                    <div class="form-group">
                        <label>Nama</label>
                        <input class="form-control form-control-solid" type="text"/>
                    </div>

                    <div class="form-group">
                        <label>Satuan Kerja</label>
                        <select class="form-control form-control-solid" type="text">
                            <option value="">1</option>
                        </select>
                    </div>

                </form>
                <div class="separator separator-dashed mt-8 mb-5"></div>
                <div class="">
                    <button type="reset" class="btn btn-outline-primary mr-2">Batal</button>
                    <button type="reset" class="btn btn-primary">Simpan</button>
                </div>

				<!--begin::Separator-->
				<!--end::Separator-->
			</div>
			<!--end::Content-->
		</div>
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
                    order: [[1, 'asc']],
                    columnDefs: [
                        {
                            targets: 3,
                            render: function(data, type, full, meta) {
                                var status = {
                                    0: {'title': 'inactive', 'class': ' label-light-danger text-capitalize'},
                                    1: {'title': 'active', 'class': ' label-light-primary text-capitalize'},
                                };
                                if (typeof status[data] === 'undefined') {
                                    return data;
                                }
                                return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title + '</span>';
                            },
                        },
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
            $('#kt_datepicker_3').datepicker({
                todayBtn: "linked",
                clearBtn: true,
                todayHighlight: true,

            });
            KTDatatablesAdvancedRowGrouping.init();
        });

    </script>
@endsection