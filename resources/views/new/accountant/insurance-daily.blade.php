@extends('new.layout')
@section('title')

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
			<h4>جزئیات صندوق امروز به تفکیک بیمه</h4><br>

			<div class="table-responsive">	
				<table class="table table-bordered" id="table-insurance" width="99%">
					<thead>
						<tr align="center" class="table-success">
							<th>
								#
							</th>
							<th>
								نام بیمه
							</th>
							<th>
								تعداد مراجعین
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
						@foreach($insurances as $row)

						@php
							$tariff = 0;
							$count = 0;
							$discount = 0;
							foreach($query as $key) {
								if($key->insurance_id == $row->id) {
									$tariff += \DB::table('insurance_service')->where('insurance_id', $row->id)->where('service_id', $key->service_id)->first()->tariff*$key->count;
									$count+=1;
									if($key->discount >0)
									$discount+=$key->discount;
								}
							}
						@endphp
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
								{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($tariff)) }} دینار
							</td>

							<td>
								{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($discount )) }} دینار
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop