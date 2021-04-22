@extends('new.layout')
@section('title')
	افزودن سوال جدید
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
														افزودن سوال جدید
													</strong>
												</h3>
											</div>
										</div>
									</div>

									<!--begin::Form-->	
										{!! Form::open(['action' => ['QuestionController@store'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
										<div class="m-portlet__body">	
											<div class="form-group m-form__group">
												<label for="title">عنوان سوال</label>
												{!! Form::text('title', null, ['class' => 'form-control m-input','required' => true]) !!}
												
											</div>

											<div class="form-group m-form__group">
												<label for="type">محل سوال</label>
												<select name="location" class="form-control m-input" id="location" style="width: 20%; font-family: Vazir;">
													<option value="turn">نوبت‌دهی</option>
													<option value="patient">تشکیل پرونده</option>
												</select>
											</div>

											<div class="form-group m-form__group">
												<label for="type">نوع پاسخ</label>
												<select name="type" class="form-control m-input" id="type" style="width: 20%; font-family: Vazir;">
													<option value="radio">تک‌جوابی</option>
													<option value="checkbox">چندجوابی</option>
													<option value="text">جواب متنی</option>
												</select>
											</div>
										<div id="options">	
											<div class="form-group m-form__group">
												<label for="title">گزینه ها:</label> <a id="add" style="margin: 0px 8px 0;"><i class="fa fa-plus"></i></a>
												
											</div>

											<div class="form-group m-form__group">
												<input type="text" class="form-control m-input" name="options[]">
												
											</div>

											<div id="append">
												
											</div>

										</div>


											

										</div>
										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions">
												<button type="submit" class="btn btn-primary">ثبت سوال</button>
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