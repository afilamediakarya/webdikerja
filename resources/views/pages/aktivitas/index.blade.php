@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection



@section('content')

<!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            
            <!--begin::Card-->
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">
                            Aktivitas
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <button onclick="Panel.action('show','submit')" class="btn btn-light-primary font-weight-bold" id="kt_quick_user_toggle">
                            <i class="ki ki-plus "></i> Tambah Aktivitas
                        </button>
                    </div>
                </div>
                <div class="card-body">
                
                    <div id="kalender"></div>

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
                    <div class="row">
                        <div class="col-5">
                            <div class="form-group">
                                <label>Tanggal Kegiatan </label>
                                <input type="date" class="form-control" name="tanggal"/>
                            </div>
                        </div>
                        <input type="text" style="display:none" name="id">
                        <div class="col">
                            <div class="form-group">
                                <label>waktu awal</label>
                                <input type="time" class="form-control" name="waktu_awal" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>waktu akhir </label>
                                <input  type="time" class="form-control" name="waktu_akhir" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Sasaran Kinerja</label>
                        <select class="form-control" name="id_skp" id="exampleSelect1">
                            <option disabled selected>Pilih Sasaran Kinerja</option>
                           @foreach($sasaran_kinerja as $key => $va)
                                <option value="{{$va['id']}}">{{$va['value']}}</option>
                           @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nama aktivitas</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" name="nama_aktivitas" placeholder="Nama Aktivitas">
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputPassword1">Hasil</label>
                            <input type="number" value="0" min="0" name="hasil" class="form-control" id="exampleInputPassword1" placeholder="Hasil">
                        </div>
                        <div class="form-group col">
                            <label for="exampleSelect1">Satuan</label>
                            <select class="form-control" name="satuan" id="exampleSelect1">
                                <option disabled selected>Pilih Satuan</option>
                                @foreach($satuan as $x => $y)
                                    <option value="{{$y['value']}}">{{$y['value']}}</option>
                                @endforeach
                            </select>
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
    <script src="{{asset('plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
    <script>
        
        jQuery(document).ready(function() {
            Panel.init('side_form');

            $(document).on('click','.btn-cancel', function(){
                Panel.action('hide');
            });

            var dataActivity = [];
            var todayDate = moment().startOf('day');
            var YM = todayDate.format('YYYY-MM');
            var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
            var TODAY = todayDate.format('YYYY-MM-DD');
            var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');
    
            // var calendarEl = document.getElementById('kt_calendar');
            var calendarEl = document.getElementById('kalender');

            var kalender = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                themeSystem: 'bootstrap',
                initialView: 'dayGridMonth',
                defaultDate: TODAY,
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: "{{route('get-aktivitas')}}"
                });
            // kalender.on('dateClick', function(info) {
            //     console.log(info);
            //     kalender.addEvent({ 
            //         title : "Event Baru", 
            //         start : info.dateStr, 
            //         description : 'desc', 
            //         end : info.dateStr, 
            //         className : 'fc-event-light fc-event-solid-primary'
            //     });
            // });

            kalender.on('eventClick', function(data) {
                let id = data.event['_def']['publicId'];
                // alert(id);
                Panel.action('show','update');
                $.ajax({
                    url : '/aktivitas/detail/'+id,
                    method:"GET",
                    success: function(res){
                        let data = JSON.parse(res);
                        console.log(data);
                        if (data.status == true) {
                            data = data.data;
                            $.each(data, function( key, value ) {
                                $("input[name='"+key+"']").val(value);
                                $("select[name='"+key+"']").val(value);
                                $("textarea[name='"+key+"']").val(value);
                            });
                        }
                    //   if(data.success){
                    //     console.log(data.success);
                    //     var res = data.success.data;
                    //     $.each(res, function( key, value ) {
                    //         $("input[name='"+key+"']").val(value);
                    //         $("select[name='"+key+"']").val(value);
                    //     });
                    //   }
                    }
                });
                // $('#kt_quick_user').modal('show');
            });
            kalender.render();

            // let calender =  $('kalender').FullCalendar({
            //     editable:true,
            //     plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list' ],
            // })

            $('#kt_datepicker_3').datepicker({
                todayBtn: "linked",
                clearBtn: true,
                todayHighlight: true,
    
            });
            $('#kt_timepicker_1, #kt_timepicker_2').timepicker();

            $('#aktivitas_save').on('click', function(){

                let id_ = $("input[name=id]").val();
                let url ='';
                let text = '';

                if (id_ == '') {
                    url = '/aktivitas/store';
                    text = 'Data anda berhasil di simpan';
                } else {
                    url = '/aktivitas/update/'+id_;
                    text = 'Data anda berhasil di update';
                }
                
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });

                $.ajax({
                    url : url,
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
                         
                                $("input[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                                $("select[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                                $("textarea[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                            });
                        }else if(res.success){
                            swal.fire({
                                text: text,
                                title:"Sukses",
                                icon: "success",
                                showConfirmButton:true,
                                confirmButtonText: "OK, Siip",
                            }).then(function() {
                                $("#createForm")[0].reset();
                                Panel.action('hide');
                            });
                        }
                    }   
                });
            });
        });
            
    </script>
@endsection