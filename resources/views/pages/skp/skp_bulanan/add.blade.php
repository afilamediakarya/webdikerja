@extends('layout.app')

@section('style')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
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
                        {{-- @dd($get_sasaran_kinerja) --}}
                        <div id="sasaran_">
                            <div class="form-group">
                                <label for="sasaran_kinerja">Sasaran Kinerja </label>
                                <!-- <input type="email" class="form-control" placeholder=""> -->
                                <select class="form-control" type="text" name="rencana_kerja" id="rencana_kerja">
                                    <option selected disabled>Pilih Sasaran Kinerja</option>
                                    @foreach ($get_sasaran_kinerja as $key => $value)
                                        <option value="{{ $value['id'] }}">{{ $value['value'] }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger rencana_kerja_error"></div>
                            </div>
                        </div>

                        <input type="hidden" value="{{ $bulan }}" name="bulan">

                        <div id="content_aspek"></div>


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
        $(function() {
            $('#rencana_kerja').select2({
                placeholder: "Pilih Sasaran Kerja"
            });
            $('.satuan_').select2();
            let bulan = {!! json_encode($bulan) !!}
            submit = () => {

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });

                $.ajax({
                    type: "POST",
                    url: "/skp/bulanan/store",
                    data: $('#skp-form').serialize(),
                    success: function(res) {
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
                                })
                                .then(function() {
                                    window.location.href = '/skp/bulanan';
                                });
                        } else {
                            console.log(res);
                            Swal.fire({
                                icon: 'error',
                                title: 'Maaf, terjadi kesalahan',
                                text: 'Silahkan Hubungi Admin'
                            })
                        }

                    },
                    error: function(xhr) {
                        $('.text-danger').html('');
                        $('.form-control').removeClass('is-invalid');
                        $.each(xhr.responseJSON, function(key, value) {
                            // console.log(key + ' - ' + value)
                            $(`.${key}_error`).html(value);
                            $(`#${key}`).addClass('is-invalid');
                        })
                    }
                });
            }

            $(document).on('change', '#rencana_kerja', function() {
                // alert($(this).val())
                let bulan = {!! json_encode($bulan) !!}
                // console.log(bulan);
                $.ajax({
                    url: '/skp/show/' + $(this).val() + '?bulan=' + bulan,
                    method: 'GET',
                    success: function(res) {
                        console.log(res);
                        let value = JSON.parse(res);
                        let html = '';
                        if (value.message == "Success") {

                            $.each(value.data['aspek_skp'], function(x, y) {
                                html += `<div class="form-group">
                                            <label for="exampleTextarea">Aspek</label>
                                            <p class="text-dark font-weight-bolder">${y.aspek_skp}</p>
                                        </div>
                                        <input type="hidden" value="${y.aspek_skp}" name="type_aspek[${x}]">
                                        <input type="hidden" value="${y.id}" name="id_aspek[${x}]">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label for="indikator_kerja_individu_${x}">Indikator Kerja Individu </label>
                                                    <textarea class="form-control" disabled name="indikator_kerja_individu[${x}]" id="indikator_kerja_individu_${x}" rows="5">${y.iki}</textarea>
                                        
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="satuan_${x}">Jenis Satuan</label>
                                                <input type="text" class="form-control" disabled value="${y.satuan}" name="satuan[${x}]">
                                            
                                            </div>
                                            <div class="form-group">
                                                <label>Target bulan ${bulan}</label>
                                                <input type="text" class="form-control" min="1" name="target[${x}]" id="target">
                                                <div class="text-danger target_${x}_error"></div>
                                            </div>
                                            </div>
                                        </div>
                                        `;
                            });
                            $('#content_aspek').html(html);
                        } else {
                            swal.fire({
                                    title: "Target SKP sudah ada!",
                                    text: "Silakan pilih sasaran kinerja yang lain.",
                                    icon: "warning",
                                })
                                .then(function() {
                                    $('#content_aspek').html('');
                                });;
                        }
                    },
                    error: function(xhr) {
                        alert('gagal');
                    }
                })
            })


        })
    </script>
@endsection
