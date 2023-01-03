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
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Laporan</h3>
                </div>
                <div class="card-body">
                    <!--begin::Form-->
                    <form class="form">
                   
                        <div class="row">
                            <div class="col-lg-3" id="satuan_kerja__">
                                <div class="form-group">
                                    <label for="satuan_kerja">Pilih Satuan Kerja</label>
                                    <select class="form-control" id="satuan_kerja">
                                        @if ($satuan_kerja != null)
                                            <option selected disabled> Pilih Satuan Kerja </option>
                                            @foreach ($satuan_kerja as $key => $value)
                                                <option value="{{ $value['id'] }}">{{ $value['nama_satuan_kerja'] }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3" id="pegawai_">
                                <div class="form-group">
                                    <label for="pegawai">Pilih Pegawai</label>
                                    <select class="form-control" id="pegawai">
                                
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-lg-3"> -->
                                <div class="form-group col-md-6">
                                    <label>Tanggal</label>
                                    <div class='input-group' id='kt_daterangepicker_2'>
                                        <input type='text' class="form-control" readonly="readonly"
                                            placeholder="Select date range" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 row">

                                    <div class="col">
                                        <button type="reset" id="export-excel" class="btn btn-block btn-success"><i
                                                class="flaticon2-pie-chart"></i>Export Excel</button>
                                    </div>
                                    <div class="col">
                                        <button type="reset" id="preview-excel" class="btn btn-block btn-danger"><i
                                                class="flaticon2-pie-chart"></i>Tampilkan Data</button>
                                    </div>
                                </div>
                            </div>
                        <!-- </div> -->

                    </form>
                    <!--end::Form-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection

@section('script')
    <script>

        function maxdate() {
            var dtToday = new Date();
            // var month = dtToday.getMonth() + 1;
            // var day = dtToday.getDate();
            var year = dtToday.getFullYear();
         
            
            // var maxDate = month + '/' + day + '/' + year;
            // return maxDate;
            // $('#tanggal').attr('min', maxDate);
            return year;
        }

        jQuery(document).ready(function() {
            // console.log($('#satuan_kerja').val());

            console.log(maxdate());
            $('#satuan_kerja').select2();
              $('#pegawai').select2({
                placeholder : 'Pilih Pegawai'
              });

            let typeRole = {!! json_encode($TypeRole) !!};
            console.log(typeRole);
            let current = {!! json_encode($current) !!};

            if (typeRole == 'super_admin' || typeRole == 'pegawai') {
                $('#satuan_kerja__').css('display', 'block');
            } else {
                $('#satuan_kerja__').css('display', 'none');
            }

            if (typeRole == 'pegawai') {
                $('#pegawai_').css('display', 'none');
                $('#satuan_kerja__').css('display', 'none');
            }

            if (typeRole == 'admin') {
                pegawaiBySatuanKerja(current.id_satuan_kerja);
            }

            function pegawaiBySatuanKerja(params) {
                // alert(params);
                     $('#pegawai').html('').trigger('change');
                $.ajax({
                    url : '/admin/pegawai/byPerangkatDaerah/'+params,
                    method : 'GET',
                    success : function (res) {
                        let newOption = '<option value="0"> Semua </option>'; 
                        $.each(res, function(indexInArray, valueOfElement) {
                                newOption += `<option value="${valueOfElement.id}">${valueOfElement.value}</option>`;
                        });
                        $('#pegawai').append(newOption).trigger('change');
                    }
                })
            }

              

            $('#kt_daterangepicker_2').daterangepicker({
                    buttonClasses: ' btn',
                    applyClass: 'btn-primary',
                    cancelClass: 'btn-danger',
                    minDate: '1/1/'+maxdate()
                },
           
            );

            $('#kt_daterangepicker_2').on('apply.daterangepicker', function(ev, picker) {
                $('#kt_daterangepicker_2 .form-control').val(picker.startDate.format('YYYY-MM-DD') + ' / ' +
                    picker.endDate.format('YYYY-MM-DD'));
            });

            $('#satuan_kerja').on('change', function () {
                pegawaiBySatuanKerja($(this).val());
            })

            $('#preview-excel').on('click', function() {
                let val_range = $('#kt_daterangepicker_2 input').val();
                let perangkat_daerah = $('#satuan_kerja option:selected').text();
                let satuan_kerja = $('#satuan_kerja').val();
                let pegawai = $("#pegawai").val();
                let type = '';

                if (typeRole == 'super_admin') {
                    if (pegawai !== 0 && satuan_kerja !== null) {
                        type = 'pegawai'
                    }
                    
                    if(pegawai == 0 && satuan_kerja !== null){
                        type = 'rekapitulasi';
                    }
                }

                if (typeRole == 'admin') {
                    if (satuan_kerja == null && pegawai !== 0)  {
                    type = 'pegawai'
                    }
                    if (satuan_kerja == null && pegawai == 0) {
                     type = 'rekapitulasi';  
                     satuan_kerja = current_satuan_kerja; 
                    }
                }

                if (typeRole == 'pegawai') {
                    type = 'pegawai';
                    pegawai = current.id;
                }
                // console.log(satuan_kerja + ' | ' +pegawai);
                // console.log(type);

                if (val_range != '') {
                    let val = val_range.split('/');
                    let params = {
                        'startDate': val[0].trim(),
                        'endDate': val[1].trim(),
                        'type': 'pdf',
                        'role': type,
                        'satuanKerja': satuan_kerja,
                        // 'perangkat_daerah':perangkat_daerah
                    };

                    let dataParams = JSON.stringify(params);
                    url = '/laporan-pegawai/export/rekapitulasi_pegawai/' + dataParams+'?perangkat_daerah='+perangkat_daerah+'&pegawai='+pegawai;
                    window.open(url);
                       $('#pegawai').val('').trigger('change');
                } else {
                    Swal.fire(
                        "Perhatian",
                        "Pilih range tanggal terlebih dahulu",
                        "warning"
                    );
                }
            })

            $('#export-excel').on('click', function() {
                let val_range = $('#kt_daterangepicker_2 input').val();
                let perangkat_daerah = $('#satuan_kerja option:selected').text();
                let pegawai = $("#pegawai").val();
                let type = '';

                if (pegawai !== 0 && satuan_kerja !== null) {
                    type = 'pegawai'
                }
                
                if(pegawai == 0 && satuan_kerja !== null){
                    type = 'rekapitulasi';
                }

                $('#pegawai').val('').trigger('change');
                if (val_range != '') {
                    let val = val_range.split('/');
                    let params = {
                        'startDate': val[0].trim(),
                        'endDate': val[1].trim(),
                        'type': 'excel',
                        'role': type,
                        'satuanKerja': satuan_kerja,
                        'perangkat_daerah':perangkat_daerah
                    };
                    let dataParams = JSON.stringify(params);
                    url = '/laporan-pegawai/export/rekapitulasi_pegawai/' + dataParams +'?perangkat_daerah='+perangkat_daerah+'&pegawai='+pegawai;
                    window.open(url);
                } else {
                    Swal.fire(
                        "Perhatian",
                        "Pilih range tanggal terlebih dahulu",
                        "warning"
                    );
                }
            })

        });
    </script>
@endsection
