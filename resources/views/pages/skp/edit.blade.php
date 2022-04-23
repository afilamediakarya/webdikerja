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
                    <h3 class="card-title">Update SKP</h3>
                </div>
                <div class="card-body">
                    <!--begin::Form-->
                    <form class="form" id="skp-form">
                        <div class="form-group">
                            <label>Jenis Kinerja</label>
                            <div class="radio-inline">
                                <label class="radio">
                                <input type="radio" value="Utama" @if($data['jenis'] == 'utama') checked @endif name="jenis_kinerja" />
                                <span></span>Utama</label>
                                <label class="radio">
                                <input type="radio" value="Tambahan" name="jenis_kinerja" />
                                <span></span>Tambahan</label>
                            </div>
                            <div class="invalid-feedback jenis_kinerja_error"></div>
                        </div>
                        <div class="form-group">
                            <label for="sasaran_kinerja">Sasaran Kerja </label>
                            <!-- <input type="email" class="form-control" placeholder=""> -->
                            <select class="form-control" type="text" name="sasaran_kinerja" id="sasaran_kinerja">
                                <option selected disabled>Pilih Sasaran Kerja</option>
                                @foreach($sasaran_kinerja_atasan as $key => $value)
                                    <option value="{{$value['id']}}" @if($data['id_skp_atasan'] == $value['id']) selected @endif>{{$value['value']}}</option>
                                @endforeach
                             </select>
                             <div class="invalid-feedback sasaran_kinerja_error"></div>
                        </div>
                        <div class="form-group">
                            <label for="rencana_kerja">Rencana Kerja 
                            <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="rencana_kerja" name="rencana_kerja" rows="3">{{$data['rencana_kerja']}}</textarea>
                            <div class="invalid-feedback rencana_kerja_error"></div>
                        </div>

                        <div class="form-group">
                            <label for="exampleTextarea">Aspek</label>
                            <p class="text-dark font-weight-bolder">Kuantitas</p>
                        </div>

                        <div class="form-group">
                            <label for="indikator_kerja_individu_0">Indikator Kerja Individu </label>
                            <textarea class="form-control" name="indikator_kerja_individu[0]" id="indikator_kerja_individu_0" rows="3">{{$data['aspek_skp'][0]['iki']}}</textarea>
                            <div class="invalid-feedback indikator_kerja_individu_0_error"></div>
                        </div>
                        <div class="form-group">
                            <label>Nilai Kinerja </label>
                            <div class="row">

                            @for ($i = 0; $i < 12; $i++)
                                <div class="col-1">
                                    <input type="number" id="target_kuantitas_{{$i}}" value="{{$data['aspek_skp'][0]['target_skp'][$i]['target']}}" name="target_kuantitas[{{$i}}]" class="form-control nilai_kinerja_kuantitas" placeholder="">
                                    <span class="form-text text-muted text-center">Bulan {{$i+1}}</span>
                                    <div class="invalid-feedback target_kuantitas_{{$i}}_error"></div>
                                </div>
                            @endfor
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="satuan_0">Jenis Satuan</label>
                                <select class="form-control form-control-solid satuan_" id="satuan_0" name="satuan[0]">
                                <option selected disabled>Pilih Satuan</option>
                                   @foreach($satuan as $i => $v)
                                    <option value="{{$v['value']}}" @if($v['value'] = $data['aspek_skp'][0]['satuan']) selected @endif >{{$v['value']}}</option>
                                   @endforeach
                                </select>
                                <div class="invalid-feedback satuan_0_error"></div>
                            </div>
                            <div class="form-group col-6">
                                <label>Total</label>
                                <input type="text" value="{{$total_sum[0]}}" class="form-control form-control-solid" readonly id="total_target_kuantitas">
                            </div>
                        </div>

                        <div class="form-group">
                            <p class="text-dark font-weight-bolder">Kualitas</p>
                        </div>

                        <div class="form-group">
                            <label for="indikator_kerja_individu_1">Indikator Kerja Individu </label>
                            <textarea class="form-control" name="indikator_kerja_individu[1]" id="indikator_kerja_individu_1" rows="3">{{$data['aspek_skp'][1]['iki']}}</textarea>
                            <div class="invalid-feedback indikator_kerja_individu_1_error"></div>
                        </div>
                        <div class="form-group">
                            <label>Nilai Kinerja </label>
                            <div class="row">

                            @for ($i = 0; $i < 12; $i++)
                                <div class="col-1">
                                    <input type="number" id="target_kualitas_{{$i}}" value="{{$data['aspek_skp'][1]['target_skp'][$i]['target']}}" name="target_kualitas[{{$i}}]" class="form-control nilai_kinerja_kualitas" placeholder="">
                                    <span class="form-text text-muted text-center">Bulan {{$i+1}}</span>
                                    <div class="invalid-feedback target_kualitas_{{$i}}_error"></div>
                                </div>
                            @endfor
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                 <label for="satuan_1">Jenis Satuan</label>
                                <select class="form-control form-control-solid satuan_" id="satuan_1" name="satuan[1]">
                                <option selected disabled>Pilih Satuan</option>
                                   @foreach($satuan as $i => $v)
                                   <option value="{{$v['value']}}" @if($v['value'] = $data['aspek_skp'][1]['satuan']) selected @endif>{{$v['value']}}</option>
                                   @endforeach
                                </select>
                                <div class="invalid-feedback satuan_1_error"></div>
                            </div>
                            <div class="form-group col-6">
                                <label>Total</label>
                                <input type="text" value="{{$total_sum[1]}}" class="form-control form-control-solid" readonly id="total_target_kualitas">
                            </div>
                        </div>

                        <div class="form-group">
                            <p class="text-dark font-weight-bolder">Waktu</p>
                        </div>

                        <div class="form-group">
                            <label for="indikator_kerja_individu_2">Indikator Kerja Individu </label>
                            <textarea class="form-control" name="indikator_kerja_individu[2]" id="indikator_kerja_individu_2" rows="3">{{$data['aspek_skp'][2]['iki']}}</textarea>
                            <div class="invalid-feedback indikator_kerja_individu_2_error"></div>
                        </div>
                        <div class="form-group">
                            <label>Nilai Kinerja </label>
                            <div class="row">

                            @for ($i = 0; $i < 12; $i++)
                                <div class="col-1">
                                    <input type="number" id="target_waktu_{{$i}}" name="target_waktu[{{$i}}]" value="{{$data['aspek_skp'][2]['target_skp'][$i]['target']}}" class="form-control nilai_kinerja_waktu" placeholder="">
                                    <span class="form-text text-muted text-center">Bulan {{$i+1}}</span>
                                    <div class="invalid-feedback target_waktu_{{$i}}_error"></div>
                                </div>
                            @endfor
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="satuan_2">Jenis Satuan</label>
                                <select class="form-control form-control-solid satuan_" id="satuan_2" name="satuan[2]">
                                <option selected disabled>Pilih Satuan</option>
                                   @foreach($satuan as $i => $v)
                                   <option value="{{$v['value']}}" @if($v['value'] = $data['aspek_skp'][2]['satuan']) selected @endif>{{$v['value']}}</option>
                                   @endforeach
                                </select>
                                <div class="invalid-feedback satuan_2_error"></div>
                            </div>
                            <div class="form-group col-6">
                                <label>Total</label>
                                <input type="text" value="{{$total_sum[2]}}" class="form-control form-control-solid" readonly id="total_target_waktu">
                            </div>
                        </div>
                        
                    </form>
                    <!--end::Form-->
                </div>
                <div class="card-footer border-0">
                    <button type="reset" class="btn btn-outline-primary mr-2">Batal</button>
                    <button onclick="submit()" type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
