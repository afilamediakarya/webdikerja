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

                    <ul class="nav nav-success nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pendidikan-tab" data-toggle="tab" href="#pendidikan"
                                role="tab" aria-controls="pendidikan" aria-selected="true">Pendidikan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pangkat-tab" data-toggle="tab" href="#pangkat" role="tab"
                                aria-controls="pangkat" aria-selected="false">Pangkat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="jabatan-tab" data-toggle="tab" href="#jabatan" role="tab"
                                aria-controls="jabatan" aria-selected="false">Jabatan</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade show active" id="pendidikan" role="tabpanel"
                            aria-labelledby="pendidikan-tab">
                            <table class="table table-group table-head-bg" id="kt_datatable_pendidikan"
                                style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tingkat Pendidikan</th>
                                        <th>Fakultas</th>
                                        <th>Jurusan</th>
                                        <th>Nomor</th>
                                        <th>Tanggal</th>
                                        <th>Nama Kepala Sekolah/Rektor</th>
                                        <th>Nama</th>
                                        <th>Lokasi (Kab/Kota)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="pangkat" role="tabpanel" aria-labelledby="pangkat-tab">Lorem, ipsum
                            dolor sit amet consectetur adipisicing elit. Voluptatibus distinctio omnis sequi voluptas.
                            Expedita nulla dolores et corrupti quas saepe illo dolorum illum tempore incidunt explicabo,
                            velit praesentium magnam dolor.</div>
                        <div class="tab-pane fade" id="jabatan" role="tabpanel" aria-labelledby="jabatan-tab">Lorem ipsum
                            dolor sit amet consectetur adipisicing elit. Ipsa aut atque, expedita tempore facilis aliquam,
                            incidunt asperiores voluptates commodi itaque dolorum? Cumque corrupti velit commodi, error quis
                            consequuntur sed. Recusandae eos nulla, facilis ut error corporis porro animi facere temporibus?
                        </div>
                    </div>

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

        $(function() {

            var currentNumber = null;
            var cntNumber = 0;
            var current = null;
            var cnt = 0;

            let table = $('#kt_datatable');
            table.DataTable({
                responsive: true,
                pageLength: 10,
                order: [
                    [1, 'desc']
                ],
                processing: true,
                ajax: '/skp-datatable?type=tahunan',
                columns: [{
                    data: 'id_skp',
                    render: function(data, type, row, meta) {
                        let id = row.id_skp;

                        if (row.id_skp != currentNumber) {
                            currentNumber = row.id_skp;
                            cntNumber++;
                        }

                        if (row.id_skp != current) {
                            current = row.id_skp;
                            cnt = 1;
                        } else {
                            cnt++;
                        }
                        return cntNumber;
                    }
                }, {
                    data: 'jenis'
                }, {
                    data: 'id_skp'
                }, {
                    data: 'iki'
                }, {
                    data: 'target'
                }, {
                    data: 'satuan'
                }, {
                    data: 'id_skp'
                }],
                columnDefs: [{
                        targets: 1,
                        visible: false
                    },
                    {
                        targets: 2,
                        render: function(data, type, row, full, meta) {

                            return row.rencana_kerja;

                        }
                    },
                    {
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        width: '10rem',
                        class: "wrapok",
                        render: function(data, type, row, full, meta) {
                            // console.log(row.id);
                            return `
                            <a role="button" href="/skp/edit/${row.id_skp}?type=tahunan" class="btn btn-success btn-sm">Ubah</a>
                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="${row.id_skp}">Hapus</button>
                            `;
                        },
                    }
                ],
                rowGroup: {
                    dataSrc: 'jenis_kinerja'
                },
                "rowsGroup": [-1, 0, 2],
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
                            console.log(res.status);
                            if (res.status !== false) {
                                Swal.fire('Deleted!',
                                        'Data Target SKP Tahunan berhasil dihapus.', 'success')
                                    .then(function() {
                                        window.location.href = '/skp/tahunan';
                                    });
                            } else {
                                swal.fire({
                                    title: "Failed!",
                                    text: `${res.message}`,
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
