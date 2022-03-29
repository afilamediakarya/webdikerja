@extends('layout.auth')

@section('style')
    <link href="{{asset('css/pages/login/login-2.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('content')

<div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
	
    <div class="content order-1 d-flex flex-column w-100 pb-0" style="background-color: #0093DD;">
        <!--begin::Title-->
        <div class="d-flex flex-column justify-content-center text-center pt-lg-40 pt-md-5 pt-sm-5 px-lg-0 pt-5 px-7">
            <a href="{{'/'}}" class="display4 font-weight-bolder my-7 text-white" style="color: #fff;">LOGO</a>
            <h3 class="display4 font-weight-bolder my-7 text-white" style="color: #fff;">BKPSDM</h3>
            <p class="font-weight-light font-size-h2-md font-size-lg text-white opacity-70">Kabupaten Bulukumba</p>
        </div>
        <!--end::Title-->
        <!--begin::Image-->
        <div class="content-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-center bgi-position-x-center" style="background-image: url(media/svg/bkpsdm/login-icon.svg);"></div>
        <!--end::Image-->
    </div>
    <!--begin::Aside-->
    <div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden">
        <!--begin: Aside Container-->
        <div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 ">
            <!--begin::Logo-->
            <a href="#" class="text-center pt-2">
                <!-- <img src="assets/media/logos/logo.png" class="max-h-75px" alt="" /> -->
            </a>
            <!--end::Logo-->
            <!--begin::Aside body-->
            <div class="d-flex flex-column-fluid flex-column flex-center">
                <!--begin::Signin-->
                <div class="login-form login-signin py-11">
                    <!--begin::Form-->
                    <form method="POST" action="{{route('do-Login')}}" class="form" novalidate="novalidate" >
                        @csrf
                        <!--begin::Title-->
                        <div class="text-center pb-8">
                            <h2 class="font-weight-bolder text-dark font-size-h1">Selamat Datang</h2>
                            <h2 class="font-weight-normal text-dark font-size-h6">Silahkan masukkan NIP dan Password anda</h2>
                        </div>
                        <!--end::Title-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-normal text-dark">NIP</label>
                            <input class="form-control form-control-solid h-auto py-5 px-4 rounded-sm" type="text" name="username" autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <div class="d-flex justify-content-between mt-n5">
                                <label class="font-size-h6 font-weight-normal text-dark pt-5">Password</label>
                                <a href="javascript:;" class="text-primary font-size-h6 font-weight-light text-hover-primary pt-5" id="kt_login_forgot">Lupa Password ?</a>
                            </div>
                            <input class="form-control form-control-solid h-auto py-5 px-4 rounded-sm" type="password" name="password" autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Action-->
                        <div class="text-center pt-2">
                            <button type="submit" class="btn btn-dark btn-block font-weight-bolder text-white font-size-h6 px-8 py-4 my-3" style="background: #0093DD;">Masuk</button>
                        </div>
                        <!--end::Action-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->
                <!--begin::Forgot-->
                <div class="login-form login-forgot pt-11">
                    <!--begin::Form-->
                    <form class="form" novalidate="novalidate" id="kt_login_forgot_form">
                        <!--begin::Title-->
                        <div class="text-center pb-8">
                            <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Forgotten Password ?</h2>
                            <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your password</p>
                        </div>
                        <!--end::Title-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="email" placeholder="Email" name="email" autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">
                            <button type="button" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">Submit</button>
                            <button type="button" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">Cancel</button>
                        </div>
                        <!--end::Form group-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Forgot-->
            </div>
            <!--end::Aside body-->
        </div>
        <!--end: Aside Container-->
    </div>
				<!--begin::Aside-->
				<!--begin::Content-->
    
    <!--end::Content-->
</div>
@endsection

@section('script')
    <script>
        "use strict";

// Class Definition
    var KTLogin = function() {
        var _login;

        var _showForm = function(form) {
            var cls = 'login-' + form + '-on';
            var form = 'kt_login_' + form + '_form';

            _login.removeClass('login-forgot-on');
            _login.removeClass('login-signin-on');

            _login.addClass(cls);

            KTUtil.animateClass(KTUtil.getById(form), 'animate__animated animate__backInUp');
        }

        var _handleSignInForm = function() {
            var validation;

            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            validation = FormValidation.formValidation(
                KTUtil.getById('kt_login_signin_form'),
                {
                    fields: {
                        username: {
                            validators: {
                                notEmpty: {
                                    message: 'Username is required'
                                }
                            }
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: 'Password is required'
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        submitButton: new FormValidation.plugins.SubmitButton(),
                        //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
                        bootstrap: new FormValidation.plugins.Bootstrap()
                    }
                }
            );

            // $('#kt_login_signin_submit').on('click', function (e) {
            //     // e.preventDefault();

            //     // validation.validate().then(function(status) {
            //     //     if (status == 'Valid') {
            //     //         swal.fire({
            //     //             text: "All is cool! Now you submit this form",
            //     //             icon: "success",
            //     //             buttonsStyling: false,
            //     //             confirmButtonText: "Ok, got it!",
            //     //             customClass: {
            //     //                 confirmButton: "btn font-weight-bold btn-light-primary"
            //     //             }
            //     //         }).then(function() {
            //     //             KTUtil.scrollTop();
            //     //         });
            //     //     } else {
            //     //         swal.fire({
            //     //             text: "Sorry, looks like there are some errors detected, please try again.",
            //     //             icon: "error",
            //     //             buttonsStyling: false,
            //     //             confirmButtonText: "Ok, got it!",
            //     //             customClass: {
            //     //                 confirmButton: "btn font-weight-bold btn-light-primary"
            //     //             }
            //     //         }).then(function() {
            //     //             KTUtil.scrollTop();
            //     //         });
            //     //     }
            //     // });
            // });

            // Handle forgot button
            $('#kt_login_forgot').on('click', function (e) {
                e.preventDefault();
                _showForm('forgot');
            });

            
        }


        var _handleForgotForm = function(e) {
            var validation;

            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            validation = FormValidation.formValidation(
                KTUtil.getById('kt_login_forgot_form'),
                {
                    fields: {
                        email: {
                            validators: {
                                notEmpty: {
                                    message: 'Email address is required'
                                },
                                emailAddress: {
                                    message: 'The value is not a valid email address'
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap()
                    }
                }
            );

            // Handle submit button
            $('#kt_login_forgot_submit').on('click', function (e) {
                e.preventDefault();

                    swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    }).then(function() {
                        KTUtil.scrollTop();
                    });

                // validation.validate().then(function(status) {
                //     if (status == 'Valid') {
                //         // Submit form
                        
                //         KTUtil.scrollTop();
                //     } else {
                //         swal.fire({
                //             text: "Sorry, looks like there are some errors detected, please try again.",
                //             icon: "error",
                //             buttonsStyling: false,
                //             confirmButtonText: "Ok, got it!",
                //             customClass: {
                //                 confirmButton: "btn font-weight-bold btn-light-primary"
                //             }
                //         }).then(function() {
                //             KTUtil.scrollTop();
                //         });
                //     }
                // });
            });

            // Handle cancel button
            $('#kt_login_forgot_cancel').on('click', function (e) {
                e.preventDefault();

                _showForm('signin');
            });
        }

        // Public Functions
        return {
            // public functions
            init: function() {
                _login = $('#kt_login');

                _handleSignInForm();
                _handleForgotForm();
            }
        };
    }();

    // Class Initialization
    jQuery(document).ready(function() {
        KTLogin.init();
    });

    </script>
@endsection