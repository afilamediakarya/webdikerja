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
                    
                    <div class="row" style="margin-bottom: 1rem">
                        <div class="col-lg-2">
                            <input type="date" value="{{ date('Y-m-d') }}" class="form-control" id="filter-tanggal">
                        </div>
                        <div class="col-lg-2">
                            <select class="form-control" id="valid_">
                                <option value="0" selected>invalid</option>
                                <option value="1">valid</option>
                                <option value="semua">semua</option>
                            </select>        
                        </div>
                        <button class="btn btn-primary btn-sm" id="filter-btn" style="position:relative;right:0px;">Filter</button>
                    </div>
                    <table class="table table-borderless table-head-bg" id="kt_absen" style="margin-top: 13px !important">
                        <thead>
                            
                            <tr>
                                <th>No</th>
                                <th>Nama Pegawai</th>
                                <th>Status</th>
                                <th>Waktu Masuk</th>
                                <th>Waktu Pulang</th>
                                <th>Validation</th>
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
      <script src="{{asset('plugins/custom/price-format/jquery.priceformat.min.js')}}"></script>
    <script>
        let url = {!! json_encode($url) !!};
        let satker = {!! json_encode($satker) !!};

    $(document).on('click','#filter-btn', function () {
        datatable_();
    })

        function datatable_() {
            let valid_ =  $("#valid_").val();
            let tanggal = $('#filter-tanggal').val();
            // alert("/absen/datatable/"+satuan_kerja+'/'+tanggal+'/'+valid_);
            $('#kt_absen').dataTable().fnDestroy();
            $('#kt_absen').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']],
                processing:true,
                ajax: '/admin/absen/datatable/'+satker+'/'+tanggal+'/'+valid_,
                columns : [
                    { 
                    data : null, 
                        render: function (data, type, row, meta) {
                            console.log(data);
                                return meta.row + meta.settings._iDisplayStart + 1;
                        }  
                    },{
                        data:'nama_pegawai'
                    },{
                        data:'status'
                    },{
                        data:'waktu_masuk'
                    },{
                        data:'waktu_pulang'
                    },{
                        data:'validation',
                    },{
                        data:null,
                    }
                ],
                columnDefs : [
                    {
                        targets: 5,
                        render: function(data, type, full, meta) {
                            if (data > 0) {
                                return `<a href="#" class="btn btn-icon btn-success btn-sm"><i class="fa fa-check" aria-hidden="true"></i></a>`;
                            }else{
                                return `<a href="#" class="btn btn-icon btn-danger btn-sm"><i class="fa fa-times" aria-hidden="true"></i></a>`;
                                
                            }
                        },
                    },
                    {
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        width: '20rem',
                        class:"wrapok",
                        render: function(data, type, full, meta) {
                            let params = data.id+','+data.tanggal_absen;
                            return `
                            <a href="javascript:;" type="button" data-id="${params}" data-valid="1" class="btn btn-success button-valid btn-sm"> <i class="fa fa-check-circle" aria-hidden="true"></i> Accept</a> 
                            <a href="javascript:;" type="button" data-id="${params}" data-valid="0" class="btn btn-danger button-valid btn-sm"> <i class="fa fa-times-circle" aria-hidden="true"></i> Reject</a>

                            `;
                        },
                    }
                ]
            });
        }

        $(document).on('click','.button-valid', function (e) {
            e.preventDefault();
            let nilai_valid = $(this).attr('data-valid');
            let key = $(this).attr('data-id');
            let params = key.split(",");

            $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url : "{{route('change-validation')}}",
            method : 'POST',
            data: {
                'id_pegawai' : params[0],
                'tanggal' : params[1],
                'valid' : nilai_valid
            },
            success : function (res) {
                console.log(res);
                if (res.success) {
                    swal.fire({
                        text: 'Absen berhasil di tambahkan',
                        icon: "success",
                        showConfirmButton:true,
                        confirmButtonText: "OK, Siip",
                    }).then(function() {
                        datatable_();
                    });      
                }else{
                    
                }
            
            },
            error : function (xhr) {
                Swal.fire({
                        icon: 'error',
                        title: 'Maaf, terjadi kesalahan',
                        text: 'Silahkan Hubungi Admin'
                    })
            }
        });
        })

        jQuery(document).ready(function() {
            Panel.init('side_form');
            $('#id_satuan_kerja').select2();
            $('#pegawai').select2({
                placeholder: "Pilih Pegawai"
            });
            $('#filter-satuan-kerja').select2({
                placeholder: "Pilih Satuan Kerja"
            });
            
            datatable_();

            

        });

    </script>
@endsection