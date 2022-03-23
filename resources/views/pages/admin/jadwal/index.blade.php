@extends('layout.app')

@section('style')
    <link href="{{asset('plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('button')
    <a href="javascrip:;" class="btn btn-primary font-weight-bolder" id="kt_quick_user_toggle">
        <span class="svg-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
            </g>
        </svg><!--end::Svg Icon--></span>
        Tambah Pegawai
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
                                <th>No.</th>
                                <th>Nama Kegiatan</th>
                                <th>Jadwal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i=1; $i<=15; $i++)
                            <tr>
                                <td>1</td>
                                <td>Jadwal Penginputan SKP</td>
                                <td>21-10-2011</td>
                                <td nowrap="nowrap">
                                    <a href="" type="button" class="btn btn-secondary">ubah</a>
                                    <a href="" type="button" class="btn btn-danger">Hapus</a>
                                </td>
                            </tr>
                            @endfor
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
        <div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
			<!--begin::Header-->
			<div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
				<h3 class="font-weight-bold m-0">Tambah Informasi<h3>
				<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
					<i class="ki ki-close icon-xs text-muted"></i>
				</a>
			</div>
			<!--end::Header-->
			<!--begin::Content-->
			<div class="offcanvas-content pr-5 mr-n5">
                <form class="form">
                    <div class="form-group">
                        <label>Tahap kegiatan</label>
                        <select class="form-control form-control-solid">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sub-Tahapan kegiatan</label>
                        <select class="form-control form-control-solid">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jadwal Pelaksanaan</label>
                        <div class="row">
                            <div class="input-group input-group-solid col">
                                <input type="text" class="form-control" readonly  value="05/20/2017" id="jadwal_1" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar icon-lg"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-1 d-flex flex-center">
                                <label class="mb-0">s/d</label>
                            </div>
                            <div class="input-group input-group-solid col">
                                <input type="text" class="form-control" readonly  value="05/20/2017" id="jadwal_2" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar icon-lg"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
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
    <script src="{{asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script>
        "use strict";
        
        jQuery(document).ready(function() {
            $('#jadwal_1, #jadwal_2').datepicker();

            $('#kt_datatable').DataTable({
                responsive: true,
                pageLength: 15,
                order: [[1, 'asc']],
            });
        });

    </script>
@endsection