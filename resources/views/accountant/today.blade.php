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
					</tr>
				</thead>
				<tbody>
					
					<tr align="center">
						<td>
							{{ $sum_today }} دینار
						</td>
						
					</tr>

				
				</tbody>
			</table>
			<br><br>

			<h4>جزئیات صندوق امروز</h4><br>

			<table class="table table-bordered" id="" width="99%">
				<thead>
					<tr align="center" class="table-success">
						<th>
							#
						</th>
						<th>
							نام بیمار
						</th>
						<th>
							مبلغ پرداختی
						</th>
						<th>
							تخفیف
						</th>
					</tr>
				</thead>
				<?php $i=0; ?>
				<tbody>
					@foreach($query as $row)
					<tr align="center">
						<td>
							{{ $i++ }}
						</td>
						<td>
							{{ $row->reception->patients[0]->name }}
						</td>
						<td>
							{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($row->invoice['amount'] )) }} دینار
						</td>

						<td>
							{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($row->invoice['discount'] )) }} دینار
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop