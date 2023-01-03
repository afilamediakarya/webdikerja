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
                    <!--begin::Form-->
                    <form class="form">
                        {{-- @dd($satuan_kerja) --}}
                        <div class="row">
                            <div class="col-lg-5" id="satuan_kerja__">
                                <div class="form-group">
                                    <label for="satuan_kerja">Pilih Satuan Kerja</label>
                                    <select class="form-control" id="satuan_kerja">
                                        {{-- <option disabled selected>Pilih Satuan Kerja</option> --}}
                                        @if ($satuan_kerja != null)
                                            @foreach ($satuan_kerja as $key => $value)
                                                <option value="{{ $value['id'] }}">{{ $value['nama_satuan_kerja'] }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                    
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label>Bulan</label>
                                    <select id="month" class="form-control form-control-solid">
                                        <option disabled selected>Pilih Bulan</option>
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
                                </div>
                                <div class="col-12 row">

                                    <div class="col">
                                        <button type="reset" id="export-excel" class="btn btn-block btn-success"><i
                                                class="flaticon2-pie-chart"></i>Export Excel</button>
                                    </div>
                                    <div class="col">
                                        <button type="reset" id="preview-excel" class="btn btn-block btn-danger"><i
                                                class="flaticon2-pie-chart"></i>Tampilkan Data</button>
                                    </div>
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
        jQuery(document).ready(function() {
            // console.log($('#satuan_kerja').val());

            $('#satuan_kerja').select2();
            $('#month').select2();

            let typeRole = {!! json_encode($TypeRole) !!};

            if (typeRole == 'super_admin') {
                $('#satuan_kerja__').css('display', 'block');
            } else {
                $('#satuan_kerja__').css('display', 'none');
            }

            $('#preview-excel').on('click', function() {
                let month = $('#month').val();
                if (month != null) {
                    let params = {
                        'month': month,
                        'type': 'pdf',
                        'role': typeRole,
                        'satuanKerja': $('#satuan_kerja').val()
                    };


                    let dataParams = JSON.stringify(params);
                    console.log(dataParams);
                    url = '/laporan-admin/export/rekapitulasi_tpp/' + dataParams;
                    window.open(url);
                } else {
                    Swal.fire(
                        "Perhatian",
                        "Pilih bulan terlebih dahulu",
                        "warning"
                    );
                }
            });

            $('#export-excel').on('click', function() {
                let month = $('#month').val();
                if (month != null) {
                    let params = {
                        'month': month,
                        'type': 'excel',
                        'role': typeRole,
                        'satuanKerja': $('#satuan_kerja').val()
                    };


                    let dataParams = JSON.stringify(params);
                    console.log(dataParams);
                    url = '/laporan/export/rekapitulasi_tpp/' + dataParams;
                    window.open(url);
                } else {
                    Swal.fire(
                        "Perhatian",
                        "Pilih bulan terlebih dahulu",
                        "warning"
                    );
                }
            });



        });
    </script>
@endsection
