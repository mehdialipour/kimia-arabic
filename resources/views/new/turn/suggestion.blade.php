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

<div class="container" id="invoice" align="center" style="margin-top: 10%;">
    <div class="inner-invoice">
    
	<?php $i=1; ?>
	<table class="table table-bordered" border="1" style="border: 1px solid #000 !important;">
		<thead style="border:1px solid #000 !important;">
			<tr align="center">
				<th style="border: 1px solid #000 !important;">#</th>
				<th style="border: 1px solid #000 !important;">پیشنهاد</th>
                <th style="border: 1px solid #000 !important;">تعداد</th>
				<th style="border: 1px solid #000 !important;">نوع</th>
				<th style="border: 1px solid #000 !important;">شرح</th>
			</tr>
		</thead>
		<tbody>
			@foreach($suggestions as $suggestion)
				<tr align="center">
					<td style="border: 1px solid #000 !important;">{{ \App\Helpers\ConvertNumber::convertToPersian($i++) }}</td>
					<td style="border: 1px solid #000 !important;">
						{{ $suggestion->service }}
					</td>
					<td style="border: 1px solid #000 !important;">
						{{ \App\Helpers\ConvertNumber::convertToPersian($suggestion->count) }}
					</td>


                    <td style="border: 1px solid #000 !important;">{{ $suggestion->type }}</td>

                    <td style="border: 1px solid #000 !important;">{{ $suggestion->description }}</td>
					
				</tr>
            @endforeach
		</tbody>
	</table>
    <br><br>
    
	<button class="btn btn-warning no-print" onclick="window.close();">بستن x</button>
	
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
        

        

        <!--end::Page Scripts -->
    </body>

    <!-- end::Body -->
</html>
