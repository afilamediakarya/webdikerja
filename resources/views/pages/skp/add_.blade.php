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
                                <div class="col-md-5">
                                    <label for="indikator_kerja_individu_2">Indikator Kerja Individu </label>
                                    <textarea class="form-control" name="indikator_kerja_individu[0]" id="indikator_kerja_individu_0" rows="3"></textarea>
                            
                                    <small class="text-danger indikator_kerja_individu_0_error"></small>
                                </div>
                                <div class="col-md-3">
                                    <label>Volume Satuan</label>
                                    <input type="text" class="form-control form-control-solid" readonly id="total_target_0">
                                </div>
                                <div class="col-md-3">
                                    <label for="satuan_2">Jenis Satuan</label>
                                    <select class="form-control form-control-solid satuan_" id="satuan_0" name="satuan[0]">
                                    <option selected disabled>Pilih Satuan</option>
                                    @foreach($satuan as $i => $v)
                                    <option value="{{$v['value']}}">{{$v['value']}}</option>
                                    @endforeach
                                    </select>
                                    <small class="text-danger satuan_0_error"></small>
                                </div>    
                            </div>

                            <div class="form-group">
                                <label>Target </label>
                                <div class="row">

                                @for ($i = 0; $i < 12; $i++)
                                    <div class="col-1">
                                        <input type="number" name="target_[0][{{$i}}]" class="form-control nilai_target_0 nilai_kinerja" data-id="0" placeholder="">
                                        <span class="form-text text-muted text-center">Bulan {{$i+1}}</span>
                                        <small class="text-danger target_0_{{$i}}_error"></small>
                                    </div>
                                @endfor
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
        
      

        let i = 1;
        $('#add_content_iki').on('click', function () {
            let html = '';
            console.log(satuan);
            html += ` 
                <div class="mt-3" id="iki_${i}"> 
                    <div class="row">
                        <div class="col-md-5">
                            <label for="indikator_kerja_individu_2">Indikator Kerja Individu </label>
                            <textarea class="form-control" name="indikator_kerja_individu[${i}]" id="indikator_kerja_individu_${i}" rows="3"></textarea>
                        
                            <small class="text-danger indikator_kerja_individu_${i}_error"></small>
                        </div>
                        <div class="col-md-3">
                            <label>Volume satuan</label>
                            <input type="text" class="form-control form-control-solid" readonly id="total_target_${i}">
                        </div>
                        <div class="col-md-3">
                            <label for="satuan_2">Jenis Satuan</label>`;

            html +=  `<select class="form-control form-control-solid satuan_" id="satuan_0" name="satuan[${i}]"><option selected disabled>Pilih Satuan</option>`;
                            
            $.each(satuan, function (i, v) { 
                 html += `<option value="${v['value']}">${v['value']}</option>`;
            });
                            
            html += `</select>`;                
            html += `<div class="text-danger satuan_${i}_error"></div>
                        </div>  
                        <div class="col-md-1">
                        <a href="javascript:;" data-id=${i} class="btn btn-icon btn-light-danger btn-circle btn-lg mr-4 delete_iki" style="position:relative;top:16px;">
                                    <i class="fas fa-trash"></i>
															</a>
                        </div>  
                    </div>`;
            
            html += ` <div class="form-group">
                                <label>Target </label>
                                <div class="row">`;
            
            for (let index = 0; index < 12; index++) {
                html += `<div class="col-1">
                            <input type="number" name="target_[${i}][${index}]" class="form-control nilai_target_${i} nilai_kinerja" data-id=${i} placeholder="">
                            <span class="form-text text-muted text-center">Bulan ${index+1}</span>
                            <small class="text-danger target_${i}_${index}_error"></small>
                        </div>`;
            }
            html += `</div></div>`;
            html += `</div>`;

            $('#content_iki').append(html);

            i++;

        })

        // $('.satuan_').select2();

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
                url: "/skp/store/kepala",
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
                        // window.location.href = '/skp';
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