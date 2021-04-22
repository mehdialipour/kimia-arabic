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
        <style>@page { size: A5 }</style>
        <meta charset="utf-8" />
        <title>صورتحساب {{ $patient_name }}</title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

        <!--begin::Web font -->
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script> --}}
        

        <!--end::Web font -->

        <!--begin::Global Theme Styles -->
        <!-- <link href="assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" /> -->
        <link href="{{ url('assets/vendors/base/print.css') }}" rel="stylesheet" type="text/css" />
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

        <link href="{{ url('assets/vendors/base/modal.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/timepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('new/assets/styles/invoice.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('new/assets/styles/new-invoice.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('new/assets/styles/print-chrome.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Page Vendors Styles -->
        <link rel="shortcut icon" href="{{ url('new/assets/Images/logo.png') }}" />
        <style>
            @media print
        {    
            .no-print, .no-print *
            {
                display: none !important;
            }
        }
        </style>
    </head>

    <!-- end::Head -->

    <!-- begin::Body -->
    <body class="A5">
        <?php ?>
<?php $discount = \DB::table('service_turn')->where('turn_id', $turn_id)->sum('discount');
      $debt = \DB::table('service_turn')->where('turn_id', $turn_id)->sum('debt');  
?>
<div class="container" id="invoice" align="center" style="margin-top: 10%;">
    <div class="inner-invoice">
        <?php $time = \App\Helpers\ConvertDate::today(date("Y-m-d")).' - '.date("H:i:s"); ?>
    <p align="center">{{ \App\Helpers\ConvertNumber::convertToPersian($time) }}</p>    
    <h5>به {{ $settings->name }} خوش آمدید</h5>
    <hr>
    <h5>جزئیات صورتحساب <strong>{{ $patient_name }}</strong></h5>
    <hr>
    <?php $i=1; ?>
    <table class="table table-bordered" border="1" style="border: 1px solid #000 !important;">
        <thead style="border:1px solid #000 !important;">
            <tr align="center">
                <th style="border: 1px solid #000 !important;">#</th>
                <th style="border: 1px solid #000 !important;">نام خدمت</th>
                <th style="border: 1px solid #000 !important;">خدمت دهنده</th>
                <th style="border: 1px solid #000 !important;">تعداد</th>
                <th style="border: 1px solid #000 !important;">مبلغ</th>
                <th style="border: 1px solid #000 !important;">وضعیت</th>
            </tr>
        </thead>
        <tbody>
            <?php $paid=0; ?>
            @foreach($paid_services as $service)
                <tr align="center">
                    <td style="border: 1px solid #000 !important;">{{ \App\Helpers\ConvertNumber::convertToPersian($i++) }}</td>
                    <td style="border: 1px solid #000 !important;">
                        {{ \App\Models\Service::find($service->service_id)->name }}
                    </td>
                    <td style="border: 1px solid #000 !important;">{{ \App\Models\User::find($service->user_id)->name }}</td>
                    <td style="border: 1px solid #000 !important;">
                        {{ \App\Helpers\ConvertNumber::convertToPersian($service->count) }}
                    </td>
                    <td style="border: 1px solid #000 !important;">
                        <?php
                        $tariff = \DB::table('insurance_service')
                            ->where('service_id',$service->service_id)
                            ->where('insurance_id',$patient_insurance_id)
                            ->first()
                            ->tariff; 
                        $paid+=$tariff*$service->count;
                        $tariff = number_format($tariff*$service->count);   
                        
                        ?> 
                        {{ \App\Helpers\ConvertNumber::convertToPersian($tariff) }} دینار
                    </td>
                    <td class="text-success" style="border: 1px solid #000 !important;">
                        پرداخت شده
                    </td>
                </tr>
            @endforeach
            <?php $unpaid = 0; ?>
            @foreach($unpaid_services as $service)
                <tr align="center">
                    <td style="border: 1px solid #000 !important;">{{ \App\Helpers\ConvertNumber::convertToPersian($i++) }}</td>
                    <td style="border: 1px solid #000 !important;">
                        {{ \App\Models\Service::find($service->service_id)->name }}
                    </td>
                    <td style="border: 1px solid #000 !important;">{{ \App\Models\User::find($service->user_id)->name }}</td>
                    <td style="border: 1px solid #000 !important;">
                        {{ \App\Helpers\ConvertNumber::convertToPersian($service->count) }}
                    </td>
                    <td style="border: 1px solid #000 !important;">
                        <?php
                        $tariff = \DB::table('insurance_service')
                            ->where('service_id',$service->service_id)
                            ->where('insurance_id',$patient_insurance_id)
                            ->first()
                            ->tariff; 
                        $unpaid+=$tariff*$service->count;
                        $tariff = number_format($tariff*$service->count);   
                        
                        ?> 
                        {{ \App\Helpers\ConvertNumber::convertToPersian($tariff) }} دینار
                    </td>
                    <td style="border: 1px solid #000 !important;" class="text-danger">
                        پرداخت نشده
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if(request('service_turn_id'))
    <?php
            $new_discount = \DB::table('service_turn')->where('id', request('service_turn_id'))->first();
        ?>
    @if(\DB::table('service_turn')->where('id',request('service_turn_id'))->first()->paid == 1)
        @if(request('service_turn_id') && \DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 31)->count() == 1)
        
        <input type="hidden"  name="" id="service_turn_id" value="{{ request('service_turn_id') }}">
        <hr>
        <p align="center" class="no-print"><strong>تخفیف</strong></p>
        <div class="form-group row no-print" align="center">
            <div class="col-lg-3">
                <input type="text" @if($new_discount->discount >= 0) value="{{ number_format($new_discount->discount) }}" @else value="0" @endif placeholder="تخفیف به دینار" id="discount" class="form-control format">
            </div>
        </div>

        <div class="form-group row no-print" align="center">
            <div class="col-lg-3">
                <input type="text" placeholder="توضیح" id="description" value="{{ $new_discount->description }}" class="form-control">
            </div>
        </div>
        @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 58)->count() == 1)
            <hr class="no-print">

            <p align="center" class="no-print"><strong>ثبت بدهی</strong></p>
            <div class="form-group row no-print" align="center">
                <div class="col-lg-3">
                    <input type="text" @if($new_discount->debt >= 0) value="{{ number_format($new_discount->debt) }}" @else value="0" @endif placeholder="مبلغ بدهی به دینار" id="debt" class="form-control format">
                </div>
            </div>
        @endif    
        

        @endif
       @endif 

    <hr>
    @endif
    <h5>
        @if(strpos($settings->printer, 'manager') !== false) 
            مدیر مرکز: {{ $settings->manager }} <br>
        @endif
        @if(strpos($settings->printer, 'phone') !== false) 
            تلفن: {{ $settings->phone }} <br>
        @endif
        @if(strpos($settings->printer, 'mobile') !== false) 
            موبایل: {{ $settings->mobile }} <br>
        @endif
        @if(strpos($settings->printer, 'address') !== false) 
            آدرس: {{ $settings->address }} <br>
        @endif
        @if(strpos($settings->printer, 'website') !== false) 
            وبسایت: {{ $settings->website }} <br>
        @endif
        @if(strpos($settings->printer, 'email') !== false) 
            ایمیل: {{ $settings->email }} <br>
        @endif
    </h5>
    <hr>
    @if(!is_null(\App\Models\Turn::find($turn_id)->user_id))
       <h5>ثبت کننده: {{ \App\Models\User::find(\App\Models\Turn::find($turn_id)->user_id)->name }}</h5>
    @endif
    @if(!is_null(\App\Models\Turn::find($turn_id)->doctor_id))
       <h5>پزشک معالج: {{ \App\Models\User::find(\App\Models\Turn::find($turn_id)->doctor_id)->name }}<h5>
    @endif   
    <hr>
    <h5>جمع کل صورتحساب: {{ \App\Helpers\ConvertNumber::convertToPersian(number_format($paid+$unpaid)) }} دینار</h5>
    <h5 class="text-success">مبلغ پرداخت شده: {{ \App\Helpers\ConvertNumber::convertToPersian(number_format($paid)) }} دینار</h5>
    <h5 class="text-danger">مبلغ پرداخت نشده: {{ \App\Helpers\ConvertNumber::convertToPersian(number_format($unpaid)) }} دینار</h5>
    @if(request('service_id'))
    <h5>@if($new_discount->discount >= 0) جمع کل تخفیف: {{ \App\Helpers\ConvertNumber::convertToPersian(number_format($new_discount->discount)) }} دینار  @else جمع کل افزایش قیمت:  {{ \App\Helpers\ConvertNumber::convertToPersian(number_format($discount*-1)) }} دینار @endif </h5>

    @if($new_discount->debt > 0)<h5> جمع کل بدهی: {{ \App\Helpers\ConvertNumber::convertToPersian(number_format($new_discount->debt)) }} دینار </h5> @endif
    <hr>
    <h5>مبلغ قابل پرداخت:<br><br>
        {{ \App\Helpers\ConvertNumber::convertToPersian(number_format( $paid+$unpaid-$new_discount->discount-$new_discount->debt )) }} دینار
    </h5>
    @else 
    <h5>@if($discount > 0) جمع کل تخفیف:  {{ \App\Helpers\ConvertNumber::convertToPersian(number_format($discount)) }} دینار  @else جمع کل افزایش قیمت:  {{ \App\Helpers\ConvertNumber::convertToPersian(number_format($discount)) }} دینار @endif</h5>
    @if($debt > 0)<h5> جمع کل بدهی: {{ \App\Helpers\ConvertNumber::convertToPersian(number_format($debt)) }} دینار </h5> @endif
    <hr>
    <h5>مبلغ قابل پرداخت:<br><br>
        {{ \App\Helpers\ConvertNumber::convertToPersian(number_format( $paid+$unpaid-$discount-$debt )) }} دینار
    </h5>
    @endif

    <br><br>
    @if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 30)->count() == 1)
                <a id="payment" href="{{ url('turns/'.$turn_id.'/money') }}" class="btn btn-success no-print">@if(!request('service_id'))پرداخت @else پرداخت و اعمال تخفیف @endif </a>
            
        @endif
    <button class="btn btn-warning no-print" onclick="window.close();">بستن x</button>
    <button class="btn btn-primary no-print" onclick="window.print(); window.close();">پرینت <i class="fa fa-print"></i></button>
      </div>
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
        <script src="{{ url('assets/vendors/base/modal.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/timepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <script src="{{ url('assets/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
        @yield('scripts')
        <script>

            $(document).ready(function(){
                $(".format").keyup(function(event){
                  // skip for arrow keys
                  if(event.which >= 37 && event.which <= 40){
                      event.preventDefault();
                  }
                  var $this = $(this);
                  var num = $this.val().replace(/,/gi, "").split("").reverse().join("");
                  
                  var num2 = RemoveRougeChar(num.replace(/(.{3})/g,"$1,").split("").reverse().join(""));
                  
                  console.log(num2);
                  
                  
                  // the following line has been simplified. Revision history contains original.
                  $this.val(num2);
              });
            });

            function RemoveRougeChar(convertString){
                
                
                if(convertString.substring(0,1) == ","){
                    
                    return convertString.substring(1, convertString.length)            
                    
                }
                return convertString;
                
            }


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
        </script>

        <script>

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
            $(document).on('click','#payment', function() {
                $.ajax({
                    url: "{!! url('turns/service-discount') !!}",
                    type: "post",
                    data: {
                        discount: $("#discount").val(),
                        description: $("#description").val(),
                        service_turn_id: $("#service_turn_id").val(),
                        debt: $("#debt").val()
                    },
                    success: function (data) {
                        
                    }
                });
            });
        </script>

        

        <!--end::Page Scripts -->
    </body>

    <!-- end::Body -->
</html>
