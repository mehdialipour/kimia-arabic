@extends('new.layout')
@section('title')
	اسکن فایل
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
							<div class="kt-portlet__head kt-portlet__head--lg">
								<div class="kt-portlet__head-label">
									<span class="kt-portlet__head-icon">
										<i class="kt-font-brand flaticon2-plus-1"></i>
									</span>
									<h3 class="kt-portlet__head-title">
										اسکن فایل
									</h3>
								</div>

							</div>

							@if ($errors->any())
									    <div class="alert alert-success">
									        <ul>
									            @foreach ($errors->all() as $error)
									                <li style="font-size: 24px;">{{ $error }}</li>
									            @endforeach
									        </ul>
									    </div>
									@endif	
								{!! Form::open(['action' => ['PatientController@scanFiles', $patient->id], 'class' => 'kt-form kt-form--label-right','files' => true]) !!}
							
								<div class="kt-portlet__body" id="append">
									<div class="form-group row" id="clone">
										<div class="col-lg-3">
											<label>نام و نام خانوادگی:</label>
											<h5>{{ $patient->name }}</h5>
										</div>


										<div class="col-lg-3">
											<label class="">نوع فایل:</label>
											{!! Form::select('file_type_id',$file_types,null,['class' => 'form-control m-input','id' => 'file_type_id']) !!}
										</div>
									

										<div class="col-lg-3">
											<label class="">تاریخ مدرک پزشکی:</label>
											{!! Form::text('date',null,['class' => 'form-control m-input','id' => 'datepicker', 'autocomplete' => 'off','required' => true]) !!}
										</div>
									
												<div class="col-lg-3">
														<label for=""> انتخاب فایلها:</label> <a id="add" style="margin: 0px 8px 0;"><i class="fa fa-plus"></i></a>
												{!! Form::file('files[]',['class' => 'form-control m-input', 'id' => 'files','multiple' => true]) !!} 
													<output id="list"></output>
													</div>
									</div>
								</div>

								
								<div class="kt-portlet__foot">

										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">

															<button type="submit" class="btn btn-primary">@if(isset($model))به روزرسانی پرونده @else ثبت پرونده @endif</button>
															<a href="{{ url('patients') }}" class="btn btn-success">بازگشت</a>
													</div>
													
												</div>
											</div>
								</div>
							</form>

							<div class="kt-portlet__body" id="append">
								<table class="table table-bordered" style="font-size: 18px;">
									<thead>
										<tr align="center">
											<td>
												ردیف
											</td>
											<td>
												نوع فایل
											</td>
											<td>
												تاریخ صدور مدرک پزشکی
											</td>
											<td>
												تصویر
											</td>
											<td>
												تاریخ درج در سیستم
											</td>
											<td>
												کاربر
											</td>
											<td>
												عملیات
											</td>
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
												{{ \App\Models\FileType::find($row->file_type_id)->type }}
											</td>
											<td>
												{{ \Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime($row->date)) }}<br>{{ \Carbon\Carbon::now()->diffInDays($row->date) }} روز قبل
											</td>
											<td>
												<img src="{{ url('uploads'.'/'.$row->file_url) }}" style="max-width: 150px;">
											</td>
											<td>
												{{ \Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime($row->created_at)) }}
											</td>
											<td>
												{{ \App\Models\User::find($row->user_id)->name }}
											</td>
											<td>
												<button type="button" class="btn btn-warning">درخواست حذف</button>
											</td>
										</tr>
									@endforeach	
									</tbody>
								</table>	
							</div>

						</div>
@stop
@section('scripts')
{{-- <script>
	$("#add").click(function() {
		$clone = $("#clone").clone();
		$($clone).find('#file_type_id').val("");
		$($clone).find('#datepicker').val("");
		$($clone).find('#files').val("");
		$($clone).find('#list').html("");
		$($clone).find('#datepicker').removeAttr("id");
		$('#append').append($clone);
	});
</script> --}}

<script>
	$(document).on('click','#files', function() {
		$("#list").html("");		
	});
  function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.createElement('span');
          span.innerHTML = ['<img class="thumb" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
          document.getElementById('list').insertBefore(span, null);
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }

  document.getElementById('files').addEventListener('change', handleFileSelect, false);
</script>
@stop