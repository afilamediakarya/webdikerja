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
            <div class="card card-custom">
                
                <div class="card-body">
                <select id="bulan_" class="form-control" style="position: relative;bottom: 11px;width: 12rem;">
                    <option selected disabled> Pilih bulan </option>
                    <option value="0">Tahunan</option>
                    @foreach($nama_bulan as $in => $month)
                        <option value="{{$in+1}}" @if($in+1 == date('m')) selected @endif>{{$month}}</option>
                    @endforeach
                </select>
                    <!--begin: Datatable-->
                    <table class="table table-borderless table-head-bg" id="kt_datatable" style="margin-top: 13px !important">
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
    <script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script>
        "use strict";
        let bulan = $('#bulan_').val();
        $(function () {
            datatable_(bulan);
        })

        function datatable_(bulan) {
            $('#kt_datatable').dataTable().fnDestroy();
            $('#kt_datatable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[1, 'asc'],[2, 'asc']],
                processing:true,
                ajax: '/realisasi/datatable?bulan='+bulan,
                columns : [
                    { 
                    data : null, 
                        render: function (data, type, row, meta) {
                            // console.log(data);
                                return meta.row + meta.settings._iDisplayStart + 1;
                        }  
                    },{
                        data:'jenis'
                    },{
                        data:'skp_atasan'
                    },{
                        data:'rencana_kerja'
                    },{
                        data: 'aspek_skp'
                    },{
                        data: 'aspek_skp'
                    },{
                        data: 'aspek_skp'
                    },{
                        data: 'aspek_skp'
                    },{
                        data: 'aspek_skp'
                    },{
                        data: null
                    }
                ],
                columnDefs : [
                    {
                        targets: [1,2],
                        visible: false
                    },
                    {
                        targets : 4,
                        render : function (data) {
                            
                            let html ='';
                            html += '<ul style="list-style:none">';
                            $.each(data,function (x,y) {
                                html += `<li style="margin-bottom:4rem">${y.aspek_skp}<li>`;
                            })
                            html += '</ul>';
                            

                            return html;
                            
                        }
                    },
                    {
                        targets : 5,
                        render : function (data) {
                            
                            let html ='';
                            html += '<ul style="list-style:none">';
                            $.each(data,function (x,y) {
                                html += `<li style="margin-bottom:4rem">${y.iki}<li>`;
                            })
                            html += '</ul>';
                            

                            return html;
                            
                        }
                    },
                    {
                        targets : 6,
                        render : function (data) {
                            console.log(data);
                            let html = '';
                            html += '<ul style="list-style:none">';
                            $.each(data, function (index,value) {
                                $.each(value.target_skp, function (x,y) {
                                    if (y['bulan'] == bulan) {
                                        html += `<li style="margin-bottom:4rem">${y.target}<li>`;
                                    }
                                })
                            })
                            html += '</ul>';
                           
                            return html;
                        }
                    },
                    {
                        targets : 7,
                        render : function (data) {
                            
                            let html ='';
                            let target = 0;
                            html += '<ul style="list-style:none">';
                            $.each(data,function (x,y) {
                                html += `<li style="margin-bottom:4rem">${y.satuan}<li>`;
                            })
                            html += '</ul>';
                            

                            return html;
                            
                        }
                    },
                    {
                        targets : 8,
                        render : function (data) {
                            console.log(data);
                            let html = '';
                            html += '<ul style="list-style:none">';
                            $.each(data, function (index,value) {
                                $.each(value.realisasi_skp, function (x,y) {
                                    if (y['bulan'] == bulan) {
                                        html += `<li style="margin-bottom:4rem">${y.realisasi_bulanan}<li>`;
                                    }
                                })
                            })
                            html += '</ul>';
                           
                            return html;
                            
                        }
                    },
                    {
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        width: '10rem',
                        class:"wrapok",
                        render: function(data, type, full, meta) {
                           let params = data.id+','+data.skp_atasan+','+bulan
                           return `<a role="button" class="btn btn-secondary btn-sm btn-realisasi" data-params="${params}">Realisasi</a><br>
                           <small>Status</small><br>
                            <span class="badge badge-${data.color}">${data.status_review}</span><br>
                            <small class="text-muted">${data.keterangan}</small>`;
                            // return `
                            // <a role="button" href="/skp/edit/${data}?type=bulanan&bulan=${bulan}" class="btn btn-success btn-sm">Ubah</a>
                            // <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="${data}" data-bulan="${bulan}">Hapus</button>
                            // `;
                        },
                    }
                ],
                rowGroup: {
                    dataSrc: ['jenis_kinerja','skp_atasan']
                },
            });
        }

        $(document).on('change','#bulan_', function () {
            let value = $(this).val();
            datatable_(value)
        })

        $(document).on('click','.btn-realisasi', function () {
            let params = $(this).attr('data-params').split(',');
            window.location.href = '/realisasi/tambah?id_skp='+params[0]+'&rencana_kerja='+params[1]+'&bulan='+params[2]; 
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
