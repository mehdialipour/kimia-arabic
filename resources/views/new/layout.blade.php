
<!DOCTYPE html>

<!-- 
Template Name: KimiaTeb
Author: alidadaashi
Contact: alidadaashhi@gmail.com
Dribbble: www.dribbble.com/alidadaashi
-->
<html lang="fa-IR" dir="rtl">

<!-- begin::Head -->

<head>

    <!--begin::Base Path (base relative path for assets of this page) -->
    <base href=".">

    <!--end::Base Path -->
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!--begin:: Global Optional Vendors -->
    <link href="{{ url('new/assets/vendors/custom/vendors/flaticon2/flaticon.css') }}" rel="stylesheet" type="text/css" />

    <!--end:: Global Optional Vendors -->
    <link href="{{ url('new/assets/vendors/general/bootstrap-markdown/css/bootstrap-markdown.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('new/assets/vendors/general/select2/dist/css/select2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('new/assets/vendors/general/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{ url('new/assets/styles/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('new/assets/styles/chosen.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/vendors/custom/fullcalendar/fullcalendar.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/vendors/base/font-style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/vendors/base/modal.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('new/assets/styles/kamadatepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/timepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ url('new/assets/styles/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('new/assets/styles/custom-tablet.css') }}" rel="stylesheet" type="text/css" />
    
    @yield('styles')

    <style>
        @media only screen and (min-width:320px) and (max-width: 1024px){

.kt-header__topbar .kt-header__topbar-item .kt-header__topbar-icon .fa-lightbulb,
.kt-header__topbar .kt-header__topbar-item .kt-header__topbar-icon .fa-check-double{

color: #22b9ff;

font-size: 20px;

padding-top: 1px;

width: 20px;

height: 20px;
}

.kt-header__topbar .kt-header__topbar-item .kt-header__topbar-icon{

overflow: visible;
}

.kt-header__topbar .kt-header__topbar-item .kt-header__topbar-icon .kt-nav__link-badge > span{

margin-right: -15px;

top: -10px;
overflow: visible;
}
.kt-header__topbar .kt-header__topbar-item .kt-header__topbar-icon .title-notif{

display: none;
}

.kt-header__topbar .kt-header__topbar-item .kt-header__topbar-icon .fa-lightbulb,
.kt-header__topbar .kt-header__topbar-item .kt-header__topbar-icon .fa-check-double{

font-size: 20px;
}
    </style>

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{ url('new/assets/Images/logo.png') }}" />
</head>

<!-- end::Head -->

<!-- begin::Body -->

<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-aside--minimize kt-page--loading" id="translate">
<?php $jdate = \App\Helpers\ConvertDate::today(date("Y-m-d"));

if(strpos($jdate, "چهارشنبه") !== false) {
    $jdate = str_replace("چهارشنبه", "الأربعاء", $jdate);
}

if(strpos($jdate, "پنجشنبه") !== false) {
    $jdate = str_replace("پنجشنبه", "يوم الخميس", $jdate);
}

if(strpos($jdate, "جمعه") !== false) {
    $jdate = str_replace("جمعة", "الأربعاء", $jdate);
}

if(strpos($jdate, "شنبه") !== false) {
    $jdate = str_replace("السبت", "الأربعاء", $jdate);
}

if(strpos($jdate, "یکشنبه") !== false) {
    $jdate = str_replace("الأحد", "الأربعاء", $jdate);
}

if(strpos($jdate, "دوشنبه") !== false) {
    $jdate = str_replace("الاثنين", "الأربعاء", $jdate);
}

if(strpos($jdate, "سه شنبه") !== false) {
    $jdate = str_replace("سه شنبه", "يوم الثلاثاء", $jdate);
}

