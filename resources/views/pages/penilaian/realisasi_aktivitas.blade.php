@extends('layout.app')

@section('style')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('button')
    <button class="btn btn-light-primary font-weight-bold" id="kt_quick_user_toggle">
                            <i class="ki ki-plus "></i> Tambah Aktivitas
                        </button>
@endsection


@section('content')
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">

            <!--begin::Card-->
            <div class="card card-custom">

                <div class="card-body">
                    <!--begin: Datatable-->
                    <form id="review_aktivitas">
                        <div class="table-responsive">
                            <table class="table table-group table-head-bg" id="kt_datatable"
                                style="margin-top: 13px !important">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Rencana Kerja</th>
                                        <th>Aktivitas</th>
                                        <th>Hasil</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </form>
                    <!--end: Datatable-->
                </div>

                <div class="card-footer border-0">
                    <button type="reset" class="btn btn-outline-primary mr-2">Batal</button>
                    <button id="submit_review_skp" type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection

@section('side-form')
        <div id="side_form" class="offcanvas offcanvas-right p-10">
			<!--begin::Header-->
			<div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
				<h3 class="font-weight-bold m-0">Tambah Aktivitas<h3>
				<a href="javascript:;"  onclick="Panel.action('hide')"  class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
					<i class="ki ki-close icon-xs text-muted"></i>
				</a>
			</div>
			<!--end::Header-->
			<!--begin::Content-->
			<div class="offcanvas-content pr-5 mr-n5">
                <form class="form" id="createForm">
                    <input type="hidden" name="id_pegawai" value="{{$pegawai}}">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Tanggal Kegiatan </label>
                                <input type="date" id="tanggal" class="form-control" name="tanggal"/>
                            </div>
                        </div>
                        <input type="text" style="display:none" name="id">
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Sasaran Kinerja</label>
                        <select class="form-control select2" name="id_skp" id="exampleSelect1">
                            <option disabled selected>Pilih Sasaran Kinerja</option>
                           @foreach($sasaran_kinerja as $key => $va)
                                <option value="{{$va['id']}}">{{$va['value']}}</option>
                           @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nama aktivitas</label>
                        <!-- <input type="text" class="form-control" id="exampleInputPassword1" name="nama_aktivitas" placeholder="Nama Aktivitas"> -->
                        <select name="nama_aktivitas" id="nama-aktivitas" class="form-control select2" >
                            <option disabled selected> Pilih Aktivitas </option>
                            @foreach($masterAktivitas as $masters)
                                <option data-id="{{$masters['id']}}" value="{{$masters['value']}}">{{$masters['value']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="exampleInputPassword1">Hasil</label>
                            <input type="number" value="0" min="0" name="hasil" class="form-control" id="exampleInputPassword1" placeholder="Hasil">
                        </div>
                        <div class="form-group col-4">
                            <label for="exampleSelect1">Satuan</label>
                            <input type="text" class="form-control" id="satuan" name="satuan" readonly>
                        </div>
                          <div class="form-group col-4">
                            <label>Waktu</label>
                            <input type="number" min="0" id="waktu" name="waktu" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="form-group mb-1">
                        <label for="exampleTextarea">Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="exampleTextarea" rows="3"></textarea>
                    </div>
                </form>
                <div class="separator separator-dashed mt-8 mb-5"></div>
                <div class="">
                    <button type="reset" class="btn btn-outline-primary mr-2 btn-cancel">Batal</button>
                    <button type="button" id="aktivitas_save" class="btn btn-primary">Simpan</button>
                </div>

				<!--begin::Separator-->
				<!--end::Separator-->
			</div>
			<!--end::Content-->
		</div>
@endsection

@section('script')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="//cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script>
        <script>
        let bulan = {!! json_encode($bulan) !!};
        let pegawai = {!! json_encode($pegawai) !!};
        let table = $('#kt_datatable');

         $(document).on('click','#kt_quick_user_toggle', function () {
            $("#createForm")[0].reset();
            $("#tanggal").prop("disabled", false);
            Panel.action('show','submit');               
        })

        function maxdate() {
            const inputElement = document.getElementById("tanggal");
            const fiveDaysAgo = new Date();
            fiveDaysAgo.setDate(fiveDaysAgo.getDate() - 5);
            minDate = fiveDaysAgo.toISOString().split("T")[0]
            inputElement.setAttribute("min", fiveDaysAgo.toISOString().split("T")[0]);
        }

        $(document).on('change','#nama-aktivitas', function () {
            let params = $('option:selected', this).attr('data-id');
            $.ajax({
                url:"admin/master-aktivitas/master-aktivitas/"+params,
                method : 'GET',
                success: function(res) {
                    if (res.success) {
                        $('#satuan').val(res.success.data.satuan);
                        $('#waktu').val(res.success.data.waktu);
                        $('#jenis').val(res.success.data.jenis);
                    }
                },
                error: function(xhr) {
                    // alert(xhr);
                }

            });
        })

        $(function() {
            maxdate()
            Panel.init('side_form');
            $('.select2').select2({
                placeholder: "Pilih"
            });
            var currentNumber = null;
            var cntNumber = 0;
            var current = null;
            var cnt = 0;

            table.DataTable({

                responsive: true,
                pageLength: 10,
                order: [
                    [1, 'desc']
                ],
                "bPaginate": false,
                processing: true,
                ajax: `/get_data/penilaian/review-aktivitas?pegawai=${pegawai}&bulan=${bulan}`,
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
                    data: 'tanggal'
                }, {
                    data: 'skp.rencana_kerja'
                }, {
                    data: 'nama_aktivitas'
                }, {
                    data: 'hasil'
                }, {
                    data: null
                }, {
                    data: 'id'
                }],
                columnDefs: [
                    {
                        targets: [2],
                        visible: false
                    },
                    {
                        targets: 5,
                        title : 'status',
                        orderable : false,
                        width: '10rem',
                        class: "wrapok",
                        render: function(data, type, row, meta) {
                            let checked_true = '';
                            let checked_false = '';
                            let keterangan = '';
                            if (row.kesesuaian == '1') {
                                checked_true = 'checked';
                            } else {
                                checked_false = 'checked';
                            }
                            return `
                             <input type="hidden" value="${row.id}" name="id_aktivitas${meta.row}" class="test"/>
                            <div class="form-group">
                                <div class="radio-inline">
                                    <label for="kesesuaian_true${meta.row}" class="radio">
                                    <input type="radio" class="kesesuaian_true" id="kesesuaian_true${meta.row}" ${checked_true} value="1" name="kesesuaian${meta.row}" />
                                    <span></span>Sesuai</label>
                                    <label for="kesesuaian_false${meta.row}" class="radio">
                                    <input type="radio" class="kesesuaian_flase" id="kesesuaian_false${meta.row}" ${checked_false} value="0" name="kesesuaian${meta.row}" />
                                    <span></span>Tidak</label>
                                </div>
                            </div>
                            `;
                        },
                    },
                    {
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return `<button type="button" class="btn btn-success btn-sm" id="ubah_review_aktivitas" data-index="${meta.row}"> Ubah </button><button type="button" class="btn btn-danger btn-sm ml-2" id="hapus_aktivitas" data-id="${data}"> Hapus </button>`;
                        },
                    }
                ],
                rowGroup: {
                    dataSrc: ['skp.rencana_kerja']
                },
                // "rowsGroup": [-1, 0, 3],
                "ordering": false,
            });

            $(document).on('click','#hapus_aktivitas', function (e) {
                e.preventDefault();
                let val = $(this).attr('data-id');

                Swal.fire({
                title: "Perhatian ",
                text: "Yakin ingin meghapus data.?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-light-danger",
                }
                }).then(function(result) {
                    // console.log(result);
                    if (result.value) {
                        axios.delete('aktivitas/delete/' + val)
                            .then(function(res) {
                                let data = res.data;
                                if (data.success) {
                                    swal.fire({
                                        text: "Data anda berhasil dihapus",
                                        title: "Sukses",
                                        icon: "success",
                                        showConfirmButton: true,
                                        confirmButtonText: "OK, Siip",
                                    }).then(function() {
                                        table.DataTable().ajax.reload();
                                        
                                    });
                                } else {
                                    Swal.fire(
                                        "Error",
                                        "Data tidak terhapus",
                                        "error"
                                    );
                                }
                            })
                            .catch(function(err) {});
                    }
                });
            })

            $(document).on('click','#ubah_review_aktivitas', function (e) {
                e.preventDefault();
                let index = $(this).attr('data-index');
                 let formData = {
                    id_aktivitas: $(`input[name="id_aktivitas${index}"]`).val(),
                    kesesuaian: $(`input[name="kesesuaian${index}"]:checked`).val(),
                 };

                var serializedData = $.param(formData);
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });

                $.ajax({
                    type: "POST",
                    url: "/review_aktivitas",
                    data: serializedData,
                    success: function(response) {
                        swal.fire({
                            text: "Aktivitas berhasil di Review.",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        }).then(function() {
                            // window.location.href = '/penilaian/skp';
                            table.DataTable().ajax.reload();
                        });
                    },
                    error: function(xhr) {

                    }
                });
            })

        })

        $(document).on('click','#aktivitas_save', function(){
                
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });

                $.ajax({
                    url : `/aktivitas/store?pegawai=${pegawai}`,
                    type : 'POST',
                    data : $('#createForm').serialize(),
                    success : function (res) {
                        console.log(res);
                        if(res.failed){
                            console.log(res);
                            swal.fire({
                                text: "Maaf Terjadi Kesalahan",
                                title:"Error",
                                timer: 2000,
                                icon: "danger",
                                showConfirmButton:false,
                            });
                        }else if(res.invalid){
                            $.each(res.invalid, function( key, value ) {
                                console.log(key);
                                if (key == 'error') {
                                        swal.fire({
                                            text: value.text,
                                            title: 'Pegawai belum absen',
                                            timer: 2000,
                                            icon: "warning",
                                            showConfirmButton:false,
                                        });
                                }else{
                                    $("input[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                                    $("select[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                                    $("textarea[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                                }
                            });
                        }else if(res.success){
                            swal.fire({
                                text: 'Aktivitas berhasil di tambahkan',
                                title:"Sukses",
                                icon: "success",
                                showConfirmButton:true,
                                confirmButtonText: "OK, Siip",
                            }).then(function() {
                                $("#createForm")[0].reset();
                                Panel.action('hide');
                                $('.select2').val(null).trigger('change');
                                table.DataTable().ajax.reload();
                            });
                        }
                    }   
                });
            });
        // console.log($('#kt_datatable').column(4).data())
    </script>
@endsection
