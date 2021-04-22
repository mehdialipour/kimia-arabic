@extends('new.layout')
@section('title')

@stop

@section('content')
	<div class="m-content" style="width: 100%; background-color: white;">
		<div class="col-md-12">

				<form action="{{ url('insurance-all') }}" method="post">
					@csrf
			<h4>انتخاب تاریخ</h4><br>
			<div class="row">
					<div class="col-md-2">
						<input type="text" name="from" placeholder="از تاریخ..." class="form-control m-input" id="datepicker" autocomplete="off">
					</div>

					<div class="col-md-2">
						<input type="text" name="to" placeholder="تا تاریخ..." class="form-control m-input" id="datepicker2" autocomplete="off">
					</div>	

					<div class="col-md-2">
						<input type="submit" class="btn btn-primary" value="مشاهده">
					</div>	

			</div>

					@if(isset($sum))
					<hr>
						<h4 align="center">جزئیات صندوق از تاریخ {{ $jalali_from }} تا تاریخ {{ $jalali_to }} به تفکیک بیمه</h4><br>

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
											{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($count[$row->id] )) }}
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

							<table class="table table-bordered" id="" width="99%">
								<thead>
									<tr align="center" class="table-success">
										<th>
											تعداد کل مراجعین
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
											{{ $count_all }} نفر
										</td>
										<td>
											{{ $sum_all }} دینار
										</td>
										<td>
											{{ $discount_all }} دینار
										</td>
										
									</tr>

								
								</tbody>
							</table>
					@endif
		</form>
			
		</div>
	</div>
@stop