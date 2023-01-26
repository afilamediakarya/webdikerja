@extends('layout.app')

@section('style')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('button')
    <button onclick="Panel.action('show','submit')" class="btn btn-primary font-weight-bolder" id="side_form_open">
        <span class="svg-icon">
            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                    <rect fill="#000000" opacity="0.3"
                        transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) "
                        x="4" y="11" width="16" height="2" rx="1" />
                </g>
            </svg>
            <!--end::Svg Icon-->
        </span>
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
                    {{-- @dd($dinas->first()['id']); --}}
                    {{-- @dd($dinas) --}}
                    <div id="container-filter-dinas" class="row" style="margin-bottom: 1rem">
                        <div class="col">
                            <label for="filter-satuan-kerja" class="form-label font-size-h4 font-weight-bolder">Satuan
                                Kerja</label>
                            <select class="form-control font-weight-bolder" type="text" id="filter-satuan-kerja">
                                <!-- <option disabled selected> Pilih Satuan Kerja </option> -->
                                <option selected disabled> Pilih satuan kerja</option>
                                @if ($role == 'super_admin')
                                    @foreach ($dinas as $key => $value)
                                        <option value="{{ $value['id'] }}"
                                            @if ($value['id'] == 1) selected @endif>
                                            {{ $value['nama_satuan_kerja'] }}</option>
                                    @endforeach
                                @else
                                    @foreach ($dinas as $key => $value)
                                        <option value="{{ $value['id'] }}"
                                            @if ($value['id'] == $dinas->first()['id']) selected @endif>
                                            {{ $value['nama_satuan_kerja'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <!-- <button class="btn btn-primary btn-sm" id="filter-btn" style="position:relative;right:0px;">Filter</button> -->
                    </div>

                    <!--begin: Datatable-->
                    <table class="table table-borderless table-head-bg" id="kt_datatable"
                        style="margin-top: 13px !important">
                        <thead>

                            <tr>
                                <th>No</th>
                                <th>Nama Jabatan</th>
                                <th>Nama Pegawai</th>
                                @if ($role !== 'admin_opd')
                                    <th>Satuan Kerja</th>
                                @endif
                                <th>Atasan Langsung</th>
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
            <h3 class="font-weight-bold m-0" id="title_modal">Tambah Jabatan<h3>
                    <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="side_form_close">
                        <i class="ki ki-close icon-xs text-muted"></i>
                    </a>
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="offcanvas-content pr-5 mr-n5">
            <form class="form" id="createForm">
                @csrf
                <input type="hidden" name="id" />

                <div class="form-group">
                    <label>Satuan Kerja</label>
                    <select class="form-control form-control-solid" type="text" id="id_satuan_kerja"
                        name="id_satuan_kerja">
                        <option disabled selected> Pilih Satuan Kerja </option>
                        @foreach ($dinas as $key => $value)
                            <option value="{{ $value['id'] }}">{{ $value['nama_satuan_kerja'] }}</option>
                        @endforeach
                    </select>
                      <small class="text-danger id_satuan_kerja_error"></small>
                </div>

                <div class="form-group">
                    <label>Nama Jabatan</label>
                    <input class="form-control form-control-solid" type="text" name="nama_jabatan" />
                      <small class="text-danger nama_jabatan_error"></small>
                </div>

                <div class="form-group">

                    <label>Nama Pejabat</label>
                    <select class="form-control form-control-solid select_" type="text" name="id_pegawai" id="pegawai">
                        <option selected disabled>Pilih pegawai</option>
                        <option>-</option>
                        <!-- <option value="">Kosong</option> -->
                        @foreach ($pegawai as $item)
                            <option value="{{ $item['id'] }}">{{ $item['value'] }}</option>
                        @endforeach
                    </select>
                      <small class="text-danger id_pegawai_error"></small>

                </div>

                  <div class="form-group">
                    <label>Status Jabatan</label>
                    <div class="radio-inline">
                        <label class="radio">
                            <input type="radio" value="Definitif" name="status_jabatan">
                            <span></span>Definitif</label>
                        <label class="radio">
                            <input type="radio" value="PLT/PLS" name="status_jabatan">
                            <span></span>PLT/PLS</label>
                    </div>
                      <small class="text-danger status_jabatan_error"></small>
                </div>

                <div class="form-group">
                    <label>Kelas Jabatan</label>
                    <select class="form-control form-control-solid" type="text" id="kelas_jabatan"
                        name="kelas_jabatan">
                        <option disabled selected> Pilih Kelas Jabatan </option>
                        @for ($x=0; $x <= 15; $x++)
                            <option value="{{ $x }}">{{ $x }}</option>
                        @endfor
                    </select>
                      <small class="text-danger kelas_jabatan_error"></small>
                </div>

                <div class="form-group">
                    <label>Jenis Jabatan</label>
                    <select class="form-control form-control-solid" type="text" name="id_jenis_jabatan"
                        id="id_jenis_jabatan">
                        <option disabled selected>Pilih Jenis Jabatan</option>
                        @foreach ($jenisJabatan as $item)
                            <option value="{{ $item['id'] }}">{{ $item['value'] }}</option>
                        @endforeach
                    </select>
                      <small class="text-danger id_jenis_jabatan_error"></small>
                </div>

                 <div class="form-group">
                    <label>Kelompok Jabatan</label>
                    <select class="form-control form-control-solid select_" type="text" name="kelompok_jabatan"
                        id="kelompok_jabatan">
    
                     
                    </select>
                      <small class="text-danger "></small>
                </div>

                <div class="form-group">
                    <label>Atasan langsung</label>
                    <select class="form-control form-control-solid" type="text" name="parent_id" id="parent">

                    </select>
                      <small class="text-danger parent_id_error"></small>
                </div>
                  

                <div class="form-group">
                    <label>Nilai Jabatan</label>
                    <input type="text" class="form-control form-control-solid price" name="nilai_jabatan">
                      <small class="text-danger nilai_jabatan_error"></small>
                </div>
                

                <div class="form-group">
                    <label>Pembayaran TPP</label>
                    <div class="radio-inline">
                        <label class="radio">
                            <input type="radio" value="100" name="pembayaran_tpp">
                            <span></span>100%</label>
                        <label class="radio">
                            <input type="radio" value="20" name="pembayaran_tpp">
                            <span></span>20%</label>
                        <label class="radio">
                            <input type="radio" value="0" name="pembayaran_tpp">
                            <span></span>0%</label>
                    </div>
                      <small class="text-danger pembayaran_tpp_error"></small>
                </div>

                <div class="form-group">
                    <label>Target Waktu</label>
                    <input type="number" class="form-control form-control-solid" value="6750" name="target_waktu">
                      <small class="text-danger target_waktu_error"></small>
                </div>

               
                

                <div class="form-group">

                    <label>Pilih lokasi kerja</label>
                    <select class="form-control form-control-solid" type="text" name="id_lokasi" id="id_lokasi">
                        <option selected disabled>Pilih lokasi kerja</option>
                        @foreach ($lokasiKerja as $loc => $locs)
                            <option value="{{ $locs['id'] }}">{{ $locs['nama_lokasi'] }}</option>
                        @endforeach
                    </select>
                      <small class="text-danger id_lokasi_error"></small>

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
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('plugins/custom/price-format/jquery.priceformat.min.js') }}"></script>
    <script>
        "use strict";
        let role = {!! json_encode($role) !!};

        let dinas = $('#filter-satuan-kerja').val();

        $(function() {
            datatable_(dinas);
        })

        function datatable_(dinas) {

            $('#kt_datatable').dataTable().fnDestroy();

            $('.price').priceFormat({
                prefix: '',
                centsLimit: 0,
                allowNegative: true
            });


            let columns = [];
            let columnDefs = [];

            if (role !== 'admin_opd') {
                columns = [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                        // console.log(data);
                    }
                }, {
                    data: 'nama_jabatan'
                }, {
                    data: 'nama'
                }, {
                    data: 'nama_satuan_kerja'
                }, {
                    data: 'atasan_langsung'
                }, {
                    data: 'id',
                }];

                columnDefs = [{
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            return `<a href="javascript:;" type="button" data-id="${data}" class="btn btn-secondary button-update">ubah</a><a href="javascript:;" type="button" data-id="${data}" class="btn btn-danger button-delete">Hapus</a>`;
                        },
                    },
                    {
                        targets: 4,
                        render: function(data, type, full, meta) {
                            let atasan_langsung = '';

                            $.each(data, function(key, val) {

                                // console.log(val);
                                atasan_langsung = val.nama + " - " + val.nama_jabatan

                            });

                            return atasan_langsung;
                        },
                    }
                ];
            } else {
                columns = [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, {
                    data: 'nama_jabatan'
                }, {
                    data: 'nama'
                }, {
                    data: 'atasan_langsung'
                }, {
                    data: 'id',
                }];

                columnDefs = [{
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            return `<a href="javascript:;" type="button" data-id="${data}" class="btn btn-secondary button-update">ubah<a>`;
                        },
                    },
                    {
                        targets: 3,
                        render: function(data, type, full, meta) {
                            let atasan_langsung = '';

                            $.each(data, function(key, val) {

                                // console.log(val);
                                atasan_langsung = val.nama + " - " + val.nama_jabatan
                                if (full.parent_id == null) {
                                    atasan_langsung = "-";
                                }

                            });

                            return atasan_langsung;
                        },
                    }
                ];
            }

            // begin first table
            if (role == 'super_admin') {
                $('#kt_datatable').DataTable({
                    responsive: true,
                    pageLength: 10,
                    order: [
                        [0, 'asc']
                    ],
                    processing: true,
                    ajax: "{{ route('jabatan') }}?dinas=" + dinas,
                    data: {
                        dinas: dinas
                    },
                    columns: columns,
                    columnDefs: columnDefs,
                });
            } else {
                $('#kt_datatable').DataTable({
                    responsive: true,
                    pageLength: 10,
                    order: [
                        [0, 'asc']
                    ],
                    processing: true,
                    ajax: "{{ route('jabatan') }}",

                    columns: columns,
                    columnDefs: columnDefs,
                });
            }


            // var destroy = function() {
            //     var table = $('#kt_datatable').DataTable();
            //     table.destroy();
            // }

            // return {
            //     init: function() {
            //         init();
            //     },
            //     destroy: function() {
            //         destroy();
            //     }

            // };

        };

        $(document).on('click','#side_form_open',function () {
            $('#title_modal').html("Tambah Jabatan");
        })


        $(document).on('submit', "#createForm[data-type='submit']", function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.ajax({
                url : "{{ route('post-jabatan') }}",
                method : 'POST',
                data: $('#createForm').serialize(),
                success : function (res) {
                    $('.text_danger').html('');
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
                    let error = xhr.responseJSON;
                    $.each( error, function( key, value ) {
                        console.log(key + ' | ' +value)
                        $(`.${key}_error`).html(value)
                    }); 
                }
            });
            // AxiosCall.post("{{ route('post-jabatan') }}", $(this).serialize(), "#createForm");
            //         Panel.action("hide");
        });

        $(document).on('change', '#id_satuan_kerja', function() {
            let val = $(this).val();
            pegawaiBysatuanKerja(val);
        })

        $(document).on('change','#id_jenis_jabatan',function () {
           let params = $(this).val();
            kelompok_jabatan_select(params);
              jenis_jabatan(params, '');
            //   beddu
        })


        $(document).on('submit', "#createForm[data-type='update']", function(e) {
            e.preventDefault();
            var _id = $("input[name='id']").val();
            // AxiosCall.post(`admin/jabatan/jabatan/${_id}`, $(this).serialize(), "#createForm");
            //                  Panel.action("hide");

               $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.ajax({
                url : `admin/jabatan/jabatan/${_id}`,
                method : 'POST',
                data: $(this).serialize(),
                success : function (res) {
                    $('.text_danger').html('');
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
                    let error = xhr.responseJSON;
                    $.each( error, function( key, value ) {
                        console.log(key + ' | ' +value)
                        $(`.${key}_error`).html(value)
                    }); 
                }
            });
        });

        $(document).on('click', '.button-delete', function(e) {
            e.preventDefault();
            var key = $(this).data('id');
            console.log(key);
            AxiosCall.delete(`admin/jabatan/jabatan/${key}`);
        })

        function kelompok_jabatan_select(params, value = null) {
            // alert('kelompok jabatan');
         $('#kelompok_jabatan').html('').trigger('change');
            $.ajax({
                url : '/admin/master-aktivitas/kelompok-jabatan/get-option/'+params,
                method : 'GET',
                success : function (res) {
                // $('#kelompok_jabatan').append(newOption).trigger('change');
                //   $('#kelompok_jabatan').val(null).trigger('change');
               
                    let newOption = '<option selected disabled> Pilih kelompok jabatan </option>'; 
                   $.each(res, function(indexInArray, valueOfElement) {
                        newOption += `<option value="${valueOfElement.id}">${valueOfElement.value}</option>`;
                    });
                        $('#kelompok_jabatan').append(newOption).trigger('change');
                       if (value !== null) {
                                $('#kelompok_jabatan').val(value);
                                $("#kelompok_jabatan").trigger('change');
                            }

                        
                }
            })
        }

         function jenis_jabatan(val, parent) {
         
                let newOption = '<option selected disabled>Pilih atasan langsung</option><option>-</option>';
                $.ajax({
                    type: "GET",
                    url: "/admin/jabatan/getParent/" + val + '?satuan_kerja='+$('#id_satuan_kerja').val(),
                    success: function(response) {
                        console.log(response);
                        $('#parent').empty();
                        if (response != '') {


                            $.each(response, function(indexInArray, valueOfElement) {
                                // var newOption = new Option(valueOfElement.value, valueOfElement.id, false, false);
                                // console.log(newOption);
                                newOption +=
                                    `<option value="${valueOfElement.id}">${valueOfElement.value}</option>`;


                            });

                            $('#parent').append(newOption).trigger('change');
                            if (parent !== '') {
                                $('#parent').val(parent);
                                $("#parent").trigger('change');
                            }
                        }
                    }
                });
            }

        jQuery(document).ready(function() {
            Panel.init('side_form');
            // dataRow.init();
            $('#jadwal_1, #jadwal_2').datepicker({
                format: 'dd-mm-yyyy'
            });
            $('#pegawai').select2({
                placeholder: "Pilih Pegawai"
            });

             $('#kelompok_jabatan').select2({
                placeholder: "Pilih Kelompok Jabatan"
            });

            $('#id_lokasi').select2();

            $('#parent').select2({
                placeholder: "Pilih Atasan"
            });

            $(document).on('click', '.btn-cancel', function() {
                Panel.action('hide');
            });

            // edit
            $(document).on('click', '.button-update', function() {

                $('#pegawai').val(null).trigger('change');
                $('#parent').val(null).trigger('change');
                Panel.action('show', 'update');
                $('#title_modal').html('Edit Jabatan');
                var key = $(this).data('id');
                $.ajax({
                    url: "admin/jabatan/jabatan/" + key,
                    method: "GET",
                    success: function(response) {
                        let data = JSON.parse(response);
                        //   if(data.success){
                        console.log(data.data);
                        var res = data.data;
                        $.each(res, function(key, value) {

                            if (key == 'id_satuan_kerja') {
                                $("select[name='" + key + "']").val(value);
                                if (role == 'super_admin') {
                                    pegawaiBysatuanKerja(value);
                                }
                            } else if (key == 'pegawai') {
                                console.log(value);
                                if (value != null) {
                                    if (typeof value !== undefined) {
                                        if (typeof value.id !== undefined) {
                                            // $("select[name='id_pegawai']").val(1);
                                            $('#pegawai').val(value.id)
                                            $("#pegawai").trigger('change');
                                        }
                                    }
                                }

                            } else if (key == 'status_jabatan') {
                                $("input[value='" + value + "']").prop("checked", true);
                            } else if (key == 'pembayaran_tpp') {
                                $("input[value='" + value + "']").prop("checked", true);
                            } else if (key == 'nested_jabatan') {
                                kelompok_jabatan_select(value.id_jenis_jabatan,value.kelompok_jabatan);
                                $("select[name='id_jenis_jabatan']").val(value.id_jenis_jabatan);
                                // $("select[name='id_jenis_jabatan']").val(value.id_jenis_jabatan);
                            } else if (key == 'parent_id') {

                                jenis_jabatan(value.jenis_jabatan, value.parent_id);
                            } else if (key == 'nilai_jabatan') {

                                $("input[name='" + key + "']").val(value.toString()
                                    .replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                                $("input[name='" + key + "']").trigger('change');
                            } else if (key == 'id_lokasi') {
                                $('#id_lokasi').val(value);
                                $('#id_lokasi').trigger('change');

                            } else {
                                $("input[name='" + key + "']").val(value);
                                $("select[name='" + key + "']").val(value);
                            }



                        });


                        //   }
                    }
                });

            })

        });

        function pegawaiBysatuanKerja(params) {
            let newOption = '<option selected disabled>Pilih Pegawai</option><option>-</option>';
            $.ajax({
                type: "GET",
                url: "/admin/jabatan/pegawaiBySatuankerja/" + params,
                success: function(response) {
                    // console.log(response);
                    // $('#parent').val(null).trigger('change');
                    $('#pegawai').empty();
                    if (response != '') {


                        $.each(response, function(indexInArray, valueOfElement) {
                            // var newOption = new Option(valueOfElement.value, valueOfElement.id, false, false);
                            // console.log(newOption);
                            newOption +=
                                `<option value="${valueOfElement.id}">${valueOfElement.value}</option>`;


                        });

                        $('#pegawai').append(newOption).trigger('change');
                        // if (parent !== '') {
                        //     $('#parent').val(parent);
                        //     $("#parent").trigger('change');
                        // }
                    }
                }
            });
        }

        $('#filter-satuan-kerja').on('change', function() {
            let value = $(this).val();
            dinas = value;
            datatable_(value);
        })

        $('#filter-satuan-kerja').select2({
            placeholder: "Pilih Satuan Kerja"
        });

        $('[data-toggle="tooltip"]').tooltip()
    </script>
@endsection
