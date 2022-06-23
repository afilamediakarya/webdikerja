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
                                <label>Tahun</label>
                                <select id="tahun_" class="form-control form-control-solid">
                                    <option disabled selected> Pilih Tahun </option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                    <option value="2013">2013</option>
                                </select>
                            </div>
                           
                            <div class="form-group col-4">
                            @if($role_page == 'admin')
                            <label>Pilih Pegawai</label>
                                <select id="pegawai_" class="form-control">
                                    <option selected value="semua">Semua</option>
                                    @foreach($pegawaiBysatker_ as $keys => $val)
                                        <option value="{{$val['id']}}">{{$val['value']}}</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                            
                            <div class="col-8 row">
                                <div class="col">
                                    <button type="reset" id="export-excel"  class="btn btn-block btn-success"><i class="flaticon2-pie-chart"></i>Export Excel</button>
                                </div>
                                <div class="col">
                                    <button type="reset" id="preview-excel" class="btn btn-block btn-danger"><i class="flaticon2-pie-chart"></i>Tampilkan Data</button>
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
        let idPegawai = {!! json_encode($idPegawai) !!}
        let role_page = {!! json_encode($role_page) !!}
        jQuery(document).ready(function() {

            $('#kt_datepicker_3').datepicker({
                todayBtn: "linked",
                clearBtn: true,
                todayHighlight: true,

            });

            $('#pegawai_').select2();

            $('#preview-excel').on('click',function () {
                let tahun_ = $('#tahun_').val();
                let pegawai = $('#pegawai_').val();

                if (role_page == 'admin') {
                    if (tahun_ !== null && pegawai !== null) {
                        url = `/laporan/export/bankom/${tahun_}/pdf/${pegawai}`;
                        window.open(url);      
                    }else{
                        Swal.fire(
                            "Perhatian",
                            "Lengkapi form terlebih dahulu",
                            "warning"
                        );
                    }    
                }else{
                    if (tahun_ !== null) {
                        url = `/laporan/export/bankom/${tahun_}/pdf/${idPegawai}`;
                        window.open(url);      
                    }else{
                        Swal.fire(
                            "Perhatian",
                            "Lengkapi form terlebih dahulu",
                            "warning"
                        );
                    }   
                }

                
            })

            $('#export-excel').on('click',function () {
                let tahun_ = $('#tahun_').val();
                let pegawai = $('#pegawai_').val();
               
                if (role_page == 'admin') {
                    if (tahun_ !== null && pegawai !== null) {
                        url = `/laporan/export/bankom/${tahun_}/pdf/${pegawai}`;
                        window.open(url);      
                    }else{
                        Swal.fire(
                            "Perhatian",
                            "Lengkapi form terlebih dahulu",
                            "warning"
                        );
                    }    
                }else{
                    if (tahun_ !== null) {
                        url = `/laporan/export/bankom/${tahun_}/pdf/${idPegawai}`;
                        window.open(url);      
                    }else{
                        Swal.fire(
                            "Perhatian",
                            "Lengkapi form terlebih dahulu",
                            "warning"
                        );
                    }   
                }

            })

        });
    </script>
@endsection