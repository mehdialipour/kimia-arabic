@extends('layout')
@section('title')
سوابق پذیرش بیماران
@stop

@section('content')

					
						
<div class="m-content" style="width: 100%; background-color: white;">

		<a style="font-family: 'Vazir';" href="{{ url('receptions/create') }}" class="btn btn-info"><i class="fa fa-plus"></i> ایجاد پذیرش جدید</a>
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
							نام بیمار
						</th>
						<th>
							سبب الارجاع
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
							{{ $row->patients[0]->name }}
						</td>
						<td>
							{{ $row->cause }}
						</td>
							<td>

								{{ Form::open(['method'  => 'DELETE', 'route' => ['receptions.destroy', $row->id]]) }}
								<a class="btn btn-success" href="{{ url('receptions') }}/{{ $row->id }}/edit">ویرایش <i class="fa fa-edit"></i></a>
								<button class="btn btn-danger" type="submit">حذف <i class="fa fa-trash"></i></button>
							</td>
								{{ Form::close() }}	
					</tr>
					@endforeach

				
				</tbody>
			</table>

		</div>
	</div>
	<div align="center">{!! $query->render() !!}</div>
</div>

@stop	