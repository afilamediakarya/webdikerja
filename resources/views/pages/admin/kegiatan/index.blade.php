@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .ui-datepicker-calendar{
            display: none;
        }
    </style>
@endsection


@section('button')
    <button onclick="Panel.action('show','submit')" class="btn btn-primary font-weight-bolder" id="side_form_toggle">
        <span class="svg-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        Tambah Kegiatan
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
                                <th>Kegiatan</th>
                                <th>Kode Kegiatan</th>
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

@section('side-form')
        <div id="side_form" class="offcanvas offcanvas-right p-10">
			<!--begin::Header-->
			<div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
				<h3 class="font-weight-bold m-0">Tambah Informasi<h3>
				<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="side_form_close">
					<i class="ki ki-close icon-xs text-muted"></i>
				</a>
			</div>
			<!--end::Header-->
			<!--begin::Content-->
			<div class="offcanvas-content pr-5 mr-n5">
                <form class="form" id="createForm" enctype="multipart/form-data">
                    <input type="hidden" name="id">
                    @csrf
                    <!-- <div class="form-group">
                        <label for=""> Satuan Kerja</label>
                        <div class="input-group">
                            <select name="id_satuan_kerja" class="form-control">
                                <option value="1">Satu</option>
                                <option value="2">Dua</option>
                            </select>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div> -->
                    <div class="form-group">
                        <label>Nama Kegiatan</label>
                        <input class="form-control" type="text" name="nama_kegiatan"/>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label>Kode Kegiatan</label>
                        <input class="form-control" type="text" name="kode_kegiatan"/>
                        <div class="invalid-feedback"></div>
                    </div>
                    <input type="hidden" name="tahun" value="2022">
                    <!-- <div class="form-group">
                        <label>Tahun</label>
                        <div class="input-group input-group-solid">
                            <select name="tahun" class="form-control form-control-solid">
                                <option value="2001">Tahun Lama</option>
                                <option value="2004">Tahun Dulu</option>
                                <option value="2021">Tahun Lalu</option>
                            </select>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div> -->
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
    <script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script>
        "use strict";
        var dataRow = function() {

        var init = function() {
            var table = $('#kt_datatable');

            // begin first table
            table.DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']],
                processing:true,
                ajax: "{{ route('kegiatan') }}",
                columns:[{ 
                        data : null, 
                        render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                        }  
                    },{
                        data:'nama_kegiatan'
                    },{
                        data:'kode_kegiatan'
                    },{
                        data:'id',
                    }
                ],
                columnDefs: [
                    {
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            return `<a href="javascript:;" type="button" data-id="${data}" class="btn btn-secondary button-update">ubah</a>`;
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
        

        $(document).on('submit', "#createForm[data-type='submit']", function(e){
            e.preventDefault();
            var formdata = new FormData(this);
            AxiosCall.post("{{route('post-kegiatan')}}", formdata, "#createForm");
        });
        
        // $(document).on('click', '.button-update', function(){
        //     Panel.action('show','update');
        //     var key = $(this).data('id');
        //     AxiosCall.show(`admin/kegiatan/${key}`);
        // })
        $(document).on('click', '.button-update', function(){
            Panel.action('show','update');
            var key = $(this).data('id');
            $.ajax({
                url:"admin/kegiatan/"+key,
                method:"GET",
                success: function(data){
                    if(data.success){
                        console.log(data.success);
                    var res = data.success.data;
                        $.each(res, function( key, value ) {
                            $("input[name='"+key+"']").val(value);
                            $("select[name='"+key+"']").val(value);
                            $("textarea[name='"+key+"']").val(value);
                        });
                    }
                }
            });
        })

        $(document).on('submit', "#createForm[data-type='update']", function(e){
            e.preventDefault();
            var formdata = new FormData(this);
            var _id = $("input[name='id']").val();
            AxiosCall.post(`admin/kegiatan/${_id}`, formdata, "#createForm");
        });

        $(document).on('click', '.button-delete', function (e) {
            e.preventDefault();
            var key = $(this).data('id');
            AxiosCall.delete(`admin/kegiatan/${key}`);
        })
        

        jQuery(document).ready(function() {
            Panel.init('side_form');
            dataRow.init();
            $(document).on('click','.btn-cancel', function(){
                Panel.action('hide');
            });
        });

    </script>
@endsection