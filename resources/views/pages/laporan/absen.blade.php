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
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <div class='input-group' id='kt_daterangepicker_2'>
                                        <input type='text' class="form-control" readonly="readonly"
                                            placeholder="Select date range" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                        </div>
                                    </div>
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
            console.log($('#satuan_kerja').val());

            $('#satuan_kerja').select2();

            let typeRole = {!! json_encode($TypeRole) !!};

            if (typeRole == 'super_admin') {
                $('#satuan_kerja__').css('display', 'block');
            } else {
                $('#satuan_kerja__').css('display', 'none');
            }

            $('#kt_daterangepicker_2').daterangepicker({
                buttonClasses: ' btn',
                applyClass: 'btn-primary',
                cancelClass: 'btn-danger',
            }, function(start, end, label) {
                $('#kt_daterangepicker_2 .form-control').val(start.format('YYYY-MM-DD') + ' / ' + end
                    .format('YYYY-MM-DD'));
            });


            $('#preview-excel').on('click', function() {
                let val_range = $('#kt_daterangepicker_2 input').val();
                if (val_range != '') {
                    let val = val_range.split('/');
                    let params = {
                        'startDate': val[0].trim(),
                        'endDate': val[1].trim(),
                        'type': 'pdf',
                        'role': typeRole,
                        'satuanKerja': $('#satuan_kerja').val()
                    };


                    let dataParams = JSON.stringify(params);
                    console.log(params.startDate);
                    // url = '/laporan/export/rekapitulasi_pegawai/' + dataParams;
                    // window.open(url);
                    $('#kt_daterangepicker_2 .form-control').val(params.startDate + ' / 2022-08-02');
                } else {
                    Swal.fire(
                        "Perhatian",
                        "Pilih range tanggal terlebih dahulu",
                        "warning"
                    );
                }
            })

            $('#export-excel').on('click', function() {
                let val_range = $('#kt_daterangepicker_2 input').val();
                if (val_range != '') {
                    let val = val_range.split('/');
                    let params = {
                        'startDate': val[0].trim(),
                        'endDate': val[1].trim(),
                        'type': 'excel',
                        'role': typeRole,
                        'satuanKerja': $('#satuan_kerja').val()
                    };
                    let dataParams = JSON.stringify(params);
                    url = '/laporan/export/rekapitulasi_pegawai/' + dataParams;
                    window.open(url);
                } else {
                    Swal.fire(
                        "Perhatian",
                        "Pilih range tanggal terlebih dahulu",
                        "warning"
                    );
                }
            })

        });
    </script>
@endsection
