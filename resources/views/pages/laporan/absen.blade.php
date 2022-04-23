@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
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
                        <div class="form-group col-6">
                            <label>Tanggal</label>
                            <!-- <div class="input-group date" >
                                <input type="text" class="form-control form-control-solid" readonly  value="05/20/2017" id="kt_datepicker_3"/>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar"></i>
                                    </span>
                                </div>
                            </div> -->
                            
                                <div class='input-group' id='kt_daterangepicker_2'>
                                    <input type='text' class="form-control" readonly="readonly" placeholder="Select date range" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar-check-o"></i>
                                        </span>
                                    </div>
                                </div>
                            
                        </div>
                        <div class="col-8 row">
                            <div class="col">
                                <button type="reset" class="btn btn-block btn-danger"><i class="flaticon2-pie-chart"></i>Cetak PDF</button>
                            </div>
                            <div class="col">
                                <button type="reset" id="export-excel"  class="btn btn-block btn-success"><i class="flaticon2-pie-chart"></i>Export Excel</button>
                            </div>
                            <div class="col">
                                <button type="reset" id="preview-excel" class="btn btn-block btn-outline-primary"><i class="flaticon2-pie-chart"></i>Tampilkan Excel</button>
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

            $('#kt_daterangepicker_2').daterangepicker({
            buttonClasses: ' btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary'
            }, function(start, end, label) {
                $('#kt_daterangepicker_2 .form-control').val( start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
            });

            

            $('#preview-excel').on('click',function () {
                let val_range = $('#kt_daterangepicker_2 input').val();
                if (val_range != '') {
                    let val = val_range.split('/');
                    console.log();
                    url = '/laporan/export/rekapitulasi_pegawai/'+val[0].trim()+'/'+val[1].trim()+'/pdf';
                    window.open(url);     
                }else{
                    Swal.fire(
                        "Perhatian",
                        "Pilih range tanggal terlebih dahulu",
                        "warning"
                    );
                }
            })

            $('#export-excel').on('click',function () {
                let val_range = $('#kt_daterangepicker_2 input').val();
                if (val_range != '') {
                    let val = val_range.split('/');
                    console.log();
                    url = '/laporan/export/rekapitulasi_pegawai/'+val[0].trim()+'/'+val[1].trim()+'/excel';
                    window.open(url);     
                }else{
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