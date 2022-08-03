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
                
                <form id="review_skp">

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

                    </form>

                </div>

                <div class="card-footer border-0">
                    <button type="reset" class="btn btn-outline-primary mr-2">Batal</button>
                    <button id="submit_review_realisasi" type="button" class="btn btn-primary">Simpan</button>
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
         let idpegawai = {!! json_encode($id_pegawai) !!};
         let bulan = {!! json_encode($bulan) !!};
      $(function(){
        $('#kt_datatable').DataTable({
            responsive: true,
                pageLength: 10,
                order: [[1, 'desc']],
                "bPaginate": false,
                processing:true,
                ajax: '/datatable/penilaian-skp-review?id_pegawai='+idpegawai,
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
                            // console.log(data);
                            let html ='';
                            let target = 0;
                            html += '<ul style="list-style:none">';
                            $.each(data,function (x,y) {
                                target = 0;
                                $.each(y.target_skp, function (n,m) {
                                        if (m['bulan'] == 0) {
                                            target = m['target'];
                                        }
                                })
                                html += `<li style="margin-bottom:4rem">${target}<li>`;
                                
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
                            console.log(bulan);
                            let html ='';
                            let target = 0;
                            html += '<ul style="list-style:none">';
                            $.each(data,function (x,y) {
                                $.each(y.realisasi_skp, function (a,b) {
                                    if (b.bulan == bulan) {
                                        html += `<li style="margin-bottom:4rem">${b.realisasi_bulanan}<li>`;
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
                            console.log(data);
                            let checked_true = '';
                            let checked_false = '';
                            let keterangan = '';
                            if (data.kesesuaian == 'ya') {
                                checked_true = 'checked';
                            } else {
                                checked_false = 'checked';
                            }

                            if (data.keterangan !== null) {
                                keterangan = data.keterangan
                            }

                            return `
                             <input type="hidden" value="${data.id}" name="id_skp[${meta.row}]"/>
                             <input type="hidden" value="${bulan}" name="bulan[${meta.row}]"/>
                            <div class="form-group">
                                <label>Kesesuaian Skp</label>
                                <div class="radio-inline">
                                    <label for="kesesuaian_true${meta.row}" class="radio kesesuaian_true${meta.row}">
                                    <input type="radio" id="kesesuaian_true${meta.row}" ${checked_true} value="ya" name="kesesuaian[${meta.row}]" />
                                    <span></span>Sesuai</label>
                                    <label for="kesesuaian_false${meta.row}" class="radio kesesuaian_false${meta.row}">
                                    <input type="radio" id="kesesuaian_false${meta.row}" ${checked_false} value="tidak" name="kesesuaian[${meta.row}]" />
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
                    dataSrc: ['jenis_kinerja','skp_atasan']
                },
        });

        $('#submit_review_realisasi').on("click", function () {
              
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.ajax({
                type: "POST",
                url: "/review_realisasi",
                data: $('#review_skp').serialize(),
                success: function (response) {
                    console.log(response);
                    swal.fire({
                        text: "Realisasi berhasil di Review.",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    }).then(function() {
                        window.location.href = '/penilaian/realisasi';
                    });
                },
                error : function (xhr) {
                 
                }
            });
                
       })

    })

    </script>
@endsection