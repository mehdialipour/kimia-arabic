@extends('new.layout')
@section('title')
	@if(isset($model))
	ویرایش دسته چک
	@else
	افزودن دسته چک جدید
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
											ویرایش دسته چک
										@else
											افزودن دسته چک جدید
										@endif
									</h3>
								</div>

							</div>

							@if(isset($model))
								{!! Form::model($model, ['method' => 'PATCH', 'action' => ['ChequeController@update', $model->id], 'class' => 'kt-form kt-form--label-right','files' => true]) !!}
							@else	
								{!! Form::open(['action' => ['ChequeController@store'], 'class' => 'kt-form kt-form--label-right','files' => true]) !!}
							@endif
								<div class="kt-portlet__body">
									<div class="form-group row">
										<div class="col-lg-3">
											<label>نام بانک:</label>
											{!! Form::text('bank', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>تعداد برگ:</label>
											{!! Form::text('papers', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>سدینار اولین برگ:</label>
											{!! Form::text('number', null, ['class' => 'form-control m-input','required' => true,'placeholder' => 'فقط عدد وارد کنید.']) !!}
										</div>
									</div>
								</div>

								<div class="kt-portlet__foot">

										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<button type="submit" class="btn btn-primary">@if(isset($model))به روزرسانی دسته چک @else ثبت دسته چک @endif</button>
													</div>
													
												</div>
											</div>
								</div>
							</form>
@stop