<!--end::Entry-->
@endsection

@section('script')
<!-- sasaran_kinerja -->

<script>
    $(function () {
        let id = {!! json_encode($data['id']) !!}
        $('#sasaran_kinerja').select2({
            placeholder: "Pilih Sasaran Kerja"
        });
        $('.satuan_').select2();

        submit = () =>{
      
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.ajax({
                type: "POST",
                url: "/skp/update/"+id,
                data: $('#skp-form').serialize(),
                success: function (response) {
                    console.log(response);
                    swal.fire({
                        text: "Skp berhasil di Update.",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    }).then(function() {
                        window.location.href = '/skp';
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

       
        $(".nilai_kinerja_kuantitas").on('change', function () {
            let sum = 0;
            $('.nilai_kinerja_kuantitas').each(function() {
                sum += Number($(this).val());
            });
            console.log(sum);
            $('#total_target_kuantitas').val(sum);
            
        })

        $(".nilai_kinerja_kualitas").on('change', function () {
            let sum = 0;
            $('.nilai_kinerja_kualitas').each(function() {
                sum += Number($(this).val());
            });
            console.log(sum);
            $('#total_target_kualitas').val(sum);
            
        })

        $(".nilai_kinerja_waktu").on('change', function () {
            let sum = 0;
            $('.nilai_kinerja_waktu').each(function() {
                sum += Number($(this).val());
            });
            console.log(sum);
            $('#total_target_waktu').val(sum);
            
        })
    

    })
</script>
    
@endsection