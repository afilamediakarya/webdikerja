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
                                <input type="radio" value="Utama" name="jenis_kinerja" />
                                <span></span>Utama</label>
                                <label class="radio">
                                <input type="radio" value="Tambahan" name="jenis_kinerja" />
                                <span></span>Tambahan</label>
                            </div>
                            <small class="text-danger jenis_kinerja_error"></small>
                        </div>
                   
                        <input type="hidden" value="kepala" name="type_skp">
                
                        <div class="form-group">
                            <label for="rencana_kerja">Rencana Kerja 
                            <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="rencana_kerja" name="rencana_kerja" rows="3"></textarea>
                            <small class="text-danger rencana_kerja_error"></small>
                        </div>

                        <button type="button" id="add_content_iki" class="btn btn-info btn-sm"> <i class="far fa-plus-square"></i> Tambah Indikator</button>

                        <div class="mt-3">
                            <div class="row">
                            <input type="hidden" value="iki" name="type_aspek[0]">
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
                        </div>

                       <div id="content_iki">


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

        let satuan = {!! json_encode($satuan) !!};
        let tahun_penganggaran = {!! json_encode(session('tahun_penganggaran')) !!}  

        let i = 1;
        $('#add_content_iki').on('click', function () {
            let html = '';
            console.log(satuan);

            html += ` 
                <div class="mt-3" id="iki_${i}">
                    <div class="row">
                    <input type="hidden" value="iki" name="type_aspek[${i}]">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="indikator_kerja_individu_${i}">Indikator Kerja Individu </label>
                                <textarea class="form-control" name="indikator_kerja_individu[${i}]" id="indikator_kerja_individu_${i}" rows="5"></textarea>
                                <div class="text-danger indikator_kerja_individu_${i}_error"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="satuan_${i}">Jenis Satuan</label>
                                <input type="text" class="form-control" name="satuan[${i}]">
                                <div class="text-danger satuan_${i}_error"></div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-10">
                                    <label>Target tahun ${tahun_penganggaran}</label>
                                    <input type="text" class="form-control" name="target[${i}]" >
                                    <div class="text-danger target_${i}_error"></div>
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
                        window.location.href = '/skp/tahunan';
                    });
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

       
        $(document).on('change',".nilai_kinerja", function () {
            let index = $(this).attr('data-id');
            console.log(index);
            let sum = 0;

             $('.nilai_target_'+index).each(function() {
                sum += Number($(this).val());
            });

            // $('.nilai_kinerja_kuantitas').each(function() {
            //     sum += Number($(this).val());
            // });
            // console.log(sum);
            $('#total_target_'+index).val(sum);
            
        })
    

    })
</script>
    
@endsection