?>
<?php $permission = \DB::table('permission_roles')->where('role_id', \Session::get('role')); ?>
    <!-- begin:: Page -->

    <!-- begin:: Header Mobile -->
    <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
        <div class="kt-header-mobile__logo">
            <a href="{{ url('/') }}">
                <img alt="Logo" style="max-height: 20px;" src="{{ url('new/assets/Images/logo.png') }}" />
            </a>
        </div>
        <div class="kt-header-mobile__toolbar">
            <button class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
            <button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>
            <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
        </div>
    </div>

    <!-- end:: Header Mobile -->
    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

            <!-- begin:: Aside -->
            <button class="kt-aside-close " id="kt_aside_close_btn"><i class="fa fa-times"></i></button>
            <div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

                <!-- begin:: Brand -->
                <div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
                    <div class="kt-aside__brand-logo">
                        <a href="{{ url('/') }}">
                            <img id="logo" alt="Logo" src="{{ url('new/assets/Images/logo.png') }}" />
                        </a>
                    </div>
                </div>

                <!-- end:: Brand -->

                <!-- begin:: Aside Menu -->
                <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
                    <div id="kt_aside_menu" class="kt-aside-menu  kt-aside-menu--dropdown " data-ktmenu-vertical="1" data-ktmenu-dropdown="1" data-ktmenu-scroll="0">
                        <ul class="kt-menu__nav ">
                            
                            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="click"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-files-and-folders"></i>
									<span class="kt-menu__link-text">الملفات</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">
                                        @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 1)->count() == 1)
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('patients') }}" class="kt-menu__link "><span class="kt-menu__link-text">الملفات</span></a></li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('patients/create') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text"> أضف ملفًا جديدًا </span></a>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('receptions/stats') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text"> إحصائية أسباب الإحالة </span></a>
                                        </li>

                                        @endif
                                        @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 44)->count() == 1)
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('patients/search-patients') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text"> ابحث عن السجلات الطبية للمرضى </span></a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                            {{-- <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="click"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-heart-rate-monitor"></i>
                                    <span class="kt-menu__link-text">پذیرش</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('receptions') }}" class="kt-menu__link "><span class="kt-menu__link-text">سوابق پذیرش</span></a></li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('receptions/create') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text"> افزودن پذیرش جدید </span></a>
                                        </li>
                                    </ul>
                                </div>
                            </li> --}}
                            {{-- <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="click"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-medical-records"></i>
									<span class="kt-menu__link-text">پذیرش</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="receptions.html" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">سوابق پذیرش</span></a>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="newreception.html" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">ایجاد پذیرش جدید</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </li> --}}
                            @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 2)->count() == 1)
                            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="click"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-calendar-6"></i>
									<span class="kt-menu__link-text">تقييمات الدور</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">
                                        <li class="kt-menu__item" aria-haspopup="true">
                                            <a href="{{ url('turns/create') }}" class="kt-menu__link ">
												<span class="kt-menu__link-text">خلق منعطفات جديدة</span></a>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('turns?page=1') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">انظر دور اليوم</span></a>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('turns/future') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">انظر في المرة القادمة</span></a>
                                        </li>

                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('turns/canceled_turns') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">عرض المواعيد الملغاة</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endif

                            @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 3)->count() == 1)
                            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="click"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-analytics-2"></i>
									<span class="kt-menu__link-text">إرسال المعلومات</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">
                                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link">
												<span class="kt-menu__link-text">تأمين</span></span>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('insurances') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">تأمين طرف العقد</span></a>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('insurances/create') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">إضافة تأمين جديد</span></a>
                                        </li>
                                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link">
												<span class="kt-menu__link-text">خدمات</span></span>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('services') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">الخدمات الحالية </span></a>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('services/create') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">أضف خدمة جديدة</span></a>
                                        </li>

                                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link">
                                                <span class="kt-menu__link-text">معلومة</span></span>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('settings') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">معلومات المركز الطبي</span></a>
                                        </li>
                                        {{-- <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link">
												<span class="kt-menu__link-text">دارو</span></span>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="medicines.html" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">بانک دارو</span></a>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="newmedicine.html" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">افزودن داروی جدید</span></a>
                                        </li> --}}
                                    </ul>
                                </div>
                            </li>
                            @endif
                            @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 17)->count() == 1)
                            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="click"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-open-box"></i>
                                    <span class="kt-menu__link-text">المخزون</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">
                                        @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 34)->count() == 1)
                                        <li class="kt-menu__item" aria-haspopup="true">
                                            <a href="{{ url('storage') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">المستودع المركزي</span></a>
                                        </li>
                                        @endif
                                        @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 36)->count() == 1)
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('storage/create') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">أضف منتج جديد</span></a>
                                        </li>
                                        @endif

                                        @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 37)->count() == 1)
                                        
                                        <li class="kt-menu__item" aria-haspopup="true">
                                            <a href="{{ url('storage/internal') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">رف الصيدلة</span></a>
                                        </li>
                                        @endif
                                        @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 35)->count() == 1)
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('storage/shelf') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">مستودع المركز الطبي</span></a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                            @endif

                            @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 43)->count() == 1)
                            <li class="kt-menu__item"><a href="{{ url('drug-store') }}" class="kt-menu__link "><i class="kt-menu__link-icon fa fa-pills"></i>
                                    <span class="kt-menu__link-text">الصیدلیه </span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                
                            </li>
                            @endif

                            @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 6)->count() == 1)
                            <?php $style = ''; $color = ''; $fund=0; ?>
                            @if(\App\Models\Fund::where('delivered', 2)->where('delivered_to', \Session::get('user_id'))->count() > 0)
                                <?php $style = 'background-color: red;'; 
                                      $color = 'color: white;';  
                                      $fund = 1;
                                ?>
                            @endif
                            <li style="{{ $style }}" class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="click"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i style="{{ $color }}" class="kt-menu__link-icon flaticon2-tools-and-utensils
									"></i>
									<span style="{{ $color }}" class="kt-menu__link-text">الصندوق</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="kt-menu__submenu " style="width: 300px;"><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav" dir="rtl">
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('fund') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">صندوق اليوم من قبل المريض</span></a>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('debts') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">قائمة المدينين</span></a>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('insurance-daily') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">رؤية الصندوق اليوم عن طريق التأمين</span></a>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('fund/users') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">اطلع على صندوق اليوم حسب تقسيم المستخدمين</span></a>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('fund/doctors') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">اعرض الخانة اليوم افتراضيا الأطباء</span></a>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('fund/doctors-detail') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">جستجوی صندوق به تفکیک کاربران</span></a>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('fund/doctors-hourly') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">جمع التبرعات كل ساعة اليوم من قبل المستخدمين</span></a>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('fund/services-detail') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">البحث عن الأموال عن طريق الخدمة</span></a>
                                        </li> 
                                        
                                        @if($fund == 1)
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('fund/receive') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">موافقة الصندوق</span></a>
                                        </li>
                                        @endif

                                        @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 16)->count() == 1)
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('fund/collect') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">إضافة الأموال الحالية إلى الصندوق الرئيسي</span></a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                            
                            @endif
                            @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 55)->count() == 1)
                            <li class="kt-menu__item"><a href="{{ url('questions') }}" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-question"></i>
                                    <span class="kt-menu__link-text">استبيان</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                
                            </li>
                            @endif
                            @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 10)->count() == 1)
                            <li class="kt-menu__item"><a href="{{ url('return') }}" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-undo"></i>
                                    <span class="kt-menu__link-text">الرجوع إلى زميل</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                
                            </li>
                            @endif
                            @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 23)->count() == 1)
                            <li class="kt-menu__item"><a href="{{ url('/my-wallet') }}" class="kt-menu__link "><i class="kt-menu__link-icon fa fa-money-bill-alt"></i>
                                    <span class="kt-menu__link-text">حسابي</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                
                            </li>
                            @endif

                            @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 18)->count() == 1)
                            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="click"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon fa fa-money-bill-wave"></i>
                                    <span class="kt-menu__link-text">محاسبة</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">

                                        <li class="kt-menu__item" aria-haspopup="true">
                                            <a href="{{ url('cheques') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">تعريف الحساب</span></a>
                                        </li>

                                        <li class="kt-menu__item" aria-haspopup="true">
                                            <a href="{{ url('cheques') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">جانب الحساب (المستخدمون)</span></a>
                                        </li>

                                        <li class="kt-menu__item" aria-haspopup="true">
                                            <a href="{{ url('cheques') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">جانب الحساب (الشركات)</span></a>
                                        </li>

                                        <li class="kt-menu__item" aria-haspopup="true">
                                            <a href="{{ url('cheques') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">جانب الحساب (الأفراد)</span></a>
                                        </li>

                                        <li class="kt-menu__item" aria-haspopup="true">
                                            <a href="{{ url('cheques') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">الدفع</span></a>
                                        </li>

                                        <li class="kt-menu__item" aria-haspopup="true">
                                            <a href="{{ url('cheques') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">تعريف فئة الشيك</span></a>
                                        </li>

                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('paid-cheques') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">إصدار الشيكات</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endif

                            @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 13)->count() == 1)
                            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="click"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-group"></i>
                                    <span class="kt-menu__link-text">المستخدمين</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">
                                        <li class="kt-menu__item" aria-haspopup="true">
                                            <a href="{{ url('users') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">مستخدمو النظام</span></a>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('users/create') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">إضافة مستخدم جديد</span></a>
                                        </li>
                                        </ul>
                                </div>
                            </li>
                            @endif
                            @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 57)->count() == 1)
                            <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="click"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-shield"></i>
                                    <span class="kt-menu__link-text">أذونات</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('roles') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">الأدوار</span></a>
                                        </li>

                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="{{ url('permissions') }}" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">أذونات</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endif
                            <li class="kt-menu__item"><a href="{{ url('/ticket') }}" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-check-double"></i>
                                    <span class="kt-menu__link-text" align="center">تذاكر للدعم</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                
                            </li>
                            @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 11)->count() == 1)
                            <li class="kt-menu__item"><a href="{{ url('/sms') }}" class="kt-menu__link"><i class="kt-menu__link-icon fa fa-sms"></i>
                                    <span class="kt-menu__link-text" align="center">إدارة الرسائل القصيرة</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                
                            </li>
                            @endif

                            {{-- <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--bottom-1" aria-haspopup="true" data-ktmenu-submenu-toggle="click"><a href="javascript:;" class="kt-menu__link kt-menu__toggle"><i class="kt-menu__link-icon flaticon2-gear"></i>
									<span class="kt-menu__link-text">ابزارها</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                                <div class="kt-menu__submenu kt-menu__submenu--up"><span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav"> 
                                        <li class="kt-menu__item  kt-menu__item--parent kt-menu__item--bottom-2" aria-haspopup="true"><span class="kt-menu__link">
												<span class="kt-menu__link-text">پیامک</span></span>
                                        </li>
                                        <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover"><a href="#" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">ارسال پیامک تعطیلی مطب</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a></li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="#" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">ارسال پیامک مناسبتی</span></a>
                                        </li>
                                        <li class="kt-menu__item  kt-menu__item--parent kt-menu__item--bottom-2" aria-haspopup="true"><span class="kt-menu__link">
												<span class="kt-menu__link-text">کاربران</span></span>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="roles.html" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">مدیریت نقش‌ها</span></a>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="#" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">اعطای دسترسی</span></a>
                                        </li>
                                        <li class="kt-menu__item " aria-haspopup="true">
                                            <a href="users.html" class="kt-menu__link ">
                                                <span class="kt-menu__link-text">کاربران سیستم</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                </div>

                <!-- end:: Aside Menu -->
            </div>
            <div class="kt-aside-menu-overlay"></div>

            <!-- end:: Aside -->
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

                <!-- begin:: Header -->

                <div id="kt_header" class="kt-header kt-grid kt-grid--ver  kt-header--fixed ">

                    <!-- begin: Header Menu -->
                    <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
                    <div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
                        <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout- ">


                            <a href="#" class="btn kt-subheader__btn-daterange" id="kt_dashboard_daterangepicker" data-toggle="kt-tooltip" title="Select dashboard daterange" data-placement="left">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect id="bound" x="0" y="0" width="24" height="24"/>
													<path d="M10.9630156,7.5 L11.0475062,7.5 C11.3043819,7.5 11.5194647,7.69464724 11.5450248,7.95024814 L12,12.5 L15.2480695,14.3560397 C15.403857,14.4450611 15.5,14.6107328 15.5,14.7901613 L15.5,15 C15.5,15.2109164 15.3290185,15.3818979 15.1181021,15.3818979 C15.0841582,15.3818979 15.0503659,15.3773725 15.0176181,15.3684413 L10.3986612,14.1087258 C10.1672824,14.0456225 10.0132986,13.8271186 10.0316926,13.5879956 L10.4644883,7.96165175 C10.4845267,7.70115317 10.7017474,7.5 10.9630156,7.5 Z" id="Path-107" fill="#000000"/>
													<path d="M7.38979581,2.8349582 C8.65216735,2.29743306 10.0413491,2 11.5,2 C17.2989899,2 22,6.70101013 22,12.5 C22,18.2989899 17.2989899,23 11.5,23 C5.70101013,23 1,18.2989899 1,12.5 C1,11.5151324 1.13559454,10.5619345 1.38913364,9.65805651 L3.31481075,10.1982117 C3.10672013,10.940064 3,11.7119264 3,12.5 C3,17.1944204 6.80557963,21 11.5,21 C16.1944204,21 20,17.1944204 20,12.5 C20,7.80557963 16.1944204,4 11.5,4 C10.54876,4 9.62236069,4.15592757 8.74872191,4.45446326 L9.93948308,5.87355717 C10.0088058,5.95617272 10.0495583,6.05898805 10.05566,6.16666224 C10.0712834,6.4423623 9.86044965,6.67852665 9.5847496,6.69415008 L4.71777931,6.96995273 C4.66931162,6.97269931 4.62070229,6.96837279 4.57348157,6.95710938 C4.30487471,6.89303938 4.13906482,6.62335149 4.20313482,6.35474463 L5.33163823,1.62361064 C5.35654118,1.51920756 5.41437908,1.4255891 5.49660017,1.35659741 C5.7081375,1.17909652 6.0235153,1.2066885 6.2010162,1.41822583 L7.38979581,2.8349582 Z" id="Combined-Shape" fill="#000000" opacity="0.3"/>
												</g>
											</svg>
                                <span class="kt-subheader__btn-daterange-title" id="kt_dashboard_daterangepicker_title">اليوم: </span>&nbsp;
                                <span class="kt-subheader__btn-daterange-date" id="kt_dashboard_daterangepicker_date">{{ \App\Helpers\ConvertNumber::convertToPersian($jdate) }}</span>

                                
                                

                                <!--<i class="flaticon2-calendar-1"></i>-->
                            </a>
                            <a href="#" class="btn kt-subheader__btn-daterange" id="kt_dashboard_daterangepicker" data-toggle="kt-tooltip" title="Select dashboard daterange" data-placement="left">
                                
                                <span class="kt-subheader__btn-daterange-title" id="kt_dashboard_daterangepicker_title">المستعمل: {{ \Session::get('name') }}</span>

                                <?php
                                    $c = \App\Models\Setting::first()->credit;
                                    $credit = number_format(\App\Models\Setting::first()->credit);
                                    $credit = \App\Helpers\ConvertNumber::convertToPersian($credit);
                                ?>
                                
                                <span class="kt-subheader__btn-daterange-title" id="kt_dashboard_daterangepicker_title">صلاحية الحساب: @if($c < 0) <span class="text-danger"> {{ $credit }} دینار </span> @else <span> {{ $credit }} دینار</span> @endif </span><a style="margin-top: 30px;" href="{{ url('payment/form') }}">زيادة رصيد الحساب</a>

                                <!--<i class="flaticon2-calendar-1"></i>-->
                            </a>
                        </div>

                    </div>

                    <!-- end: Header Menu -->

                    <!-- begin:: Header Topbar -->
                    <div class="kt-header__topbar">




                        

                        <!--end: Search -->

                        <!--begin: Quick actions -->
                        @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 24)->count() == 1)
                        <div class="kt-header__topbar-item dropdown">
                            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                                <span class="kt-header__topbar-icon kt-header__topbar-icon--warning">
                                            
                                            <span style="color: #22b9ff;" class="kt-nav__link-badge fa fa-lightbulb" >
                                                    <span id="online-count" class="kt-badge kt-badge--unified-danger kt-badge--md kt-badge--rounded kt-badge--boldest"></span>
                                </span>
                                <span class="title-notif">مستخدمين على الهواء</span>


                                </span>

                            </div>
                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

                                <!--begin: Head -->
                                <div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
                                    <div style="color: #22b9ff;" class="kt-user-card__avatar fa fa-check-double">
                                        

                                        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                        <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold kt-hidden">S</span>
                                    </div>
                                    <div class="kt-user-card__name">
                                        مستخدمين على الهواء
                                    </div>
                                </div>

                                <!--end: Head -->

                                <!--begin: Navigation -->
                                <div class="kt-notification" id="online-users" style="height: 600px; overflow: scroll;">
                                    
                                </div>

                                <!--end: Navigation -->
                            </div>
                        </div>
                        @endif
                        @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 29)->count() == 1)
                        <div class="kt-header__topbar-item dropdown">
                            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                                <span class="kt-header__topbar-icon kt-header__topbar-icon--warning">
                                            
                                            <span style="color: #22b9ff;" class="kt-nav__link-badge fa fa-check-double" >
                                                    <span id="" class="kt-badge kt-badge--unified-danger kt-badge--md kt-badge--rounded kt-badge--boldest">۰</span>
                                </span>
                                <span class="title-notif">تذاكر</span>


                                </span>

                            </div>
                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

                                <!--begin: Head -->
                                <div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
                                    <div style="color: #22b9ff;" class="kt-user-card__avatar fa fa-check-double">
                                        

                                        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                        <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold kt-hidden">S</span>
                                    </div>
                                    <div class="kt-user-card__name">
                                        تذاكر
                                    </div>
                                </div>

                                <!--end: Head -->

                                <!--begin: Navigation -->
                                <div class="kt-notification" id="" style="height: 600px; overflow: scroll;">
                                    
                                </div>

                                <!--end: Navigation -->
                            </div>
                        </div>
                        @endif
                        @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 26)->count() == 1)
                        <div class="kt-header__topbar-item dropdown">
                            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                                <span class="kt-header__topbar-icon kt-header__topbar-icon--warning">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect id="bound" x="0" y="0" width="24" height="24"/>
													<path d="M6.54246133,21.5014597 L8.1406184,15.5370564 C8.28356021,15.0035903 8.83189716,14.6870078 9.36536327,14.8299496 C9.89882937,14.9728914 10.2154119,15.5212284 10.07247,16.0546945 L8.47431299,22.0190978 C8.33137118,22.5525639 7.78303422,22.8691464 7.24956812,22.7262046 C6.71610201,22.5832628 6.39951952,22.0349258 6.54246133,21.5014597 Z M17.4495897,21.4711096 C17.5925315,22.0045757 17.275949,22.5529126 16.7424829,22.6958545 C16.2090168,22.8387963 15.6606799,22.5222138 15.517738,21.9887477 L14.2148496,17.126302 C14.0719078,16.5928359 14.3884903,16.0444989 14.9219564,15.9015571 C15.4554225,15.7586153 16.0037595,16.0751978 16.1467013,16.6086639 L17.4495897,21.4711096 Z" id="Combined-Shape" fill="#000000" opacity="0.3"/>
													<path d="M7.36092084,1 L16.6390792,1 C17.7436487,1 18.6390792,1.8954305 18.6390792,3 C18.6390792,3.11016172 18.6299775,3.22013512 18.611867,3.32879797 L17.0696334,12.5821995 C17.0294511,12.8232935 16.820856,13 16.5764365,13 L7.42356354,13 C7.17914397,13 6.97054891,12.8232935 6.93036658,12.5821995 L5.388133,3.32879797 C5.20654289,2.23925733 5.94258223,1.20880226 7.03212287,1.02721215 C7.14078572,1.00910168 7.25075912,1 7.36092084,1 Z M5.5,14 L18.5,14 C19.3284271,14 20,14.6715729 20,15.5 C20,16.3284271 19.3284271,17 18.5,17 L5.5,17 C4.67157288,17 4,16.3284271 4,15.5 C4,14.6715729 4.67157288,14 5.5,14 Z" id="Combined-Shape" fill="#000000"/>
												</g>
											</svg>
											<span class="kt-nav__link-badge">
													<span id="waiters-count" class="kt-badge kt-badge--unified-danger kt-badge--md kt-badge--rounded kt-badge--boldest"></span>
                                </span>
                                <span class="title-notif">طابور الانتظار</span>


                                </span>

                            </div>
                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

                                <!--begin: Head -->
                                <div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
                                    <div class="kt-user-card__avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect id="bound" x="0" y="0" width="24" height="24"/>
															<path d="M6.54246133,21.5014597 L8.1406184,15.5370564 C8.28356021,15.0035903 8.83189716,14.6870078 9.36536327,14.8299496 C9.89882937,14.9728914 10.2154119,15.5212284 10.07247,16.0546945 L8.47431299,22.0190978 C8.33137118,22.5525639 7.78303422,22.8691464 7.24956812,22.7262046 C6.71610201,22.5832628 6.39951952,22.0349258 6.54246133,21.5014597 Z M17.4495897,21.4711096 C17.5925315,22.0045757 17.275949,22.5529126 16.7424829,22.6958545 C16.2090168,22.8387963 15.6606799,22.5222138 15.517738,21.9887477 L14.2148496,17.126302 C14.0719078,16.5928359 14.3884903,16.0444989 14.9219564,15.9015571 C15.4554225,15.7586153 16.0037595,16.0751978 16.1467013,16.6086639 L17.4495897,21.4711096 Z" id="Combined-Shape" fill="#000000" opacity="0.3"/>
															<path d="M7.36092084,1 L16.6390792,1 C17.7436487,1 18.6390792,1.8954305 18.6390792,3 C18.6390792,3.11016172 18.6299775,3.22013512 18.611867,3.32879797 L17.0696334,12.5821995 C17.0294511,12.8232935 16.820856,13 16.5764365,13 L7.42356354,13 C7.17914397,13 6.97054891,12.8232935 6.93036658,12.5821995 L5.388133,3.32879797 C5.20654289,2.23925733 5.94258223,1.20880226 7.03212287,1.02721215 C7.14078572,1.00910168 7.25075912,1 7.36092084,1 Z M5.5,14 L18.5,14 C19.3284271,14 20,14.6715729 20,15.5 C20,16.3284271 19.3284271,17 18.5,17 L5.5,17 C4.67157288,17 4,16.3284271 4,15.5 C4,14.6715729 4.67157288,14 5.5,14 Z" id="Combined-Shape" fill="#000000"/>
														</g>
													</svg>

                                        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                        <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold kt-hidden">S</span>
                                    </div>
                                    <div class="kt-user-card__name">
                                        بیماران در حال انتظار
                                    </div>
                                </div>

                                <!--end: Head -->

                                <!--begin: Navigation -->
                                <div class="kt-notification" id="waiting" style="height: 600px; overflow: scroll;">
                                    
                                </div>

                                <!--end: Navigation -->
                            </div>
                        </div>
                        @endif

                        @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 27)->count() == 1)
                        <div class="kt-header__topbar-item dropdown">
                            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                                <span class="kt-header__topbar-icon kt-header__topbar-icon--warning">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect id="bound" opacity="0.300000012" x="0" y="0" width="24" height="24"/>
														<polygon id="Path-90" fill="#000000" fill-rule="nonzero" opacity="0.3" points="7 4.89473684 7 21 5 21 5 3 11 3 11 4.89473684"/>
														<path d="M10.1782982,2.24743315 L18.1782982,3.6970464 C18.6540619,3.78325557 19,4.19751166 19,4.68102291 L19,19.3190064 C19,19.8025177 18.6540619,20.2167738 18.1782982,20.3029829 L10.1782982,21.7525962 C9.63486295,21.8510675 9.11449486,21.4903531 9.0160235,20.9469179 C9.00536265,20.8880837 9,20.8284119 9,20.7686197 L9,3.23140966 C9,2.67912491 9.44771525,2.23140966 10,2.23140966 C10.0597922,2.23140966 10.119464,2.2367723 10.1782982,2.24743315 Z M11.9166667,12.9060229 C12.6070226,12.9060229 13.1666667,12.2975724 13.1666667,11.5470105 C13.1666667,10.7964487 12.6070226,10.1879981 11.9166667,10.1879981 C11.2263107,10.1879981 10.6666667,10.7964487 10.6666667,11.5470105 C10.6666667,12.2975724 11.2263107,12.9060229 11.9166667,12.9060229 Z" id="Combined-Shape" fill="#000000"/>
													</g>
												</svg>
												<span class="kt-nav__link-badge">
														<span class="kt-badge kt-badge--unified-warning kt-badge--md kt-badge--rounded kt-badge--boldest" id="in-office"></span>
                                </span>
                                <span class="title-notif">داخل المكتب</span>


                                </span>

                            </div>
                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

                                <!--begin: Head -->
                                <div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
                                    <div class="kt-user-card__avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																<rect id="bound" opacity="0.300000012" x="0" y="0" width="24" height="24"/>
																<polygon id="Path-90" fill="#000000" fill-rule="nonzero" opacity="0.3" points="7 4.89473684 7 21 5 21 5 3 11 3 11 4.89473684"/>
																<path d="M10.1782982,2.24743315 L18.1782982,3.6970464 C18.6540619,3.78325557 19,4.19751166 19,4.68102291 L19,19.3190064 C19,19.8025177 18.6540619,20.2167738 18.1782982,20.3029829 L10.1782982,21.7525962 C9.63486295,21.8510675 9.11449486,21.4903531 9.0160235,20.9469179 C9.00536265,20.8880837 9,20.8284119 9,20.7686197 L9,3.23140966 C9,2.67912491 9.44771525,2.23140966 10,2.23140966 C10.0597922,2.23140966 10.119464,2.2367723 10.1782982,2.24743315 Z M11.9166667,12.9060229 C12.6070226,12.9060229 13.1666667,12.2975724 13.1666667,11.5470105 C13.1666667,10.7964487 12.6070226,10.1879981 11.9166667,10.1879981 C11.2263107,10.1879981 10.6666667,10.7964487 10.6666667,11.5470105 C10.6666667,12.2975724 11.2263107,12.9060229 11.9166667,12.9060229 Z" id="Combined-Shape" fill="#000000"/>
															</g>
														</svg>

                                        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                        <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold kt-hidden">S</span>
                                    </div>
                                    <div class="kt-user-card__name">
                                        داخل المكتب
                                    </div>
                                </div>

                                <!--end: Head -->

                                <!--begin: Navigation -->
                                <div class="kt-notification" id="office" style="height: 600px; overflow: scroll;">
                                    
                                </div>
                                <!--end: Navigation -->
                            </div>
                        </div>
                        @endif

                        @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 28)->count() == 1)

                        <div class="kt-header__topbar-item dropdown">
                            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                                <span class="kt-header__topbar-icon kt-header__topbar-icon--warning">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect id="bound" x="0" y="0" width="24" height="24"/>
															<rect id="Combined-Shape" fill="#000000" opacity="0.3" x="2" y="3" width="20" height="18" rx="2"/>
															<path d="M9.9486833,13.3162278 C9.81256925,13.7245699 9.43043041,14 9,14 L5,14 C4.44771525,14 4,13.5522847 4,13 C4,12.4477153 4.44771525,12 5,12 L8.27924078,12 L10.0513167,6.68377223 C10.367686,5.73466443 11.7274983,5.78688777 11.9701425,6.75746437 L13.8145063,14.1349195 L14.6055728,12.5527864 C14.7749648,12.2140024 15.1212279,12 15.5,12 L19,12 C19.5522847,12 20,12.4477153 20,13 C20,13.5522847 19.5522847,14 19,14 L16.118034,14 L14.3944272,17.4472136 C13.9792313,18.2776054 12.7550291,18.143222 12.5298575,17.2425356 L10.8627389,10.5740611 L9.9486833,13.3162278 Z" id="Path-108" fill="#000000" fill-rule="nonzero"/>
															<circle id="Oval" fill="#000000" opacity="0.3" cx="19" cy="6" r="1"/>
														</g>
													</svg>
													<span class="kt-nav__link-badge">
															<span class="kt-badge kt-badge--unified-warning kt-badge--md kt-badge--rounded kt-badge--boldest" id="in-release"></span>
                                </span>
                                 <span class="title-notif">ترخیص شده</span>


                                </span>

                            </div>
                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

                                <!--begin: Head -->
                                <div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
                                    <div class="kt-user-card__avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect id="bound" x="0" y="0" width="24" height="24"/>
																	<rect id="Combined-Shape" fill="#000000" opacity="0.3" x="2" y="3" width="20" height="18" rx="2"/>
																	<path d="M9.9486833,13.3162278 C9.81256925,13.7245699 9.43043041,14 9,14 L5,14 C4.44771525,14 4,13.5522847 4,13 C4,12.4477153 4.44771525,12 5,12 L8.27924078,12 L10.0513167,6.68377223 C10.367686,5.73466443 11.7274983,5.78688777 11.9701425,6.75746437 L13.8145063,14.1349195 L14.6055728,12.5527864 C14.7749648,12.2140024 15.1212279,12 15.5,12 L19,12 C19.5522847,12 20,12.4477153 20,13 C20,13.5522847 19.5522847,14 19,14 L16.118034,14 L14.3944272,17.4472136 C13.9792313,18.2776054 12.7550291,18.143222 12.5298575,17.2425356 L10.8627389,10.5740611 L9.9486833,13.3162278 Z" id="Path-108" fill="#000000" fill-rule="nonzero"/>
																	<circle id="Oval" fill="#000000" opacity="0.3" cx="19" cy="6" r="1"/>
																</g>
															</svg>

                                        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                        <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold kt-hidden">S</span>
                                    </div>
                                    <div class="kt-user-card__name">
                                         ترخیص شده
                                    </div>
                                </div>

                                <!--end: Head -->

                                <!--begin: Navigation -->
                                <div class="kt-notification" id="release" style="height: 600px; overflow: scroll;">
                                    
                                </div>

                                <!--end: Navigation -->
                            </div>
                        </div>
                        @endif

                        @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 25)->count() == 1)
                        <div class="kt-header__topbar-item dropdown">
                            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                                <span class="kt-header__topbar-icon kt-header__topbar-icon--warning">
														<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																<rect id="bound" x="0" y="0" width="24" height="24"/>
																<path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" id="Combined-Shape" fill="#000000" opacity="0.3"/>
																<path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" id="check-path" fill="#000000"/>
																<path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" id="Combined-Shape" fill="#000000"/>
															</g>
														</svg>
														<span class="kt-nav__link-badge">
																<span class="kt-badge kt-badge--unified-success kt-badge--md kt-badge--rounded kt-badge--boldest" id="in-therapist"></span>
                                </span>
                                <span class="title-notif">الخدمات السريرية </span>


                                </span>

                            </div>
                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

                                <!--begin: Head -->
                                <div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
                                    <div class="kt-user-card__avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect id="bound" x="0" y="0" width="24" height="24"/>
																		<path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" id="Combined-Shape" fill="#000000" opacity="0.3"/>
																		<path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" id="check-path" fill="#000000"/>
																		<path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" id="Combined-Shape" fill="#000000"/>
																	</g>
																</svg>

                                        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                        <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold kt-hidden">S</span>
                                    </div>
                                    <div class="kt-user-card__name">
                                        الخدمات السريرية 
                                    </div>
                                </div>

                                <!--end: Head -->

                                <!--begin: Navigation -->
                                <div class="kt-notification" id="therapist" style="height: 600px; overflow: scroll;">
                                    
                                </div>

                                <!--end: Navigation -->
                            </div>
                        </div>
                        @endif
                        <!--end: Quick actions -->

                        <!--begin: User bar -->
                        <div class="kt-header__topbar-item kt-header__topbar-item--user">
                            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                                <span class="kt-hidden kt-header__topbar-welcome">Hi,</span>
                                <span class="kt-hidden kt-header__topbar-username">Nick</span>
                                <img class="kt-hidden" alt="Pic" src="{{ url('new/assets/media/users/300_21.jpg') }}" />
                                <span class="kt-header__topbar-icon"><i class="flaticon2-user-outline-symbol"></i></span>
                            </div>
                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

                                <!--begin: Head -->
                                <div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
                                    <div class="kt-user-card__avatar">

                                        <img src="{{ url('uploads/'.\App\Models\User::find(\Session::get('user_id'))->profile_image) }}">

                                        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                        <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold kt-hidden">S</span>
                                    </div>
                                    <div class="kt-user-card__name">
                                       {{ \Session::get('name') }}
                                    </div>

                                </div>

                                <!--end: Head -->

                                <!--begin: Navigation -->
                                <div class="kt-notification">
                                    {{-- <a href="prescriptions.html" class="kt-notification__item">
                                        <div class="kt-notification__item-icon">
                                            <i class="flaticon2-calendar-3"></i>
                                        </div>
                                        <div class="kt-notification__item-details">
                                            <div class="kt-notification__item-title kt-font-bold">
                                                ویرایش مشخصات
                                            </div>
                                            <div class="kt-notification__item-time">
                                                تغییر مشخصات، رمز عبور و ...
                                            </div>
                                        </div>
                                    </a> --}}

                                    <div class="kt-notification__custom kt-space-between">
                                        <a href="{{ url('users/'.\Session::get('user_id').'/edit') }}" target="_blank" class="btn btn-label btn-label-success btn-sm btn-bold">تعديل الملف الشخصي</a>
                                        <a href="{{ url('logout') }}" target="_blank" class="btn btn-label btn-label-danger btn-sm btn-bold">تسجيل خروج</a>
                                    </div>
                                </div>

                                <!--end: Navigation -->
                            </div>
                        </div>

                        <!--end: User bar -->


                    </div>

                    <!-- end:: Header Topbar -->
                </div>

                <!-- end:: Header -->
                <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

                    <!-- begin:: Content -->
                    @yield('content')
                    <!-- end:: Content -->
                </div>
                </div>

                <!-- begin:: Footer -->
                <div class="kt-footer  kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
                    <div class="kt-container  kt-container--fluid ">
                        <div class="kt-footer__copyright">
                            ۱۳۹۹&nbsp;&copy;&nbsp;<a href="{{ url('about') }}" target="_blank" class="kt-link">کیمیاطب</a>
                        </div>
                        <div class="kt-footer__menu">
                            <a href="{{ url('about') }}" target="_blank" class="kt-footer__menu-link kt-link">معلومات عن کیمیاطب</a>
                            
                        </div>
                    </div>
                </div>

                <!-- end:: Footer -->
            </div>
        </div>
    </div>

    <!-- end:: Page -->



    <!-- begin::Scrolltop -->
    <div id="kt_scrolltop" class="kt-scrolltop">
        <i class="fa fa-arrow-up"></i>
    </div>

    <!-- end::Scrolltop -->


    <!-- begin::Global Config(global config for global JS sciprts) -->
    <script>
        var KTAppOptions = {
            "colors": {
                "state": {
                    "brand": "#22b9f8",
                    "light": "#ffffff",
                    "dark": "#282a3c",
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

    <!-- end::Global Config -->


    <!--begin:: Global Mandatory Vendors -->

    <script src="{{ url('new/assets/vendors/general/jquery/dist/jquery.js') }}" type="text/javascript"></script>
    <script src="{{ url('new/assets/vendors/general/popper.js/dist/umd/popper.js') }}" type="text/javascript"></script>
    <script src="{{ url('new/assets/vendors/general/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('new/assets/vendors/general/js-cookie/src/js.cookie.js') }}" type="text/javascript"></script>

    <!--end:: Global Mandatory Vendors -->





    <!--begin:: Global Optional Vendors -->
    <script src="{{ url('new/assets/vendors/general/raphael/raphael.js') }}" type="text/javascript"></script>
    <script src="{{ url('new/assets/vendors/general/morris.js/morris.js') }}" type="text/javascript"></script>
    <script src="{{ url('new/assets/vendors/general/chart.js/dist/Chart.bundle.js') }}" type="text/javascript"></script>
    <!--end:: Global Optional Vendors -->

    <script src="{{ url('new/assets/vendors/general/markdown/lib/markdown.js') }}" type="text/javascript"></script>
    <script src="{{ url('new/assets/vendors/general/bootstrap-markdown/js/bootstrap-markdown.js') }}" type="text/javascript"></script>
    <script src="{{ url('new/assets/vendors/custom/js/vendors/bootstrap-markdown.init.js') }}" type="text/javascript"></script>

    <script src="{{ url('new/assets/js/scripts.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ url('new/assets/js/chosen.jquery.js') }}" type="text/javascript"></script>
    
        <script src="{{ url('assets/vendors/base/modal.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/timepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>

    <!--end::Global Theme Bundle -->



    <script src="{{ url('new/assets/js/kamadatepicker.min.js') }}"></script>
    <script src="{{ url('assets/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
    <script src="{{ url('new/assets/vendors/general/select2/dist/js/select2.full.js') }}" type="text/javascript"></script>

    <!--begin::Page Scripts(used by this page) -->
    <script src="{{ url('new/assets/js/dashboard.js') }}" type="text/javascript"></script>
    <script src="{{ url('new/assets/js/select2.js') }}" type="text/javascript"></script>

    <script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'fa', 
            includedLanguages: 'ar', 
            autoDisplay: false
        }, 'google_translate_element');
        var a = document.querySelector("#translate");
        a.selectedIndex=1;
        a.dispatchEvent(new Event('change'));
    }
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
    @yield('scripts')

    <script>

            $(document).on('mouseover','#translate', function() {
                $(".goog-te-banner-frame").hide();
            });
            $(document).ready(function() {
                $('.selectbox').select2();
            });

            $(document).ready(function() {
                $('.selectbox2').select2();
            });

            $(".selectbox").select2({
              dir: "rtl"
            });

            $(".selectbox2").select2({
              dir: "rtl"
            });

            $(".selectbox3").select2({
              dir: "rtl"
            });

            $(".selectbox4").select2({
              dir: "rtl"
            });

            $(".selectbox5").select2({
              dir: "rtl"
            });

            $(".selectbox6").select2({
              dir: "rtl"
            });

            $(".selectbox7").select2({
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
            getWaiters();
        }, 6000);

        function getWaiters(){
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
            getWaiters();
        });

        $(document).on('keydown', '#search', function(e){
            if(e.which == 13) {

            $.ajax({
                url: "{!! url('search') !!}",
                type: "post",
                data: {
                    q: $("#search").val(),
                },
                success: function (data) {
                    $("#results").css("height","500px");
                    $("#results").css("overflow","scroll");
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

        <script>

         window.setInterval(function(){
            getTherapist();
        }, 6000);

         window.setInterval(function(){
            getRelease();
        }, 6000);

        function getTherapist(){
           $.ajax({
                url: "{!! url('turns/load-therapist') !!}",
                type: "post",
                data: {
                    x: 1,
                },
                success: function (data) {
                    data = data.split("|");
                    $("#therapist").html(data[0]);
                    $("#in-therapist").html(data[1]);
                }
            });
        }
        $(document).ready(function() {
            getTherapist();
        }) 

        function getRelease(){
           $.ajax({
                url: "{!! url('turns/load-release') !!}",
                type: "post",
                data: {
                    x: 1,
                },
                success: function (data) {
                    data = data.split("|");
                    $("#release").html(data[0]);
                    $("#in-release").html(data[1]);
                }
            });
        }
        $(document).ready(function() {
            getRelease();
        })
        </script>

        <script>

        window.setInterval(function(){
            getOnlineUsers();
        }, 6000);    

        function getOnlineUsers(){
           $.ajax({
                url: "{!! url('online-users') !!}",
                type: "post",
                data: {
                    x: 1,
                },
                success: function (data) {
                    data = data.split("|");
                    $("#online-users").html(data[0]);
                    $("#online-count").html(data[1]);
                }
            });
        }
        $(document).ready(function() {
            getOnlineUsers();
        })
        </script>

    <!--end::Page Scripts -->
</body>

<!-- end::Body -->

</html>