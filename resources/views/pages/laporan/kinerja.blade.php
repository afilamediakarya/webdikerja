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

                        <div class="row">         
                        <!-- <div class="form-group">
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
                                </div> -->
                        
                        <div class="form-group col-6">
                                <label>Bulan</label>
                                <select id="bulan" class="form-control form-control-solid">
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

                            @if ($level['current']['role'] == 'super_admin')
                                <div class="form-group col-3">
                                    <label>Pilih Dinas</label>
                                    <select id="dinas" class="form-control form-control-solid">
                                        @foreach ($getDataDinas as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['nama_satuan_kerja'] }}</option>
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
        let type = {!! json_encode($type) !!};
        let level = {!! json_encode($level) !!};

        jQuery(document).ready(function() {
       
              $('#bulan').val(null).trigger('change');
                         $('#dinas').val(null).trigger('change');
            $('#kt_daterangepicker_2').daterangepicker({
                    buttonClasses: ' btn',
                    applyClass: 'btn-primary',
                    cancelClass: 'btn-danger',
                },
           
            );

            $('#kt_daterangepicker_2').on('apply.daterangepicker', function(ev, picker) {
                // $(this).val(picker.startDate.format('L'));
                $('#kt_daterangepicker_2 .form-control').val(picker.startDate.format('YYYY-MM-DD') + ' / ' +
                    picker.endDate.format('YYYY-MM-DD'));
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
                let bulan = $('#bulan').val();
                let nama_bulan = $('#bulan option:selected').text();
                let dinas = $('#dinas').val();
                let nama_dinas = $('#dinas option:selected').text();
                let export_type = $(this).attr('data-type');

                if (level['role'] == 'admin_opd' && type == 'rekapitulasi') {
                    dinas = level.current.id_satuan_kerja;
                    nama_dinas = level.current.nama_satuan_kerja;
                };
            
                if (bulan != '') {
              
                    url = '/laporan-pegawai/export/kinerja?bulan='+bulan+`&tipe=${type}`+'&nama_bulan='+nama_bulan+'&dinas='+dinas+'&nama_dinas='+nama_dinas+'&export_type='+export_type;
                            $('#bulan').val(null).trigger('change');
                         $('#dinas').val(null).trigger('change');
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
