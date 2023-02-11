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
                        <select id="bulan_" class="form-control" style="position: relative;bottom: 11px;width: 12rem;">
                            <option selected disabled> Pilih bulan </option>
                            @foreach ($nama_bulan as $in => $month)
                                <option value="{{ $in + 1 }}" @if ($in + 1 == date('m')) selected @endif>
                                    {{ $month }}</option>
                            @endforeach
                        </select>
                
                    <!--begin: Datatable-->
                    <table class="table table-borderless table-head-bg" id="kt_datatable"
                        style="margin-top: 13px !important">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Jabatan</th>
                                <th>Nilai</th>
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
    <script>
        "use strict";
        let type = {!! json_encode($type) !!};

        $(document).on('change', '#bulan_', function() {
            let bulan = $(this).val();
            // alert(bulan)
            datatable(bulan);
        })

        function datatable(bulan) {
            $('#kt_datatable').dataTable().fnDestroy();
            var table = $('#kt_datatable');
                table.DataTable({
                    responsive: true,
                    pageLength: 10,
                    order: [
                        [0, 'asc']
                    ],
                    processing: true,
                    ajax: `/get_data/penilaian/${type}?bulan=${bulan}`,
                    columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, {
                        data: 'nama'
                    }, {
                        data: 'nip'
                    }, {
                        data: 'nama_jabatan'
                    }, {
                        data: 'nilai_kinerja',
                    }, {
                        data: null,
                    }],
                    columnDefs: [
                        {
                            targets: 4,
                            render :  function (data) {
                                if (data < 50) {
                                    return `<badge class="badge badge-danger">${data} %</badge>`;
                                }else if(data > 50 && data < 70){
                                    return `<badge class="badge badge-warning">${data} %</badge>`;
                                }else{
                                    return `<badge class="badge badge-primary">${data} %</badge>`;
                                }
                            }
                        },
                        {
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        render: function(data) {
                            return `<a href="/penilaian-kinerja?pegawai=${data.id_pegawai}&bulan=${bulan}" role="button" class="btn btn-primary">Review</a>`;

                        },
                    }
                ],
                });
          
        }

        jQuery(document).ready(function() {
            datatable($('#bulan_').val());
            // KTDatatablesAdvancedRowGrouping.init();
        });
    </script>
@endsection
