@extends('layout')
@section('title')
	@if(isset($model))
	ویرایش پذیرش
	@else
	ایجاد پذیرش جدید
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
														ویرایش پذیرش
														@else
														ایجاد پذیرش جدید
														@endif
													</strong>
												</h3>
											</div>
										</div>
									</div>

									<!--begin::Form-->
									@if(isset($model))
										{!! Form::model($model, ['method' => 'PATCH', 'action' => ['ReceptionController@update', $model->id], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
									@else	
										{!! Form::open(['action' => ['ReceptionController@store'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
									@endif		
										<div class="m-portlet__body">	
											<div class="form-group m-form__group">
												<label for="">نام بیمار</label>

												{!! Form::select('patient_id',$patients,null,['class' => 'form-control m-input selectbox', 'style' => 'font-family: Vazir']) !!}
											</div>
											<div class="form-group m-form__group">
												<label for="">سبب الارجاع</label>
												{!! Form::text('cause', null, ['class' => 'form-control m-input', 'placeholder' => 'سبب الارجاع‌ی بیمار','required' => true]) !!}
												
											</div>
											
										</div>
										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions">
												<button type="submit" class="btn btn-primary">@if(isset($model))به روزرسانی پذیرش @else ثبت پذیرش @endif</button>
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