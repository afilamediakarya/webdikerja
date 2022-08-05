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
                                <input type="radio" value="utama" @if($data['jenis'] == 'utama') checked @endif name="jenis_kinerja" />
                                <span></span>Utama</label>
                                <label class="radio">
                                <input type="radio" value="tambahan" @if($data['jenis'] == 'tambahan') checked @endif name="jenis_kinerja" />
                                <span></span>Tambahan</label>
                            </div>
                            <div class="text-danger jenis_kinerja_error"></div>
                        </div>

                        @if($level > 2)
                        <input type="hidden" value="pegawai" name="type_skp">
                        @else
                        <input type="hidden" value="kepala" name="type_skp">
                        @endif

                        @if($level !== 1 || $level !== 2)
                        <div id="sasaran_">
                            <div class="form-group">
                                <label for="sasaran_kinerja">Sasaran Kerja </label>
                                <!-- <input type="email" class="form-control" placeholder=""> -->
                                <select class="form-control" type="text" name="sasaran_kinerja" id="sasaran_kinerja">
                                    <option selected disabled>Pilih Sasaran Kerja</option>
                                    @foreach($sasaran_kinerja_atasan as $key => $value)
                                        <option value="{{$value['id']}}" @if($data['id_skp_atasan'] == $value['id']) selected @endif>{{$value['value']}}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger sasaran_kinerja_error"></div>
                            </div>
                        </div>
                        @endif
                       
                        <div class="form-group">
                            <label for="rencana_kerja">Rencana Kerja 
                            <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="rencana_kerja" name="rencana_kerja" rows="3">{{$data['rencana_kerja']}}</textarea>
                            <div class="text-danger rencana_kerja_error"></div>
                        </div>

                        @if($level == 1 || $level == 2)
                        <button type="button" id="add_content_iki" class="btn btn-info btn-sm mb-5"> <i class="far fa-plus-square"></i> Tambah Indikator</button>
                        @endif
                        

                        @foreach($data['aspek_skp'] as $key => $value)
                            @if($level > 2)
                            <div class="form-group">
                                <label for="exampleTextarea">Aspek</label>
                                <p class="text-dark font-weight-bolder">{{$value['aspek_skp']}}</p>
                            </div>
                            @endif
                            <input type="hidden" value="{{$value['aspek_skp']}}" name="type_aspek[{{$key}}]">
                            <input type="hidden" value="{{$value['id']}}" name="id_aspek[{{$key}}]">
                            <input type="hidden" value="{{$value['target_skp'][0]['id']}}" name="id_target[{{$key}}]">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="indikator_kerja_individu_{{$key}}">Indikator Kerja Individu </label>
                                        <textarea class="form-control" name="indikator_kerja_individu[{{$key}}]" id="indikator_kerja_individu_{{$key}}" rows="5">{{$value['iki']}}</textarea>
                                        <div class="text-danger indikator_kerja_individu_{{$key}}_error"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="satuan_{{$key}}">Jenis Satuan</label>
                                    <input type="text" class="form-control" value="{{$value['satuan']}}" name="satuan[{{$key}}]">
                                    <div class="text-danger satuan_{{$key}}_error"></div>
                                </div>
                                <div class="form-group">
                                <label>Target tahun {{ session('tahun_penganggaran') }}</label>
                                    <input type="text" class="form-control" value="{{$value['target_skp'][0]['target']}}" name="target[{{$key}}]" id="target">
                                    <div class="text-danger target_{{$key}}_error"></div>
                                </div>
                                </div>
                            </div>
                        @endforeach

                        <div id="content_iki"></div>

                        

                        <!-- <div class="form-group">
                            <label for="exampleTextarea">Aspek</label>
                            <p class="text-dark font-weight-bolder">Kualitas</p>
                        </div>
                        <input type="hidden" value="kualitas" name="type_aspek[1]">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="indikator_kerja_individu_1">Indikator Kerja Individu </label>
                                    <textarea class="form-control" name="indikator_kerja_individu[1]" id="indikator_kerja_individu_1" rows="5"></textarea>
                                    <div class="text-danger indikator_kerja_individu_1_error"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                            <div class="form-group">
                                <label for="satuan_1">Jenis Satuan</label>
                                <input type="text" class="form-control" name="satuan[1]">
                                <div class="text-danger satuan_1_error"></div>
                            </div>
                            <div class="form-group">
                                <label>Target tahun {{ session('tahun_penganggaran') }}</label>
                                <input type="text" class="form-control" name="target[1]"  id="target">
                                <div class="text-danger target_1_error"></div>
                            </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleTextarea">Aspek</label>
                            <p class="text-dark font-weight-bolder">Waktu</p>
                        </div>
                        <input type="hidden" value="waktu" name="type_aspek[2]">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="indikator_kerja_individu_2">Indikator Kerja Individu </label>
                                    <textarea class="form-control" name="indikator_kerja_individu[2]" id="indikator_kerja_individu_2" rows="5"></textarea>
                                    <div class="text-danger indikator_kerja_individu_2_error"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                            <div class="form-group">
                                <label for="satuan_2">Jenis Satuan</label>
                                <input type="text" class="form-control" name="satuan[2]">
                                <div class="text-danger satuan_2_error"></div>
                            </div>
                            <div class="form-group">
                                <label>Target tahun {{ session('tahun_penganggaran') }}</label>
                                <input type="text" class="form-control" name="target[2]" id="target">
                                <div class="text-danger target_2_error"></div>
                            </div>
                            </div>
                        </div> -->

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

        let id = {!! json_encode($data['id']) !!};
        let jenis_ = {!! json_encode($data['jenis']) !!};

        if (jenis_ == 'tambahan') {
            $('#sasaran_').hide();
        }
        let tahun_penganggaran = {!! json_encode(session('tahun_penganggaran')) !!}  

        let i = 0;
        $('#add_content_iki').on('click', function () {
            let html = '';

            html += ` 
                <div class="mt-3" id="iki_${i}">
                    <div class="row">
                    <input type="hidden" value="iki" name="type_aspek_add[${i}]">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="indikator_kerja_individu_${i}">Indikator Kerja Individu </label>
                                <textarea class="form-control" name="indikator_kerja_individu_add[${i}]" id="indikator_kerja_individu_${i}" rows="5"></textarea>
                                <div class="text-danger indikator_kerja_individu_add_${i}_error"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="satuan_${i}">Jenis Satuan</label>
                                <input type="text" class="form-control" name="satuan_add[${i}]">
                                <div class="text-danger satuan_add_${i}_error"></div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-10">
                                    <label>Target tahun ${tahun_penganggaran}</label>
                                    <input type="text" class="form-control" name="target_add[${i}]" >
                                    <div class="text-danger target_add_${i}_error"></div>
                                </div>
                                <div class="col-lg-2">
                                     <a href="javascript:;" data-id=${i} class="btn btn-icon btn-light-danger btn-circle btn-lg mr-4 delete_iki" style="position:relative;top:16px;">
                                            <i class="fas fa-trash"></i>
                                                                    </a>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
               `;

            $('#content_iki').append(html);

            i++;

        })

        $(document).on('click','.delete_iki', function(){
            let index = $(this).attr('data-id');
            $('#iki_'+index).remove();
        });

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
                success: function (res) {
                    console.log(res);
                if (res.success) {
                    swal.fire({
                        text: "Skp berhasil di update.",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    }).then(function() {
                        window.location.href = '/skp/tahunan';
                    });      
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Maaf, terjadi kesalahan',
                        text: 'Silahkan Hubungi Admin'
                    })
                }

                },
                error : function (xhr) {
                    $('.text-danger').html('');
                    $('.form-control').removeClass('is-invalid');
                    $.each(xhr.responseJSON,function (key, value) {
                        console.log(key+' - '+value)
                        $(`.${key}_error`).html(value);
                        $(`#${key}`).addClass('is-invalid');
                    })
                }
            });
        }

        $('input[type=radio][name=jenis_kinerja]').change(function() {
            let val = $(this).val();
            if (val == 'utama') {
                $('#sasaran_').show();
            }
            else if (val == 'tambahan') {
                $('#sasaran_').hide();
                $('#sasaran_kinerja').val(null).trigger('change');
            }
        });
    

    })
</script>
    
@endsection