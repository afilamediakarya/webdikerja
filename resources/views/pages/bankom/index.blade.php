@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .ui-datepicker-calendar{
            display: none;
        }
        #img_preview{
            border:1px dashed #c7c7c7; 
            width: 150px; 
            height:150px;
            border-radius:4px;
            margin-bottom : 6px;
        }
    </style>
@endsection


@section('button')
    <button onclick="Panel.action('show','submit')"  class="btn btn-primary font-weight-bolder" id="side_form_toggle">
        <span class="svg-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        Tambah Bankom
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
                                <th>Nama Pelatihan</th>
                                <th>Jenis Pelatihan</th>
                                <th>Waktu Pelaksanaan</th>
                                <th>Sertifikat</th>
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
				<h3 class="font-weight-bold m-0">Form Bankom<h3>
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
                    <div class="form-group">
                        <label>Nama Pelatihan</label>
                        <input class="form-control" type="text" name="nama_pelatihan"/>
                        <small class="text-danger nama_pelatihan_error"></small>
                    </div>
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label>Jenis Pelatihan</label>
                        <select name="jenis_pelatihan" class="form-control" >
                            <option disabled selected>Pilih jenis pelatihan</option>
                            <option value="Manajerial">Manajerial</option>
                            <option value="Teknis Fungsional">Teknis Fungsional</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                           <small class="text-danger jenis_pelatihan_error"></small>
                    </div>
                    <div class="form-group">
                        <label>Jumlah JP</label>
                        <input type="number" class="form-control" value="0" name="jumlah_jp"/>
                           <small class="text-danger jumlah_jp_error"></small>
                    </div>
                    <div class="form-group">
                        <label>Sertifikat</label>
                        <small class="text-primary filename"></small>
                        <input type="file" class="form-control" name="sertifikat"/>
                           <small class="text-danger sertifikat_error"></small>
                    </div>
                    <div class="form-group">
                        <label>Waktu Pelaksanaan</label>
                        <input type="date" class="form-control" name="waktu_pelaksanaan">
                           <small class="text-danger waktu_pelaksanaan_error"></small>
                    </div>
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
        let url_ = {!! json_encode($url_img) !!};
        let role = {!! json_encode($role) !!}
        let url_img = {!! json_encode($url_img) !!}
        
        if (role == 'super_admin') {
            $('#id_satuan_kerja').select2();
        }

        var dataRow = function() {
        var init = function() {
            var table = $('#kt_datatable');

            // begin first table
            table.DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']],
                processing:true,
                ajax: "{{ route('bankom') }}",
                columns:[
                    { 
                        data : null, 
                        render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                        }  
                    },{
                        data:'nama_pelatihan'
                    },{
                        data:'jenis_pelatihan'
                    },{
                        data: 'waktu_pelaksanaan',
                    },{ 
                        data : null, 
                        render: function (data) {
                                return `<a href="${url_img}/storage/image/${data.sertifikat}" target="_blank" type="button" class="btn btn-primary btn-sm ">Lihat</a>`;
                        }  
                    }
                    ,{
                        data:'id',
                    }
                ],
                columnDefs: [
                    {
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            return '\
                                <a href="javascript:;" type="button" data-id="'+data+'" class="btn btn-secondary btn-sm button-update">ubah</a>\
                                <a href="javascript:;" type="button" data-id="'+data+'" class="btn btn-danger btn-sm button-delete">Hapus</a>\
                            ';
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
            $.ajax({
                url:"{{route('post-bankom')}}",
                type:"POST",
                data : formdata,
                processData: false,
                contentType: false,
                success: function(data){
                    swal.fire({
                        text: 'Bankom berhasil di tambahkan',
                        icon: "success",
                        showConfirmButton:true,
                        confirmButtonText: "OK, Siip",
                    }).then(function() {
                        $("#createForm")[0].reset();
                        Panel.action('hide');
                        $('#kt_datatable').DataTable().ajax.reload();
                    });
                   
                },
                error: function (err) {
                    console.log(err);
                    let error = err.responseJSON.errors;
                    $.each( error, function( key, value ) {
                        console.log(key + ": " + value);
                        $(`.${key}_error`).html(value)
                    }); 
                }
            });

            
       
        });

        
        $(document).on('click', '.button-update', function(){
            Panel.action('show','update');
            var key = $(this).data('id');
            $.ajax({
                    url:`/bankom/${key}`,
                    method:"GET",
                    success: function(res){
                        res = JSON.parse(res);
                        console.log(res.status);
                      
                      if(res.status == 1){
                        // console.log(data.success);
                        var result = res.data;
                        console.log(result);
                 
                        $.each(result, function( key, value ) {
                           if (key == 'sertifikat') {
                            $('.filename').html('<i class="fa fa-file" aria-hidden="true"></i> '+value)
                           } else {
                            $("input[name='"+key+"']").val(value);
                            $("select[name='"+key+"']").val(value);
                           }   
                           
                        });
                      }
                    }
                });
        })

        $(document).on('submit', "#createForm[data-type='update']", function(e){
            e.preventDefault();
            var formdata = new FormData(this);
            let id_ = $("input[name='id']").val();
        
            $.ajax({
                url:"bankom/"+id_,
                type:"POST",
                data : formdata,
                processData: false,
                contentType: false,
                success: function(data){
                    swal.fire({
                        text: 'Bankom berhasil di update',
                        icon: "success",
                        showConfirmButton:true,
                        confirmButtonText: "OK, Siip",
                    }).then(function() {
                        $("#createForm")[0].reset();
                        Panel.action('hide');
                        $('#kt_datatable').DataTable().ajax.reload();
                    });
                   
                },
                error: function (err) {
                    console.log(err);
                    let error = err.responseJSON.errors;
                    $.each( error, function( key, value ) {
                        console.log(key + ": " + value);
                        $(`.${key}_error`).html(value)
                    }); 
                }
            });
        });

        $(document).on('click', '.button-delete', function (e) {
            e.preventDefault();
            var key = $(this).data('id');
    
            Swal.fire({
            title: 'Apakah kamu yakin akan menghapus data ini ?',
            text: "Data akan di hapus permanen",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url  : 'bankom/'+ key,
                        type : 'POST',
                        data : {
                            '_method' : 'DELETE',
                            '_token' : $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            let res = JSON.parse(response);
                            console.log(res.status);
                            if (res.status !== false) {
                                Swal.fire('Deleted!', 'Your file has been deleted.','success');
                                $('#kt_datatable').DataTable().ajax.reload();   
                            }else{
                                swal.fire({
                                    title : "Bankom tidak dapat di hapus. ",
                                    text: "Bankom digunakan oleh bawahaan. ",
                                    icon: "warning",
                                });
                            }
                        }
                    })
                }
            })
          
            // swal.fire({
            //     title: "Apakah kamu yakin ?",
            //     text: "Data tidak dapat di pulihkan kembali",
            //     icon: "warning",
            //     buttons: true,
            //     dangerMode: true,
            // })
            // .then((willDelete) => {
            // if (willDelete) {
            //     // AxiosCall.delete(`bankom/${key}`);
            //     //     $('#kt_datatable').DataTable().ajax.reload();
            //     // swal("Data anda berhasil di hapus", {
            //     //     icon: "success",
            //     // });
            // } else {
            //     swal("Data anda di amankan");
            // }
            // });

           
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