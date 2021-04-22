@extends('layout')
@section('title')
فایلهای پزشکی بیماران
@stop

@section('content')

					
						
<div class="m-content" style="width: 100%; background-color: white;">

		
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
							تصویر
						</th>
						<th>
							عملیات
						</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; ?>
					@foreach($files as $row)
					<tr align="center">
						<td>
							{{ $i++ }}
						</td>
						<td>
							{{ $row->reception->patients[0]->name }} ({{ $row->reception->cause }})
						</td>
						<td>
							<a href="{{ url('uploads/'.$row->file_url) }}" target="_new">
								<img src="{{ url('uploads'.'/'.$row->file_url) }}" style="max-width: 100px;">
							</a>
						</td>
						
							<td>
								<a class="btn btn-danger" href="{{ url('patient-files/'.$row->id.'/delete') }}" onclick="return confirm('آیا از حذف فایل مطمئن هستید؟')">حذف <i class="fa fa-trash"></i></a>
							</td>
								
					</tr>
					@endforeach

				
				</tbody>
			</table>

		</div>
	</div>
	<div align="center">{!! $files->render() !!}</div>
</div>

@stop	