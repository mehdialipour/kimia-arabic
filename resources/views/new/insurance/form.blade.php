@extends('new.layout')
@section('title')
	@if(isset($model))
	ویرایش شرکت بیمه
	@else
	ایجاد شرکت بیمه جدید
	@endif
@stop

@section('content')
<div class="kt-portlet kt-portlet--mobile col-lg-6 mx-auto">
							<div class="kt-portlet__head kt-portlet__head--lg">
								<div class="kt-portlet__head-label">
									<span class="kt-portlet__head-icon">
										<i class="kt-font-brand flaticon2-plus-1"></i>
									</span>
									<h3 class="kt-portlet__head-title">
										@if(isset($model))
														ویرایش بیمه
														@else
														ایجاد بیمه جدید
														@endif
									</h3>
								</div>

							</div>


							@if(isset($model))
										{!! Form::model($model, ['method' => 'PATCH', 'action' => ['InsuranceController@update', $model->id], 'class' => 'kt-form kt-form--label-right']) !!}
									@else	
										{!! Form::open(['action' => ['InsuranceController@store'], 'class' => 'kt-form kt-form--label-right']) !!}
									@endif
								<div class="kt-portlet__body">
									<div class="form-group row">
										<div class="col-lg-11 mx-auto">
											<label> نام بیمه:</label>
											{!! Form::text('name', null, ['class' => 'form-control m-input', 'placeholder' => 'نام شرکت بیمه طرف قرارداد']) !!}
										</div>
									</div>
									
								</div>
								<div class="kt-portlet__foot">

										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<button type="submit" class="btn btn-primary">@if(isset($model))به روزرسانی شرکت بیمه @else ثبت شرکت بیمه @endif</button>
															
													</div>
													
												</div>
											</div>
								</div>
							</form>



						</div>
@stop