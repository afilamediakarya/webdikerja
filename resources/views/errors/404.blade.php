
<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
        <base href="../../../">
		<meta charset="utf-8" />
		{{-- Title Section --}}
        <title>{{ config('app.name') }} | Error Page</title>

        {{-- Meta Data --}}
        <meta name="description" content="@yield('page_description', $page_description ?? '')"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<link href="{{asset('css/pages/error/error-6.css')}}" rel="stylesheet" type="text/css" />

		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="{{asset('plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="{{asset('css/themes/layout/header/base/light.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('css/themes/layout/header/menu/light.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('css/themes/layout/brand/dark.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('css/themes/layout/aside/dark.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="{{asset('media/logos/favicon.ico')}}" />
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Error-->
			<div class="error error-6 d-flex flex-row-fluid bgi-size-cover bgi-position-center" style="background-image: url({{asset('image/bg6.jpeg')}});">
				<!--begin::Content-->
				<div class="d-flex flex-column flex-row-fluid text-center">
					<h1 class="error-title font-weight-boldest text-white mb-12" style="margin-top: 12rem;">Oops...</h1>
					<p class="display-4 font-weight-bold text-white">Sepertinya Anda Berlayar Kearah yang Salah.</p>
					
					<a href="{{route('indexes')}}" class="btn btn-secondary" style="width: 12%;position: absolute;top: 18%;left: 44%;">Dashboard</a>

				</div>
						
				<!--end::Content-->
			</div>
			<!--end::Error-->
		</div>
		
		<!--end::Main-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="{{asset('plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{asset('plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
		<script src="{{asset('js/scripts.bundle.js')}}"></script>
		<!--end::Global Theme Bundle-->
        @yield('script')
	</body>
	<!--end::Body-->
</html>