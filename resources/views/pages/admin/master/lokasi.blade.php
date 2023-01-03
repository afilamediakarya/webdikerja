@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('button')
    <a onclick="Panel.action('show','submit')" class="btn btn-primary font-weight-bolder">
        <span class="svg-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        Tambah Lokasi
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
                                <th>No</th>
                                <th>Nama Lokasi</th>
                                <th>Satuan Kerja</th>
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

@section('side-form')
        <div id="side_form" class="offcanvas offcanvas-right p-10">
			<!--begin::Header-->
			<div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
				<h3 class="font-weight-bold m-0" id="title">Form Lokasi<h3>
				<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="side_form_close">
					<i class="ki ki-close icon-xs text-muted"></i>
				</a>
			</div>
			<!--end::Header-->
			<!--begin::Content-->
			<div class="offcanvas-content pr-5 mr-n5">
                <form class="form" id="createForm">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label>Satuan Kerja</label>
                        <select class="form-control" type="text" name="satuan_kerja" id="satuan_kerja">
                            <option selected disabled>Pilih Satuan kerja</option>
                            @foreach($satuan_kerja as $key => $value)
                                <option value="{{$value['id']}}">{{$value['nama_satuan_kerja']}}</option>
                            @endforeach
                        </select>
                        <small class="text-danger satuan_kerja_error"></small>
                    </div>

                    <div class="form-group">
                        <label>Nama lokasi</label>
                        <input type="text" class="form-control" name="nama_lokasi">
                        <small class="text-danger nama_lokasi_error"></small>
                    </div>

                    <div id="mapView" style="height: 300px;"></div>

                    <div class="form-group">
                        <label>Lokasi Satker</label>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Lattitude</label>
                                    <input class="form-control col" id="lat_location" type="text" name="lattitude" placeholder="lattitude" readonly/>
                                      <small class="text-danger lattitude_error"></small>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Longitude</label>
                                    <input class="form-control col" id="long_location" type="text" name="longitude" placeholder="longitude" readonly/>
                                      <small class="text-danger longitude_error"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="separator separator-dashed mt-8 mb-5"></div>
                    <div class="">
                        <button type="reset" class="btn btn-outline-primary mr-2 btn-cancel">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

				<!--begin::Separator-->
				<!--end::Separator-->
			</div>
			<!--end::Content-->
		</div>
@endsection


