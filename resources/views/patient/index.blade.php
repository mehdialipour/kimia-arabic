@extends('layout')
@section('title')
پرونده بیماران
@stop

@section('content')

					
						
<div class="m-content" style="width: 100%; background-color: white;">

		<form action="{{ url('patients/search') }}" method="get">
		<a style="font-family: 'Vazir';" href="{{ url('patients/create?redirect=receptions') }}" class="btn btn-info"><i class="fa fa-plus"></i> افزودن پرونده جدید</a>
		<hr>
	<div class="row">
			<div class="col-md-3">
				<input type="text" class="form-control m-input" name="name" placeholder="نام و نام خانوادگی">
			</div>
			<div class="col-md-3">
				<input type="text" class="form-control m-input" name="national_id" placeholder="شماره ملی">
			</div>
			<div class="col-md-3">
				<input type="text" class="form-control m-input" name="mobile" placeholder="شماره موبایل">
			</div>
			<div class="col-md-3">
				<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
			</div>
		</form>
	</div>
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
							جنسیت
						</th>
						<th>
							نوع بیمه
						</th>
						<th>
							شماره موبایل
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
							@if($row->gender == 'male') مذکر @else مونث @endif
						</td>
						<td>
							{{ \App\Models\Insurance::find($row->insurance_id)->name }}
						</td>
						<td>
							{{ $row->mobile }}
						</td>
							<td>

								{{ Form::open(['method'  => 'DELETE', 'route' => ['patients.destroy', $row->id]]) }}
								@if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 19)->count() == 19)
								<a class="btn btn-success" href="{{ url('patients') }}/{{ $row->id }}/edit">ویرایش <i class="fa fa-edit"></i></a>
								@endif
								<?php 
									$count = \DB::table('patients')
												 ->join('receptions','patients.id','=','receptions.patient_id')
												 ->join('turns','receptions.id','=','turns.reception_id')
												 ->where('receptions.patient_id', $row->id)
												 ->count();
								?>
								@if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 20)->count() == 1)
									@if($count == 0)
										
										<button class="btn btn-danger" type="submit">حذف <i class="fa fa-trash"></i></button>
									@else
										<button class="btn btn-dark" type="button">پذیرش شده</button>	
									@endif
								@endif	
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