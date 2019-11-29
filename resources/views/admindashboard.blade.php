<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Admin Dashboard</title>

        <meta name="description" content="Case Study for Frankie Financial">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--begin::Fonts -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
				google: {
					"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
				},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
		</script>
        <!--end::Fonts -->

        <!--begin::Page Vendors Styles(used by this page) -->
		@yield('css')
		<!--end::Page Vendors Styles -->

		<!--begin::Global Theme Styles(used by all pages) -->
		<link href="{{ asset('css/theme.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles -->
		<link rel="shortcut icon" href="/assets/media/logos/favicon.ico" />
        <!--begin::Page Vendors Styles(used by this page) -->
        <link href="//www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css" />
        <!--end::Page Vendors Styles -->
        <link href="{{ asset('css/dashboard/custom.css') }}" rel="stylesheet" type="text/css" />
    </head>

    <body class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading" >
	 {{-- @include('layouts.partials._layout-page-loader') --}} 
    <!-- begin:: Page -->
    @include('layouts.partials._header-base-mobile')
    
    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
            <button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
            <div class="kt-aside kt-aside--fixed kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">
                @include('layouts.partials._aside-brand')
                <!-- begin:: Aside Menu --> 
                <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
                    <div id="kt_aside_menu"class="kt-aside-menu "data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500" >
                        <ul class="kt-menu__nav ">
                            
                            <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--open" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                                    <span class="kt-menu__link-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" id="Combined-Shape" fill="#000000" opacity="0.3"/>
                                                <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" id="Rectangle-102-Copy" fill="#000000"/>
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="kt-menu__link-text">User</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
                                </a>
                                <div class="kt-menu__submenu ">
                                    <span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">
                                        <li class="kt-menu__item kt-menu__item--parent" aria-haspopup="true" >
                                            <span class="kt-menu__link"><span class="kt-menu__link-text">Forms</span></span>
                                        </li>
                                        </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                <div id="kt_header" class="kt-header kt-grid__item kt-header--fixed " >
                    <div class="text-center m-auto">
                        <h2>Welcome to your Admin dashboard</h2>
                    </div>
                    @include('layouts.partials._topbar-base')
                </div>
                <div class="kt-content kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                <div class='row'>
                    <div class='col'>
                        <div class="kt-portlet kt-portlet--fit kt-portlet--head-lg kt-portlet--head-overlay kt-portlet--skin-solid kt-portlet--height-fluid">
                            <div class="kt-portlet__head kt-portlet__head--noborder kt-portlet__space-x">
                            </div>
                            <div class="kt-portlet__body kt-portlet__body--fit">
                                <div class="kt-widget17">
                                    <div class="kt-widget17__stats">
                                        <div class="kt-widget17__items">
                                            <div class="kt-widget17__item">
                                                <div class="kt-demo-icon">
                                                    <div class="kt-demo-icon__preview">
                                                        <i class="fas fa-globe-europe kt-shape-font-color-4  kt-shape-bg-color-4"></i>
                                                    </div>
                                                    <!-- <div class="kt-demo-icon__class">
                                                        Total
                                                    </div> -->
                                                </div>
                                                <span class="kt-widget17__subtitle">
                                                    Total
                                                </span>
                                                <span class="kt-widget17__desc">
                                                    70 New Comments
                                                </span>
                                            </div>
                                            <div class="kt-widget17__item">
                                            <a href="">
                                                <div class="kt-demo-icon">
                                                    <div class="kt-demo-icon__preview">
                                                        <i class="fab fa-facebook kt-font-primary"></i>
                                                    </div>
                                                    <!-- <div class="kt-demo-icon__class">
                                                        Facebook
                                                    </div> -->
                                                </div>
                                            </a>
                                                    <span class="kt-widget17__subtitle" >
                                                        Facebook
                                                    </span>
                                                
                                                <span class="kt-widget17__desc">
                                                    10 New Comments
                                                </span>
                                            </div>
                                            <div class="kt-widget17__item">
                                            <a href="">
                                                <div class="kt-demo-icon">
                                                    <div class="kt-demo-icon__preview">
                                                        <i class="fab fa-twitter kt-font-info"></i>
                                                    </div>
                                                    <!-- <div class="kt-demo-icon__class">
                                                        Twitter
                                                    </div> -->
                                                </div>
                                            </a>
                                                <span class="kt-widget17__subtitle">
                                                    Twitter
                                                </span>
                                                <span class="kt-widget17__desc">
                                                    10 New Comments
                                                </span>
                                            </div>
                                            <div class="kt-widget17__item">
                                            <a href="">
                                                <div class="kt-demo-icon">
                                                    <div class="kt-demo-icon__preview">
                                                        <i class="fab fa-instagram kt-font-warning"></i>
                                                    </div>
                                                    <!-- <div class="kt-demo-icon__class">
                                                        Reddit
                                                    </div> -->
                                                </div>
                                            </a>
                                                <span class="kt-widget17__subtitle">
                                                    Instagram
                                                </span>
                                                <span class="kt-widget17__desc">
                                                    10 New Comments
                                                </span>
                                            </div>
                                            <div class="kt-widget17__item">
                                            <a href="">
                                                <div class="kt-demo-icon">
                                                    <div class="kt-demo-icon__preview">
                                                        <i class="fab fa-youtube kt-font-danger"></i>
                                                    </div>
                                                    <!-- <div class="kt-demo-icon__class">
                                                        YouTube
                                                    </div> -->
                                                </div>
                                            </a>
                                                <span class="kt-widget17__subtitle">
                                                    YouTube
                                                </span>
                                                <span class="kt-widget17__desc">
                                                    10 New Comments
                                                </span>
                                            </div>
                                            <div class="kt-widget17__item">
                                            <a href="">
                                                <div class="kt-demo-icon">
                                                    <div class="kt-demo-icon__preview">
                                                        <i class="fab fa-chrome kt-font-success"></i>
                                                    </div>
                                                    <!-- <div class="kt-demo-icon__class">
                                                        Web
                                                    </div> -->
                                                </div>
                                            </a>
                                                <span class="kt-widget17__subtitle">
                                                    Web
                                                </span>
                                                <span class="kt-widget17__desc">
                                                    10 New Comments
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col'>
                    <!-- begin:: Content -->
                    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                        <div class="kt-portlet kt-portlet--mobile">
                            <div class="kt-portlet__head kt-portlet__head--lg">
                                <div class="kt-portlet__head-label">
                                    <span class="kt-portlet__head-icon">
                                        <i class="kt-font-brand flaticon2-line-chart"></i>
                                    </span>
                                    <h3 class="kt-portlet__head-title">User Datatable
                                    <!-- <small>initialized from remote json file</small> -->
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <!--begin: Search Form -->
                                <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
                                    <div class="row align-items-center">
                                        <div class="col-xl-8 order-2 order-xl-1">
                                            <div class="row align-items-center">
                                                <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                                    <div class="kt-input-icon kt-input-icon--left">
                                                        <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
                                                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                                            <span><i class="la la-search"></i></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            <!--    <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                                    <div class="kt-form__group kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Type of data:</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <select class="form-control bootstrap-select" id="kt_form_status">
                                                                <option value="">All</option>
                                                                <option value="facebook">facebook</option>
                                                                <option value="twitter">twitter</option>
                                                                <option value="instagram">instagram</option>
                                                                <option value="youtube">youtube</option>
                                                                <option value="web">web</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>-->
                                                <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                                    <div class="kt-form__group kt-form__group--inline">
														<div class="kt-form__label">
                                                            <label>Country:</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <select class="form-control" id="kt_form_country">
                                                                <option vaule="">All</option>
                                                                @foreach ($countries as $country)
                                                                    <option vaule="{{ $country }}">{{ $country }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
													</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body kt-portlet__body--fit">
                            <!--begin: Datatable -->
                            <div class="kt-datatable" id="json_data"></div>
                            <!--end: Datatable -->
                        </div>
                        <div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Comment Edit Box</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                            <div class="form-group">
                                                <input type="text" id="modal-userid" style="display: none;">
                                                <label for="recipient-name" class="form-control-label">Username:</label>
                                                <input type="text" class="form-control" id="modal-username" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="form-control-label">Comment:</label>
                                                <textarea class="form-control" id="modal-comment" style="height:300px"></textarea>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="btn-modal-save">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('layouts.partials._footer-base')
                <!-- end:: Content -->
                </div>
                </div>
 
            </div>
        </div>
    </div>
    <!-- end:: Page -->
    @include('layouts.partials._layout-quick-panel')
    @include('layouts.partials._layout-scrolltop')
 
 
		
		<!-- begin::Global Config(global config for global JS sciprts) -->
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#5d78ff",
						"dark": "#282a3c",
						"light": "#ffffff",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
						"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
					}
				}
			};
		</script>

		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="{{ asset('js/theme.js') }}" type="text/javascript"></script>
		<!--end::Global Theme Bundle -->
        <script src="//www.amcharts.com/lib/3/amcharts.js" type="text/javascript"></script>
        <script src="//www.amcharts.com/lib/3/serial.js" type="text/javascript"></script>
        <script src="//www.amcharts.com/lib/3/amstock.js" type="text/javascript"></script>
        <script src="//www.amcharts.com/lib/3/plugins/animate/animate.min.js" type="text/javascript"></script>
        <script src="//www.amcharts.com/lib/3/plugins/export/export.min.js" type="text/javascript"></script>
        <script src="//www.amcharts.com/lib/3/themes/light.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js" integrity="sha256-JIBDRWRB0n67sjMusTy4xZ9L09V8BINF0nd/UUUOi48=" crossorigin="anonymous"></script>
        <script src="/js/dashboard/admindashboard.js"></script>
		<!--end::Page Scripts -->
	</body>
</html>