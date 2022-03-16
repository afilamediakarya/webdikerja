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
                            Basic Calendar
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <button class="btn btn-light-primary font-weight-bold" id="kt_quick_user_toggle">
                            <i class="ki ki-plus "></i> Add Event
                        </button>
                    </div>
                </div>
                <div class="card-body">
                <div id="kt_calendar"></div>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
<!--end::Entry-->
@endsection

@section('side-form')
        <div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
			<!--begin::Header-->
			<div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
				<h3 class="font-weight-bold m-0">Tambah Aktivitas<h3>
				<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
					<i class="ki ki-close icon-xs text-muted"></i>
				</a>
			</div>
			<!--end::Header-->
			<!--begin::Content-->
			<div class="offcanvas-content pr-5 mr-n5">
                <form class="form">
                    <div class="row">
                        <div class="col-5">
                            <div class="form-group">
                                <label>Tanggal Kegiatan </label>
                                <div class="input-group date" >
                                    <input type="text" class="form-control" readonly  value="05/20/2017" id="kt_datepicker_3"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>waktu awal</label>
                                <input class="form-control" id="kt_timepicker_1" readonly placeholder="Select time" type="text"/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>waktu akhir </label>
                                <input class="form-control" id="kt_timepicker_2" readonly placeholder="Select time" type="text"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Sasaran Kinerja</label>
                        <select class="form-control" id="exampleSelect1">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nama aktivitas</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputPassword1">Hasil</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <div class="form-group col">
                            <label for="exampleSelect1">Sasaran</label>
                            <select class="form-control" id="exampleSelect1">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-1">
                        <label for="exampleTextarea">Keterangan</label>
                        <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                    </div>
                </form>
                <div class="separator separator-dashed mt-8 mb-5"></div>
                <div class="">
                    <button type="reset" class="btn btn-outline-primary mr-2">Batal</button>
                    <button type="reset" class="btn btn-primary">Simpan</button>
                </div>

				<!--begin::Separator-->
				<!--end::Separator-->
			</div>
			<!--end::Content-->
		</div>
@endsection



@section('script')
    <script src="{{asset('plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
    <!-- <script src="assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script> -->
    <script>

    jQuery(document).ready(function() {
        // KTCalendarBasic.init();
        // $('#kt_calendar').Calendar();
        var todayDate = moment().startOf('day');
            var YM = todayDate.format('YYYY-MM');
            var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
            var TODAY = todayDate.format('YYYY-MM-DD');
            var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

            var calendarEl = document.getElementById('kt_calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                themeSystem: 'bootstrap',

                isRTL: KTUtil.isRTL(),

                header: {
                    right: 'prev,next',
                    center: 'title',
                    left: 'today'
                },

                height: 800,
                contentHeight: 780,
                aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio

                nowIndicator: true,
                now: TODAY + 'T09:25:00', // just for demo

                views: {
                    dayGridMonth: { buttonText: 'month' },
                    timeGridWeek: { buttonText: 'week' },
                    timeGridDay: { buttonText: 'day' }
                },

                defaultView: 'dayGridMonth',
                defaultDate: TODAY,

                editable: true,
                eventLimit: true, // allow "more" link when too many events
                navLinks: true,
                events: [
                    {
                        title: 'Rapat Cantik',
                        start: YM + '-02',
                        description: 'Rapat Cantik Saja.',
                        end: YM + '-03',
                        className: "fc-event-light fc-event-solid-primary"
                    }
                ],

                eventRender: function(info) {
                    var element = $(info.el);

                    if (info.event.extendedProps && info.event.extendedProps.description) {
                        if (element.hasClass('fc-day-grid-event')) {
                            element.data('content', info.event.extendedProps.description);
                            element.data('placement', 'top');
                            KTApp.initPopover(element);
                        } else if (element.hasClass('fc-time-grid-event')) {
                            element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                        } else if (element.find('.fc-list-item-title').lenght !== 0) {
                            element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                        }
                    }
                }
            });

        calendar.render();


        $('#kt_datepicker_3').datepicker({
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,

        });
        $('#kt_timepicker_1, #kt_timepicker_2').timepicker();
    });

    </script>
@endsection