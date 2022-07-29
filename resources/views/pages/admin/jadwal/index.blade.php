@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('button')
    <button id="side_form_open" class="btn btn-primary font-weight-bolder">
        <span class="svg-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        Tambah Jadwal
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
                                <th>Nama Tahapan</th>
                                <th>Nama Sub Tahapan</th>
                                <th>Jadwal</th>
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
				<h3 class="font-weight-bold m-0">Form Jadwal<h3>
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
                        <label>Nama Tahapan</label>
                        <select name="tahapan" class="form-control">
                            <option selected disabled> Pilih tahapan </option>
                            <option value="Tahapan target">Tahapan target</option>
                            <option value="Tahapan realisasi">Tahapan realisasi</option>
                        </select>
                        <small class="text-danger tahapan_error"></small>
                    </div>
                    <div class="form-group">
                        <label>Nama Sub Tahapan</label>
                        <select name="sub_tahapan" class="form-control">
                            <option selected disabled> Pilih sub tahapan </option>
                            <option value="0">Tahunan</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <small class="text-danger sub_tahapan_error"></small>
                    </div>
                    <div class="form-group">
                        <label>Jadwal Pelaksanaan</label>
                        <div class="row">
                            <div class="input-group input-group-solid col">
                                <input type="text" class="form-control" readonly  value="{{date("d-m-Y")}}" id="jadwal_1" aria-describedby="basic-addon2" name="tanggal_awal">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar icon-lg"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-1 d-flex flex-center">
                                <label class="mb-0">s/d</label>
                            </div>
                            <div class="input-group input-group-solid col">
                                <input type="text" class="form-control" readonly  value="{{date("d-m-Y")}}" id="jadwal_2" aria-describedby="basic-addon2" name="tanggal_akhir">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar icon-lg"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
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
      
        $(document).on('click','#side_form_open', function (e) {
            e.preventDefault();
            $('.text_danger').html('');
            Panel.action('show','submit')
        })

        function datatable_() {
            $('#kt_datatable').dataTable().fnDestroy();
            $('#kt_datatable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']],
                processing:true,
                ajax: '{{route("jadwal.datatable")}}',
                columns : [
                    { 
                    data : null, 
                        render: function (data, type, row, meta) {
                            console.log(data);
                                return meta.row + meta.settings._iDisplayStart + 1;
                        }  
                    },{
                        data:'tahapan'
                    },{
                        data:'sub_tahapan'
                    },{
                        data:null
                    },{
                        data:'id',
                    }
                ],
                columnDefs : [
                    {
                        targets: 2,
                        render: function(data, type, full, meta) {
                 
                          let months = [ "Tahunan","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ];
                            return months[data];

                        },
                    },
                    {
                        targets: 3,
                        width: '22rem',
                        render: function(data, type, full, meta) {
                           return data.tanggal_awal+ ' s/d ' +data.tanggal_akhir;
                        },
                    },
                    {
                        targets: -1,
                        title: 'Actions',
                        width: '15rem',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            let params = data.id+','+data.tanggal_absen+','+data.validation;
                           
                            return `
                            <a href="javascript:;" type="button" data-id="${params}" class="btn btn-secondary btn-sm button-update">Ubah</a>
                            <a href="javascript:;" type="button" data-id="${params}" class="btn btn-danger btn-sm button-update">Hapus</a>
                            `;
                        },
                    }
                ]
            });
        }

        $(document).on('submit', "#createForm[data-type='submit']", function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url : "{{route('post-jadwal')}}",
            method : 'POST',
            data: $('#createForm').serialize(),
            success : function (res) {
                    $('.text_danger').html('');
                    console.log(res);
                    if (res.success) {
                        swal.fire({
                            text: 'Jadwal berhasil di tambahkan',
                            icon: "success",
                            showConfirmButton:true,
                            confirmButtonText: "OK, Siip",
                        }).then(function() {
                            $("#createForm")[0].reset();
                            Panel.action('hide');
                            $('.text_danger').html('');
                            // $('#kt_datatable').DataTable().ajax.reload();
                        });      
                    }else if(res.failed){
                        Swal.fire({
                            icon: 'warning',
                            title: 'Maaf, Anda gagal',
                            text: res.failed
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

        jQuery(document).ready(function() {
            Panel.init('side_form');
            datatable_();
        });

    </script>
@endsection