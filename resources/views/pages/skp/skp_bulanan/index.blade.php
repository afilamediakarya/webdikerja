@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('button')
    <!-- <input id="bday-month" type="month" value="{{ date('Y-m') }}" class="form-control" > -->

 

    <a href="javascript:;" id="create_target" class="btn btn-primary font-weight-bolder">
        <span class="svg-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
            </g>
        </svg></span>
        Tambah Target
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
                <select id="bulan_" class="form-control" style="    position: relative;left: 52rem;top: 32px;width: 12rem;">
                    <option selected disabled> Pilih bulan </option>
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
                ajax: '/skp-datatable?type=bulanan&bulan='+bulan,
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
                        data: 'id'
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
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        width: '10rem',
                        class:"wrapok",
                        render: function(data, type, full, meta) {
                            return `
                            <a role="button" href="/skp/edit/${data}?type=bulanan&bulan=${bulan}" class="btn btn-success btn-sm">Ubah</a>
                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="${data}" data-bulan="${bulan}">Hapus</button>
                            `;
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

        $(document).on('click','#create_target', function (e) {
            e.preventDefault();
            let bulan = $('#bulan_').val();
            if (bulan !== null) {
                window.location.href = '/skp/bulanan/create-target?bulan='+bulan
            }else{
                swal.fire({
                    title : "Maaf. ",
                    text: "Pilih bulan terlebih dahulu. ",
                    icon: "warning",
                });
            }
        })

        $(document).on('click','.btn-delete', function (e) {
            e.preventDefault()
            let params = $(this).attr('data-id');
            let params_bulan = $(this).attr('data-bulan'); 
            alert(params_bulan);
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
                                url  : '/skp/delete/'+ params + '?type=bulanan&bulan='+params_bulan,
                                type : 'POST',
                                data : {
                                    '_method' : 'DELETE',
                                    '_token' : $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (response) {
                                    let res = JSON.parse(response);
                                    console.log(response);
                                    if (res.status !== false) {
                                        Swal.fire('Deleted!', 'Your file has been deleted.','success');
                                        $('#kt_datatable').DataTable().ajax.reload()
                                    }else{
                                        swal.fire({
                                            title : "SKP tidak dapat di hapus. ",
                                            text: "SKP digunakan oleh bawahaan. ",
                                            icon: "warning",
                                        });
                                    }
                                }
                            })
                        }
                })
        })

        // function deleteRow(params) {
        //     Swal.fire({
        //     title: 'Apakah kamu yakin akan menghapus data ini ?',
        //     text: "Data akan di hapus permanen",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'Yes, delete it!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 url  : '/skp/delete/'+ params,
        //                 type : 'POST',
        //                 data : {
        //                     '_method' : 'DELETE',
        //                     '_token' : $('meta[name="csrf-token"]').attr('content')
        //                 },
        //                 success: function (response) {
        //                     let res = JSON.parse(response);
        //                     console.log(res.status);
        //                     if (res.status !== false) {
        //                         Swal.fire('Deleted!', 'Your file has been deleted.','success');
        //                           setTimeout(function () {
        //                             window.location.href = '/skp';
        //                         }, 1500);     
        //                     }else{
        //                         swal.fire({
        //                             title : "SKP tidak dapat di hapus. ",
        //                             text: "SKP digunakan oleh bawahaan. ",
        //                             icon: "warning",
        //                         });
        //                     }
        //                 }
        //             })
        //         }
        //     })
        // }
       

    </script>
@endsection