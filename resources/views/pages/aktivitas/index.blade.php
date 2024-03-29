@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection



@section('content')

<!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">
                            Aktivitas
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <button class="btn btn-light-primary font-weight-bold" id="kt_quick_user_toggle">
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
    <script src="{{asset('plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
    <script>

        let dataabsen = {!! json_encode($checkAbsen) !!};
        let minDate = '';

        $(document).on('click','#kt_quick_user_toggle', function () {
            $("#createForm")[0].reset();
            $("#tanggal").prop("disabled", false);
            Panel.action('show','submit');               
        })

        $(document).on('keydown','#tanggal', function(e) {
            if (navigator.userAgent.indexOf('Firefox') !== -1) {
                console.log('Firefox');
                this.blur(); 
            }else{
                e.preventDefault();
                 e.stopPropagation();
            } 
        });
        
        function maxdate() {
            const inputElement = document.getElementById("tanggal");
            const fiveDaysAgo = new Date();
            fiveDaysAgo.setDate(fiveDaysAgo.getDate() - 5);
            minDate = fiveDaysAgo.toISOString().split("T")[0]
            inputElement.setAttribute("min", fiveDaysAgo.toISOString().split("T")[0]);
        }
        
        jQuery(document).ready(function() {
            Panel.init('side_form');

            $('.select2').select2({
                placeholder: "Pilih"
            });

            maxdate();

            $(document).on('click','.btn-cancel', function(){
                Panel.action('hide');
            });

            $('#nama-aktivitas').on('change', function () {
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
            // checkAbsen(dataabsen);


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
                 selectable: true,
                selectHelper: true,
                events: "{{route('get-aktivitas')}}",
                selectAllow: function(event)
                {
                    return moment(event.start).utcOffset(false).isSame(moment(event.end).subtract(1, 'second').utcOffset(false), 'day');
                }, 

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
                $.ajax({
                    url : '/aktivitas/detail/'+id,
                    method:"GET",
                    success: function(res){
                        let data = JSON.parse(res);
                        console.log(data);
                        if (data.status == true) {
                            data = data.data;
         
                                Panel.action('show','update');
                                $.each(data, function( key, value ) {
                                    if (key == 'tanggal') {
                                        if (value < minDate) {
                                            $("#tanggal").prop("disabled", true);
                                        }else{
                                            $("input[name='"+key+"']").val(value);
                                        }
                                        
                                    }
                                    $("input[name='"+key+"']").val(value);
                                    $("select[name='"+key+"']").val(value);
                                    $("textarea[name='"+key+"']").val(value);
                                });
                                $('.select2').trigger('change');
                        }
                    }
                });
                // $('#kt_quick_user').modal('show');
            });

            converValueDate = (params) =>{
                if (params.toString().length < 2) {
                    params = '0'+params;
                }
                return params;
            }

            downDate = (day,year,month,type) => {
                let array_pre = [];
                let array_ot = [];
                let result = [];
                let num = 0;
                console.log(day);
                if (type == 'previousDate') {
                    num = day + 5;
                }
                
                // if (type == 'previousDate' && type == 'nextDate') {
                //     for (let index = day; index <= num; index++) {
                //         array_.push(year+'-'+converValueDate(month)+'-'+converValueDate(index));
                //     }
                // }else{
                //     // alert(day);
                    
                // }

                 for (let index = day; index < num; index++) {
                     array_pre.push(year+'-'+converValueDate(month)+'-'+converValueDate(index));
                    result['previous'] = array_pre;   
                }

                for (let i = 1; i < day; i++) {
                      array_ot.push(year+'-'+converValueDate(month)+'-'+converValueDate(i));
                      result['other'] = array_ot;   
                }
                
                return result;
            }
        
            kalender.on('dayRender',function (event) {
                var today = new Date();
                var thismonth = today.getMonth() + 1;
                var thisday = today.getDate();
                var thisyear = today.getFullYear();
                let daydown = today.getDate() - 4;
                let previousDate = [];
                let afterDate = [];
                let nextDate = [];
                let data_date = $(event.el).attr('data-date');

                previousDate = downDate(daydown,thisyear,thismonth,'previousDate');
                $.each(previousDate.previous, function (x,y) {
                    if (y == $(event.el).attr('data-date')) {
                        console.log(data_date);
                        $.ajax({
                            url : '/admin/absen/checkAbsenbyDate?tanggal='+data_date,
                            method : 'GET',
                            success : function (res) {
                                res = JSON.parse(res);
                                if (res.status == true) {
                                    $(event.el).css("background-color", "#7bd188");
                                }else{
                                    $(event.el).css("background-color", "#ebebe4");
                                }
                            }
                        })
                        
                    }
                })

                $.each(previousDate.other, function (x,y) {
                if (y == $(event.el).attr('data-date')) {
                    console.log(data_date);
                    $.ajax({
                        url : '/admin/absen/checkAbsenbyDate?tanggal='+data_date,
                        method : 'GET',
                        success : function (res) {
                            res = JSON.parse(res);
                            if (res.status == true) {
                                $(event.el).css("background-color", "#74c1e8");
                            }else{
                                  $(event.el).css("background-color", "#ebebe4");
                            }
                        }
                    })
                      
                }
            })
                 
                
            })

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
                                console.log(key);
                                if (key == 'error') {
                                          console.log(value.text + '|' +value.title);
                                        swal.fire({
                                            text: value.text,
                                            title: value.title,
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
                                text: text,
                                title:"Sukses",
                                icon: "success",
                                showConfirmButton:true,
                                confirmButtonText: "OK, Siip",
                            }).then(function() {
                                $("#createForm")[0].reset();
                                Panel.action('hide');
                                // $('.select2').select2('val', '');
                                $('.select2').val(null).trigger('change');
                                // calendar.addEventSource( response );
                                kalender.refetchEvents();

                                // .fullCalendar( ‘refresh’ )
                            });
                        }
                    }   
                });
            });
        });
            
    </script>
@endsection