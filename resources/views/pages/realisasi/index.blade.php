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
                                <th>Realisasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $inc_letter = 'A';
                                $no = 0;
                            @endphp

                            @if($level == 'pegawai')
                                
                                @if(isset($data['data']['utama']))
                                    <tr>
                                    <td colspan="7"><b>A. Kinerja Utama</b></td>
                                </tr>
                                @foreach($data['data']['utama'] as $key => $value)
                                    
                                    <tr style="background:#f2f2f2">
                                        <td>{{$inc_letter++}}.</td>
                                        <td colspan="8">{{$value['atasan']['rencana_kerja']}}</td>  
                                    <tr>

                                    @foreach($value['skp'] as $k => $v)
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
                                                    $num += $b['target'];
                                                }
                                            @endphp
                                            <td>{{$num}}</td>
                                            <td>{{$l['satuan']}}</td>
                                            @php
                                                $total_realisasi = 0;
                                                foreach($l['realisasi_skp'] as $n => $m){
                                                    $total_realisasi += $m['realisasi_bulanan'];
                                                }
                                            @endphp
                                            <td>{{$total_realisasi}}</td>
                                            @if($i == 0)
                                            
                                            <td >
                                                <a role="button" onclick="realisasi('{{$v['id']}}','{{stripslashes($value['atasan']['rencana_kerja'])}}')" class="btn btn-secondary btn-sm">Realisasi</a><br>
                                                <small>Status</small><br>
                                                <span class="badge badge-{{$v['color']}}">{{$v['status_review']}}</span><br>
                                                <small class="text-muted">{{$v['label']}}</small>
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
                                    @endif

                                   @if(isset($data['data']['tambahan']))

                                    @php
                                        $nox = 0;
                                    @endphp

                                    <tr>
                                        <td colspan="7"><b>B. Kinerja Tambahan</b></td>
                                    </tr>
                                    @foreach($data['data']['tambahan'] as $k => $v)
                                        @foreach($v['aspek_skp'] as $i => $l)
                                        <tr>
                                        
                                            @if($i == 0)
                                            <td>{{$k+1}}.</td>
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
                                                    $num += $b['target'];
                                                }
                                            @endphp
                                            <td>{{$num}}</td>
                                            <td>{{$l['satuan']}}</td>
                                            @php
                                                $total_realisasi = 0;
                                                foreach($l['realisasi_skp'] as $n => $m){
                                                    $total_realisasi += $m['realisasi_bulanan'];
                                                }
                                            @endphp
                                            <td>{{$total_realisasi}}</td>
                                            @if($i == 0)
                                         
                                            <td>
                                                <a role="button" onclick="realisasi('{{$v['id']}}','{{stripslashes($value['atasan']['rencana_kerja'])}}')" class="btn btn-secondary btn-sm">Realisasi </a><br>
                                                <small>Status</small><br>
                                                <span class="badge badge-{{$v['color']}}">{{$v['status_review']}}</span><br>
                                                <small class="text-muted">{{$v['label']}}</small>
                                            </td>
                                            
                                            @else
                                            <td></td>
                                            @endif
                                        </tr>
                                        @php
                                                $nox++;
                                        @endphp
                                        @endforeach
                                  
                                    @endforeach

                                   @endif

                                
                            @else
                            @php
                                        $nox = 0;
                                    @endphp
                                @foreach($data['data'] as $key => $value)
                                    
                                    @foreach($value['aspek_skp'] as $i => $l)
                                        <tr>
                                            @if($i == 0)
                                            <td>{{$nox+1}}.</td>
                                            <td>{{$value['rencana_kerja']}}</td>
                                            @else
                                            <td></td>
                                            <td></td>
                                            @endif
                                            <td>-</td>
                                            <td>{{$l['iki']}}</td>                                       
                                            @php
                                                $num = 0;
                                                foreach($l['target_skp'] as $f => $b){
                                                    $num += $b['target'];
                                                }
                                            @endphp
                                            <td>{{$num}}</td>
                                            <td>{{$l['satuan']}}</td>
                                            @php
                                                $total_realisasi = 0;
                                                foreach($l['realisasi_skp'] as $n => $m){
                                                    $total_realisasi += $m['realisasi_bulanan'];
                                                }
                                            @endphp
                                            <td>{{$total_realisasi}}</td>
                                            @if($i == 0)
                                            
                                            <td >
                                                <a role="button" onclick="realisasi('{{$value['id']}}','-')" class="btn btn-secondary btn-sm">Realisasi</a><br>
                                                <small>Status</small><br>
                                                <span class="badge badge-{{$value['color']}}">{{$value['status_review']}}</span><br>
                                                <small class="text-muted">{{$value['label']}}</small>
                                            </td>
                                            @else
                                            <td></td>
                                            @endif
                                        </tr>
                                        @php
                                                $nox++;
                                    @endphp
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

        let bulan = '';

        $('#month_select').html(`<select id="bulan_select" class="form-control">
                <option selected disabled>Pilih Bulan</option>
                <option value="0">Semua</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>`);

            $('#bulan_select').on('change',function () {
                bulan = $(this).val();
            })

        function realisasi(id,rencana_kerja){
         
            if (bulan !== '') {
                window.location.href = '/realisasi/tambah/'+id+'/'+rencana_kerja+'/'+bulan; 
            }else{
                swal.fire({
                    text: "Silahkan pilih bulan terlebih dahulu.",
                    icon: "warning",
                });
            }
        }    

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
                            Swal.fire('Deleted!', 'Your file has been deleted.','success')
                            setTimeout(function () {
                                window.location.href = '/skp';
                            }, 1500); 
                            
                        }
                    })
                }
            })
        }

    </script>
@endsection