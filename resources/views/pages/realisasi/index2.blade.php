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
            <div class="card card-custom">

                <div class="card-body">
                
                @if($current_jadwal['status'] == true)    
                    <span class="label label-warning label-pill label-inline mr-2 mb-4"> Jadwal Penginputan : {{ Carbon\Carbon::parse($current_jadwal['data']['tanggal_awal'])->format('d/m/y') }} - {{ Carbon\Carbon::parse($current_jadwal['data']['tanggal_akhir'])->format('d/m/y') }} </span>
                @endif

                    <!--begin: Datatable-->
                    <table class="table table-group table-head-bg" id="kt_datatable" style="margin-top: 13px !important">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis Kinerja</th>
                                <th>Rencana Kerja</th>
                                <th nowrap="nowrap">Indikator Kinerja Individu</th>
                                <th>Target</th>
                                <th>Satuan</th>
                                <th>Realisasi</th>
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
        let bulan = $('#bulan_').val();
        let date = new Date();
        if (!bulan) {
            bulan = date.getMonth() + 1;
        }

        let current_jadwal = {!! json_encode($current_jadwal) !!}

        $(function() {
            datatable_(bulan);
        })

        function datatable_(bulan) {

            var currentNumber = null;
            var cntNumber = 0;
            var current = null;
            var cnt = 0;

            $('#kt_datatable').dataTable().fnDestroy();
            $('#kt_datatable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [
                    [1, 'desc'],
                    [2, 'desc']
                ],
                processing: true,
                ajax: '/realisasi/datatable?bulan=' + bulan,
                columns: [{
                    data: 'id',
                    render: function(data, type, row, meta) {
                        let id = row.id;

                        if (row.id != currentNumber) {
                            currentNumber = row.id;
                            cntNumber++;
                        }

                        if (row.id != current) {
                            current = row.id;
                            cnt = 1;
                        } else {
                            cnt++;
                        }
                        return cntNumber;
                    }
                }, {
                    data: 'jenis'
                }, {
                    data: 'id'
                }, {
                    data: 'aspek_skp'
                }, {
                    data: 'aspek_skp'
                }, {
                    data: 'aspek_skp'
                }, {
                    data: 'aspek_skp'
                }, {
                    data: 'id'
                }],
                columnDefs: [{
                        targets: 1,
                        visible: false
                    },
                    {
                        targets: 2,
                        render: function(data, type, row, meta) {

                            return row.rencana_kerja;

                        }
                    },
                    {
                        targets: 3,
                        render: function(data, type, row, meta) {
                            let iki = '';

                            $.each(data, function(x, y) {

                                if (cnt - 1 == x && cnt - 1 < data.length) {
                                    iki = y.iki
                                }
                            });

                            return iki;

                        }
                    },
                    {
                        targets: 4,
                        render: function(data, type, row, meta) {
                            let target = '';
                            $.each(data, function(i, v) {
                                $.each(v.target_skp, function(x, y) {
                                    if (cnt - 1 == i && cnt - 1 < data.length) {
                                        if (y['bulan'] == bulan) {
                                            target = y.target
                                        }
                                    }
                                })
                            });

                            return target;

                        }
                    },
                    {
                        targets: 5,
                        render: function(data, type, row, meta) {
                            let satuan = '';
                            $.each(data, function(x, y) {

                                if (cnt - 1 == x && cnt - 1 < data.length) {
                                    satuan = y.satuan
                                }
                            });

                            return satuan;

                        }
                    },
                    {
                        targets: 6,
                        render: function(data, type, row, meta) {
                            let realisasi_bulanan = '';
                            $.each(data, function(i, v) {
                                $.each(v.realisasi_skp, function(x, y) {
                                    if (cnt - 1 == i && cnt - 1 < data.length) {
                                        if (y['bulan'] == bulan) {
                                            realisasi_bulanan = y.realisasi_bulanan
                                        }
                                    }
                                })
                            });

                            return realisasi_bulanan;

                        }
                    },
                    {
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        width: '10rem',
                        class: "wrapok",
                        render: function(data, type, row, full, meta) {
                            
                            let disabled_ = '';
                            if (current_jadwal['status'] == true) {
                                disabled_ = 'disabled'
                            }

                            let params = row.id + ',' + row.skp_atasan + ',' + bulan
                            return `<a role="button" class="btn btn-secondary btn-sm btn-realisasi ${disabled_}" data-params="${params}">Realisasi</a><br>
                           <small>Status</small><br>
                            <span class="badge badge-${row.color}">${row.status_review}</span><br>
                            <small class="text-muted">${row.keterangan}</small>`;
                            // return `
                        // <a role="button" href="/skp/edit/${data}?type=bulanan&bulan=${bulan}" class="btn btn-success btn-sm">Ubah</a>
                        // <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="${data}" data-bulan="${bulan}">Hapus</button>
                        // `;
                        },
                    }
                ],
                rowGroup: {
                    dataSrc: 'jenis_kinerja'
                },
                "rowsGroup": [-1, 0, 2],
                "ordering": false,
            });
        }

        $(document).on('change', '#bulan_', function() {
            let value = $(this).val();
            datatable_(value)
        })

        $(document).on('click', '.btn-realisasi', function() {
            let params = $(this).attr('data-params').split(',');
            window.location.href = '/realisasi/tambah?id_skp=' + params[0] + '&rencana_kerja=' + params[1] +
                '&bulan=' + params[2];
        })

        // function realisasi(id,rencana_kerja){
        //     if (bulan !== '') {
        //         window.location.href = '/realisasi/tambah/'+id+'/'+rencana_kerja+'/'+bulan; 
        //     }else{
        //         swal.fire({
        //             text: "Silahkan pilih bulan terlebih dahulu.",
        //             icon: "warning",
        //         });
        //     }
        // }
    </script>
@endsection
