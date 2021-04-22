@extends('layout')
@section('title')
نوبت‌ها
@stop

@section('content')

					
						
<div class="m-content" style="width: 100%; background-color: white;">

			<form action="{{ url('previous-turns') }}" method="get">
		<div class="row">
				<div class="col-md-4">
					<a style="font-family: 'Vazir';" href="{{ url('turns/create') }}" class="btn btn-info"><i class="fa fa-plus"></i> ایجاد نوبت جدید</a>
				</div>
				<div class="col-md-2">
					<input type="text" id="datepicker" class="form-control s-input" placeholder="انتخاب تاریخ" name="date" value="{{ @$jalali_date }}" autocomplete="off">
				</div>
				<div class="col-md-2">
					<button type="submit" class="btn btn-primary" name="">مشاهده نوبت‌ها</button>
				</div>
			</form>
		</div>
		<hr>
	<div class="row">

		<div class="col-md-12">
			<table class="table table-hovered" id="" width="99%">
				<thead>
					<tr align="center">
						<th>
							شماره
						</th>
						<th>
							نام بیمار
						</th>
						<th>
							نوع بیمه
						</th>
						<th>
							سبب الارجاع
						</th>
						<th style="width: 15%;">
							پزشک
						</th>
						<th>
							وضعیت
						</th>

						<th>
							هزینه
						</th>

						<th style="width: 33%;">
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
							{{ \App\Models\Insurance::find($row->reception->patients[0]->insurance_id)->name }} @if(\App\Models\Insurance::find($row->reception->patients[0]->insurance_id)->name != 'آزاد')<br> کد: {{ \App\Helpers\ConvertNumber::convertToPersian($row->reception->patients[0]->insurance_code) }} @endif
						</td>
						<td>
							{!! $row->reception->cause !!}
						</td>
						<td>
							@if($row->doctor_id > 0)
							{{ \App\Models\User::find($row->doctor_id)->name }} ({{ \App\Models\Role::find(\App\Models\User::find($row->doctor_id)->role_id)->title }})
							@else
							خدمات کلینیکی
							@endif
						</td>
						<td>
							@if($row->status == 'فی انتظار' || $row->status == 'کلینیک')

							<button class="btn @if($row->status == 'فی انتظار') btn-info @else btn-dark @endif" >{{ $row->status }}</button>
							@if($row->doctor_id > 0)
							<a href="{{ url('turns/toggle') }}/{{ $row->id }}" style="color: white;" class="btn btn-success @if(\App\Models\Invoice::where('turn_id', $row->id)->first()->paid == 0) disabled @endif" title="ارجاع به داخل مطب"><i class="fa fa-arrow-left"></i></a>
							<a href="{{ url('turns/release') }}/{{ $row->id }}" style="color: white;" class="btn btn-dark @if(\App\Models\Invoice::where('turn_id', $row->id)->first()->paid == 0) disabled @endif" title="ترخیص" onclick="return confirm('آیا از ترخیص این بیمار مطمئنید؟');"><i class="fa fa-arrow-up"></i></a>
							@else

							<a href="{{ url('patients') }}/{{ $row->id }}/to-therapist" style="color: white;" class="btn btn-success @if(\App\Models\Invoice::where('turn_id', $row->id)->first()->paid == 0) disabled @endif" title="ارجاع به خدمات کلینیکی"><i class="fa fa-arrow-left"></i></a>
							<a href="{{ url('turns/release') }}/{{ $row->id }}" style="color: white;" class="btn btn-dark @if(\App\Models\Invoice::where('turn_id', $row->id)->first()->paid == 0) disabled @endif" title="ترخیص" onclick="return confirm('آیا از ترخیص این بیمار مطمئنید؟');"><i class="fa fa-arrow-up"></i></a>
							@endif

							@elseif($row->status == 'داخل مطب') 

							<button class="btn btn-success">{{ $row->status }}</button>
							<a href="{{ url('turns/toggle') }}/{{ $row->id }}" style="color: white;" class="btn btn-danger" title="برگشت به انتظار"><i class="fa fa-arrow-right"></i></a>
							<a href="{{ url('turns/clinic') }}/{{ $row->id }}" style="color: black;" class="btn btn-warning @if(\App\Models\Invoice::where('turn_id', $row->id)->first()->paid == 0) disabled @endif" title="ارجاع به کلینیک"><i class="fa fa-syringe"></i></a>
							<a href="{{ url('turns/release') }}/{{ $row->id }}" style="color: white;" class="btn btn-dark @if(\App\Models\Invoice::where('turn_id', $row->id)->first()->paid == 0) disabled @endif" title="ترخیص" onclick="return confirm('آیا از ترخیص این بیمار مطمئنید؟');"><i class="fa fa-arrow-up"></i></a>


							@elseif($row->status == 'ترخیص شده') <button class="btn btn-danger">{{ $row->status }}</button>
							<a href="{{ url('turns/release') }}/{{ $row->id }}" style="color: white;" onclick="return confirm('بازگشت به لیست انتظار؟')" class="btn btn-success"><i class="fa fa-arrow-left"></i></a>
							@else <button class="btn btn-dark">{{ $row->status }}</button>

							@endif


						</td>

						<td>
							@if(\App\Models\Invoice::where('turn_id', $row->id)->first()->paid == 1) 
								<a href="{{ url('turns/'.$row->id.'/money') }}" onclick="return confirm('هل أنت واثق؟؟')" class="btn btn-success"><i class="fa fa-check-circle"></i></a>
							@else
								<a href="{{ url('turns/'.$row->id.'/money') }}" onclick="return confirm('هل أنت واثق؟؟')" class="btn btn-danger"><i class="fa fa-times-circle"></i></a>
							@endif	

								<button class="btn btn-success" onclick="window.open('{{ url('turns/'.$row->id.'/invoice-details') }}',null,'height=700,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no');" style="background-color: purple !important;">...</button>
						</td>
						
							<td>

								{{ Form::open(['method'  => 'DELETE', 'route' => ['turns.destroy', $row->id]]) }}
								<a class="btn btn-success" href="{{ url('turns') }}/{{ $row->id }}/edit">ویرایش <i class="fa fa-edit"></i></a>
								<a href="{{ url('turns/delete'.'/'.$row->id) }}" onclick="return confirm('آیا از لغو نوبت مطمئنید؟')" class="btn btn-danger">لغو نوبت <i class="fa fa-trash"></i></a>
								<?php
									$patient_id = \App\Models\Reception::find($row->reception_id)->patient_id;
									$query = \DB::table('turns')
												->join('receptions','turns.reception_id','=','receptions.id')
												->join('patients','receptions.patient_id','=','patients.id')
												->where('patients.id', $patient_id)
												->where('turns.turn_time','>',\Carbon\Carbon::tomorrow())
												->select('turns.id');
								?>
								@if($query->count() > 0)
								<a href="{{ url('turns'.'/'.$query->first()->id.'/edit') }}" class="btn btn-dark"> نوبت ثبت شده <i class="fa fa-check"></i></a>
								@else
								<a href="{{ url('turns'.'/'.$row->id.'/turn-future') }}" class="btn btn-warning"> نوبت آینده <i class="fa fa-history"></i></a>
								@endif
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