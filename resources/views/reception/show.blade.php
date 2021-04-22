@extends('layout')
@section('title')
پرونده مراجعه‌ی {{ $patient->name }}
@stop

@section('content')
	<div class="m-content" style="width: 100%; background-color: white;">

		<div class="col-md-12">
			<h4>اطلاعات اولیه بیمار</h4><br>
			<table class="table table-bordered" id="" width="99%">
				<thead>
					<tr align="center" class="table-info">
						<th>
							نام بیمار
						</th>
						<th>
							سن بیمار
						</th>	
						<th>
							شکایت بیمار
						</th>
						<th>
							سابقه بیماری یا جراحی
						</th>
						<th>
							دفعات مراجعه
						</th>
					</tr>
				</thead>
				<tbody>
					
					<tr align="center">
						<td>
							{{ $patient->name }}
						</td>
						<td>
							<?php $today = \Morilog\Jalali\Jalalian::now();
								  $ex_today = explode(" ", $today);

								  $ex_date = explode('-', $ex_today[0]);

								  $age = $ex_date[0] - $patient->birth_year;

								  $age = $age.' سال';

								  if($age == 0) $age = 'نوزاد';	
							 ?>
							{{ $age }}
						</td>
						<td>
							{!! $query->cause !!}
						</td>
						<td>
							{{ $patient->disease_history }}
						</td>
						<td>
							@if($turn_count == 1) اولین مراجعه
							@else {{ \App\Helpers\ConvertNumber::convertToPersian($turn_count) }} بار
							@endif
						</td>
					</tr>

				
				</tbody>
			</table>



			@if(count($files) > 0)
			<br>
			<hr>
			<br>
			<h4>مدارک پزشکی بیمار</h4>
			<br><br>
			<output id="">
				@foreach($files as $file) 
					<!-- Trigger the Modal -->
<img class="myImg" src="{{ url('uploads/'.$file->file_url) }}" alt="" style="width:50%;max-width:300px;">
<a href="{{ url('patients/delete-image/'.$file->id) }}" class="btn btn-danger">x</a>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- The Close Button -->
  <span class="close">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="modal-content" id="img01">

  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
