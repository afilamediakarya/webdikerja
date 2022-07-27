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
                    <form class="form" id="skp-form">
                        <div class="form-group">
                            <label>Jenis Kinerja</label>
                            <div class="radio-inline">
                                <label class="radio">
                                <input type="radio" value="utama" name="jenis_kinerja" />
                                <span></span>Utama</label>
                                <label class="radio">
                                <input type="radio" value="tambahan" name="jenis_kinerja" />
                                <span></span>Tambahan</label>
                            </div>
                            <div class="text-danger jenis_kinerja_error"></div>
                        </div>

                        <input type="hidden" value="pegawai" name="type_skp">

                        <div id="sasaran_">
                        <div class="form-group">
                            <label for="sasaran_kinerja">Sasaran Kerja </label>
                            <!-- <input type="email" class="form-control" placeholder=""> -->
                            <select class="form-control" type="text" name="sasaran_kinerja" id="sasaran_kinerja">
                                <option selected disabled>Pilih Sasaran Kerja</option>
                                @foreach($sasaran_kinerja_atasan as $key => $value)
                                    <option value="{{$value['id']}}">{{$value['value']}}</option>
                                @endforeach
                             </select>
                             <div class="text-danger sasaran_kinerja_error"></div>
                        </div>
                        </div>
                       
                        <div class="form-group">
                            <label for="rencana_kerja">Rencana Kerja 
                            <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="rencana_kerja" name="rencana_kerja" rows="3"></textarea>
                            <div class="text-danger rencana_kerja_error"></div>
                        </div>

                        <div class="form-group">
                            <label for="exampleTextarea">Aspek</label>
                            <p class="text-dark font-weight-bolder">Kuantitas</p>
                        </div>
                        <input type="hidden" value="kuantitas" name="type_aspek[0]">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="indikator_kerja_individu_0">Indikator Kerja Individu </label>
                                    <textarea class="form-control" name="indikator_kerja_individu[0]" id="indikator_kerja_individu_0" rows="5"></textarea>
                                    <div class="text-danger indikator_kerja_individu_0_error"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                            <div class="form-group">
                                <label for="satuan_0">Jenis Satuan</label>
                                <input type="text" class="form-control" name="satuan[0]">
                                <div class="text-danger satuan_0_error"></div>
                            </div>
                            <div class="form-group">
                            <label>Target tahun {{ session('tahun_penganggaran') }}</label>
                                <input type="text" class="form-control" name="target[0]" id="target">
                                <div class="text-danger target_0_error"></div>
                            </div>
                            </div>
                        </div>

                        <div class="form-group">
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
                url: "/skp/store",
                data: $('#skp-form').serialize(),
                success: function (res) {
                    console.log(res);
                if (res.success) {
                    swal.fire({
                        text: "Skp berhasil di tambahkan.",
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