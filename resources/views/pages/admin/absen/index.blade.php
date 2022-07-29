@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('button')
    <button class="btn btn-primary font-weight-bolder" id="side_form_open">
        <span class="svg-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        Tambah Absen
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
                    
                    <div class="row" style="margin-bottom: 1rem">
                        <div class="col-lg-2">
                            <select class="form-control" type="text" id="filter-satuan-kerja">
                                <!-- <option disabled selected> Pilih Satuan Kerja </option> -->
                                <option selected disabled> Pilih satuan kerja</option>
                                @foreach ($satker as $key => $value)
                                    <option value="{{$value['id']}}">{{$value['nama_satuan_kerja']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <input type="date" value="{{ date('Y-m-d') }}" class="form-control" id="filter-tanggal">
                        </div>
                        <div class="col-lg-2">
                            <select class="form-control" id="valid_">
                            <option value="semua" selected>semua</option>
                                <option value="0">invalid</option>
                                <option value="1">valid</option>
                                
                            </select>        
                        </div>
                        <button class="btn btn-primary btn-sm" id="filter-btn" style="position:relative;right:0px;">Filter</button>
                    </div>
                    <table class="table table-borderless table-head-bg" id="kt_absen" style="margin-top: 13px !important">
                        <thead>
                            
                            <tr>
                                <th>No</th>
                                <th>Nama Pegawai</th>
                                <th>Status</th>
                                <th>Waktu Masuk</th>
                                <th>Waktu Pulang</th>
                                <th>Validation</th>
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
				<h3 class="font-weight-bold m-0">Form Absen<h3>
				<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="side_form_close">
					<i class="ki ki-close icon-xs text-muted"></i>
				</a>
			</div>
			<!--end::Header-->
			<!--begin::Content-->
			<div class="offcanvas-content pr-5 mr-n5">
                <form class="form" id="createForm">
                    <input type="hidden" name="id"/>
                    <div class="form-group">
                        <label>Satuan Kerja</label>
                        <select class="form-control" type="text" id="id_satuan_kerja" name="satuan_kerja">
                            <option disabled selected> Pilih satuan kerja </option>
                            @foreach ($satker as $key => $value)
                                <option value="{{$value['id']}}">{{$value['nama_satuan_kerja']}}</option>
                            @endforeach
                        </select>
                       <small class="text-danger satuan_kerja_error"></small>
                    </div>

                    <div class="form-group">
                        <label>Pegawai</label>
                        <select class="form-control" type="text" id="pegawai" name="pegawai">
                         
                        </select>
                       <small class="text-danger pegawai_error"></small>
                    </div>

                    <div class="form-group form-create-form">
                        <label>Jenis</label>
                        <div class="radio-inline">
                            <label class="radio">
                            <input type="radio" value="checkin" id="checkin" name="jenis">
                            <span></span>Checkin</label>
                            <label class="radio">
                            <input type="radio" value="checkout" id="checkout" name="jenis">
                            <span></span>Checkout</label>
                        </div>
                       <small class="text-danger jenis_error"></small>
                    </div>

                    <div class="row form-update-form">
                        <div class="form-group col-6">
                            <label>Waktu absen masuk</label>
                            <input type="time" class="form-control" name="waktu_absen_masuk">
                           <small class="text-danger waktu_absen_masuk_error"></small>
                        </div>
                        <div class="form-group col-6">
                                <label>Waktu Absen pulang</label>
                                <input type="time" class="form-control" name="waktu_absen_pulang">
                           <small class="text-danger waktu_absen_pulang_error"></small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label>Tanggal</label>
                            <input type="date" class="form-control" name="tanggal">
                           <small class="text-danger tanggal_error"></small>
                        </div>
                        <div class="form-group col-6 form-create-form">
                                <label>Waktu Absen</label>
                                <input type="time" class="form-control" name="waktu_absen">
                           <small class="text-danger waktu_absen_error"></small>
                        </div>
                    </div>

                    <div class="form-group" id="status_">
                        <label>Status</label>
                        <div class="radio-inline">
                            <label class="radio">
                            <input type="radio" value="hadir" id="hadir" name="status">
                            <span></span>Hadir</label>
                            <label class="radio">
                            <input type="radio" value="dinas luar" id="dinas_luar" name="status">
                            <span></span>Dinas luar</label>
                            <label class="radio">
                            <input type="radio" value="izin" id="izin"  name="status">
                            <span></span>Izin</label>
                            <label class="radio">
                            <input type="radio" value="sakit" id="sakit" name="status">
                            <span></span>Sakit</label>
                            <label class="radio">
                            <input type="radio" value="apel" id="apel" name="status">
                            <span></span>Apel</label>
                        </div>
                       <small class="text-danger status_error"></small>
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
      <script src="{{asset('plugins/custom/price-format/jquery.priceformat.min.js')}}"></script>
    <script>
        let url = {!! json_encode($url) !!};

    $(document).on('change','#id_satuan_kerja', function () {
        satuanKerjaChange('',$(this).val());
    
    })

    $(document).on('click','#side_form_open', function (e) {
        e.preventDefault();
        $("#pegawai").prop('disabled', false);
            $("#id_satuan_kerja").prop('disabled', false);
            $("input[name='tanggal']").prop('disabled', false);
        $('.form-create-form').show();
        $('.form-update-form').hide();
        $('#pegawai').val(null).trigger('change');
        $('#id_satuan_kerja').val(null).trigger('change');
        Panel.action('show','submit')
    })

    function satuanKerjaChange(params,value) {
        $.ajax({
            url : '/admin/axios/pegawai/'+value,
            method : 'GET',
            success : function (res) {
                $('#pegawai').html('').trigger('change');
                let newOption = ' <option disabled selected> Pilih Pegawai </option>';
              
                if (res.success) {
                    $.each(res.success, function (indexInArray, valueOfElement) { 
                     newOption += `<option value="${valueOfElement.id}">${valueOfElement.value}</option>`;
                    });
                    $('#pegawai').append(newOption).trigger('change');
                    // if (params !== null) {
                        $('#pegawai').val(params).trigger('change');
                        $('#id_satuan_kerja').val(value).trigger('change.select2');;
                        // $docInput.val(null).trigger('change.select2');
                    // }
                    
                }
            }, 
            error : function (xhr) {
                alert('gagal');
            }
        })
    }

    $(document).on('click', '.button-update', function(){
        Panel.action('show','update');
        $('#pegawai').val(null).trigger('change');
        $('#id_satuan_kerja').val(null).trigger('change');
        $('.form-create-form').hide();
        $('.form-update-form').show();
        $('.text_danger').html('');
        var key = $(this).data('id');
        let params = key.split(",");
        console.log(params);
        $.ajax({
            url:"admin/absen/"+params[0]+'/'+params[1]+'/'+params[2],
            method:"GET",
            success: function(response){
             console.log(response.success)
            if (response.success) {
                satuanKerjaChange(response.success['satker']['id_pegawai'],response.success['satker']['satuan_kerja']);
                $.each(response.success, function( key, value ) {
                    if(key == 'status'){
                        $(`#${value}`).prop('checked', true);
                    }
                    else{
                        $("input[name='"+key+"']").val(value); 
                        $('#checkin').prop('checked',true);
                    }
                });
            }
            $("#pegawai").prop('disabled', true);
            $("#id_satuan_kerja").prop('disabled', true);
            $("input[name='tanggal']").prop('disabled', true);
            }
        });
        
    })

    $(document).on('submit', "#createForm[data-type='submit']", function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url : "{{route('post-absen')}}",
            method : 'POST',
            data: $('#createForm').serialize(),
            success : function (res) {
                $('.text_danger').html('');
                console.log(res);
                if (res.success) {
                    swal.fire({
                        text: 'Absen berhasil di tambahkan',
                        icon: "success",
                        showConfirmButton:true,
                        confirmButtonText: "OK, Siip",
                    }).then(function() {
                        $("#createForm")[0].reset();
                        Panel.action('hide');
                        $('.text_danger').html('');
                        $('#pegawai').val(null).trigger('change');
                        $('#id_satuan_kerja').val(null).trigger('change');
                        datatable_();
                        // $('#kt_datatable').DataTable().ajax.reload();
                    });      
                }else if(res.fails){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Maaf, Anda tidak bisa absen',
                        text: res.fails
                    })
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Maaf, terjadi kesalahan',
                        text: 'Silahkan Hubungi Admin'
                    })
                }
            
            },
            error : function (xhr) {
                $('.text_danger').html('');
                let error = xhr.responseJSON.errors;
                $.each( error, function( key, value ) {
                    $(`.${key}_error`).html(value)
                }); 
            }
        });
    });

    $(document).on('submit', "#createForm[data-type='update']", function(e){
        e.preventDefault();

        $("#pegawai").prop('disabled', false);
        $("#id_satuan_kerja").prop('disabled', false);
        $("input[name='tanggal']").prop('disabled', false);

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url : "/admin/absen/"+$('#pegawai').val(),
            method : 'POST',
            data: $('#createForm').serialize(),
            success : function (res) {
                $('.text_danger').html('');
                console.log(res);
                if (res.success) {
                    swal.fire({
                        text: 'Absen berhasil di update',
                        icon: "success",
                        showConfirmButton:true,
                        confirmButtonText: "OK, Siip",
                    }).then(function() {
                        $("#createForm")[0].reset();
                        Panel.action('hide');
                        datatable_();
                    });      
                }else if(res.fails){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Maaf, Anda tidak bisa absen',
                        text: res.fails
                    })
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Maaf, terjadi kesalahan',
                        text: 'Silahkan Hubungi Admin'
                    })
                }
            
            },
            error : function (xhr) {
                $('.text_danger').html('');
                let error = xhr.responseJSON.errors;
                $.each( error, function( key, value ) {
                    $(`.${key}_error`).html(value)
                }); 
            }
        });
    });

    $(document).on('change',"input[name='jenis']",function () {
        let val = $(this).val();
        if (val == 'checkin') {
            $('#status_').show();
        }else{
            $('#status_').hide();
            
        }
    })

    $(document).on('click','#filter-btn', function () {
        datatable_();
    })

        function datatable_() {
            let satuan_kerja = $('#filter-satuan-kerja').val();
            let valid_ =  $("#valid_").val();
            let tanggal = $('#filter-tanggal').val();
            // alert("/absen/datatable/"+satuan_kerja+'/'+tanggal+'/'+valid_);
            $('#kt_absen').dataTable().fnDestroy();
            $('#kt_absen').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']],
                processing:true,
                ajax: '/admin/absen/datatable/'+satuan_kerja+'/'+tanggal+'/'+valid_,
                columns : [
                    { 
                    data : null, 
                        render: function (data, type, row, meta) {
                            console.log(data);
                                return meta.row + meta.settings._iDisplayStart + 1;
                        }  
                    },{
                        data:'nama_pegawai'
                    },{
                        data:'status'
                    },{
                        data:'waktu_masuk'
                    },{
                        data:'waktu_pulang'
                    },{
                        data:'validation',
                    },{
                        data:null,
                    }
                ],
                columnDefs : [
                    {
                        targets: 5,
                        render: function(data, type, full, meta) {
                            if (data > 0) {
                                return ` <a href="javascript:;" style="cursor:none" class="btn btn-icon btn-success btn-sm"><i class="fa fa-check" aria-hidden="true"></i></a>`;
                            }else{
                                return `<a href="javascript:;" style="cursor:none" class="btn btn-icon btn-danger btn-sm"><i class="fa fa-times" aria-hidden="true"></i></a>`;
                                
                            }
                        },
                    },
                    {
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            let params = data.id+','+data.tanggal_absen+','+data.validation;
                           
                            return `<a href="javascript:;" type="button" data-id="${params}" class="btn btn-secondary button-update">ubah</a>`;
                        },
                    }
                ]
            });
        }

        jQuery(document).ready(function() {
            Panel.init('side_form');
            $('#id_satuan_kerja').select2();
            $('#pegawai').select2({
                placeholder: "Pilih Pegawai"
            });
            $('#filter-satuan-kerja').select2({
                placeholder: "Pilih Satuan Kerja"
            });
            
            datatable_();

            

        });

    </script>
@endsection