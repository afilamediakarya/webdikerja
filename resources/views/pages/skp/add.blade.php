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
                    <form class="form">
                        <div class="form-group">
                            <label>Inline radios</label>
                            <div class="radio-inline">
                                <label class="radio">
                                <input type="radio" name="radios2" />
                                <span></span>Utama</label>
                                <label class="radio">
                                <input type="radio" name="radios2" />
                                <span></span>Tambahan</label>
                            </div>
                            <span class="form-text text-danger">Error Alert</span>
                        </div>
                        <div class="form-group">
                            <label>Sasaran Kerja </label>
                            <input type="email" class="form-control" placeholder="">
                            <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea">Rencana Kerja 
                            <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleTextarea">Aspek</label>
                            <p class="text-dark font-weight-bolder">Kuantitas</p>
                        </div>

                        <div class="form-group">
                            <label for="exampleTextarea">Indikator Kerja Individu </label>
                            <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Nilai Kinerja </label>
                            <div class="row">

                            @for ($i = 1; $i <= 12; $i++)
                                <div class="col-1">
                                    <input type="email" class="form-control" placeholder="">
                                    <span class="form-text text-muted text-center">Bulan {{$i}}</span>
                                </div>
                            @endfor
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Jenis Satuan</label>
                                <select class="form-control form-control-solid">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label>Total</label>
                                <select class="form-control form-control-solid">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <p class="text-dark font-weight-bolder">Kualitas</p>
                        </div>

                        <div class="form-group">
                            <label for="exampleTextarea">Indikator Kerja Individu </label>
                            <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Nilai Kinerja </label>
                            <div class="row">

                            @for ($i = 1; $i <= 12; $i++)
                                <div class="col-1">
                                    <input type="email" class="form-control" placeholder="">
                                    <span class="form-text text-muted text-center">Bulan {{$i}}</span>
                                </div>
                            @endfor
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Jenis Satuan</label>
                                <select class="form-control form-control-solid">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label>Total</label>
                                <select class="form-control form-control-solid">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <p class="text-dark font-weight-bolder">Waktu</p>
                        </div>

                        <div class="form-group">
                            <label for="exampleTextarea">Indikator Kerja Individu </label>
                            <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Nilai Kinerja </label>
                            <div class="row">

                            @for ($i = 1; $i <= 12; $i++)
                                <div class="col-1">
                                    <input type="email" class="form-control" placeholder="">
                                    <span class="form-text text-muted text-center">Bulan {{$i}}</span>
                                </div>
                            @endfor
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Jenis Satuan</label>
                                <select class="form-control form-control-solid">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label>Total</label>
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