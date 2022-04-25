@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('button')
    <a href="{{url('skp/tambah')}}" class="btn btn-primary font-weight-bolder">
        <span class="svg-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        Tambah SKP
    </a>
@endsection


@section('content')

<!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            
            <!--begin::Card-->
            <div class="card card-custom">
                
                <div class="card-body">
                    <!--begin: Datatable-->
                    <form id="review_skp">
                    <table class="table table-borderless table-head-bg" id="kt_datatable" style="margin-top: 13px !important">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Rencana Kerja</th>
                                    <th>Aspek</th>
                                    <th nowrap="nowrap">Indikator Kinerja Individu</th>
                                    <th>Target</th>
                                    <th>Satuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $inc_letter = 'A';
                                    $no = 0;
                                @endphp
                                @foreach($skp as $key => $value)
                                    <tr style="background:#f2f2f2">
                                        <td>{{$inc_letter++}}.</td>
                                        <td colspan="6">{{$value['atasan']['rencana_kerja']}}</td>  
                                    <tr>

                                    @foreach($value['skp_child'] as $k => $v)
                                        @foreach($v['aspek_skp'] as $i => $l)
                                        <tr>
                                        
                                            @if($i == 0)
                                            <td>{{$no+1}}.</td>
                                            <td>{{$v['rencana_kerja']}}</td>
                                            @else
                                            <td></td>
                                            <td></td>
                                            @endif
                                            <td>{{$l['aspek_skp']}}</td>
                                            <td>{{$l['iki']}}</td>                                       
                                            @php
                                                $num = 0;
                                                foreach($l['target_skp'] as $f => $b){
                                                    $num =+ $b['target'];
                                                }
                                            @endphp
                                            <td>{{$num}}</td>
                                            <td>{{$l['satuan']}}</td>
                                            @if($i == 0)
                                            <td rowspan="3">
                                                        <div class="form-group">
                                                            <label>Kesesuaian Skp</label>
                                                            <div class="radio-inline">
                                                                <label class="radio">
                                                                <input type="radio" value="ya" name="kesesuaian[{{$key}}]" />
                                                                <span></span>Sesuai</label>
                                                                <label class="radio">
                                                                <input type="radio" value="tidak" name="kesesuaian[{{$key}}]" />
                                                                <span></span>Tidak</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="keterangan">Keterangan</label>
                                                            <textarea name="keterangan[{{$key}}]" class="form-control form-control-solid" id="keterangan"  rows="5"></textarea>
                                                        </div>
                                            </td>
                                            @else
                                            <td></td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    @php
                                                $no++;
                                    @endphp
                                    @endforeach
                                @endforeach    
                            </tbody>
                            
                            </tbody>
                        </table>
                    </form>
                    <!--end: Datatable-->
                </div>

                <div class="card-footer border-0">
                    <button type="reset" class="btn btn-outline-primary mr-2">Batal</button>
                    <button type="button" id="submit_review_skp" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
<!--end::Entry-->
@endsection



@section('script')
    <script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script>
         
        $(function () {
            // let table = $('#kt_datatable');
            // table.DataTable({
            //     responsive: true,
            //     pageLength: 25,
            //     ordering:false,
            // });

            $('#submit_review_skp').on("click", function () {
                // console.log($('#skp-form').serialize());
                 $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });
                 $.ajax({
                        type: "POST",
                        url: "/review_skp",
                        data: $('#review_skp').serialize(),
                        success: function (response) {
                            console.log(response);
                            // swal.fire({
                            //     text: "Skp berhasil di tambahkan.",
                            //     icon: "success",
                            //     buttonsStyling: false,
                            //     confirmButtonText: "Ok, got it!",
                            //     customClass: {
                            //         confirmButton: "btn font-weight-bold btn-light-primary"
                            //     }
                            // }).then(function() {
                            //     window.location.href = '/skp';
                            // });
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

            })

            
            
        })

    </script>
@endsection