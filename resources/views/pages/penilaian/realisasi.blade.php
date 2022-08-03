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