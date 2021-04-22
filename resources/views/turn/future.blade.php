@extends('layout')
@section('title')
نوبت‌ها
@stop

@section('content')

					
						
<div class="m-content" style="width: 100%; background-color: white;">
		@if($p > 1)
		<?php $x=$p-1; ?>
			<a href="{{ url('turns/future?p='.$x) }}" class="btn btn-info"><i class="fa fa-arrow-right"></i></a>
		@else
			<a href="{{ url('turns/future') }}" class="btn btn-info"><i class="fa fa-arrow-right"></i></a>
		@endif
		<?php $x = $p+1; ?>
		<button class="btn btn-info"> از تاریخ <strong>{{ \App\Helpers\ConvertNumber::convertToPersian($j_tomorrow) }}</strong> تا تاریخ <strong>{{ \App\Helpers\ConvertNumber::convertToPersian($j_next_month) }}</strong></button> <a href="{{ url('turns/future?p='.$x) }}" class="btn btn-info"><i class="fa fa-arrow-left"></i></a>
		<hr>
	<div class="row">

		<div class="col-md-12">
			<table class="m-datatable" id="" width="99%">
				<thead>
					<tr align="center">
						<th>
							شماره
						</th>
						<th>
							نام بیمار
						</th>
						<th>
							سبب الارجاع
						</th>
						<th>
							تاریخ مراجعه
						</th>
						<th>
							عملیات
						</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; ?>
					@foreach($query as $row)
					<tr align="center">
						<td>
							{{ $i++ }}
						</td>
						<td>
							{{ $row->reception->patients[0]->name }}
						</td>
						<td>
							{{ $row->reception->cause }}
						</td>
						<td>
							<?php
								$date = explode(" ", $row->turn_time);
							?>
							{{ \App\Helpers\ConvertNumber::convertToPersian(\App\Helpers\ConvertDate::toJalali($date[0]." ".$date[1])) }}
						</td>
						
							<td>

								{{ Form::open(['method'  => 'DELETE', 'route' => ['turns.destroy', $row->id]]) }}
								<a class="btn btn-success" href="{{ url('turns') }}/{{ $row->id }}/edit">ویرایش <i class="fa fa-edit"></i></a>
								<button class="btn btn-danger" type="submit">لغو نوبت <i class="fa fa-trash"></i></button>
							</td>
								{{ Form::close() }}
					</tr>
					@endforeach

				
				</tbody>
			</table>

		</div>
	</div>
</div>

@stop	