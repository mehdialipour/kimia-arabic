<!DOCTYPE html>

<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">

    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

        <!--begin::Web font -->
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script> --}}
        

        <!--end::Web font -->

        <!--begin::Global Theme Styles -->
        <!-- <link href="assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" /> -->

        <link href="{{ url('assets/vendors/base/vendors.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
        <!-- <link href="assets/demo/demo11/base/style.bundle.css" rel="stylesheet" type="text/css" /> -->

        <link href="{{ url('assets/demo/demo11/base/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />

        <!--end::Global Theme Styles -->

        <!--begin::Page Vendors Styles -->
        <!-- <link href="assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" /> -->

        <link href="{{ url('assets/vendors/custom/fullcalendar/fullcalendar.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/vendors/base/font-style.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/vendors/base/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/vendors/base/datepicker.css') }}" rel="stylesheet" type="text/css" />

        <!--end::Page Vendors Styles -->
        <link rel="shortcut icon" href="{{ url('assets/logo.png') }}" />
    </head>

    <!-- end::Head -->

    <!-- begin::Body -->
    <body class="m-content--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-light m-aside--offcanvas-default">

        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">

            <!-- BEGIN: Header -->
            <header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
                <div class="m-container m-container--fluid m-container--full-height">
                    <div class="m-stack m-stack--ver m-stack--desktop">

                        <!-- BEGIN: Brand -->
                        <div class="m-stack__item m-brand  m-brand--skin-light ">
                            <div class="m-stack m-stack--ver m-stack--general m-stack--fluid">
                                <div class="m-stack__item m-stack__item--middle m-brand__logo">
                                    <a href="{{ url('/') }}" class="m-brand__logo-wrapper">
                                        <img style="max-width: 50px;" alt="" src="{{ url('assets/logo.png') }}" />
                                    </a>
                                </div>
                                <div class="m-stack__item m-stack__item--middle m-brand__tools">
                                    <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-left m-dropdown--align-push" m-dropdown-toggle="click" aria-expanded="true">
                                        <a href="#" class="dropdown-toggle m-dropdown__toggle btn btn-outline-metal m-btn  m-btn--icon m-btn--pill">
                                            <span>داشبورد</span>
                                        </a>
                                        <div class="m-dropdown__wrapper">
                                            <span class="m-dropdown__arrow m-dropdown__arrow--left m-dropdown__arrow--adjust"></span>
                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <ul class="m-nav">
                                                            <li class="m-nav__section m-nav__section--first m--hide">
                                                                <span class="m-nav__section-text">دسترسی سریع</span>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="{{ url('patients') }}" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-users"></i>
                                                                    <span class="m-nav__link-text">پرونده بیماران</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="{{ url('turns') }}" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                    <span class="m-nav__link-text">نوبت دهی</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                                    <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                                        <span></span>
                                    </a>

                                    <!-- END -->

                                    <!-- BEGIN: Topbar Toggler -->
                                    <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                        <i class="flaticon-more"></i>
                                    </a>

                                    <!-- BEGIN: Topbar Toggler -->
                                </div>
                            </div>
                        </div>

                        <!-- END: Brand -->
                        <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

                            <!-- BEGIN: Topbar -->
                            <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                                <div class="m-stack__item m-topbar__nav-wrapper">
                                    <ul class="m-topbar__nav m-nav m-nav--inline">
                                        <li class="m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light m-list-search m-list-search--skin-light" m-dropdown-toggle="click" id="m_quicksearch"
                                         m-quicksearch-mode="dropdown" m-dropdown-persistent="1">
                                            <a href="#" class="m-nav__link m-dropdown__toggle">
                                                <span class="m-nav__link-icon"><span class="m-nav__link-icon-wrapper"><i class="flaticon-search-1"></i></span></span>
                                            </a>
                                            <div class="m-dropdown__wrapper">
                                                <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                                                <div class="m-dropdown__inner ">
                                                    <div class="m-dropdown__header">
                                                        <form class="m-list-search__form">
                                                            <div class="m-list-search__form-wrapper">
                                                                <span class="m-list-search__form-input-wrapper">
                                                                    <input id="search" autocomplete="off" type="text" name="q" class="m-list-search__form-input" value="" placeholder="جستجو ..." autofocus="">
                                                                </span>
                                                                <span class="m-list-search__form-icon-close" id="m_quicksearch_close">
                                                                    <i class="la la-remove"></i>
                                                                </span>
                                                                
                                                            </div>
                                                            <div id="results">
                                                                
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="m-dropdown__body">
                                                        <div class="m-dropdown__scrollable m-scrollable" data-scrollable="true" data-height="300" data-mobile-height="200">
                                                            <div class="m-dropdown__content">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="m-nav__item m-topbar__notifications m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center  m-dropdown--mobile-full-width" m-dropdown-toggle="click" m-dropdown-persistent="1">
                                            <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                                                <span class="m-nav__link-icon">
                                                    <span class="m-nav__link-icon-wrapper"><i class="fa fa-users"></i></span>
                                                    <span id="waiters-count" class="m-nav__link-badge m-badge m-badge--success"></span>
                                                </span>
                                            </a>
                                            <div class="m-dropdown__wrapper">
                                                <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                                                <div class="m-dropdown__inner">
                                                    <div class="m-dropdown__header m--align-center">
                                                        <h5 class="">بیماران در اتاق انتظار</h5>
                                                        <hr>
                                                        <div id="waiting">
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="m-nav__item m-topbar__quick-actions m-dropdown m-dropdown--skin-light m-dropdown--large m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
                                            <a href="#" class="m-nav__link m-dropdown__toggle">
                                                <span class="m-nav__link-icon">
                                                    <span class="m-nav__link-icon-wrapper"><i class="fa fa-user-md"></i></span>
                                                    <span id="in-office" class="m-nav__link-badge m-badge m-badge--brand"></span>
                                                </span>
                                            </a>
                                            <div class="m-dropdown__wrapper" style="margin-left: -150px !important;">
                                                <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                                                <div class="m-dropdown__inner">
                                                    <div class="m-dropdown__header m--align-center">
                                                        <h5>بیماران داخل مطب</h5>
                                                        <hr>
                                                        <div id="office">
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="m-nav__item m-topbar__user-profile  m-dropdown m-dropdown--medium m-dropdown--arrow  m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
                                            <a href="#" class="m-nav__link m-dropdown__toggle">
                                                <span class="m-topbar__userpic">
                                                    <img src="{{ url('assets/nurse.png') }}" class="m--img-rounded m--marginless m--img-centered" alt="" />
                                                </span>
                                                <span class="m-nav__link-icon m-topbar__usericon  m--hide">
                                                    <span class="m-nav__link-icon-wrapper"><i class="flaticon-user-ok"></i></span>
                                                </span>
                                                <span class="m-topbar__username m--hide">Nick</span>
                                            </a>
                                            <div class="m-dropdown__wrapper">
                                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                <div class="m-dropdown__inner">
                                                    <div class="m-dropdown__header m--align-center">
                                                        <div class="m-card-user m-card-user--skin-light">
                                                            <div class="m-card-user__pic">
                                                                <img src="{{ url('assets/nurse.png') }}" class="m--img-rounded m--marginless" alt="" />
                                                            </div>
                                                            <div class="m-card-user__details">
                                                                <span class="m-card-user__name m--font-weight-500">منشی</span>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-dropdown__body">
                                                        <div class="m-dropdown__content">
                                                            <ul class="m-nav m-nav--skin-light">
                                                                <li class="m-nav__section m--hide">
                                                                    <span class="m-nav__section-text">Section</span>
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="{{ url('/') }}" class="m-nav__link">
                                                                        <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                                        <span class="m-nav__link-title">
                                                                            <span class="m-nav__link-wrap">
                                                                                <span class="m-nav__link-text">داشبورد</span>
                                                                                
                                                                            </span>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                
                                                                <li class="m-nav__separator m-nav__separator--fit">
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="{{ url('logout') }}" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">خروج</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li id="m_quick_sidebar_toggle" class="m-nav__item m-topbar__quick-sidebar">
                                            <a href="#" class="m-nav__link m-dropdown__toggle">
                                                <span class="m-nav__link-icon"><i class="flaticon-grid-menu"></i></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- END: Topbar -->
                        </div>
                    </div>
                </div>
            </header>

            <!-- END: Header -->

            <!-- begin::Body -->

            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

                <!-- BEGIN: Left Aside -->
                <button class="m-aside-left-close  m-aside-left-close--skin-light " id="m_aside_left_close_btn"><i class="la la-close"></i></button>

                <div id="m_aside_left" class="m-grid__item  m-aside-left  m-aside-left--skin-light ">

                    <!-- BEGIN: Aside Menu -->
                    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-light m-aside-menu--submenu-skin-light " m-menu-vertical="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500">
                        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
                            
                            <li class="m-menu__item" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{ url('patients') }}" class="m-menu__link"><i class="m-menu__link-icon fa fa-file"></i><span class="m-menu__link-text">پرونده بیماران</span><i
                                     class="m-menu__ver-arrow"></i></a>
                                
                            </li>

                            <li class="m-menu__item" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{ url('receptions') }}" class="m-menu__link"><i class="m-menu__link-icon fa fa-users"></i><span class="m-menu__link-text">سوابق پذیرش</span><i
                                     class="m-menu__ver-arrow"></i></a>
                                
                            </li>

                            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fa fa-clock"></i><span class="m-menu__link-text">نوبت دهی</span><i
                                     class="m-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                                    <ul class="m-menu__subnav">
                                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">مشاهده نوبت های امروز</span></span></li>
                                        <li class="m-menu__item " aria-haspopup="true"><a href="{{ url('turns') }}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">مشاهده نوبت های امروز</span></a></li>
                                        <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1"><a href="{{ url('turns/create') }}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">صدور نوبت</span></a></li>
                                        <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1"><a href="{{ url('turns/future') }}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">مشاهده نوبت‌های آینده</span></a></li>
                                    </ul>
                                </div>
                            </li>

                            <li class="m-menu__item" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{ url('patient-files') }}" class="m-menu__link"><i class="m-menu__link-icon fa fa-file-medical"></i><span class="m-menu__link-text">مدارک پزشکی بیماران</span><i
                                     class="m-menu__ver-arrow"></i></a>
                                
                            </li>

                            <li class="m-menu__item" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{ url('insurances') }}" class="m-menu__link"><i class="m-menu__link-icon fa fa-building"></i><span class="m-menu__link-text">بیمه های طرف قرارداد</span><i
                                     class="m-menu__ver-arrow"></i></a>
                                
                            </li>

                            <li class="m-menu__item" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{ url('services') }}" class="m-menu__link"><i class="m-menu__link-icon fa fa-user-md"></i><span class="m-menu__link-text">ثبت خدمات</span><i
                                     class="m-menu__ver-arrow"></i></a>
                                
                            </li>

                            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fa fa-credit-card"></i><span class="m-menu__link-text">صندوق</span><i
                                     class="m-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                                    <ul class="m-menu__subnav">
                                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">صندوق امروز به تفکیک بیمار</span></span></li>
                                        <li class="m-menu__item " aria-haspopup="true"><a href="{{ url('fund') }}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">صندوق امروز به تفکیک بیمار</span></a></li>
                                        <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1"><a href="{{ url('insurance-daily') }}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">صندوق به تفکیک بیمه</span></a></li>

                                        <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1"><a href="{{ url('insurance-all') }}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">صندوق در بازه زمانی</span></a></li>


                                        
                                    </ul>
                                </div>
                            </li>

                            <li class="m-menu__item" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="{{ url('insurance') }}" class="m-menu__link"><i class="m-menu__link-icon fa fa-hospital"></i><span class="m-menu__link-text">صدور لیست بیمه</span><i
                                     class="m-menu__ver-arrow"></i></a>
                                
                            </li>

                            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon fa fa-comments"></i><span class="m-menu__link-text">ارسال پیامک</span><i
                                     class="m-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                                    <ul class="m-menu__subnav">
                                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span class="m-menu__link"><span class="m-menu__link-text">ارسال پیامک</span></span></li>
                                        <li class="m-menu__item " aria-haspopup="true"><a href="{{ url('premium') }}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">ارسال پیامک گروهی</span></a></li>
                                        <li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1"><a href="{{ url('premium') }}" class="m-menu__link"><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">ارسال پیامک مناسبتی</span></a></li>


                                        
                                    </ul>
                                </div>
                            </li>
                            
                        </ul>
                    </div>

                    <!-- END: Aside Menu -->
                </div>
                <!-- END: Left Aside -->

            @yield('content')
            </div>
            <!-- end:: Body -->

            <!-- begin::Footer -->
            <footer class="m-grid__item     m-footer ">
                <div class="m-container m-container--fluid m-container--full-height m-page__container">
                    <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
                        <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
                            <span class="m-footer__copyright">
                                نرم افزار کیمیا طب - ورژن ۳.۰
                            </span>
                        </div>
                        
                    </div>
                </div>
            </footer>

            <!-- end::Footer -->
        </div>

        <!-- end:: Page -->

        <!-- begin::Quick Sidebar -->
        

        <!-- end::Quick Sidebar -->

        <!-- begin::Scroll Top -->
        <div id="m_scroll_top" class="m-scroll-top">
            <i class="la la-arrow-up"></i>
        </div>

        <!-- end::Scroll Top -->

        
        <!--begin::Global Theme Bundle -->
        <script src="{{ url('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/demo/demo11/base/scripts.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/demo/demo11/base/html-table.js') }}" type="text/javascript"></script>

        <!--end::Global Theme Bundle -->

        <!--begin::Page Vendors -->
        <script src="{{ url('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>

        <!--end::Page Vendors -->

        <!--begin::Page Scripts -->
        <script src="{{ url('assets/app/js/dashboard.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/vendors/base/datepicker.js') }}" type="text/javascript"></script>
        @yield('scripts')
        <script>
            $(document).ready(function() {
                $('.selectbox').select2();
            });

            $(".selectbox").select2({
              dir: "rtl"
            });
            var next = '{{ url('assets/vendors/base/timeir_next.png') }}';
            var prev = '{{ url('assets/vendors/base/timeir_prev.png') }}';
            kamaDatepicker('datepicker', {
                nextButtonIcon: next
                , previousButtonIcon: prev
                , forceFarsiDigits: true
                , markToday: true
                , markHolidays: true
                , highlightSelectedDay: true
                , sync: true
            });

            kamaDatepicker('datepicker2', {
                nextButtonIcon: next
                , previousButtonIcon: prev
                , forceFarsiDigits: true
                , markToday: true
                , markHolidays: true
                , highlightSelectedDay: true
                , sync: true
            });
        </script>


        <script>

        window.setInterval(function(){
            getIt();
        }, 6000);

        function getIt(){
           $.ajax({
                url: "{!! url('turns/load-waiters') !!}",
                type: "post",
                data: {
                    x: 1,
                },
                success: function (data) {
                    data = data.split("|");
                    $("#waiting").html(data[0]);
                    $("#waiters-count").html(data[1]);
                }
            });
        }
        $(document).ready(function() {
            getIt();
        });

        $(document).on('keyup', '#search', function(e){
            if(e.which == 13) {
            $.ajax({
                url: "{!! url('search') !!}",
                type: "post",
                data: {
                    q: $("#search").val(),
                },
                success: function (data) {
                    $("#results").html(data);
                }
            });
        }
        
        });
        </script>

        <script>

        window.setInterval(function(){
            getOffice();
        }, 6000);

        function getOffice(){
           $.ajax({
                url: "{!! url('turns/load-office') !!}",
                type: "post",
                data: {
                    x: 1,
                },
                success: function (data) {
                    data = data.split("|");
                    $("#office").html(data[0]);
                    $("#in-office").html(data[1]);
                }
            });
        }
        $(document).ready(function() {
            getOffice();
        })
        </script>    

        <!--end::Page Scripts -->
    </body>

    <!-- end::Body -->
</html>