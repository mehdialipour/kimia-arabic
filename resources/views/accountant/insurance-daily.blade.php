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
							مجموع امروز صندوق
						</th>
						<th>
							مجموع کل صندوق تا امروز
						</th>
					</tr>
				</thead>
				<tbody>
					
					<tr align="center">
						<td>
							{{ $sum_today }} دینار
						</td>
						<td>
							{{ $sum_all }} دینار
						</td>
						
					</tr>

				
				</tbody>
			</table>
			<br><br>

			<h4>جزئیات صندوق امروز به تفکیک بیمه</h4><br>

			<table class="table table-bordered" id="" width="99%">
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
					<tr align="center">
						<td>
							{{ \App\Helpers\ConvertNumber::convertToPersian($i++) }}
						</td>
						<td>
							{{ $row->name }}
						</td>
						<td>
							{{\App\Helpers\ConvertNumber::convertToPersian($count[$row->id])}}
						</td>
						<td>
							{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($sum[$row->id] )) }} دینار
						</td>

						<td>
							{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($discount[$row->id] )) }} دینار
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop