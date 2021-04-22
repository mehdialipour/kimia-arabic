@extends('layout')
@section('title')
	@if(isset($model))
	ویرایش پرونده
	@else
	ایجاد پرونده جدید
	@endif
@stop

@section('content')

<div class="m-content" style="width: 100%;">
						<div class="row">
							<div class="col-md-3">
							</div>	
							<div class="col-md-6">

								<!--begin::Portlet-->
								<div class="m-portlet m-portlet--tab">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
												<h3 class="m-portlet__head-text">
													<strong>
														@if(isset($model))
														ویرایش پرونده
														@else
														ایجاد پرونده جدید
														@endif
													</strong>
												</h3>
											</div>
										</div>
									</div>

									<!--begin::Form-->
									@if(isset($model))
										{!! Form::model($model, ['method' => 'PATCH', 'action' => ['PatientController@update', $model->id], 'class' => 'm-form m-form--fit m-form--label-align-right', 'id' => 'patients-create','files' => true]) !!}
										<input type="hidden" name="redirect" value="{{ $redirect }}">
									@else	
										{!! Form::open(['action' => ['PatientController@store'], 'class' => 'm-form m-form--fit m-form--label-align-right', 'id' => 'patients-create','files' => true]) !!}
										<input type="hidden" name="redirect" value="{{ $redirect }}">
									@endif		
										<div class="m-portlet__body">	
											<div class="form-group m-form__group">
												<label for="">نام و نام خانوادگی</label>
												{!! Form::text('name', null, ['class' => 'form-control m-input', 'placeholder' => 'نام و نام خانوادگی بیمار','required' => true]) !!}
												
											</div>
											<div class="form-group m-form__group">

												@if(isset($model) && $model->birth_year == '') 
													@php $style='border-color:red;' @endphp 
												@else 
													@php $style=''; @endphp
												@endif

												<label for="">سال تولد</label>
												{!! Form::text('birth_year', null, ['class' => 'form-control m-input' , 'style' => $style,'maxlength' => 4, 'placeholder' => 'سال تولد بیمار. مثال: ۱۳۶۰']) !!}
												
											</div>

											<div class="form-group m-form__group">

												@if(isset($model) && $model->father_name == '') 
													@php $style='border-color:red;' @endphp 
												@else 
													@php $style=''; @endphp
												@endif

												<label for="">اسم الاب</label>
												{!! Form::text('father_name', null, ['class' => 'form-control m-input','style' => $style, 'placeholder' => 'اسم الاب']) !!}
												
											</div>

											<div class="form-group m-form__group">
												<label for="">جنسیت</label>

												{!! Form::select('gender',['female' => 'مونث', 'male' => 'مذکر'],null,['class' => 'form-control m-input', 'style' => 'font-family: Vazir']) !!}
											</div>

											<div class="form-group m-form__group">
												<label for="">وضعیت تاهل</label>

												{!! Form::select('marriage',['single' => 'مجرد', 'married' => 'متاهل'],null,['class' => 'form-control m-input', 'style' => 'font-family: Vazir']) !!}
											</div>

											<div class="form-group m-form__group">

												@if(isset($model) && $model->national_id == '') 
													@php $style='border-color:red;' @endphp 
												@else 
													@php $style=''; @endphp
												@endif

												<label for="">شماره ملی</label>
												{!! Form::text('national_id', null, ['class' => 'form-control m-input','id' => 'national_id' , 'style' => $style , 'placeholder' => 'شماره ملی یا شماره شناسنامه بیمار','autocomplete' => 'off']) !!}
												<p id="error"></p>
											</div>

											<div class="form-group m-form__group">
												<label for="">نوع بیمه</label>
												{!! Form::select('insurance_id',$insurances,null,['class' => 'form-control m-input', 'style' => 'font-family: Vazir']) !!}
											</div>

											@if(isset($model) && $model->mobile == '') 
												@php $style='border-color:red;' @endphp 
											@else 
												@php $style='' @endphp
											@endif

											<div class="form-group m-form__group">
												<label for="">شماره موبایل</label>
												{!! Form::text('mobile', null, ['class' => 'form-control m-input','id' => 'mobile','autocomplete' => 'off','style' => $style, 'placeholder' => 'شماره موبایل']) !!}
												<p id="error_mobile"></p>
											</div>

											

											<div class="form-group m-form__group">
												<label for="">شماره ثابت</label>
												{!! Form::text('phone', null, ['class' => 'form-control m-input', 'placeholder' => 'شماره ثابت']) !!}
											</div>

											

											<div class="form-group m-form__group">
												<label for="">آدرس</label>
												{!! Form::text('address', null, ['class' => 'form-control m-input', 'placeholder' => 'آدرس محل سکونت']) !!}
											</div>

											<div class="form-group m-form__group">
												<label for="">سابقه بیماری یا جراحی</label>
												{!! Form::textarea('disease_history', null, ['class' => 'form-control m-input', 'placeholder' => 'هر گونه سابقه بیماری اعم از فشار خون، دیابت، حساسیت و... و یا سابقه عمل جراحی']) !!}
											</div>

											<div class="form-group m-form__group" id="append">
												<label for="">@if(isset($model)) افزودن فایل جدید به پرونده @else انتخاب فایلها@endif</label> <a id="add" style="margin: 0px 8px 0;"><i class="fa fa-plus"></i></a>
												{!! Form::file('files[]',['class' => 'form-control m-input', 'id' => 'files','multiple' => true]) !!} 
													<output id="list"></output>
											</div>
											@if(isset($model))
											<hr>
											<div class="form-group m-form__group">
												<label for="">* انتخاب فایل برای حذف از پرونده</label>
											</div>
											<table class="table table-bordered">
												<thead>
													
													<tr align="center">
														@foreach($files as$file)
														<th>
															<input type="checkbox" name="patient_file[]" value="{{ $file->id }}">
														</th>
														@endforeach
													</tr>
												</thead>		
												<tbody>
													<tr align="center">
														@foreach($files as$file)
														<td>
															<img src="{{ url('uploads'.'/'.$file->file_url) }}" style="max-height: 100px; max-width: 100px;">
														</td>
														@endforeach
													</tr>
												</tbody>									
											</table>
											@endif

										</div>
										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions">
												<button type="submit" class="btn btn-primary">@if(isset($model))به روزرسانی پرونده @else ثبت پرونده @endif</button>
											</div>
										</div>
									</form>

									<!--end::Form-->
								</div>

								<!--end::Portlet-->

							</div>
							<div class="col-md-3">
							</div>
						</div>
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
            	} else if(data == 'not_valid') {
                	$("#error").html("<span class='text-danger'>شماره ملی معتبر نمی‌باشد.</span>");
                } else {
                	$("#error").html("<span class='text-success'>شماره ملی صحیح است.</span>");
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
                	$("#error_mobile").html("<span class='text-danger'>شماره موبایل معتبر نمی‌باشد.</span>");
                } else {
                	$("#error_mobile").html("<span class='text-success'>شماره موبایل صحیح است. کد تایید هویت: <strong>"+data+"</strong></span>");
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