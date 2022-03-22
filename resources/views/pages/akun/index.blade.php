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
                    <h3 class="card-title">Atasan</h3>
                    <a href="" type="reset" class="btn btn-sm btn-primary align-self-center"><i class="flaticon2-pen"></i>edit Atasan</a>
                </div>
                <div class="card-body">
                    <!--begin::Form-->
                    <form class="form">

                        <div class="row">
                            <div class="form-group col-6">
                                <label>Atasan</label>
                                <select class="form-control form-control-solid">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                        </div>
                        
                    </form>
                    <!--end::Form-->
                </div>
            </div>


            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Profil Pegawai</h3>
                    <a href="{{route('edit-profil')}}" type="reset" class="btn btn-sm btn-primary align-self-center"><i class="flaticon2-pen"></i> Edit Profil</a>
                </div>
                <div class="card-body">
                    <!--begin::Form-->
                    <form class="form">

                        <div class="row">
                            <div class="form-group col-6">
                                <label>Nama</label>
                                <input type="text" class="form-control form-control-solid disabled" value="Batula, S.E." readonly>
                            </div>

                            <div class="form-group col-6">
                                <label>NIP</label>
                                <input type="text" class="form-control form-control-solid disabled" value="198609262015051001" readonly>
                            </div>
                            
                            
                            <div class="form-group col-6">
                                <label>Jenis Kelamin</label>
                                <select class="form-control form-control-solid">
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                            </div>

                            <div class="form-group col-6">
                                <label>Agama</label>
                                <input type="text" class="form-control form-control-solid disabled" value="ISLAM" readonly>
                            </div>

                            <div class="form-group col-6">
                                <label>Status Perkawinan</label>
                                <input type="text" class="form-control form-control-solid disabled" value="" readonly>
                            </div>
                            <div class="form-group col-6">
                                <label>Status Pegawai</label>
                                <input type="text" class="form-control form-control-solid disabled" value="" readonly>
                            </div>

                            <div class="form-group col-6">
                                <label>Eselon</label>
                                <input type="text" class="form-control form-control-solid disabled" value="" readonly>
                            </div>

                            <div class="form-group col-6">
                                <label>Jenis Jabatan</label>
                                <select class="form-control form-control-solid">
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label>Alamat</label>
                                <input type="text" class="form-control form-control-solid disabled" value="" readonly>
                            </div>
                            <div class="form-group col-6">
                                <label>No. Hp</label>
                                <input type="text" class="form-control form-control-solid disabled" value="" readonly>
                            </div>
                            <div class="form-group col-6">
                                <label>Email</label>
                                <input type="text" class="form-control form-control-solid disabled" value="" readonly>
                            </div>
                        </div>
                        
                    </form>
                    <!--end::Form-->
                </div>
            </div>

            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Password</h3>
                    <button type="reset" class="btn btn-sm btn-primary align-self-center"><i class="flaticon2-pen"></i>Ganti Password</button>
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