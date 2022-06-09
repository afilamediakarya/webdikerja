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
            <div class="card card-custom gutter-b example example-compact d-none">
                <div class="card-header">
                    <h3 class="card-title">Atasan</h3>
                    <!-- <button type="button" id="update_atasan" class="btn btn-sm btn-primary align-self-center"><i class="flaticon2-pen"></i>update Atasan</button> -->
                </div>
                <div class="card-body">
                    <!--begin::Form-->
                    <form class="form">
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Atasan</label>
                                <select class="form-control form-control-solid" name="atasan">
                                    <option value="">Pilih Atasan</option>
                                    @foreach($atasan as $item)
                                    <option value="{{$item['id']}}" {{ (Session::has('atasan') ? (Session::get('atasan.id') == $item['id'] ? "selected" : "") : "") }}>{{$item['value']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                    </form>
                    <!--end::Form-->
                </div>
            </div>


            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Profil Pegawai</h3>
                    <!-- <a href="{{route('edit-profil')}}" type="reset" class="btn btn-sm btn-primary align-self-center"><i class="flaticon2-pen"></i> Edit Profil</a> -->
                </div>
                <div class="card-body">
                    <!--begin::Form-->
                    <form class="form" id="createForm">
                
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Nama</label>
                                    <input type="text" class="form-control form-control-solid" value="{{$data_['nama']}}" name="nama">
                                    <span class="invalid-feedback"></span>
                                </div>

                                <input type="hidden" name="id" value="{{$data_['id']}}">

    
                                <div class="form-group col-6">
                                    <label>NIP</label>
                                    <input type="text" class="form-control form-control-solid" value="{{ $data_['nip'] }}" name="nip">
                                    <span class="invalid-feedback"></span>
                                </div>
    
                                <div class="form-group col-6">
                                    <label>Tempat Lahir</label>
                                    <input type="text" class="form-control form-control-solid" value="{{ $data_['tempat_lahir'] }}" name="tempat_lahir">
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="form-group col-6">
                                    <label>Tanggal Lahir</label>
                                    <div class="input-group date" >
                                        <input type="text" class="form-control form-control-solid" readonly name="tanggal_lahir" value="{{ $data_['tanggal_lahir'] }}" id="tgl_lahir"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="form-group col-6">
                                    <label>Satuan Kerja</label>
                                    <select name="id_satuan_kerja" class="form-control form-control-solid">
                                        <option value="">Pilih Satuan Kerja</option>
                                        @foreach ($dinas as $item)
                                            <option value="{{$item['id']}}" {{ ($data_['id_satuan_kerja'] == $item['id'] ? "selected" : "") }}>{{$item['nama_satuan_kerja']}}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
    
                                <div class="form-group col-6">
                                    <label>Golongan Pangkat</label>
                                    <select name="golongan" class="form-control form-control-solid">
                                        <option selected disabled>Pilih Golongan Pangkat</option>
                                        @foreach ($pangkat as $item)
                                            <option value="{{$item['value']}}" {{ ($data_['golongan'] ? ($data_['golongan'] == $item['value'] ? "selected" : "") : "") }} >{{$item['value']}}</option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                                <div class="form-group col-6">
                                    <label>TMT Golongan</label>
                                    <div class="input-group date" >
                                        <input type="text" class="form-control form-control-solid" readonly  value="{{$data_['tmt_golongan']}}" id="tmt_gol" name="tmt_golongan"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <span class="invalid-feedback"></span>
                                </div>

                                <input type="hidden" name="eselon" value="{{ $data_['eselon'] }}">
                                <input type="hidden" name="tmt_pegawai" value="{{ $data_['tmt_pegawai'] }}">

                                <div class="form-group col-6">
                                <label>TMT Pegawai</label>
                                <div class="input-group date" >
                                    <input type="text" class="form-control form-control-solid" readonly  value="{{ $data_['tmt_pegawai'] }}" name="tmt_pegawai" id="tmt_peg"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                                <div class="form-group col-6">
                                    <label>Jenis Kelamin</label>
                                    <select class="form-control form-control-solid" name="jenis_kelamin">
                                        <option value="Laki-Laki" {{ ($data_['jenis_kelamin'] ? ($data_['jenis_kelamin'] == "Laki-Laki" ? "selected" : "") : "") }} >Laki-Laki</option>
                                        <option value="Perempuan" {{ ($data_['jenis_kelamin'] ? ($data_['jenis_kelamin'] == "Perempuan" ? "selected" : "") : "") }}>Perempuan</option>
                                    </select>
                                </div>
    
                                <div class="form-group col-6">
                                    <label>Agama</label>
                                    <select name="agama" class="form-control form-control-solid">
                                        @foreach($agama as $item)
                                            <option value="{{$item['value']}}" {{ ($data_['agama'] ? ($data_['agama'] == $item['value'] ? "selected" : "") : "") }}>{{$item['value']}}</option>
                                        @endforeach
                                    </select>
                                </div>
    
                                <div class="form-group col-6">
                                    <label>Status Perkawinan</label>
                                    <select name="status_perkawinan" class="form-control form-control-solid">
                                        @foreach($status_kawin as $item)
                                            <option value="{{$item['value']}} {{ ($data_['status_perkawinan'] ? ($data_['status_perkawinan'] == $item['value'] ? "selected" : "") : "") }}">{{$item['value']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label>Pendidikan Terakhir</label>
                                    <select name="pendidikan" class="form-control form-control-solid">
                                        @foreach($pendidikan as $item)
                                            <option value="{{$item['value']}}" {{ ($data_['pendidikan'] ? ($data_['pendidikan'] == $item['value'] ? "selected" : "") : "") }}>{{$item['value']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label>Tahun Lulus</label>
                                    <input type="text" class="form-control form-control-solid" value="{{ $data_['lulus_pendidikan'] }}" name="lulus_pendidikan">
                                </div>
    
    
                                <div class="form-group col-6">
                                    <label>Pendidikan Struktural</label>
                                    <input type="text" class="form-control form-control-solid" value="{{ $data_['pendidikan_struktural'] }}" name="pendidikan_struktural">
                                </div>
                                <div class="form-group col-6">
                                    <label>Tahun Lulus Pendidikan Struktural</label>
                                    <input type="text" class="form-control form-control-solid" value="{{ $data_['lulus_pendidikan_struktural'] }}" name="lulus_pendidikan_struktural">
                                </div>

                                <input type="hidden" value="profil" name="type">
    
                                <div class="form-group col-6">
                                    <label>Jurusan</label>
                                    <input type="text" class="form-control form-control-solid" value="{{ $data_['jurusan'] }}" name="jurusan">
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-footer border-0">
                            <!-- <button type="reset" class="btn btn-outline-primary mr-2 btn-cancel">Batal</button> -->
                            <button type="button" id="update_profile" class="btn btn-primary">Update Data</button>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
            </div>

            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Password</h3>
                    <button type="reset" class="btn btn-sm btn-primary align-self-center"><i class="flaticon2-pen"></i>Ganti Password</button>
                </div>
                <div class="card-body">
                    <div class="form-group col-6">
                        <label>Password Baru</label>
                        <input type="text" class="form-control form-control-solid" name="old_password">
                    </div>

                    <div class="form-group col-6">
                        <label>Kenformasi Password</label>
                        <input type="text" class="form-control form-control-solid" name="old_password">
                    </div>
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

        $(document).on('click', '#update_atasan', function(e){
            e.preventDefault();
            let base_url = "{{env('API_URL')}}";
            let id_penilai = $("[name='atasan']").val();
            if (id_penilai == "") {
                swal.fire({
                    text: "Pilih Atasan Terlebih Dahulu",
                    title:"Perhatian",
                    timer: 1000,
                    icon: "warning",
                    showConfirmButton:false,
                });
            }else{
                axios.get(`atasan/update/${id_penilai}`)
                .then(function(res){
                    if(res.data.success){
                        swal.fire({
                            text: "Berhasil Mengubah Atasan",
                            title:"Sukses",
                            timer: 2000,
                            icon: "success",
                            showConfirmButton:true,
                            confirmButtonText: "OK, Siip",
                        });
                    }else{
                        swal.fire({
                            text: "Terjadi Kesalahan",
                            title:"Perhatian",
                            timer: 1000,
                            icon: "warning",
                            showConfirmButton:false,
                        });
                    }
                }).catch(function(err) {
                        swal.fire({
                            text: "Terjadi Kesalahan Server, Silahkan Screenshoot dan laporkan",
                            title:"Error",
                            icon: "error",
                            showConfirmButton:true,
                        });
                })
            }
        });

        $(document).on('click','#update_profile', function () {
 
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            let _id = $("input[name='id']").val();
            // alert(`/admin/pegawai/${_id}    `)
            // $.ajax({
            //     url:`/admin/pegawai/update/${_id}`,
            //     method:"POST",
            //     data : $('#createForm').serialize(),
            //     success: function(data){
            //         swal.fire({
            //             text: "Profil berhasil di update.",
            //             icon: "success",
            //             buttonsStyling: false,
            //             confirmButtonText: "Ok, got it!",
            //             customClass: {
            //                 confirmButton: "btn font-weight-bold btn-light-primary"
            //             }
            //         }).then(function() {
            //             // window.location.href = '/akun';
            //         });   
            //     }
            // });
            
            axios.post( `/admin/pegawai/update/${_id}`,  $('#createForm').serialize())
            .then(function(res){
                var data = res.data;
                if(data.fail){
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
                        $("input[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                        $("textarea[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                        $("select[name='"+key+"']").addClass('is-invalid').siblings('.invalid-feedback').html(value[0]);
                    });
                }else if(data.success){
                    swal.fire({
                        text: "Data anda berhasil disimpan",
                        title:"Sukses",
                        icon: "success",
                        showConfirmButton:true,
                        confirmButtonText: "OK, Siip",
                    }).then(function() {
                        window.location.href = '/akun';    
                    });
                }
            }).catch(function(){
                swal.fire({
                    text: "Terjadi Kesalahan Sistem",
                    title:"Error",
                    icon: "error",
                    showConfirmButton:true,
                    confirmButtonText: "OK",
                })
            });
        })

        jQuery(document).ready(function() {
            $('#tmt_peg, #tmt_jab, #tmt_gol, #tgl_lahir').datepicker({format: 'yyyy-mm-dd'});
        });
    </script>
@endsection