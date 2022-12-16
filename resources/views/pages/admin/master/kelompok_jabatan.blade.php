@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('button')
    <a onclick="Panel.action('show','submit')" class="btn btn-primary font-weight-bolder">
        <span class="svg-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        Tambah Kelompok Jabatan
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
                                <th>Kelompok</th>
                                <th>Jenis Jabatan</th>
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
				<h3 class="font-weight-bold m-0" id="title">Tambah Kelompok Jabatan<h3>
				<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="side_form_close">
					<i class="ki ki-close icon-xs text-muted"></i>
				</a>
			</div>
			<!--end::Header-->
			<!--begin::Content-->
			<div class="offcanvas-content pr-5 mr-n5">
                <form class="form" id="createForm">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label>Nama Kelompok</label>
                        <input class="form-control form-control-solid" type="text" name="kelompok"/>
                        <small class="text-danger" id="kelompok"></small>
                    </div>

                    <div class="form-group">
                        <label>Jenis Jabatan</label>
                        <select class="form-control form-control-solid" type="text" name="jenis_jabatan">
                            <option selected disabled> Pilih Jenis Jabatan </option>
                            @foreach($jenisJabatan as $val)
                                <option value="{{$val['id']}}">{{$val['value']}}</option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="jenis_jabatan"></small>
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
        var dataRow = function() {

        var init = function() {
            var table = $('#kt_datatable');

            // begin first table
            table.DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']],
                processing:true,
                ajax: "{{ route('kelompok-jabatan') }}",
                columns:[{ 
                        data : null, 
                        render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                        }  
                    },{
                        data:'kelompok'
                    },{
                        data:'jenis_jabatan'
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
                            return '\
                                <a href="javascript:;" type="button" data-id="'+data+'" class="btn btn-secondary button-update">ubah</a>\
                                <a href="javascript:;" type="button" data-id="'+data+'" class="btn btn-danger button-delete">Hapus</a>\
                            ';
                        },
                    },
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
            Panel.init('side_form');
            dataRow.init();


            $(document).on('click','.btn-cancel', function(){
                Panel.action('hide');
            });

            $(document).on('submit', '#createForm', function(e){
                e.preventDefault();
                var type = $(this).attr('data-type');
                var _url = '';
                var _id = $("input[name='id']").val();
                if(type == 'submit'){
                    console.log('ini tambah '+type)
                    _url = "{{route('post-kelompok-jabatan')}}";
                }else{
                    console.log('ini update '+type)
                    _url = "admin/master/kelompok-jabatan/"+_id;
                }

                $.ajax({
                    url: _url,
                    method:"POST",
                    data: $(this).serialize(),
                    beforeSend: function(){
                        $("input[type='text']").removeClass('is-invalid');
                        $("select").removeClass('is-invalid');
                    },
                    success : function(data) {
                        if(data.fail){
                            swal.fire({
                                text: "Maaf Terjadi Kesalahan",
                                title:"Error",
                                timer: 2000,
                                icon: "danger",
                                showConfirmButton:false,
                            });
                        }else if(data.invalid){
                            $.each(data.invalid, function( key, value ) {
                                console.log(key);
                                $("input[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                                $("select[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                                $(`#${key}`).html(value[0]);
                            });
                        }else if(data.success){
                            swal.fire({
                                text: "Data anda berhasil disimpan",
                                title:"Sukses",
                                icon: "success",
                                showConfirmButton:true,
                                confirmButtonText: "OK, Siip",
                            }).then(function() {
                                dataRow.destroy();
                                dataRow.init();
                                $("#createForm")[0].reset();
                                Panel.action('hide');
                            });
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr);
                    }
                })
            });

            // edit
            $(document).on('click', '.button-update', function(){
                Panel.action('show','update');
                // $('#title').html('Update Satuan');   
                var key = $(this).data('id');
                $.ajax({
                    url:"admin/master/kelompok-jabatan/"+key,
                    method:"GET",
                    success: function(data){
                      if(data.success){
                        console.log(data.success);
                        var res = data.success.data;
                        $.each(res, function( key, value ) {
                            $("input[name='"+key+"']").val(value);
                            $("select[name='"+key+"']").val(value);
                        });
                      }
                    }
                });
            })

            // delete
            $(document).on('click', '.button-delete', function (e) {
                e.preventDefault();
                var key = $(this).data('id');
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
                }).then(function(result) {
                    console.log(result);
                    if (result.value) {
                        $.ajax({
                            method: 'delete',
                            url: 'admin/master/kelompok-jabatan/'+key,
                            data:{
                                "_token": "{{ csrf_token() }}"
                            }
                        })
                        .then(function(response){
                            if(response.success){
                                Swal.fire(
                                    "Deleted!",
                                    "Data terhapus",
                                    "success"
                                );
                                dataRow.destroy();
                                dataRow.init();
                            }
                        });
                    }
                });
            })
        });

    </script>
@endsection