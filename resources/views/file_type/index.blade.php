@extends('layout')
@section('title')
بیمه های طرف قرارداد
@stop

@section('content')

					
						
<div class="m-content" style="width: 100%; background-color: white;">

		<a style="font-family: 'Vazir';" href="{{ url('insurances/create') }}" class="btn btn-info"><i class="fa fa-plus"></i> افزودن بیمه جدید</a>
		<hr>
	<div class="row">

		<div class="col-md-12">
			<table class="m-datatable" id="" width="99%">
				<thead>
					<tr align="center">
						<th>
							#
						</th>
						<th>
							نام بیمه
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
							{{ $row->name }}
						</td>
						
							<td>

								
								<a class="btn btn-success" href="{{ url('insurances') }}/{{ $row->id }}/edit">ویرایش <i class="fa fa-edit"></i></a>
								@if($row->status == 'فعال')
									<a class="btn btn-danger" href="{{ url('insurances') }}/{{ $row->id }}?action=deactivate">غیر فعال‌سازی <i class="fa fa-ban"></i></a>
								@else
									<a class="btn btn-info" href="{{ url('insurances') }}/{{ $row->id }}?action=activate">فعال‌سازی <i class="fa fa-check"></i></a>
								@endif	
							</td>
					</tr>
					@endforeach

				
				</tbody>
			</table>

		</div>
	</div>
	<div align="center">{!! $query->render() !!}</div>
</div>

@stop	