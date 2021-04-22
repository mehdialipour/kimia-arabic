@extends('new.layout')
@section('title')
پرسشنامه
@stop

@section('content')

					
						
<div class="m-content" style="width: 100%; background-color: white;">
<div class="row">
		<a style="font-family: 'Vazir';" href="{{ url('questions/create') }}" class="btn btn-info"><i class="fa fa-plus"></i> افزودن سوال جدید</a>
	</div>	
	<div class="row">

		<div class="col-md-12">
			<table class="table table-bordered" id="" width="99%">
				<thead>
					<tr align="center">
						<th>
							#
						</th>
						<th>
							عنوان سوال
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
							{{ $row->title }}
						</td>
					
						<td>

							{{ Form::open(['method'  => 'DELETE', 'route' => ['questions.destroy', $row->id]]) }}
							<a class="btn btn-success" href="{{ url('questions') }}/{{ $row->id }}/edit">ویرایش <i class="fa fa-edit"></i></a>
							<button class="btn btn-danger" type="submit">حذف <i class="fa fa-trash"></i></button>
							{{ Form::close() }}
						</td>
						
					</tr>
					@endforeach

				
				</tbody>
			</table>

	<div align="center">{!! $query->render() !!}</div>
		</div>
	</div>
</div>

@stop	