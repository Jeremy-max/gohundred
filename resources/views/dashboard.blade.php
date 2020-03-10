@extends('layouts.app')
@section('css')
<!--begin::Page Vendors Styles(used by this page) -->
<meta name="slack-app-id" content="ARCKJE84X">
<link href="//www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css" />
<!--end::Page Vendors Styles -->
<link href="{{ asset('css/dashboard/custom.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('header')
<div class="text-center m-auto">
    <h2>Welcome to your dashboard</h2>
</div>
@endsection
@section('content')
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
                                    <span class="total_cnt">0</span>
                                    New Comments
								</span>
							</div>
							<div class="kt-widget17__item">
							{{-- <a href=""> --}}
								<div class="kt-demo-icon">
									<div class="kt-demo-icon__preview">
										<i class="fab fa-facebook kt-font-primary"></i>
									</div>
									<!-- <div class="kt-demo-icon__class">
										Facebook
									</div> -->
								</div>
							{{-- </a> --}}
									<span class="kt-widget17__subtitle" >
										Facebook
									</span>

								<span class="kt-widget17__desc">
                                    <span class="fb_cnt" >0</span>
                                    New Comments
								</span>
							</div>
							<div class="kt-widget17__item">
							{{-- <a href=""> --}}
								<div class="kt-demo-icon">
									<div class="kt-demo-icon__preview">
										<i class="fab fa-twitter kt-font-info"></i>
									</div>
									<!-- <div class="kt-demo-icon__class">
										Twitter
									</div> -->
								</div>
							{{-- </a> --}}
								<span class="kt-widget17__subtitle">
									Twitter
								</span>
								<span class="kt-widget17__desc">
                                    <span class="tw_cnt" >0</span>
                                    New Comments
								</span>
							</div>
							{{-- <div class="kt-widget17__item">
								<div class="kt-demo-icon">
									<div class="kt-demo-icon__preview">
										<i class="fab fa-twitch kt-font-warning"></i>
									</div>
								</div>
								<span class="kt-widget17__subtitle">
									Tictok
								</span>
								<span class="kt-widget17__desc">
									10 New Comments
								</span>
							</div> --}}
							<div class="kt-widget17__item">
							{{-- <a href=""> --}}
								<div class="kt-demo-icon">
									<div class="kt-demo-icon__preview">
										<i class="fab fa-youtube kt-font-danger"></i>
									</div>
									<!-- <div class="kt-demo-icon__class">
										YouTube
									</div> -->
								</div>
							{{-- </a> --}}
								<span class="kt-widget17__subtitle">
									YouTube
								</span>
								<span class="kt-widget17__desc">
                                    <span class="yt_cnt" >0</span>
                                    New Comments
								</span>
							</div>
							<div class="kt-widget17__item">
							{{-- <a href=""> --}}
								<div class="kt-demo-icon">
									<div class="kt-demo-icon__preview">
										<i class="fab fa-chrome kt-font-success"></i>
									</div>
									<!-- <div class="kt-demo-icon__class">
										Web
									</div> -->
								</div>
							{{-- </a> --}}
								<span class="kt-widget17__subtitle">
									Web
								</span>
								<span class="kt-widget17__desc">
                                    <span class="web_cnt" >0</span>
                                    New Comments
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class='row'>
	<div class='col'>
        <!--begin::Portlet-->
		<div class="kt-portlet">
			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<span class="kt-portlet__head-icon kt-hidden">
						<i class="la la-gear"></i>
					</span>
					<h3 class="kt-portlet__head-title">
                        This graph shows you when and how many times the keyword is mentioned across all platforms
					</h3>
				</div>
			</div>
			<div class="kt-portlet__body">
				<div id="campaign_graph" style="height: 500px;"></div>
			</div>
		</div>
		<!--end::Portlet-->
	</div>
