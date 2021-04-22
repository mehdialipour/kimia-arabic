@extends('layout')
@section('title')
نقش‌های سیستم
@stop

@section('content')

					
						
<div class="m-content" style="width: 100%; background-color: white;">

		<a style="font-family: 'Vazir';" href="{{ url('roles/create') }}" class="btn btn-info"><i class="fa fa-plus"></i> افزودن نقش جدید</a>
		<hr>
	<div class="row">

		<div class="col-md-12">
			<table class="table table-hovered" id="roles-table">
				<thead>
					<tr align="center">
						<th>
							#
						</th>
						<th>
							نام لاتین نقش
						</th>
						<th>
							نام فارسی نقش
						</th>
						<th>
							عملیات
						</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; ?>
					@foreach($roles as $row)
					<tr align="center">
						<td>
							{{ $i++ }}
						</td>
						<td>
							{{ $row->name }}
						</td>

						<td>
							{{ $row->title }}
						</td>
					
						<td>

							{{ Form::open(['method'  => 'DELETE', 'route' => ['roles.destroy', $row->id]]) }}
							<a class="btn btn-success" href="{{ url('roles') }}/{{ $row->id }}/edit">ویرایش <i class="fa fa-edit"></i></a>
							<button class="btn btn-danger" type="submit">حذف <i class="fa fa-trash"></i></button>
							{{ Form::close() }}
						</td>
						
					</tr>
					@endforeach

				
				</tbody>
			</table>

		</div>
	</div>
</div>

@stop	