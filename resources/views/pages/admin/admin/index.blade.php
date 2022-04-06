@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('button')
    <button onclick="Panel.action('show', 'submit')" class="btn btn-primary font-weight-bolder" id="kt_quick_user_toggle">
        <span class="svg-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        Tambah FAQ
    </button>
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
				<h3 class="font-weight-bold m-0">Tambah FAQ<h3>
				<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="side_form_close">
					<i class="ki ki-close icon-xs text-muted"></i>
				</a>
			</div>
			<!--end::Header-->
			<!--begin::Content-->
			<div class="offcanvas-content pr-5 mr-n5">
                <form class="form" id="createForm">
                    <div class="form-group row">
                        <label class="col-form-label col-12">Satuan Kerja</label>
                        <div class="col-12">
                            <select class="form-control form-control-solid select2" id="satker" name="satker">
                                <option value="" disabled selected>Pilih Satuan Kerja</option>
                                @foreach ($dinas as $item)
                                    <option value="{{$item['id']}}">{{$item['nama_satuan_kerja']}}</option>
                                @endforeach
                            </select>
                        </div>
                   </div>
                   <div class="form-group row">
                       <label class="col-form-label col-12">Pegawai</label>
                       <div class="col-12">
                           <select class="form-control form-control-solid select2" id="pegawai" name="pegawai">
                               
                           </select>
                       </div>
                  </div>
                </form>
                <div class="separator separator-dashed mt-8 mb-5"></div>
                <div class="">
                    <button type="reset" class="btn btn-outline-primary mr-2 btn-cancel">Batal</button>
                    <button type="reset" class="btn btn-primary btn-submit">Simpan</button>
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
        var dataRow = function() {
            var init = function() {
                var table = $('#kt_datatable');
    
                // begin first table
                table.DataTable({
                    responsive: true,
                    pageLength: 25,
                    order: [[0, 'asc']],
                    processing:true,
                    ajax: "{{ route('admin') }}",
                    columns:[{ 
                            data : null, 
                            render: function (data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                            }  
                        },{
                            data:'nama'
                        },{
                            data:'satuan_kerja.nama_satuan_kerja'
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
                                return '<a href="javascript:;" type="button" data-id="'+data+'" class="btn btn-danger button-delete">Hapus</a>';
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

        $(document).on('change', "#satker", function(){
            let id = $(this).val();
            axios.get('admin/axios/pegawai/'+id)
            .then(function(res){
                if (res.data.success && res.data.success != '') {
                    var data = res.data.success;
                    var opt = '';
                    $.each(data, function(i, val){
                        opt += '<option value="'+ val.id +'">'+ val.value +'</option>';
                    });
                    $("#pegawai").html(opt);
                }
            })
        })

        $(document).on('click', ".btn-submit", function(){
            let id = $("#pegawai").val();
            axios.post('admin/admin/'+id, [])
            .then(function(res){
                if (res.data.success && res.data.success != '') {
                    swal.fire({
                    text: "Data anda berhasil disimpan",
                    title:"Sukses",
                    icon: "success",
                    showConfirmButton:true,
                    confirmButtonText: "OK, Siip",
                    }).then(function() {
                        dataRow.destroy();
                        dataRow.init();
                        Panel.action('hide');
                        $("#creteForm")[0].reset();
                    });
                }
            });
        })
        $(document).on('click', ".button-delete", function(){
            let id = $(this).data('id');
            Swal.fire({
                title: "Perhatian ",
                text: "Yakin ingin meghapus data.?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-light-danger",
                    }
            }).then(function(result){
                if (result.value) {
                    axios.delete('admin/admin/'+id)
                    .then(function(res){
                        var data = res.data;
                        if(data.status){
                            Swal.fire(
                                "Deleted!",
                                "Data terhapus",
                                "success"
                            );
                            dataRow.destroy();
                            dataRow.init();
                        }else{
                            Swal.fire(
                                "Error",
                                "Gagal Menghapus Data",
                                "error"
                            );
                        }
                    })
                    .catch(function(err){
                        swal.fire({
                            text: "Terjadi Kesalahan Sistem",
                            title:"Error",
                            icon: "error",
                            showConfirmButton:true,
                            confirmButtonText: "OK",
                        });
                    });
                }
            })
        })
        
        $(document).on('click', '.button-update', function(){
            var key = $(this).data('id');
            AxiosCall.show(`admin/master/faq/${key}`);
        })
            
            
        jQuery(document).ready(function() {
            Panel.init('side_form');
            dataRow.init();
            $('#satker').select2({
                placeholder: "Pilih Satuan Kerja"
            });
            $('#pegawai').select2({
                placeholder: "Pilih Pegawai"
            });

            
            $(document).on('click','.btn-cancel', function(){
                Panel.action('hide');
            });
        });
    </script>
@endsection