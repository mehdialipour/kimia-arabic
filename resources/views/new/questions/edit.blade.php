@extends('new.layout')
@section('title')
	ویرایش سوال پرسشنامه
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
														ویرایش سوال پرسشنامه
													</strong>
												</h3>
											</div>
										</div>
									</div>

									<!--begin::Form-->	
										{!! Form::model($model, ['method' => 'PATCH', 'action' => ['QuestionController@update', $model->id], 'class' => 'm-form m-form--fit m-form--label-align-right','files' => true]) !!}
										<div class="m-portlet__body">	
											<div class="form-group m-form__group">
												<label for="title">عنوان سوال</label>
												{!! Form::text('title', $model->title, ['class' => 'form-control m-input','required' => true]) !!}
												
											</div>

											<div class="form-group m-form__group">
												<label for="type">محل سوال</label>
												<select name="location" class="form-control m-input" id="location" style="width: 20%; font-family: Vazir;">
													<option value="turn" @if($model->location == 'turn') selected="" @endif>نوبت‌دهی</option>
													<option value="patient" @if($model->location == 'patient') selected="" @endif>تشکیل پرونده</option>
												</select>
											</div>

											<div class="form-group m-form__group">
												<label for="type">نوع پاسخ</label>
												<select name="type" class="form-control m-input" id="type" style="width: 20%; font-family: Vazir;">
													<option value="radio" @if($model->type == 'radio') selected="" @endif>تک‌جوابی</option>
													<option value="checkbox" @if($model->type == 'checkbox') selected="" @endif>چندجوابی</option>
													<option value="text" @if($model->type == 'text') selected="" @endif>جواب متنی</option>
												</select>
											</div>
										
										<div id="options" @if($model->type == 'text') style="display: none;" @endif>	
											<div class="form-group m-form__group">
												<label for="title">گزینه ها:</label> <a id="add" style="margin: 0px 8px 0;"><i class="fa fa-plus"></i></a>
												
											</div>

											@if($model->type != 'text')
											@foreach($options as $value)
												<div class="form-group m-form__group">
												<input type="text" class="form-control m-input" value="{{ $value->title }}" name="options[]">
												
												</div>
											@endforeach
												
											@else
												<div class="form-group m-form__group">
												<input type="text" class="form-control m-input" name="options[]">
												
												</div>
											@endif

											<div id="append">
												
											</div>

										</div>
											

										</div>
										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions">
												<button type="submit" class="btn btn-primary">به روزرسانی سوال</button>
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
		$("#append").append('<div class="form-group m-form__group"><input type="text" class="form-control m-input" name="options[]" autofocus=""></div>');
	});

	$(document).on('change','#type', function(){
		if($('#type').val() == 'text') {
			$("#options").slideUp(500);
		} else {
			$("#options").slideDown(500);
		}
	});
</script>
@stop