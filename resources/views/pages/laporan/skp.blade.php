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
                            <div class="form-group col-3">
                                <label>Jenis SKP</label>
                                <select class="form-control form-control-solid">
                                    <option disabled>Realisasi</option>
                                    <option value="skp">Skp</option>
                                </select>
                            </div>
                            <div class="form-group col-3">
                                <label>Bulan</label>
                                <select class="form-control form-control-solid">
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
                            <div class="col-8 row">
                                <div class="col">
                                    <button type="reset" class="btn btn-block btn-danger"><i class="flaticon2-pie-chart"></i>Cetak PDF</button>
                                </div>
                                <div class="col">
                                    <button type="reset" class="btn btn-block btn-success"><i class="flaticon2-pie-chart"></i>Export Excel</button>
                                </div>
                                <div class="col">
                                    <button type="reset" class="btn btn-block btn-outline-primary"><i class="flaticon2-pie-chart"></i>Tampilkan Excel</button>
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

            $('#kt_datepicker_3').datepicker({
                todayBtn: "linked",
                clearBtn: true,
                todayHighlight: true,

            });
        });
    </script>
@endsection