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
                          
                            @if($data['utama'] != [])
                            <tr>
                                <td colspan="7"><b>A. Kinerja Utama</b></td>
                            </tr>
                            @foreach($data['utama'] as $key => $value)
                                @foreach($value['aspek_skp'] as $x => $vb)
                                <tr>
                                    
                                    @if($x == 0)
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{$value['rencana_kerja']}}</td>
                                    @else
                                        <td></td>
                                        <td></td>
                                    @endif
                                    <td>{{$vb['aspek_skp']}}</td>
                                    <td>{{$vb['iki']}}</td>
                                    @php
                                        $num = 0;
                                        foreach($vb['target_skp'] as $f => $b){
                                            $num += $b['target'];
                                        }
                                    @endphp
                                    <td>{{$num}}</td>
                                    <td>{{$vb['satuan']}}</td>
                                    @if($x == 0)
                                            <td nowrap="nowrap">
                                                <a role="button" href="{{url('/skp/edit/'.$value['id'])}}" class="btn btn-success btn-sm">Ubah</a>
                                                <button onclick="deleteRow('{{$value["id"]}}')" type="button" class="btn btn-danger btn-sm">Hapus</button>
                                            </td>
                                    @else
                                        <td></td>
                                    @endif
                                 
                                </tr>
                                @endforeach
                            @endforeach
                            @else
                            <tr>
                                <td colspan=7>Belum ada data</td>
                            </tr>
                            @endif    
                            
                            
                            @if($data['tambahan'] != [])   
                            <tr>
                                <td colspan="7"><b>B. Kinerja Tambahan</b></td>
                            </tr>
                            @foreach($data['tambahan'] as $key => $value)
                                @foreach($value['aspek_skp'] as $x => $vb)
                                <tr>
                                    
                                    @if($x == 0)
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{$value['rencana_kerja']}}</td>
                                    @else
                                        <td></td>
                                        <td></td>
                                    @endif
                                    <td>{{$vb['aspek_skp']}}</td>
                                    <td>{{$vb['iki']}}</td>
                                    @php
                                        $num = 0;
                                        foreach($vb['target_skp'] as $f => $b){
                                            $num += $b['target'];
                                        }
                                    @endphp
                                    <td>{{$num}}</td>
                                    <td>{{$vb['satuan']}}</td>
                                    @if($x == 0)
                                            <td nowrap="nowrap">
                                                <a role="button" href="{{url('/skp/edit/'.$value['id'])}}" class="btn btn-success btn-sm">Ubah</a>
                                                <button onclick="deleteRow('{{$value["id"]}}')" type="button" class="btn btn-danger btn-sm">Hapus</button>
                                            </td>
                                    @else
                                        <td></td>
                                    @endif
                                 
                                </tr>
                                @endforeach
                            @endforeach
                          
                            @endif
                        </tbody>
                          
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
        $(function () {
            let table = $('#kt_datatable');
            table.DataTable({
                responsive: true,
                pageLength: 25,
                ordering:false,
            });
        })

        function deleteRow(params) {
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
                        url  : '/skp/delete/'+ params,
                        type : 'POST',
                        data : {
                            '_method' : 'DELETE',
                            '_token' : $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            let res = JSON.parse(response);
                            console.log(res.status);
                            if (res.status !== false) {
                                Swal.fire('Deleted!', 'Your file has been deleted.','success');
                                  setTimeout(function () {
                                    window.location.href = '/skp';
                                }, 1500);     
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
        }

    </script>
@endsection