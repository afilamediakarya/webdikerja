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
                                <th>Golongan</th>
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
                                <span class="invalid-feedback"></span>
                            </div>

                            <div class="form-group col-6">
                                <label>NIP</label>
                                <input type="text" class="form-control form-control-solid" name="nip">
                                <span class="invalid-feedback"></span>
                            </div>

                            <div class="form-group col-6">
                                <label>Tempat Lahir</label>
                                <input type="text" class="form-control form-control-solid" name="tempat_lahir">
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="form-group col-6">
                                <label>Tanggal Lahir</label>
                                <div class="input-group date" >
                                    <input type="text" class="form-control form-control-solid" readonly name="tanggal_lahir" value="{{date("1990-m-d")}}" id="tgl_lahir"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                                <span class="invalid-feedback"></span>
                            </div>
                            
                            
                            @if($role == 'super_admin')
                            <div class="form-group col-6">
                                <label>Satuan Kerja</label>
                                <select name="id_satuan_kerja" class="form-control form-control-solid">
                                    <option value="">Pilih Satuan Kerja</option>
                                    @foreach ($dinas as $item)
                                        <option value="{{$item['id']}}">{{$item['nama_satuan_kerja']}}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback"></span>
                            </div>
                            @else
                                <input type="hidden" name="id_satuan_kerja" value="{{$dinas}}">
                            @endif

                            <!-- <div class="form-group col-6">
                                <label>Eselon</label>
                                <select class="form-control form-control-solid" name="eselon">
                                    @foreach($eselon as $item)
                                        <option value="{{$item['value']}}">{{$item['value']}}</option>
                                    @endforeach
                                </select>
                            </div> -->

                            <div class="form-group col-6">
                                <label>Golongan Pangkat</label>
                                <select name="golongan" class="form-control form-control-solid">
                                    @foreach ($pangkat as $item)
                                        <option value="{{$item['value']}}">{{$item['value']}}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback"></span>
                            </div>
                            <div class="form-group col-6">
                                <label>TMT Golongan</label>
                                <div class="input-group date" >
                                    <input type="text" class="form-control form-control-solid" readonly  value="{{date("Y-m-d")}}" id="tmt_gol" name="tmt_golongan"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                                <span class="invalid-feedback"></span>
                            </div>
