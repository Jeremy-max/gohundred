<!-- begin:: Page -->
@include('layouts.partials._header-base-mobile')

<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        @include('layouts.partials._aside-base')
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
            @include('layouts.partials._header-base')
            <div class="kt-content kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                
                @include('layouts.partials._content-base')
            </div>
            @include('layouts.partials._footer-base')
        </div>
    </div>
</div>
<!-- end:: Page -->
@include('layouts.partials._layout-quick-panel')
@include('layouts.partials._layout-scrolltop')
@include('layouts.partials._layout-toolbar')
@include('layouts.partials._layout-demo-panel')
@include('layouts.partials._layout-chat')