@extends('layout.app')

@section('style')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('button')
    <a href="{{ url('skp/tahunan/tambah') }}" class="btn btn-primary font-weight-bolder">
        <span class="svg-icon">
            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                    <rect fill="#000000" opacity="0.3"
                        transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) "
                        x="4" y="11" width="16" height="2" rx="1" />
                </g>
            </svg>
            <!--end::Svg Icon-->
        </span>
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
                    <table class="table table-group table-head-bg" id="kt_datatable" style="margin-top: 13px !important">
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
                    <!--end: Datatable-->
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
        "use strict";
        let table = $('#kt_datatable');

        $(function() {

            var currentNumber = null;
            var cntNumber = 0;
            var current = null;
            var cnt = 0;

            table.DataTable({
                responsive: true,
                pageLength: 10,
                order: [
                    [1, 'desc'],
                    [2, 'desc']
                ],
                processing: true,
                ajax: '/skp-datatable?type=tahunan',
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
                        render: function(data, type, row, full, meta) {
                            // console.log(row);
                            return `
                            <a role="button" href="/skp/edit/${row.id_skp}?type=tahunan" class="btn btn-success btn-sm">Ubah</a>
                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="${row.id_skp}">Hapus</button>
                            `;
                        },
                    }
                ],
                rowGroup: {
                    dataSrc: ['jenis_kinerja', 'skp_atasan'],
                    // className: 'table-group',
                },
                "rowsGroup": [-1, 0, 3],
                "ordering": false,
            });
        })

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault()
            let params = $(this).attr('data-id');

            Swal.fire({
                title: 'Apakah kamu yakin akan menghapus data ini ?',
                text: "Data akan di hapus permanen",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/skp/delete/' + params + '?type=tahunan',
                        type: 'POST',
                        data: {
                            '_method': 'DELETE',
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            let res = JSON.parse(response);
                            console.log(response);
                            if (res.status !== false) {
                                Swal.fire('Deleted!', 'Your file has been deleted.', 'success')
                                    .then(function() {
                                        window.location.href = '/skp/bulanan';
                                    });
                            } else {
                                swal.fire({
                                    title: "SKP tidak dapat di hapus. ",
                                    text: "SKP digunakan oleh bawahaan. ",
                                    icon: "warning",
                                });
                            }
                        }
                    })
                }
            })
        })
    </script>
@endsection