<!-- 
                            <div class="form-group col-6">
                                <label>Jenis Jabatan Pegawai</label>
                                <select class="form-control form-control-solid" name="jenis_jabatan">
                                   
                                    @foreach ($jabatan as $item)
                                        <option value="{{$item['id']}}">{{$item['nama_jabatan']}}</option>
                                    @endforeach
                               
                                </select>
                            </div> -->
                            <!-- <div class="form-group col-6">
                                <label>Jabatan Pegawai</label>
                                <select class="form-control form-control-solid" name="jabatan">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Non Aktif">Non Aktif</option>
                                </select>
                            </div> -->
                            <!-- <div class="form-group col-6">
                                <label>TMT Jabatan</label>
                                <div class="input-group date" >
                                    <input type="text" class="form-control form-control-solid" readonly  value="{{date("Y-m-d")}}" name="tmt_jabatan" id="tmt_jab"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="form-group col-6">
                                <label>TMT Pegawai</label>
                                <div class="input-group date" >
                                    <input type="text" class="form-control form-control-solid" readonly  value="{{date("Y-m-d")}}" name="tmt_pegawai" id="tmt_peg"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div> -->
                            
                            
                            <!-- <div class="form-group col-6">
                                <label>Jenis Jabatan</label>
                                <select class="form-control form-control-solid" name="jenis_jabatan">
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                            </div>
                             -->
                            <div class="form-group col-6">
                                <label>Jenis Kelamin</label>
                                <select class="form-control form-control-solid" name="jenis_kelamin">
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <div class="form-group col-6">
                                <label>Agama</label>
                                <select name="agama" class="form-control form-control-solid">
                                    @foreach($agama as $item)
                                        <option value="{{$item['value']}}">{{$item['value']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-6">
                                <label>Status Perkawinan</label>
                                <select name="status_perkawinan" class="form-control form-control-solid">
                                    @foreach($status_kawin as $item)
                                        <option value="{{$item['value']}}">{{$item['value']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label>Pendidikan Terakhir</label>
                                <select name="pendidikan" class="form-control form-control-solid">
                                    @foreach($pendidikan as $item)
                                        <option value="{{$item['value']}}">{{$item['value']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label>Tahun Lulus</label>
                                <input type="text" class="form-control form-control-solid" name="lulus_pendidikan">
                            </div>


                            <!-- <div class="form-group col-6">
                                <label>Pendidikan Struktural</label>
                                <input type="text" class="form-control form-control-solid" name="pendidikan_struktural">
                            </div>
                            <div class="form-group col-6">
                                <label>Tahun Lulus Pendidikan Struktural</label>
                                <input type="text" class="form-control form-control-solid" name="lulus_pendidikan_struktural">
                            </div> -->

                            <input type="hidden" value="pegawai" name="type">

                            <div class="form-group col-6">
                                <label>Jurusan</label>
                                <input type="text" class="form-control form-control-solid" name="jurusan">
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
        let role = {!! json_encode($role) !!}
        console.log(role);
        var dataRow = function() {
            let columnDefs = [];
            if (role == 'admin_opd') {
                columnDefs = [
                    {
                            targets: -1,
                            title: 'Actions',
                            orderable: false,
                            render: function(data, type, full, meta) {
                                return '\
                                    <a href="javascript:;" type="button" data-id="'+data+'" class="btn btn-secondary button-update">ubah</a>\
                                ';
                            }
                        }
                ];
            } else {
                columnDefs = [
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
                ];
            }

            console.log(columnDefs);

            var init = function() {
                var table = $('#kt_datatable');
                
                table.DataTable({
                    responsive: true,
                    pageLength: 25,
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
                        {
                            data:'golongan',
                            render: function (data) {
                                    return data !== null ? data : '-'
                            }
                        },
                        {
                            data:'id',
                        }
                    ],
                    filter: function (data) {
                        console.log(data);
                    },
                    columnDefs: columnDefs
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
            $("input").removeClass('is-invalid');
            $("select").removeClass('is-invalid');
            $("textarea").removeClass('is-invalid');
        })
        
        $(document).on('click', ".btn-cancel", function(){
            $("#table").toggle();
            $("#form").toggle();
            $(".open_form").toggle();
        })

        $(document).on('submit', "#createForm[data-type='submit']", function(e){
            e.preventDefault();
            axios.post( "{{route('store-pegawai')}}", $(this).serialize())
            .then(function(res){
                var data = res.data;
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
                        $("textarea[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                        $("select[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
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
                        $("#table").toggle();
                        $("#form").toggle();
                        $(".open_form").toggle();
                    });
                }
            }).catch(function(){
                swal.fire({
                    text: "Terjadi Kesalahan Sistem",
                    title:"Error",
                    icon: "error",
                    showConfirmButton:true,
                    confirmButtonText: "OK",
                })
            });
        });

        $(document).on('submit', "#createForm[data-type='update']", function(e){
            e.preventDefault();
            var _id = $("input[name='id']").val();
            axios.post( `admin/pegawai/update/${_id}`,  $(this).serialize())
            .then(function(res){
                var data = res.data;
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
                        $("textarea[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
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
                        $("#table").toggle();
                        $("#form").toggle();
                        $(".open_form").toggle();
                    });
                }
            }).catch(function(){
                swal.fire({
                    text: "Terjadi Kesalahan Sistem",
                    title:"Error",
                    icon: "error",
                    showConfirmButton:true,
                    confirmButtonText: "OK",
                })
            });
        });

        $(document).on('click', ".button-update", function(){
            $("#table").toggle();
            $("#form").toggle();
            $(".open_form").toggle();
            $("#createForm").attr('data-type','update');
            $("#createForm")[0].reset();
            $("input").removeClass('is-invalid');
            $("select").removeClass('is-invalid');
            $("textarea").removeClass('is-invalid');

            var key = $(this).data('id');
            axios.get('admin/pegawai/'+key)
            .then(function(res){
                let data = res.data;
                console.log(data);
                $.map(data.data, function(val, i){
                    $("input[name="+i+"]").val(val);
                    $("select[name="+i+"]").val(val);
                    
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
            $('#tmt_peg, #tmt_jab, #tmt_gol, #tgl_lahir').datepicker({format: 'yyyy-mm-dd'});
            dataRow.init();
        });

    </script>
@endsection