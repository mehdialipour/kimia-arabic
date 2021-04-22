@extends('new.layout')
@section('title')
	@if(isset($model))
	قم بتحرير الملف
	@else
	أضف ملفًا جديدًا
	@endif
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
							<div class="kt-portlet__head kt-portlet__head--lg">
								<div class="kt-portlet__head-label">
									<span class="kt-portlet__head-icon">
										<i class="kt-font-brand flaticon2-plus-1"></i>
									</span>
									<h3 class="kt-portlet__head-title">
										@if(isset($model))
										قم بتحرير الملف
										@else
										أضف ملفًا جديدًا
										@endif
									</h3>
								</div>

							</div>

							@if(isset($model))
								{!! Form::model($model, ['method' => 'PATCH', 'action' => ['PatientController@update', $model->id], 'class' => 'kt-form kt-form--label-right','files' => true]) !!}
								<input type="hidden" name="redirect" value="{{ $redirect }}">
							@else	
								{!! Form::open(['action' => ['PatientController@store'], 'class' => 'kt-form kt-form--label-right','files' => true]) !!}
							@endif
								<div class="kt-portlet__body">
									<div class="form-group row">
										<div class="col-lg-3">
											<label>اسم:</label>
											{!! Form::text('firstname', null, ['class' => 'form-control m-input', 'placeholder' => 'اسم المريض','required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>الكنية: </label>
											{!! Form::text('lastname', null, ['class' => 'form-control m-input', 'placeholder' => 'الكنية المريض','required' => true]) !!}
										</div>

										<div class="col-lg-2">
											@if(isset($model) && $model->birth_year == '') 
													@php $style='border-color:red;' @endphp 
												@else 
													@php $style=''; @endphp
												@endif

												<label for="">سنة الميلاد:</label>
												{!! Form::text('birth_year', null, ['class' => 'form-control m-input' , 'style' => $style, 'id' => 'datepicker','autocomplete' => 'off']) !!}
										</div>
										<div class="col-lg-2">
											@if(isset($model) && $model->father_name == '') 
													@php $style='border-color:red;' @endphp 
												@else 
													@php $style=''; @endphp
												@endif

												<label for="">اسم الاب:</label>
												{!! Form::text('father_name', null, ['class' => 'form-control m-input','style' => $style, 'placeholder' => 'اسم الاب']) !!}

										</div>


										<div class="col-lg-2">
											@if(isset($model) && $model->national_id == '') 
													@php $style='border-color:red;' @endphp 
												@else 
													@php $style=''; @endphp
												@endif

												<label for="">الرقم الوطني:</label>
												{!! Form::text('national_id', null, ['class' => 'form-control m-input','id' => 'national_id' , 'style' => $style , 'placeholder' => 'الرقم الوطني','autocomplete' => 'off']) !!}
												<p id="error"></p>
										</div>
									</div>
									<div class="form-group row">

											<div class="col-lg-3">
													<label class="">جنس:</label>
													{!! Form::select('gender',['female' => 'مونث', 'male' => 'مذکر'],null,['class' => 'form-control m-input']) !!}
												</div>


												<div class="col-lg-3">
														<label class="">الحالة الاجتماعية:</label>
														{!! Form::select('marriage',['single' => 'أعزب', 'married' => 'متزوج'],null,['class' => 'form-control m-input']) !!}
													</div>


										<div class="col-lg-3">
											<label class="">نوع التأمين:</label>
												{!! Form::select('insurance_id',$insurances,null,['class' => 'form-control m-input']) !!}
										</div>

										<div class="col-lg-3">
											<label class="">رقم التأمين:</label>
												{!! Form::text('insurance_code', null, ['class' => 'form-control m-input', 'placeholder' => 'رقم التأمين']) !!}
										</div>

										</div>

										
									
									<div class="form-group row">
										<div class="col-lg-3">
											@if(isset($model) && strlen($model->mobile) != 11) 
												@php $style='border-color:red;' @endphp 
											@else 
												@php $style='' @endphp
											@endif
												<label class="">التليفون المحمول:</label>
												{!! Form::text('mobile', null, ['class' => 'form-control m-input','id' => 'mobile','autocomplete' => 'off','style' => $style, 'placeholder' => 'التليفون المحمول']) !!}
												<p id="error_mobile"></p>
											</div>

											<div class="col-lg-6">
													<label>عنوان:</label>
													<div class="kt-input-icon kt-input-icon--right">
														{!! Form::text('address', null, ['class' => 'form-control m-input', 'placeholder' => 'عنوان']) !!}
														<span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i
																	class="la la-map-marker"></i></span></span>
													</div>
												</div>


												<div class="col-lg-3">
														<label class="">رقم الهاتف:</label>
														{!! Form::text('phone', null, ['class' => 'form-control m-input', 'placeholder' => 'رقم الهاتف']) !!}
													</div>


										
										
									</div>

									<div class="form-group row">
											<div class="col-lg-9">
													<label class="">تاريخ المرض أو الجراحة:</label>
													{!! Form::textarea('disease_history', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => 'أي شی مرضي بما في ذلك ضغط الدم والسكري والحساسية وما إلى ذلك أو تاريخ من الجراحة']) !!}
												</div>

												
									</div>
								</div>
								<div class="kt-portlet__foot">
									<?php $questions = \DB::table('questions')->where('location','patient')->get(); $i=1;?>

									
										@foreach($questions as $row) 
										<div class="row">
											<div class="m-portlet__body">	
											<div class="form-group m-form__group">
												<label for="">{{ \App\Helpers\ConvertNumber::convertToPersian($i++) }} - {{ $row->title }}</label>
												<br><br>
												
												@if($row->type == 'radio')
													<?php 
														$options = \App\Models\Option::where('question_id', $row->id)->get();
													?>
													@foreach($options as $option)
														<input class="" type="radio" name="question_{{ $row->id }}" value="{{ $option->id }}" style="margin-right: 20px"> {{ $option->title }}
													@endforeach	

												@elseif($row->type == 'checkbox')
													<?php 
														$options = \App\Models\Option::where('question_id', $row->id)->get();
													?>
													@foreach($options as $option)
														<input class="" type="checkbox" name="question_{{ $row->id }}[]" value="{{ $option->id }}" style="margin-right: 20px"> {{ $option->title }}
													@endforeach	

												@else
													<input type="text" class="form-control m-input" name="question_{{ $row->id }}">
												@endif
												
											</div>

										</div>
									</div>
									<hr>
										@endforeach
								</div>
								<div class="kt-portlet__foot">

										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<button type="submit" class="btn btn-primary" id="submit">@if(isset($model))تحدیث الملف @else تسجيل ملف @endif</button>
													</div>
													
												</div>
											</div>
								</div>
							</form>



						</div>
@stop
@section('scripts')
<script>
	$("#add").click(function() {
		$("#append").append('<input class="form-control m-input" id="files" multiple="" name="files[]" type="file"><br>');
	});
</script>
<script>
	$(document).on("keyup", "#national_id", function () {

        $.ajax({
            url: "{!! url('patients/national-id-check') !!}",
            type: "post",
            data: {
                national_id: $('#national_id').val(),
            },
            success: function (data) {
            	if(data == 'length_error') {
            		$("#error").html("<span class='text-danger'>شماره ملی بایستی ۱۰ رقمی باشد.</span>");
            		$("#submit").removeAttr('disabled');
            	} else if(data == 'not_valid') {
                	$("#error").html("<span class='text-danger'>شماره ملی معتبر نمی‌باشد.</span>");
                	$("#submit").removeAttr('disabled');
                } else if(data == 'repeat') {
                	$("#error").html("<span class='text-danger'>شماره ملی تکراری است.</span>");
                	$("#submit").attr('disabled',true);
                } else {
                	$("#error").html("<span class='text-success'>شماره ملی صحیح است.</span>");
                	$("#submit").removeAttr('disabled');
                }
            }
        });
    });

    $(document).on("keyup", "#mobile", function () {

        $.ajax({
            url: "{!! url('patients/mobile-check') !!}",
            type: "post",
            data: {
                mobile: $('#mobile').val(),
            },
            success: function (data) {
            	if(data == 'not_valid') {
                	$("#error_mobile").html("<span class='text-danger'>التليفون المحمول معتبر نمی‌باشد.</span>");
                } else {
                	$("#error_mobile").html("<span class='text-success'>التليفون المحمول صحیح است. کد تایید هویت: <strong>"+data+"</strong></span>");
                }
            }
        });
    });
</script>
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