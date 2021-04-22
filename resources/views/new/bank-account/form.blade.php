@extends('new.layout')
@section('title')
	@if(isset($model))
	ویرایش حساب
	@else
	افزودن حساب جدید
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
											ویرایش حساب
										@else
											افزودن حساب جدید
										@endif
									</h3>
								</div>

							</div>

							@if(isset($model))
								{!! Form::model($model, ['method' => 'PATCH', 'action' => ['BankAccountController@update', $model->id], 'class' => 'kt-form kt-form--label-right','files' => true]) !!}
							@else	
								{!! Form::open(['action' => ['BankAccountController@store'], 'class' => 'kt-form kt-form--label-right','files' => true]) !!}
							@endif
								<div class="kt-portlet__body">
									<div class="form-group row">
										<div class="col-lg-3">
											<label>عنوان حساب:</label>
											{!! Form::text('title', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>نام بانک:</label>
											{!! Form::text('bank_name', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>نام شعبه:</label>
											{!! Form::text('branch_name', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>
										<div class="col-lg-3">
											<label>کد شعبه:</label>
											{!! Form::text('branch_code', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>
									</div>

									<div class="form-group row">
										<div class="col-lg-3">
											<label>نام صاحب حساب:</label>
											{!! Form::text('owner_name', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>شماره حساب:</label>
											{!! Form::text('account_number', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>شماره شبا:</label>
											{!! Form::text('sheba_number', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>
										<div class="col-lg-3">
											<label>شماره کارت:</label>
											{!! Form::text('card_number', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>
									</div>

									<div class="form-group row">
										<div class="col-lg-3">
											<label>نوع حساب:</label>
											{!! Form::text('account_type', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>موجودی فعلی:</label>
											{!! Form::text('balance', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>واریز صندوق به این حساب:</label>
											<br>
											<br>
											<input type="radio" name="fund" value="1" checked="">بله
											
											<input type="radio" name="fund" value="0">خیر
										</div>


									</div>
								</div>

								<div class="kt-portlet__foot">

										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<button type="submit" class="btn btn-primary">@if(isset($model))به روزرسانی حساب بانکی @else ثبت حساب بانکی @endif</button>
													</div>
													
												</div>
											</div>
								</div>
							</form>
@stop