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
                    <p class="text-dark ">A. Kinerja {{$data['jenis']}}</p>
                    <form class="form">

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="exampleTextarea">Rencana Kinerja Pimpinan
                            <span class="text-danger">*</span></label>
                            <textarea 
                                class="form-control bg-secondary" 
                                readonly="readonly" 
                                id="exampleTextarea" 
                                rows="4">{{$rencana}}</textarea>
                        </div>
                        <div class="form-group col-6">
                            <label for="exampleTextarea">Rencana Kinerja Pegawai
                            <span class="text-danger">*</span></label>
                            <textarea 
                                class="form-control bg-secondary" 
                                readonly="readonly" 
                                id="exampleTextarea" 
                                rows="4">{{$data['rencana_kerja']}}</textarea>
                        </div>
                    </div>

                    <form class="form" id="realisasi_form">

                    <input type="hidden" name="bulan" value="{{$bulan}}">

                    @foreach($data['aspek_skp'] as $key => $value)
                        <div class="row">
                            <div class="col-12">
                                <p class="text-dark font-weight-bolder">{{ $value['aspek_skp'] }}</p>
                            </div>
                            <div class="form-group col-6">
                                <label for="exampleTextarea">Indikator Kinerja Individu
                                <span class="text-danger">*</span></label>
                                <textarea 
                                    class="form-control" 
                                    id="exampleTextarea" 
                                    rows="6" readonly>{{$value['iki']}}</textarea>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="form-group col-6">
                                            @php
                                                $num = 0;
                                                foreach($value['target_skp'] as $f => $b){
                                                    $num += $b['target'];
                                                }
                                            @endphp
                                        <label>Target </label>
                                        <input type="text" readonly value="{{$num}}" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Satuan </label>
                                        <input type="text" readonly value="{{$value['satuan']}}" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group col-6">
                                        
                                        @if($value['realisasi_skp'] != [])
                                            @for ($i=0; $i < count($value['realisasi_skp']); $i++)
                                                @if($bulan != 0)
                                                    @if($value['realisasi_skp'][$i]['bulan'] == $bulan)
                                                    <label>Realisasi </label>
                                                    <input type="text" id="tes" class="form-control" name="realisasi[{{$key}}]" value="{{$value['realisasi_skp'][$i]['realisasi_bulanan']}}" placeholder="">
                                                    @endif
                                                @else
                                                <div class="mb-10">
														<label class="form-label">Realisasi bulan ke {{$i+1}}</label>
														<input type="text" id="tes" class="form-control" name="realisasi[{{$key}}][{{$i}}]" value="{{$value['realisasi_skp'][$i]['realisasi_bulanan']}}" placeholder="">
													</div>
                                                
                                                @endif
                                            @endfor
                                        @else
                                        <input type="text" id="tes" class="form-control" name="realisasi[{{$key}}]" placeholder="">    
                                        @endif
                                        
                                        <input type="hidden" name="id_aspek_skp[{{$key}}]" value="{{$value['id']}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    
                  

                    </form>
                    <!-- <div class="row">
                        <div class="col-12">
                            <p class="text-dark font-weight-bolder">Kualitas</p>
                        </div>
                        <div class="form-group col-6">
                            <label for="exampleTextarea">Indikator Kinerja Individu
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
                    </div> -->
                    <!-- <div class="row">
                        <div class="col-12">
                            <p class="text-dark font-weight-bolder">Waktu</p>
                        </div>
                        <div class="form-group col-6">
                            <label for="exampleTextarea">Indikator Kinerja Individu
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
                    </div> -->
                    
                    <!--end::Form-->
                </div>
                <div class="card-footer border-0">
                    <button type="reset" class="btn btn-outline-primary mr-2">Batal</button>
                    <button type="button" onclick="submit()" class="btn btn-primary">Simpan</button>
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
        $(function () {

        submit = () =>{
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.ajax({
                type: "POST",
                url: "/realisasi/store",
                data: $('.form').serialize(),
                success: function (response) {
                    console.log(response);
                        swal.fire({
                            text: "Skp berhasil di tambahkan.",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        }).then(function() {
                            window.location.href = '/realisasi';
                        });
                },
                error : function (xhr) {
                    $('.invalid-feedback').html('');
                    $('.form-control').removeClass('is-invalid');
                    $.each(xhr.responseJSON,function (key, value) {
                        console.log(key+' - '+value)
                        $(`.${key}_error`).html(value);
                        $(`#${key}`).addClass('is-invalid');
                    })
                }
            });
        }

        })
    </script>
@endsection