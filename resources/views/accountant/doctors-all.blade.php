@extends('new.layout')
@section('title')
صندوق امروز به تفکیک پزشک
@stop

@section('content')
	<div class="m-content" style="width: 100%; background-color: white;">
		<div class="col-md-12">

			<form action="{{ url('fund/doctors-detail') }}" method="GET">
					
			<h4>جستجو</h4><br>
			<div class="row">

					<div class="col-md-2">
						<select class="form-control selectbox" name="user_id">
							@foreach($nurses as $n) 
								<option value="{{ $n->id }}">{{ \App\Models\Role::find($n->role_id)->title }} {{ $n->name }}</option>
							@endforeach
						</select>
					</div>

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

			@if(request('user_id'))
			<h4>{{ $name }}</h4><br>

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
							نام خدمت
						</th>

						<th>
							پزشک معالج
						</th>
						<th>
							مبلغ
						</th>
					</tr>
				</thead>
				<?php $i=1; ?>
				<tbody>
					@foreach($query as $row)
					<tr align="center">
						<td>
							{{ \App\Helpers\ConvertNumber::convertToPersian($i++) }}
						</td>
						<td>
							{{ $row->patient_name }}
						</td>
						<td>
							{{ $row->service_name }}
						</td>
						<td>
							دکتر {{ \App\Models\User::find($row->doctor_id)->name }}
						</td>
						<td>
							<?php
                            	$tariff = \DB::table('insurance_service')->where('insurance_id', $row->insurance_id)->where('service_id', $row->service_id)->first()->tariff;
                         	?>
                         {{ \App\Helpers\ConvertNumber::convertToPersian(number_format($tariff)) }} دینار
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@endif
			
		</div>
	</div>
@stop