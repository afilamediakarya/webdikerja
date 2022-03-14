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
                    <h3 class="card-title">Tambah SKP</h3>
                </div>
                <div class="card-body">
                    <!--begin::Form-->
                    <p class="text-dark ">A. Kinerja Utama</p>
                    <form class="form">

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="exampleTextarea">Rencana Kinerja Pimpinan
                            <span class="text-danger">*</span></label>
                            <textarea 
                                class="form-control bg-secondary" 
                                readonly="readonly" 
                                id="exampleTextarea" 
                                rows="4">Terselenggaranya Instansi Pemerintah yang profesional dalam menerapkan manajemen, Pembinaan dan Pelayanan Kepegawaian ASN yang berkualitas prima sesuai NSPK</textarea>
                        </div>
                        <div class="form-group col-6">
                            <label for="exampleTextarea">Rencana Kinerja Pegawai
                            <span class="text-danger">*</span></label>
                            <textarea 
                                class="form-control bg-secondary" 
                                readonly="readonly" 
                                id="exampleTextarea" 
                                rows="4">Terselenggaranya Instansi Pemerintah yang profesional dalam menerapkan manajemen, Pembinaan dan Pelayanan Kepegawaian ASN yang berkualitas prima sesuai NSPK</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="text-dark font-weight-bolder">Kuantitas</p>
                        </div>
                        <div class="form-group col-6">
                            <label for="exampleTextarea">Rencana Kinerja Pegawai
                            <span class="text-danger">*</span></label>
                            <textarea 
                                class="form-control" 
                                id="exampleTextarea" 
                                rows="6"></textarea>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Target </label>
                                    <input type="email" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-6">
                                    <label>Satuan </label>
                                    <input type="email" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-6">
                                    <label>Realisasi </label>
                                    <input type="email" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="text-dark font-weight-bolder">Kualitas</p>
                        </div>
                        <div class="form-group col-6">
                            <label for="exampleTextarea">Rencana Kinerja Pegawai
                            <span class="text-danger">*</span></label>
                            <textarea 
                                class="form-control" 
                                id="exampleTextarea" 
                                rows="6"></textarea>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Target </label>
                                    <input type="email" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-6">
                                    <label>Satuan </label>
                                    <input type="email" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-6">
                                    <label>Realisasi </label>
                                    <input type="email" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="text-dark font-weight-bolder">Waktu</p>
                        </div>
                        <div class="form-group col-6">
                            <label for="exampleTextarea">Rencana Kinerja Pegawai
                            <span class="text-danger">*</span></label>
                            <textarea 
                                class="form-control" 
                                id="exampleTextarea" 
                                rows="6"></textarea>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Target </label>
                                    <input type="email" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-6">
                                    <label>Satuan </label>
                                    <input type="email" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-6">
                                    <label>Realisasi </label>
                                    <input type="email" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    </form>
                    <!--end::Form-->
                </div>
                <div class="card-footer border-0">
                    <button type="reset" class="btn btn-outline-primary mr-2">Batal</button>
                    <button type="reset" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
<!--end::Entry-->
@endsection

@section('script')
    
@endsection