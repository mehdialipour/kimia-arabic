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

        <!--end::Page Vendors Styles -->
        <link rel="shortcut icon" href="{{ url('assets/logo.png') }}" />
    </head>

    <!-- end::Head -->

    <!-- begin::Body -->
    <body class="A5">

<div class="container" align="center" style="margin-top: 10%;">
	<h3>جزئیات صورتحساب <strong>{{ $patient_name }}</strong></h3>
	<hr>
	<?php $i=1; ?>
	<table class="table table-bordered" border="1" style="border: 1px solid #000 !important;">
		<thead style="border:1px solid #000 !important;">
			<tr align="center">
				<th style="border: 1px solid #000 !important;">#</th>
				<th style="border: 1px solid #000 !important;">نام خدمت</th>
				<th style="border: 1px solid #000 !important;">تعداد</th>
				<th style="border: 1px solid #000 !important;">مبلغ</th>
			</tr>
		</thead>
		<tbody>
			@foreach($services as $service)
				<tr align="center">
					<td style="border: 1px solid #000 !important;">{{ \App\Helpers\ConvertNumber::convertToPersian($i++) }}</td>
					<td style="border: 1px solid #000 !important;">
						{{ \App\Models\Service::find($service->service_id)->name }}
					</td>
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

						$tariff = number_format($tariff*$service->count);	
						?> 
						{{ \App\Helpers\ConvertNumber::convertToPersian($tariff) }} دینار
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<hr>
	<?php
	$amount = \App\Models\Invoice::where('turn_id', $turn_id)->first()->amount;
	$discount = \App\Models\Invoice::where('turn_id', $turn_id)->first()->discount;
	$total = $amount - $discount;
	?>
	<h5>جمع کل صورتحساب: {{ \App\Helpers\ConvertNumber::convertToPersian(number_format($amount)) }} دینار</h5>
	<h5>جمع کل تخفیف: {{ \App\Helpers\ConvertNumber::convertToPersian(number_format($discount)) }} دینار </h5>
	<hr>
	<h3><strong>مبلغ قابل پرداخت:<br><br>
		{{ \App\Helpers\ConvertNumber::convertToPersian(number_format( $total )) }} دینار
	</strong></h3>

	<br><br>
    
	<button class="btn btn-warning" onclick="window.close();">بستن x</button>
	<button class="btn btn-primary" onclick="window.print(); window.close();">پرینت <i class="fa fa-print"></i></button>
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

        

        <!--end::Page Scripts -->
    </body>

    <!-- end::Body -->
</html>