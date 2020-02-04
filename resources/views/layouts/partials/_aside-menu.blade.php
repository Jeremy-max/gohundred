<!-- begin:: Aside Menu -->
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu"class="kt-aside-menu "data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500" >
        @isset($campaign_list)
        <ul class="kt-menu__nav ">
            <li class="kt-menu__item kt-menu__item--submenu mt-4" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="/step" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M7,5 L17,5 C17.5522847,5 18,5.44771525 18,6 C18,6.55228475 17.5522847,7 17,7 L7,7 C6.44771525,7 6,6.55228475 6,6 C6,5.44771525 6.44771525,5 7,5 Z M7,9 L17,9 C17.5522847,9 18,9.44771525 18,10 C18,10.5522847 17.5522847,11 17,11 L7,11 C6.44771525,11 6,10.5522847 6,10 C6,9.44771525 6.44771525,9 7,9 Z M7,13 L17,13 C17.5522847,13 18,13.4477153 18,14 C18,14.5522847 17.5522847,15 17,15 L7,15 C6.44771525,15 6,14.5522847 6,14 C6,13.4477153 6.44771525,13 7,13 Z M7,17 L17,17 C17.5522847,17 18,17.4477153 18,18 C18,18.5522847 17.5522847,19 17,19 L7,19 C6.44771525,19 6,18.5522847 6,18 C6,17.4477153 6.44771525,17 7,17 Z" fill="#000000" opacity="0.3"/>
                                <path d="M5.5,2 C6.32842712,2 7,2.67157288 7,3.5 L7,20.5 C7,21.3284271 6.32842712,22 5.5,22 C4.67157288,22 4,21.3284271 4,20.5 L4,3.5 C4,2.67157288 4.67157288,2 5.5,2 Z M18.5,2 C19.3284271,2 20,2.67157288 20,3.5 L20,20.5 C20,21.3284271 19.3284271,22 18.5,22 C17.6715729,22 17,21.3284271 17,20.5 L17,3.5 C17,2.67157288 17.6715729,2 18.5,2 Z" fill="#000000"/>
                            </g>
                        </svg>
                    </span>
                    <span class="kt-menu__link-text font-italic">Add campaign</span>
                </a>
            </li>
            @if (count($campaign_list) > 0)
                @foreach ($campaign_list as $campaign)
                @if ($campaign == reset($campaign_list ))
                    <li class="kt-menu__item kt-menu__item--submenu kt-menu__item--open" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                @else
                    <li class="kt-menu__item kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                @endif
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
                        <span class="kt-menu__link-text">{{ $campaign['campaign'] }}</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="kt-menu__submenu ">
                        <span class="kt-menu__arrow"></span>
                        <ul class="kt-menu__subnav">
                            <li class="kt-menu__item kt-menu__item--parent" aria-haspopup="true" >
                                <span class="kt-menu__link"><span class="kt-menu__link-text">Forms</span></span>
                            </li>
                            @if (count($campaign['keyword_list']) > 0)
                                @foreach ($campaign['keyword_list'] as $keyword)
                                    <li class="kt-menu__item kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                                        <a href="{{ route('campaignPage', ['keyword_id' => $keyword->id]) }}" class="kt-menu__link ">
                                            <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                            <span class="kt-menu__link-text">{{ $keyword->keyword }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </li>
                @endforeach
            @endif
        </ul>
        @endisset
    </div>
</div>
<!-- end:: Aside Menu -->