</div>
<div class='row'>
	<div class='col'>
		<!-- begin:: Content -->
		<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
			<div class="kt-portlet kt-portlet--mobile">
				<div class="kt-portlet__head kt-portlet__head--lg">
					<div class="kt-portlet__head-label">
						<span class="kt-portlet__head-icon">
							<i class="kt-font-brand flaticon2-line-chart"></i>
						</span>
						<h3 class="kt-portlet__head-title">
                            This section shows you all the mentions on your keywords
						<!-- <small>initialized from remote json file</small> -->
						</h3>
					</div>
				</div>
				<div class="kt-portlet__body">
					<!--begin: Search Form -->
					<div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
						<div class="row">
							<div class="col-md-3 kt-margin-b-20-tablet-and-mobile">
								<div class="kt-input-icon kt-input-icon--left">
									<input type="text" class="form-control" placeholder="Search..." id="generalSearch">
									<span class="kt-input-icon__icon kt-input-icon__icon--left">
										<span><i class="la la-search"></i></span>
									</span>
								</div>
							</div>
							<div class="col-md-3 kt-margin-b-20-tablet-and-mobile">
								<div class="kt-form__group kt-form__group--inline">
									<div class="kt-form__label">
										<label>Type of data:</label>
									</div>
									<div class="kt-form__control">
										<select class="form-control bootstrap-select" id="kt_form_status">
											<option value="">All</option>
											<option value="facebook">facebook</option>
											<option value="twitter">twitter</option>
											{{-- <option value="tiktok">tiktok</option> --}}
											<option value="youtube">youtube</option>
											<option value="web">web</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-3 kt-margin-b-20-tablet-and-mobile">
								<div class="kt-form__group kt-form__group--inline">
									<div class="kt-form__label">
										<label>Date:</label>
									</div>
									<div class="kt-form__control">
										<div class="input-group date" >
											<input type="text" class="form-control datepicker" readonly="" id="kt_datepicker_3">
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="la la-calendar"></i>
												</span>
											</div>
										</div>
									<!-- <input class="form-control" id="kt_form_country" placeholder="Date...yyyy-mm-dd" data-live-search="true"/> -->
									<!-- <select class="selectpicker countrypicker form-control bootstrap-select" id="kt_form_country" data-live-search="true" ></select> -->
									</div>
								</div>
							</div>
							{{-- <div class="col-md-3 kt-margin-b-20-tablet-and-mobile">
								<div class="kt-form__group kt-form__group--inline">
									<div class="kt-form__label">
										<label>Language:</label>
									</div>
									<div class="kt-form__control">
										<div class="input-group date" >
											<select class="form-control bfh-languages" data-language="">
												<option value="">Any language</option>
												<option value="en">English</option>
                                                <option disabled>___________________________</option>
                                                <option value="ar"> Arabic </option>
                                                <option value="eu"> Basque </option>
                                                <option value="zh"> Chinese </option>
                                                <option value="cs"> Czech </option>
                                                <option value="da"> Danish </option>
                                                <option value="fi"> Finnish </option>
                                                <option value="fr"> French </option>
                                                <option value="de"> German </option>
                                                <option value="hu"> Hungarian </option>
                                                <option value="id"> Indonesian </option>
                                                <option value="it"> Italian </option>
                                                <option value="ko"> Korean </option>
                                                <option value="no"> Norwegian </option>
                                                <option value="pl"> Polish </option>
                                                <option value="pt"> Portuguese </option>
                                                <option value="ro"> Romanian </option>
                                                <option value="ru"> Russian </option>
                                                <option value="sk"> Slovak </option>
                                                <option value="es"> Spanish </option>
                                                <option value="sv"> Swedish </option>
                                                <option value="th"> Thai </option>
                                                <option value="tr"> Turkish </option>
                                                <option value="vi"> Vietnames </option>
											{{-- @foreach ($langs as $ac => $label)
												<option value="{{ $ac }}">{{ $label }}</option>
											@endforeach --}}
											{{-- </select>
										</div>
									</div>
								</div>
							</div> --}}
						</div>
					</div>
					<!--end: Search Form-->
					<!--begin: Group action Form-->
					<div class="kt-form kt-form--label-align-right kt-margin-t-20 collapse" id="kt_datatable_group_action_form">
						<div class="row">
							<div class="col-xl-12">
								<div class="kt-form__group kt-form__group--inline">
									<div class="kt-form__label kt-form__label-no-wrap">
										<label class="kt-font-bold kt-font-danger-">Selected
											<span id="kt_datatable_selected_number"></span> records:</label>
									</div>
									<div class="kt-form__control">
										<div class="btn-toolbar">
											<!-- <div class="dropdown">
												<button type="button" class="btn btn-brand btn-sm dropdown-toggle" data-toggle="dropdown">
													Update status
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#">Pending</a>
													<a class="dropdown-item" href="#">Delivered</a>
													<a class="dropdown-item" href="#">Canceled</a>
												</div>
											</div> -->
											&nbsp;&nbsp;&nbsp;
											<button class="btn btn-sm btn-danger" type="button" id="kt_datatable_delete_all">Delete All</button>
											&nbsp;&nbsp;&nbsp;
											<!-- <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#kt_modal_fetch_id">Fetch Selected Records</button> -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--end: Group action Form-->
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
                                <h1 class="modal-title" id="exampleModalLabel">Slack Integration</h1>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body" style="height: 300px;">
                                <h4 class="text-center">Select a campaign you would like to connect to slack workspace.</h4>
                                <div class="mt-5">
                                    <div class="row">
                                        <div class="col-sm-6 offset-md-3">
                                            <div class="dropdown">
                                                <select class="form-control" id="slack_campaign_select">
                                                    {{-- <option disabled selected value="0">Select Campaign</option>
                                                    <option disabled>___________________________</option> --}}
                                                    @if (count($campaign_list) > 0)
                                                        @for ($i = 0; $i < count($campaign_list); $i++)
                                                            @if ($i === 0)
                                                                <option value="{{ $campaign_list[$i]['campaign_id'] }}" selected>{{ $campaign_list[$i]['campaign'] }}</option>
                                                            @else
                                                                <option value="{{ $campaign_list[$i]['campaign_id'] }}">{{ $campaign_list[$i]['campaign'] }}</option>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer" style="justify-content: center!important;">
                                <form method="POST" action="{{ route('addSlack') }}">
                                @csrf
                                <input id="slack_campaign_id" name="slack_campaign_id" style="display:none;">
                                <button id="slack_button">
                                    <img alt="Add to Slack" height="40" width="139" src="https://platform.slack-edge.com/img/add_to_slack.png" srcset="https://platform.slack-edge.com/img/add_to_slack.png 1x, https://platform.slack-edge.com/img/add_to_slack@2x.png 2x">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	@if (count($campaign_list) > 0)
		<input id="table_keyword" type="hidden" value="{{ $keyword_id }}"/>
    @endif
    @if (isset($job))
        <input id="job" type="hidden" value="{{$job}}"
            data-fb="{{$fb_cnt}}"
            data-tw="{{$tw_cnt}}"
            data-yt="{{$yt_cnt}}"
            data-web="{{$web_cnt}}"/>
    @endif
	<!-- end:: Content -->
	</div>
</div>




@endsection
@section('page_vendor_scripts')

@endsection
@section('page_scripts')
<script>
    var botmanWidget = {
        aboutText: 'ssdsd',
        introMessage: "Hello! We’re helping professionals like you monitor web and social media data.<br>Is there anything I can help you with? "
    };
</script>
<script src="//www.amcharts.com/lib/3/amcharts.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/serial.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/amstock.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/plugins/animate/animate.min.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/plugins/export/export.min.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/themes/light.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js" integrity="sha256-JIBDRWRB0n67sjMusTy4xZ9L09V8BINF0nd/UUUOi48=" crossorigin="anonymous"></script>
<script src="/js/dashboard/dashboard.js"></script>
@endsection
