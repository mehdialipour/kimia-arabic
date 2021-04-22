@extends('layout')
@section('title')
بانک دارو
@stop

@section('content')

					
						
<div class="m-content" style="width: 100%; background-color: white;">

		<a style="font-family: 'Vazir';" href="{{ url('medicines/create') }}" class="btn btn-info"><i class="fa fa-plus"></i> افزودن دارو جدید</a>
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
							نام دارو
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
								<a class="btn btn-success" href="{{ url('medicines'.'/'.$row->id.'/edit') }}">ویرایش <i class="fa fa-edit"></i></a>
								<a class="btn btn-danger" href="{{ url('medicines/delete'.'/'.$row->id) }}">حذف <i class="fa fa-trash"></i></a>
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