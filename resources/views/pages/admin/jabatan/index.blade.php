@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('button')
    <button onclick="Panel.action('show','submit')" class="btn btn-primary font-weight-bolder" id="side_form_open">
        <span class="svg-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        Tambah Jabatan
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
                                <th>Nama Jabatan</th>
                                <th>Nama Struktur</th>
                                <th>Level</th>
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
				<h3 class="font-weight-bold m-0">Tambah Jabatan<h3>
				<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="side_form_close">
					<i class="ki ki-close icon-xs text-muted"></i>
				</a>
			</div>
			<!--end::Header-->
			<!--begin::Content-->
			<div class="offcanvas-content pr-5 mr-n5">
                <form class="form" id="createForm">
                    @csrf
                    <input type="hidden" name="id"/>
                    <div class="form-group">
                        <label>Nama Jabatan</label>
                        <input class="form-control form-control-solid" type="text" name="nama_jabatan"/>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group">
                        <label>Nama Struktur</label>
                        <input class="form-control form-control-solid" type="text" name="nama_struktur"/>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label>Satuan Kerja</label>
                        <select class="form-control form-control-solid" type="text" name="id_satuan_kerja">
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label>Pegawai</label>
                        <select class="form-control form-control-solid" type="text" name="id_pegawai">
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label>Kelas Jabatan</label>
                        <select class="form-control form-control-solid" type="text" name="id_kelas_jabatan">
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label>Jabatan Atasan</label>
                        <select class="form-control form-control-solid" type="text" name="parent_id">
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label>Level</label>
                        <select class="form-control form-control-solid" type="text" name="level">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label>Status Jabatan</label>
                        <select class="form-control form-control-solid" type="text" name="status_jabatan">
                            <option value="tetap">Tetap</option>
                            <option value="fana">Tidak Tetap</option>
                        </select>
                        <div class="invalid-feedback"></div>
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
                ajax: "{{ route('jabatan') }}",
                columns:[{ 
                        data : null, 
                        render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                        }  
                    },{
                        data:'nama_jabatan'
                    },{
                        data:'nama_struktur'
                    },{
                        data:'level'
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
                            return '\
                                <a href="javascript:;" type="button" data-id="'+data+'" class="btn btn-secondary button-update">ubah</a>\
                                <a href="javascript:;" type="button" data-id="'+data+'" class="btn btn-danger button-delete">Hapus</a>\
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
            AxiosCall.post("{{route('post-jabatan')}}", $(this).serialize(), "#createForm");
        });
        
        
        $(document).on('submit', "#createForm[data-type='update']", function(e){
            e.preventDefault();
            var _id = $("input[name='id']").val();
            AxiosCall.post(`admin/jabatan/jabatan/${_id}`, $(this).serialize(), "#createForm");
        });
        
        $(document).on('click', '.button-delete', function (e) {
            e.preventDefault();
            var key = $(this).data('id');
            AxiosCall.delete(`admin/jabatan/jabatan/${key}`);
        })

        jQuery(document).ready(function() {
            Panel.init('side_form');
            dataRow.init();
            $('#jadwal_1, #jadwal_2').datepicker({format: 'dd-mm-yyyy'});


            $(document).on('click','.btn-cancel', function(){
                Panel.action('hide');
            });

            // $(document).on('submit', '#createForm', function(e){
            //     e.preventDefault();
            //     var type = $(this).data('type');
            //     var _url = '';
            //     var _id = $("input[name='id']").val();
            //     if(type == 'submit'){
            //         _url = "{{route('post-jabatan')}}";
            //     }else{
            //         _url = "admin/jabatan/jabatan/"+_id
            //     }

            //     $.ajax({
            //         url: _url,
            //         method:"POST",
            //         data: $(this).serialize(),
            //         beforeSend: function(){
            //             $("input[type='text']").removeClass('is-invalid');
            //             $("select").removeClass('is-invalid');
            //         },
            //         success : function(data) {
            //             if(data.fail){
            //                 console.log(data);
            //                 swal.fire({
            //                     text: "Maaf Terjadi Kesalahan",
            //                     title:"Error",
            //                     timer: 2000,
            //                     icon: "danger",
            //                     showConfirmButton:false,
            //                 });
            //             }else if(data.invalid){
            //                 $.each(data.invalid, function( key, value ) {
            //                     console.log(key);
            //                     $("input[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
            //                     $("select[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
            //                 });
            //             }else if(data.success){
            //                 swal.fire({
            //                     text: "Data anda berhasil disimpan",
            //                     title:"Sukses",
            //                     icon: "success",
            //                     showConfirmButton:true,
            //                     confirmButtonText: "OK, Siip",
            //                 }).then(function() {
            //                     dataRow.destroy();
            //                     dataRow.init();
            //                     $("#createForm")[0].reset();
            //                     Panel.action('hide');
            //                 });
            //             }
            //         }
            //     })
            // });

            // edit
            $(document).on('click', '.button-update', function(){
                Panel.action('show','update');
                var key = $(this).data('id');
                $.ajax({
                    url:"admin/jabatan/jabatan/"+key,
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

        //     // delete
        //     $(document).on('click', '.button-delete', function (e) {
        //         e.preventDefault();
        //         var key = $(this).data('id');
        //         Swal.fire({
        //             title: "Perhatian ",
        //             text: "Yakin ingin meghapus data.?",
        //             icon: "warning",
        //             showCancelButton: true,
        //             confirmButtonText: "Hapus",
        //             cancelButtonText: "Batal",
        //             customClass: {
        //                 confirmButton: "btn btn-danger",
        //                 cancelButton: "btn btn-light-danger",
        //                }
        //         }).then(function(result) {
        //             console.log(result);
        //             if (result.value) {
        //                 $.ajax({
        //                     method: 'delete',
        //                     url: 'admin/jabatan/jabatan/'+key,
        //                     data:{
        //                         "_token": "{{ csrf_token() }}"
        //                     }
        //                 })
        //                 .then(function(response){
        //                     if(response.success){
        //                         Swal.fire(
        //                             "Deleted!",
        //                             "Data terhapus",
        //                             "success"
        //                         );
        //                         dataRow.destroy();
        //                         dataRow.init();
        //                     }
        //                 });
        //             }
        //         });
        //     })
        });

    </script>
@endsection