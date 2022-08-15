@extends('layout.app')

@section('style')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('button')
    <!-- <a href="{{ url('skp/tambah') }}" class="btn btn-primary font-weight-bolder">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <span class="svg-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </g>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </svg></span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Tambah SKP
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </a> -->
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
                        <div class="table-responsive">
                            <table class="table table-group table-head-bg" id="kt_datatable"
                                style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Jenis Kinerja</th>
                                        <th>Rencana Kerja atasan</th>
                                        <th>Rencana Kerja</th>
                                        <th>Aspek</th>
                                        <th nowrap="nowrap">Indikator Kinerja Individu</th>
                                        <th>Target</th>
                                        <th>Satuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </form>
                    <!--end: Datatable-->
                </div>

                <div class="card-footer border-0">
                    <button type="reset" class="btn btn-outline-primary mr-2">Batal</button>
                    <button id="submit_review_skp" type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection



@section('script')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="//cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script>
    <script>
        let idpegawai = {!! json_encode($id_pegawai) !!}
        $(function() {

            var currentNumber = null;
            var cntNumber = 0;
            var current = null;
            var cnt = 0;

            $('#kt_datatable').DataTable({

                responsive: true,
                pageLength: 10,
                order: [
                    [1, 'desc']
                ],
                "bPaginate": false,
                processing: true,
                ajax: '/datatable/penilaian-skp-review?type=skp&id_pegawai=' + idpegawai,
                columns: [{
                    data: 'rencana_kerja',
                    render: function(data, type, row, meta) {
                        let id = row.rencana_kerja;

                        if (row.rencana_kerja != currentNumber) {
                            currentNumber = row.rencana_kerja;
                            cntNumber++;
                        }

                        if (row.rencana_kerja != current) {
                            current = row.rencana_kerja;
                            cnt = 1;
                        } else {
                            cnt++;
                        }
                        return cntNumber;
                    }
                }, {
                    data: 'jenis'
                }, {
                    data: 'skp_atasan'
                }, {
                    data: 'rencana_kerja'
                }, {
                    data: 'aspek_skp'
                }, {
                    data: 'iki'
                }, {
                    data: 'target'
                }, {
                    data: 'satuan'
                }, {
                    data: 'rencana_kerja'
                }],
                columnDefs: [{
                        targets: [1, 2],
                        visible: false
                    },
                    {
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        width: '10rem',
                        class: "wrapok",
                        render: function(data, type, row, meta) {
                            // console.log(meta);
                            let checked_true = '';
                            let checked_false = '';
                            let keterangan = '';
                            if (row.kesesuaian == 'ya') {
                                checked_true = 'checked';
                            } else {
                                checked_false = 'checked';
                            }

                            if (row.keterangan !== null) {
                                keterangan = row.keterangan
                            }

                            return `
                             <input type="hidden" value="${row.id_skp}" id="id_skp[${meta.row}]" name="id_skp[${meta.row}]" class="test"/>
                            <div class="form-group">
                                <label>Kesesuaian Skp</label>
                                <div class="radio-inline">
                                    <label for="kesesuaian_true${meta.row}" class="radio">
                                    <input type="radio" class="kesesuaian_true" data-id="${row.id_skp}" id="kesesuaian_true${meta.row}" ${checked_true} value="ya" name="kesesuaian[${meta.row}]" />
                                    <span></span>Sesuai</label>
                                    <label for="kesesuaian_false${meta.row}" class="radio">
                                    <input type="radio" class="kesesuaian_flase" id="kesesuaian_false${meta.row}" ${checked_false} value="tidak" name="kesesuaian[${meta.row}]" />
                                    <span></span>Tidak</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="keterangan${meta.row}">Keterangan</label>
                                <textarea name="keterangan[${meta.row}]" class="form-control form-control-solid" id="keterangan${meta.row}"  rows="5">${keterangan}</textarea>
                            </div>
                            `;
                        },
                    }
                ],
                rowGroup: {
                    dataSrc: ['jenis_kinerja', 'skp_atasan']
                },
                "rowsGroup": [-1, 0, 3],
                "ordering": false,
            });

            $('#submit_review_skp').on("click", function() {
                let data = '';
                // let id_skp = '';
                // let kesesuaian_true = $(".kesesuaian_true").map(function() {
                //     let id_skp = $(this).data('id');
                //     if ($(this).is(":checked")) {
                //         if ($(this).data('id') == id_skp) {
                //             $(this).prop("checked", false);
                //             console.log(id_skp);
                //             return "ok";
                //         } else {
                //             id_skp = $(this).data('id');
                //             console.log(id_skp);
                //             return "no";
                //         }
                //     }
                //     // return $(this).data('id');
                // }).get();
                // console.log(kesesuaian_true);

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });

                $.ajax({
                    type: "POST",
                    url: "/review_skp",
                    data: $('#review_skp').serialize(),
                    success: function(response) {
                        console.log(response);
                        swal.fire({
                            text: "Skp berhasil di Review.",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        }).then(function() {
                            window.location.href = '/penilaian/skp';
                        });
                    },
                    error: function(xhr) {

                    }
                });

            })

        })
    </script>
@endsection
