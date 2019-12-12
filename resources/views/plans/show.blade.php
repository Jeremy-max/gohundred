@extends('layouts.app')

@section('css')
<!--begin::Page Vendors Styles(used by this page) -->
<link href="//www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css" />
<link href="/css/creative.css" rel="stylesheet">
<!--end::Page Vendors Styles -->
<link href="{{ asset('css/dashboard/custom.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('header')
<div class="text-center m-auto">
    <h2>Choose a subscription plan for your account</h2>
</div>
@endsection
@section('content')
<div class="text-center">
  <div class="plan">
    <div class="plan-inner">
          <div class="entry-title">
            <h3>{{ $plan->name }} Plan</h3>
            <div class="price">€{{ $plan->cost }}<span></span>
            </div>
          </div>
          <div class="entry-content">
            <ul>
              <li>Keep tabs on <strong>&nbsp;1&nbsp;</strong> campaign <br>(5 keywords)</li>
              <li>Get<strong>&nbsp;1</strong>k data every month</li>
              <li>Slack integration</li>
              <li>Update every 12 hours</li>
              <li>Excel file export</li>
            </ul>
          </div>
          <div class="btn">
          <a href="{{ route('plans.creditCard', $plan->slug) }}">Choose</a>
          </div>
        </div>
    </div>
</div>
@endsection


