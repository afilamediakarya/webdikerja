@extends('layout.app')

@section('style')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Laporan</h3>
                </div>
                <div class="card-body">
                    {{-- @dd(session('user')) --}}
                    <!--begin::Form-->
                    <form class="form">

                        <div class="row">
                             @if ($type == 'pegawai')
                            <div class="form-group col-8">
                            @else
                            <div class="form-group col-3">
                            @endif
                                <label>Jenis SKP</label>
                                <select id="jenis-skp-select" class="form-control form-control-solid">
                                    <option disabled selected>Pilih Jenis Laporan</option>
                                    <option value="skp">Target SKP</option>
                                    <option value="realisasi">Realisasi SKP</option>
                                </select>
                            </div>
                            <!-- <div class="form-group col-3">
                                <label>Bulan</label>
                                <select id="bulan" class="form-control form-control-solid">
                                    <option disabled selected>Pilih Bulan</option>
                                    <option value="0">Semua</option>
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
                            </div> -->

                            @if ($level == 'super_admin' || $level == 'keuangan' && $type == 'admin')
                                <div class="form-group col-3">
                                    <label>Pilih Dinas</label>
                                    <select id="dinas" class="form-control form-control-solid">
                                        <option disabled selected>Pilih Dinas</option>
                                        @foreach ($getDataDinas as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['nama_satuan_kerja'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif ($level == 'admin_opd' && $type == 'admin')
                                <div class="form-group col-3">
                                    <label>Pilih Pegawai</label>
                                    <select id="pegawai" class="form-control form-control-solid">
                                        <option disabled selected>Pilih Pegawai</option>
                                        <option value="0">Semua Pegawai</option>
                                        @foreach ($pegawai as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['value'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="col-8 row">
                                <div class="col">
                                    <button type="reset" id="export-excel" data-type="excel" class="btn btn-block btn-success"><i
                                            class="flaticon2-pie-chart"></i>Export Excel</button>
                                </div>
                                <div class="col">
                                    <button type="reset" id="preview-excel" data-type="pdf" class="btn btn-block btn-danger"><i
                                            class="flaticon2-pie-chart"></i>Tampilkan Data</button>
                                </div>
                            </div>
                        </div>

                    </form>
                    <!--end::Form-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection

@section('script')
    <script>
        let level = {!! json_encode($level) !!};
        let type = {!! json_encode($type) !!};

        jQuery(document).ready(function() {


            $('#kt_datepicker_3').datepicker({
                todayBtn: "linked",
                clearBtn: true,
                todayHighlight: true,

            });

            $('#pegawai').select2({
                placeholder: "Pilih Pegawai"
            });
            $('#dinas').select2({
                placeholder: "Pilih Dinas"
            });
            $('#bulan').select2({
                placeholder: "Pilih Bulan"
            });
            $('#jenis-skp-select').select2({
                placeholder: "Pilih Jenis"
            });

            $('#preview-excel,#export-excel').on('click', function() {

                let jenis_skp = $('#jenis-skp-select').val();
                let bulan = 0;
                let id_pegawai = (type == 'admin') ? $('#pegawai').val() :
                    {!! json_encode($id_pegawai) !!};

                let pegawai = $('#pegawai').val();
                if (jenis_skp !== null && bulan !== null) {

                    if (type == 'admin') {
                        if (level == 'super_admin' || level == 'keuangan') {
                                 let idDinas = $('#dinas').val();
                                url =
                                    `/laporan-pegawai/export/rekapitulasiSkp/${jenis_skp}/${$(this).attr('data-type')}/${bulan}?dinas=${idDinas}`;
                                window.open(url);
                                $('#dinas').val(null).trigger("change");
                                $('#jenis-skp-select').val(null).trigger("change");
                                $('#bulan').val(null).trigger("change");
                        }else{
                                  if (id_pegawai == 0) {
                            url = `/laporan-pegawai/export/rekapitulasiSkp/${jenis_skp}/${$(this).attr('data-type')}/${bulan}`;
                            window.open(url);
                        }
                        url = `/laporan-pegawai/export/laporanSkp/${jenis_skp}/${$(this).attr('data-type')}/${bulan}/${id_pegawai}`;
                        window.open(url);
                        $('#pegawai').val(null).trigger("change");
                        $('#jenis-skp-select').val(null).trigger("change");
                        $('#bulan').val(null).trigger("change");
                        }
                    }else{
                        url = `/laporan-pegawai/export/laporanSkp/${jenis_skp}/${$(this).attr('data-type')}/${bulan}/${id_pegawai}`;
                        window.open(url);
                        $('#jenis-skp-select').val(null).trigger("change");
                        $('#bulan').val(null).trigger("change");
                    }


                } else {
                    Swal.fire(
                        "Perhatian",
                        "Lengkapi form terlebih dahulu",
                        "warning"
                    );
                }
            })

            // $('#export-excel').on('click', function() {

            //     let jenis_skp = $('#jenis-skp-select').val();
            //     let bulan = $('#bulan').val();
            //     let id_pegawai = (level == 'admin_opd' || level == 'super_admin') ? $('#pegawai').val() :
            //         {!! json_encode($id_pegawai) !!};

            //     let pegawai = $('#pegawai').val();
            //     if (jenis_skp !== null && bulan !== null) {
            //         if (level == 'admin_opd') {
            //             if (id_pegawai == 0) {
            //                 url = `/laporan-pegawai/export/rekapitulasiSkp/${jenis_skp}/excel/${bulan}`;
            //                 window.open(url);
            //             }
            //             url = `/laporan/export/laporanSkp/${jenis_skp}/excel/${bulan}/${id_pegawai}`;
            //             window.open(url);
            //             $('#pegawai').val(null).trigger("change");
            //             $('#jenis-skp-select').val(null).trigger("change");
            //             $('#bulan').val(null).trigger("change");

            //         } else {
            //             // url = `/laporan/export/laporanSkp/${jenis_skp}/excel/${bulan}`;
            //             url = `/laporan-pegawai/export/laporanSkp/${jenis_skp}/excel/${bulan}/${id_pegawai}`;
            //             window.open(url);
            //             $('#jenis-skp-select').val(null).trigger("change");
            //             $('#bulan').val(null).trigger("change");
            //         }
            //     } else {
            //         Swal.fire(
            //             "Perhatian",
            //             "Lengkapi form terlebih dahulu",
            //             "warning"
            //         );
            //     }
            // })

        });
    </script>
@endsection