@section('script')
    <script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4tan2XjYELKen0nPXwN8ElHwdkghRksE&callback=initMap&libraries=v=weekly,places&sensor=false" defer></script>
    <script>
        "use strict";
        var dataRow = function() {

        var init = function() {
            var table = $('#kt_datatable');

            // begin first table
            table.DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']],
                processing:true,
                ajax: "{{ route('lokasi') }}",
                columns:[{ 
                        data : null, 
                        render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                        }  
                    },{
                        data:'nama_lokasi'
                    },{
                        data:'satuan_kerja.nama_satuan_kerja'
                    },{
                        data:'id',
                    }
                ],
                columnDefs: [
                    {
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            return '\
                                <a href="javascript:;" type="button" data-id="'+data+'" class="btn btn-secondary button-update">ubah</a>\
                                <a href="javascript:;" type="button" data-id="'+data+'" class="btn btn-danger button-delete">Hapus</a>\
                            ';
                        },
                    },
                    {
                        targets: 3,
                        render: function(data, type, full, meta) {
                            var status = {
                                'Tidak aktif': {'title': 'inactive', 'class': ' label-light-danger text-capitalize'},
                                'Aktif': {'title': 'active', 'class': ' label-light-primary text-capitalize'},
                            };
                            if (typeof status[data] === 'undefined') {
                                return data;
                            }
                            return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title + '</span>';
                        },
                    },
                ],
            });
        };

        var destroy = function(){
            var table = $('#kt_datatable').DataTable();
            table.destroy();
        }

        return {
            init: function() {
                init();
            },
            destroy:function(){
                destroy();
            }

        };

        }();

        let marker;
        function initMap() {
                const center = { lat: parseFloat('-5.558543'), lng: parseFloat('120.1909133,17') };
                const bounds = new google.maps.LatLngBounds();
                const map = new google.maps.Map(document.getElementById("mapView"), {
                    zoom: 14,
                    center: center,
                    mapTypeControl: true,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                        // mapTypeId: google.maps.MapTypeId.SATELLITE
                        mapTypeId: 'satellite'
                    },
                });

                const geocoder = new google.maps.Geocoder();
             // build request
                


            marker = new google.maps.Marker({
                position: center,
                map,
            });
            google.maps.event.addListener(map, 'click', function(event) {
                setMarker(this, event.latLng);
                // geocodeLatLng(geocoder, map);

            });

        }

        function setMarker(map, markerPosition) {
            const geocoder = new google.maps.Geocoder();
            const service = new google.maps.DistanceMatrixService();
            console.log(markerPosition)
            if( marker ){
                marker.setPosition(markerPosition);
            } else {
                marker = new google.maps.Marker({
                    position: markerPosition,
                    map: map
                });
            }
            map.setZoom(16);
            map.setCenter(markerPosition);
                // isi nilai koordinat ke form
                // document.getElementById("setLongitude").value = markerPosition.lng();
                // document.getElementById("setLatitude").value = markerPosition.lat();
                document.getElementById('lat_location').value = markerPosition.lat();
                 document.getElementById('long_location').value = markerPosition.lng();
                // Get Lokasi
                // lat_locationlong_location


        }

        
        

        jQuery(document).ready(function() {
            $('#satuan_kerja').select2();
            initMap();
            Panel.init('side_form');
            dataRow.init();
            $('#jadwal_1, #jadwal_2').datepicker({format: 'dd-mm-yyyy'});


            $(document).on('click','.btn-cancel', function(){
                Panel.action('hide');
            });

            $(document).on('submit', '#createForm', function(e){
                e.preventDefault();
                var type = $(this).attr('data-type');
                var _url = '';
                var _id = $("input[name='id']").val();
                if(type == 'submit'){
                    console.log('ini tambah '+type)
                    _url = "{{route('post-lokasi')}}";
                }else{
                    console.log('ini update '+type)
                    _url = "admin/satuan-kerja/lokasi/"+_id;
                }

                $.ajax({
                    url: _url,
                    method:"POST",
                    data: $(this).serialize(),
                    beforeSend: function(){
                        $("input[type='text']").removeClass('is-invalid');
                        $("select").removeClass('is-invalid');
                    },
                    success : function(data) {
                        if(data.fail){
                            console.log(data);
                            swal.fire({
                                text: "Maaf Terjadi Kesalahan",
                                title:"Error",
                                timer: 2000,
                                icon: "danger",
                                showConfirmButton:false,
                            });
                        }else if(data.invalid){
                            $.each(data.invalid, function( key, value ) {
                                console.log(key);
                                $(`.${key}_error`).html(value[0]);
                                // $("input[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                                // $("select[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                            });
                        }else if(data.success){
                            swal.fire({
                                text: "Data anda berhasil disimpan",
                                title:"Sukses",
                                icon: "success",
                                showConfirmButton:true,
                                confirmButtonText: "OK, Siip",
                            }).then(function() {
                                dataRow.destroy();
                                dataRow.init();
                                $("#createForm")[0].reset();
                                Panel.action('hide');
                            });
                        }
                    }
                })
            });

            // edit
            $(document).on('click', '.button-update', function(){
                Panel.action('show','update');
                // $('#title').html('Update Satuan');   
                var key = $(this).data('id');
                $.ajax({
                    url:"admin/satuan-kerja/lokasi/"+key,
                    method:"GET",
                    success: function(data){
                     
                      if(data.success){
                        console.log(data.success);
                        var res = data.success.data;
                        console.log(res);
                        $.each(res, function( key, value ) {
                            if (key == 'id_satuan_kerja') {
                                $('#satuan_kerja').val(value);
                                $("#satuan_kerja").trigger('change');    
                            }else if(key == 'long'){
                                $('#long_location').val(value);
                            }else if(key == 'lat'){
                                $('#lat_location').val(value);
                            }else{
                             $("input[name='"+key+"']").val(value);
                            }
                        });
                      }
                    }
                });
            })

            // delete
            $(document).on('click', '.button-delete', function (e) {
                e.preventDefault();
                var key = $(this).data('id');
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
                    console.log(result);
                    if (result.value) {
                        $.ajax({
                            method: 'delete',
                            url: 'admin/master/lokasi/'+key,
                            data:{
                                "_token": "{{ csrf_token() }}"
                            }
                        })
                        .then(function(response){
                            if(response.success){
                                Swal.fire(
                                    "Deleted!",
                                    "Data terhapus",
                                    "success"
                                );
                                dataRow.destroy();
                                dataRow.init();
                            }
                        });
                    }
                });
            })
        });

    </script>
@endsection