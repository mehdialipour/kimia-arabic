@extends('new.layout')
@section('title')
صندوق امروز به تفکیک خدمات
@stop

@section('styles')
<style>
	@media print {

    #kt_header,
    #kt_footer,
    #kt_aside,
    .col-xl-3.col-lg-3.order-lg-1.order-xl-1,
    #kt_scrolltop{

        display: none;
    }

    #kt_content {
        padding-top: 0;
    }
    
    
    
}
@media (min-width: 599px) and (max-width: 1300px) {

    #future-turns {

        flex: 0 0 50%;
        max-width: 50%;
        text-align: center;
    }

    #patients-table {

        width: 150%;
    }

}

</style>
@stop
@section('content')

	<div class="m-content" style="width: 100%; background-color: white;">
		<div class="col-md-12">

			<h4>صندوق</h4><br>
			<table class="table table-bordered" id="" width="99%">
				<thead>
					<tr align="center" class="table-success">
						<th>
							دریافتی امروز
						</th>
						<th>
							مجموع تخفیف‌ها
						</th>

						<th>
							صندوق امروز
						</th>
					</tr>
				</thead>
				<tbody>
					
					<tr align="center">
						<td>
							{{ $sum_today }} دینار 
						</td>
						<td>
							{{ $discount }} دینار
						</td>
						<td>
							{{ $total }} دینار
						</td>
						
					</tr>

				
				</tbody>
			</table>
			<br><br>
			<form action="{{ url('fund/services-detail') }}" method="post">
					@csrf
			<h4>انتخاب تاریخ ()</h4><br>
			<div class="row">
					<div class="col-md-2">
						<input type="text" name="from" placeholder="از تاریخ..." class="form-control m-input" id="datepicker" autocomplete="off">
					</div>

					<div class="col-md-2">
						<input type="time" value="03:00" name="from_time" class="form-control m-input">
					</div>


					<div class="col-md-2">
						<input type="text" name="to" placeholder="تا تاریخ..." class="form-control m-input" id="datepicker2" autocomplete="off">
					</div>	

					<div class="col-md-2">
						<input type="time" value="23:59" name="to_time" class="form-control m-input">
					</div>

					<div class="col-md-2">
						<input type="submit" class="btn btn-primary" value="مشاهده">
					</div>	

			</div>
			<br><br>
			<h4>جزئیات صندوق امروز به تفکیک خدمات</h4><br>

			<table class="table table-bordered" id="" width="99%">
				<thead>
					<tr align="center" class="table-success">
						<th>
							#
						</th>
						<th>
							نام خدمت
						</th>
						<th>
							تعداد انجام خدمت
						</th>
						<th>
							مبلغ پرداختی
						</th>
						<th>
							تخفیف
						</th>
					</tr>
				</thead>
				<?php $i=1; ?>
				<tbody>
					@foreach($services as $row)
					@php
						$tariff = 0;
						$count = 0;
						$discount = 0;
						foreach($query as $key) {
							if($key->service_id == $row->id) {
								$tariff += \DB::table('insurance_service')->where('insurance_id', $key->insurance_id)->where('service_id', $row->id)->first()->tariff*$key->count;
								$count+=$key->count;
								if($key->discount >0)
								$discount+=$key->discount;
							}
						}
					@endphp
					@if($count > 0)
					<tr align="center">
						<td>
							{{ \App\Helpers\ConvertNumber::convertToPersian($i++) }}
						</td>
						<td>
							{{ $row->name }}
						</td>
						<td>
							{{\App\Helpers\ConvertNumber::convertToPersian($count)}}
						</td>
						<td>
							{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($tariff )) }} دینار
						</td>

						<td>
							{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($discount)) }} دینار
						</td>
					</tr>
					@endif
					@endforeach
				</tbody>
			</table>


		</div>
	</div>
@stop