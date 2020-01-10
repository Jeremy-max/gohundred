<!--begin: User Bar -->
@if(isset($namefirstchar))
<div class="kt-header__topbar-item kt-header__topbar-item--user">
    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
        <div class="kt-header__topbar-user">
            <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
            <div class="kt-user-card-v2">
                <div class="kt-user-card-v2__pic">
                    <div class="kt-badge kt-badge--xl kt-badge--primary">

                        {{ $namefirstchar }}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">
        @include('layouts.partials._dropdown-user')
    </div>
</div>
@endif
<!--end: User Bar -->
