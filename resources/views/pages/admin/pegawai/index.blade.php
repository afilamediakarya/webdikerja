@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('button')
    <button class="btn btn-primary font-weight-bolder open_form">
        <span class="svg-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        Tambah Pegawai
    </button>
    <button style="display: none" class="btn btn-secondary font-weight-bolder open_form">
        <span class="svg-icon "><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                    <rect x="0" y="7" width="16" height="2" rx="1"/>
                    <rect opacity="0.3" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) " x="0" y="7" width="16" height="2" rx="1"/>
                </g>
            </g>
        </svg><!--end::Svg Icon--></span>
        
        Batal
    </button>
@endsection


@section('content')

<!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            
            <!--begin::Card-->
            <div class="card card-custom" id="table">
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-borderless table-head-bg" id="kt_datatable" style="margin-top: 13px !important">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Jabatan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>

            <div class="card card-custom gutter-b example example-compact" style="display: none" id="form">
                <div class="card-header">
                    <h3 class="card-title">Tambah Pegawai</h3>
                </div>
                <form class="form" id="createForm" data-type="submit">
                    <input type="hidden" name="id">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Nama</label>
                                <input type="text" class="form-control form-control-solid" value="" name="nama">
                            </div>

                            <div class="form-group col-6">
                                <label>NIP</label>
                                <input type="text" class="form-control form-control-solid" name="nip">
                            </div>

                            <div class="form-group col-6">
                                <label>Tempat Lahir</label>
                                <input type="text" class="form-control form-control-solid" name="tempat_lahir">
                            </div>
                            <div class="form-group col-6">
                                <label>Tanggal Lahir</label>
                                <div class="input-group date" >
                                    <input type="text" class="form-control form-control-solid" readonly name="tgl_lahir" value="{{date("d-m-1990")}}" id="tgl_lahir"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-6">
                                <label>Golongan Pangkat</label>
                                <select name="golongan_pangkat" class="form-control form-control-solid">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label>TMT Golongan</label>
                                <div class="input-group date" >
                                    <input type="text" class="form-control form-control-solid" readonly  value="{{date("d-m-Y")}}" id="tmt_gol" name="tmt_golongan"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-6">
                                <label>Status Pegawai</label>
                                <select class="form-control form-control-solid" name="status_pegawai">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Non Aktif">Non Aktif</option>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label>TMT Pegawai</label>
                                <div class="input-group date" >
                                    <input type="text" class="form-control form-control-solid" readonly  value="{{date("d-m-Y")}}" name="tmt_pegawai" id="tmt_peg"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group col-6">
                                <label>Eselon</label>
                                <select class="form-control form-control-solid" name="eselon">
                                    <option value="1">Eselon I</option>
                                    <option value="2">Eselon II</option>
                                    <option value="3">Eselon III</option>
                                    <option value="4">Eselon IV</option>
                                    <option value="5">Eselon V</option>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label>Jenis Jabatan</label>
                                <select class="form-control form-control-solid" name="jenis_jabatan">
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                            </div>
                            
                            <div class="form-group col-6">
                                <label>Jenis Kelamin</label>
                                <select class="form-control form-control-solid" name="jenis_kelamin">
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                            </div>

                            <div class="form-group col-6">
                                <label>Agama</label>
                                <select name="agama" class="form-control form-control-solid">
                                    <option value="Islam">Islam</option>
                                    <option value="Nasrani">Nasrani</option>
                                    <option value="Budha">Budha</option>
                                </select>
                            </div>

                            <div class="form-group col-6">
                                <label>Status Perkawinan</label>
                                <select name="status_perkawinan" class="form-control form-control-solid">
                                    <option value="Menikah">Menikah</option>
                                    <option value="Cerai">Cerai</option>
                                    <option value="Belum Menikah">Belum Menikah</option>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label>Pendidikan Terakhir</label>
                                <select name="pendidikan_akhir" class="form-control form-control-solid">
                                    <option value="SLTA/Sederajat">SLTA/Sederajat</option>
                                    <option value="Diploma I/II">Diploma I/II</option>
                                    <option value="Akademi/Diploma III/Sarjana Muda">Akademi/Diploma III/Sarjana Muda</option>
                                    <option value="Diploma IV/Strata I">Diploma IV/Strata I</option>
                                    <option value="Strata II">Strata II</option>
                                    <option value="Strata III">Strata III</option>
                                </select>
                            </div>

                            <div class="form-group col-6">
                                <label>No. NPWP</label>
                                <input type="text" class="form-control form-control-solid" name="no_npwp">
                            </div>

                            <div class="form-group col-6">
                                <label>No. KTP</label>
                                <input type="text" class="form-control form-control-solid" name="no_ktp">
                            </div>

                            <div class="form-group col-12">
                                <label>Alamat</label>
                                <input type="text" class="form-control form-control-solid" name="alamat_rumah">
                            </div>
                            <div class="form-group col-6">
                                <label>E-Mail</label>
                                <input type="text" class="form-control form-control-solid" name="email">
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-footer border-0">
                        <button type="reset" class="btn btn-outline-primary mr-2 btn-cancel">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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
        var dataRow = function() {
            var init = function() {
                var table = $('#kt_datatable');
                // begin first table
                table.DataTable({
                    responsive: true,
                    pageLength: 10,
                    order: [[0, 'asc']],
                    processing:true,
                    ajax: '{{ route('pegawai') }}',
                    columns:[{ 
                            data : null, 
                            render: function (data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                            }  
                        },
                        {data:'nama'},
                        {data:'nip'},
                        {data:'jenis_jabatan'},
                        {data:'status_pegawai'},
                        {
                            data:'id',
                        }
                    ],
                    columnDefs: [
                        {
                            targets: 4,
                            render: function(data, type, full, meta) {
                                var status = {
                                    'tidak aktif': {'title': 'tidak aktif', 'class': ' label-light-danger text-capitalize'},
                                    'Aktif': {'title': 'aktif', 'class': ' label-light-primary text-capitalize'},
                                };
                                if (typeof status[data] === 'undefined') {
                                    return data;
                                }
                                return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title + '</span>';
                            },
                        },
                        {
                            targets: -1,
                            title: 'Actions',
                            orderable: false,
                            render: function(data, type, full, meta) {
                                return '\
                                    <a href="javascript:;" type="button" data-id="'+data+'" class="btn btn-secondary button-update">ubah</a>\
                                    <a href="javascript:;" type="button" data-id="'+data+'" class="btn btn-danger button-delete">Hapus</a>\
                                ';
                            }
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

        $(document).on('click', ".open_form", function(){
            $("#table").toggle();
            $("#form").toggle();
            $(".open_form").toggle();
            $("#createForm").attr('data-type','submit');
            $("#createForm")[0].reset();
        })
        
        $(document).on('click', ".btn-cancel", function(){
            $("#table").toggle();
            $("#form").toggle();
            $(".open_form").toggle();
        })

        

        $(document).on('submit', '#createForm', function(e){
            e.preventDefault();
            $("input").removeClass('is-invalid');
            var type = $(this).data('type');
            var url = '';
            let id = $("input[name='id']").val();
            if (type == 'submit') {
                url = "{{route('store-pegawai')}}";
            }else{
                url = "admin/pegawai/"+id;
            }

            axios.post(url, $(this).serialize())
            .then(function(res){
                let data = res.data; 
                if (data.invalid) {
                    $.map(data.invalid, function(val, i){
                        if (i == 'tempat_tanggal_lahir') {
                            $("input[name='tempat_lahir']").addClass('is-invalid').siblings('.invalid-feedback').html(val[0]);
                        }
                        $("input[name="+i+"]").addClass('is-invalid').siblings('.invalid-feedback').html(val[0]);
                    })
                } else if(data.success){
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
                        $("#table").toggle();
                        $("#form").toggle();
                        $(".open_form").toggle();
                    });
                }else{
                    swal.fire({
                        text: "Terjadi Kesalahan Sistem",
                        title:"Error",
                        icon: "error",
                        showConfirmButton:true,
                        confirmButtonText: "OK",
                    });
                }
            })
            .catch(function(error){
                console.log('error',error);
                swal.fire({
                    text: "Terjadi Kesalahan Sistem",
                    title:"Error",
                    icon: "error",
                    showConfirmButton:true,
                    confirmButtonText: "OK",
                })
            })
        })

        $(document).on('click', ".button-update", function(){
            $("#table").toggle();
            $("#form").toggle();
            $(".open_form").toggle();
            $("#createForm").attr('data-type','update');
            $("#createForm")[0].reset();
            var key = $(this).data('id');
            axios.get('admin/pegawai/'+key)
            .then(function(res){
                let data = res.data;
                $.map(data.data, function(val, i){
                    $("input[name="+i+"]").val(val);
                    if (i == 'tempat_tanggal_lahir') {
                        var d = val.split(',');
                        $("input[name='tempat_lahir']").val(d[0]);
                        $("input[name='tgl_lahir']").val(d[1]);
                    }
                })
            })
            .catch(function(err){

            });
        })

        $(document).on('click', ".button-delete", function(){
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
                    axios.delete('admin/pegawai/'+key)
                    .then(function(res){
                        let data = res.data;
                        if (data.success) {
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
                                "Data tidak terhapus",
                                "error"
                            );
                        }
                    })
                    .catch(function(err){
        
                    });
                }
            });
        })

        jQuery(document).ready(function() {
            $('#tmt_peg, #tmt_gol, #tgl_lahir').datepicker({format: 'dd-mm-yyyy'});
            dataRow.init();
        });

    </script>
@endsection