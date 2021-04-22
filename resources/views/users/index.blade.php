@extends('layout')
@section('title')
کاربران
@stop

@section('content')

					
						
<div class="m-content" style="width: 100%; background-color: white;">

		<a style="font-family: 'Vazir';" href="{{ url('users/create') }}" class="btn btn-info"><i class="fa fa-plus"></i> افزودن کاربر جدید</a>
		<hr>
	<div class="row">

		<div class="col-md-12">
			<table class="table table-hovered">
				<thead>
					<tr align="center">
						<th>
							#
						</th>
						<th>
							نام 
						</th>
						<th>
							نام کاربری
						</th>
						<th>
							شماره موبایل
						</th>
						<th>
							نقش در سیستم
						</th>
						<th>
							عملیات
						</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; ?>
					@foreach($users as $row)
					<tr align="center">
						<td>
							{{ $i++ }}
						</td>
						<td>
							{{ $row->name }}
						</td>

						<td>
							{{ $row->username }}
						</td>

						<td>
							{{ $row->mobile }}
						</td>
						<td>
							@if($row->role_id > 0)
							{{ \App\Models\Role::find($row->role_id)->title }}
							@else
							<button class="btn btn-danger" type="button">بدون نقش</button>
							@endif

						</td>
						<td>

							{{ Form::open(['method'  => 'DELETE', 'route' => ['users.destroy', $row->id]]) }}
							<a class="btn btn-success" href="{{ url('users') }}/{{ $row->id }}/edit">ویرایش <i class="fa fa-edit"></i></a>
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