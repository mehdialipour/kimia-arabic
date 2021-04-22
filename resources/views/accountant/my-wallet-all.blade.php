@extends('new.layout')
@section('title')

@stop

@section('content')
	<div class="m-content" style="width: 100%; background-color: white;">
		<div class="col-md-12">

				<form action="{{ url('my-wallet') }}" method="post">
					@csrf
			<h4>انتخاب تاریخ</h4><br>
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
					<hr>
						<h4 align="center">جزئیات صندوق از تاریخ {{ $jalali_from }} ساعت {{ $from_time }} تا تاریخ {{ $jalali_to }} ساعت {{ $to_time }} به تفکیک خدمت</h4><br>

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
				<?php $i=1; $sum_all=0; $discount_all=0; $count_all=0;?>
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
					<?php $sum_all+=$tariff; $discount_all+=$discount; $count_all+=$count;?>
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
			<br>
			<hr>
			<br>
			<table class="table table-bordered" id="" width="99%">
								<thead>
									<tr align="center" class="table-success">
										<th>
											تعداد کل خدمات ارائه شده
										</th>
										<th>
											مجموع کل پرداختی
										</th>
										<th>
											مجموع تخفیف
										</th>
									</tr>
								</thead>
								<tbody>
									
									<tr align="center">
										<td>
											{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($count_all)) }} 
										</td>
										<td>
											{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($sum_all)) }} دینار
										</td>
										<td>
											{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($discount_all)) }} دینار
										</td>
										
									</tr>

								
								</tbody>
							</table>

		</form>
			
		</div>
	</div>
@stop