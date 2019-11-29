@extends('layouts.app')
@section('css')
<!--begin::Page Vendors Styles(used by this page) -->
<link href="//www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css" />
<!--end::Page Vendors Styles -->
<link href="{{ asset('css/dashboard/custom.css') }}" rel="stylesheet" type="text/css" />
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
							<a href="password">
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
					Multiple Data Sets
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
						<h3 class="kt-portlet__head-title">Datatable
						<!-- <small>initialized from remote json file</small> -->
						</h3>
					</div>
				</div>
				<div class="kt-portlet__body">
					<!--begin: Search Form -->
					<div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
						<div class="row align-items-center">
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
											<option value="instagram">instagram</option>
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
							<div class="col-md-3 kt-margin-b-20-tablet-and-mobile">
								<div class="kt-form__group kt-form__group--inline">
									<div class="kt-form__label">
										<label>Language:</label>
									</div>
									<div class="kt-form__control">
										<div class="input-group date" >
											<select class="form-control bfh-languages" data-language="">
												<option value="">Any language</option>
												<option vaule="en">English</option>
												<option disabled>___________________________</option>
											@foreach ($langs as $ac => $label)
												<option value="{{ $ac }}">{{ $label }}</option>
											@endforeach
											</select>
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
		</div>
	</div>
	@if (count($campaign_list) > 0)
		<input id="table_keyword" type="hidden" value="{{ $keyword_id }}"/>
	@endif
	<!-- end:: Content -->
</div>
</div>
@endsection
@section('page_vendor_scripts')

@endsection
@section('page_scripts')
<script src="//www.amcharts.com/lib/3/amcharts.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/serial.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/amstock.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/plugins/animate/animate.min.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/plugins/export/export.min.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/themes/light.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js" integrity="sha256-JIBDRWRB0n67sjMusTy4xZ9L09V8BINF0nd/UUUOi48=" crossorigin="anonymous"></script>
<script src="/js/dashboard/dashboard.js"></script>
@endsection