</div>
<br><br>
				@endforeach
			</output>
			<br>
			<br>
			@endif

			@if($diagnoses->count() > 0)
			<br>
			<hr>
			<br>
			<h4>تشخیص‌های پزشک</h4>

			<table class="table table-bordered" id="" width="99%">
				<thead>
					<tr align="center" class="table-info">
						<th>
							#
						</th>
						<th  style=" width: 30%;">
							تصویر
						</th>
						<th>
							شکایت بیمار
						</th>	
						<th>
							فشار خون
						</th>
						<th>
							تشخیص پزشک
						</th>
						<th>
							تاریخ ثبت
						</th>

						<th>
							ثبت کننده
						</th>

						<th>
							عملیات
						</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; ?>
					@foreach($diagnoses->get() as $diagnosis)
					<?php $date = explode(" ", $diagnosis->created_at); ?>
						<tr align="center">
							<td>{{ $i++ }}</td>
							<td>
									
									<img class="myImg" src="{{ url('uploads/'.$diagnosis->file_url) }}" alt=""  style=" width: 100%;">
									<!-- The Modal -->
									<div id="myModal" class="modal">

									  <!-- The Close Button -->
									  <span class="close">&times;</span>

									  <!-- Modal Content (The Image) -->
									  <img class="modal-content" id="img01" style="width: 70%;">

									  <!-- Modal Caption (Image Text) -->
									  <div id="caption"></div>
									</div>

							</td>
							<td>{!! $diagnosis->cause !!}</td>
							<td>{!! $diagnosis->blood_pressure !!}</td>
							<td>
								{!! $diagnosis->diagnosis !!}
							</td>
							<td>{{ \App\Helpers\ConvertDate::toJalali($date[0]) }}</td>
							<td>
								{{ $diagnosis->editor }}
							</td>
							<td>
								<a class="btn btn-success" href="{{ url('receptions/diagnosis/edit').'/'.$diagnosis->id }}">ویرایش</a>
								<a class="btn btn-danger" href="{{ url('receptions/diagnosis/delete').'/'.$diagnosis->id }}">حذف</a>
							</td>
						</tr>
					@endforeach	
					
				</tbody>
			</table>	
			<br>
			<br>
			@endif
			@if($perceptions->count() > 0)
			<br>
			<hr>
			<br>
			<h4>نسخه های پزشک</h4>

			<table class="table table-bordered" id="" width="99%">
				<thead>
					<tr align="center" class="table-info">
						<th>
							#
						</th>	
						<th>
							تاریخ ثبت
						</th>
						<th>
							داروها
						</th>
						<th>
							ثبت کننده
						</th>
						<th>
							عملیات
						</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; ?>
					@foreach($perceptions->get() as $perception)
					<?php $date = explode(" ", $perception->created_at); ?>
						<tr align="center">
							<td>{{ $i++ }}</td>
							<td>{{ \App\Helpers\ConvertDate::toJalali($date[0]) }}</td>
							<td>{!! $perception->description !!}</td>
							<td>{!! $perception->editor !!}</td>
							<td>
								<a class="btn btn-success" href="{{ url('receptions/medicines/edit').'/'.$perception->id }}">ویرایش</a>
								<a class="btn btn-danger" href="{{ url('receptions/medicines/delete').'/'.$perception->id }}">حذف</a>
							</td>
						</tr>
					@endforeach	
					
				</tbody>
			</table>	
			<br>
			<br>
			@endif

			@if($reception_count > 1)
				<br>
				<hr>

				<br>

				<h6>
					*این بیمار قبلا با شکایت های زیر به مطب مراجعه کرده است:
				</h6>
				<form id="myForm" action="{{ url('receptions/collect') }}" method="post">
					@csrf
					@foreach($receptions as $reception)
						<input type="checkbox" name="causes[]" value="{{ $reception->id }}"><a href="{{ url('receptions/'.$reception->id) }}">{!!$reception->cause!!}</a>
						<br>
					@endforeach
					<br>
					<input type="text" class="" placeholder="سبب الارجاع" name="cause" required="">
					<input type="hidden" name="patient_id" value="{{ $patient->id }}">
					<br><br>
					<input type="submit" class="btn btn-success" value="تجمیع علل مراجعه">
				</form>
				<br>
			@endif
			<hr>
			<br>
			<div align="center">
				
					@if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 8)->count() == 1)
							
							<a style="margin: 0px 2.5% 0px;" href="{{ url('receptions/'.$id.'/diagnosis') }}" class="btn btn-primary">ثبت مشاهدات و نسخه</a>
						
					@endif

					@if(\Session::get('role') == 2)
						
							<a style="margin: 0px 2.5% 0px;" href="{{ url('patients/'.$turn_id.'/to-wait') }}" class="btn btn-primary">ارجاع به اتاق انتظار</a>
						

						
							
					@else

							<a style="margin: 0px 2.5% 0px;" href="{{ url('patients/'.$turn_id.'/to-wait') }}" class="btn btn-primary">ارجاع به اتاق انتظار</a>
						

						
							<a style="margin: 0px 2.5% 0px;" href="{{ url('patients/'.$turn_id.'/to-office') }}" class="btn btn-primary">ارجاع به اتاق پزشک</a>	
					
					@endif	
						
					<a style="margin: 0px 2.5% 0px;" href="{{ url('receptions/'.$id.'/release') }}" class="btn btn-primary">ترخیص</a>
					
					

			</div>
		</div>
	</div>
@stop
@section('scripts')
<script>
$("#myForm").submit(function(){
    var checked = $("#myForm input:checked").length > 0;
    if (!checked){
        alert("حداقل دو مورد را جهت تجمیع بایستی انتخاب کنید.");
        return false;
    }
});
function keyPress (e) {
    if(e.key === "Escape") {
		document.getElementByClass('myModal2').style.display='none'
		}
	}
</script>
@stop