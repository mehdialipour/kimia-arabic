@extends('new.layout')
@section('title')
	@if(isset($model))
	ویرایش کالا
	@else
	افزودن کالا جدید
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
											ویرایش کالا
										@else
											افزودن کالا جدید
										@endif
									</h3>
								</div>

							</div>

							@if(isset($model))
								{!! Form::model($model, ['method' => 'PATCH', 'action' => ['DrugStorageController@update', $model->id], 'class' => 'kt-form kt-form--label-right','id' => 'storage-create','files' => true]) !!}
							@else	
								{!! Form::open(['action' => ['DrugStorageController@store'], 'class' => 'kt-form kt-form--label-right','id' => 'storage-create','files' => true]) !!}
							@endif
								<div class="kt-portlet__body">
									<div class="form-group row">

										<div class="col-lg-3">
											<label>بارکد:</label>
											{!! Form::text('code', null, ['class' => 'form-control m-input', 'required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>نام فارسی کالا:</label>
											{!! Form::text('name_fa', null, ['class' => 'form-control m-input', 'placeholder' => 'فقط حروف فارسی','required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>نام لاتین کالا:</label>
											{!! Form::text('name_en', null, ['class' => 'form-control m-input', 'placeholder' => 'فقط حروف انگلیسی','required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>نام تجاری:</label>
											{!! Form::text('name_co', null, ['class' => 'form-control m-input', 'required' => true]) !!}
										</div>
									</div>
									<div class="form-group row">

										<div class="col-lg-3">
											<label>نام شرکت تولید کننده:</label>
											{!! Form::text('company_name', null, ['class' => 'form-control m-input']) !!}
										</div>

										<div class="col-lg-3">
											<label>نام شرکت توزیع کننده:</label>
											{!! Form::text('distributer', null, ['class' => 'form-control m-input']) !!}
										</div>

										<div class="col-lg-3">
											<label>نحوه مصرف:</label>
											<select class="form-control selectbox" name="drug_form">
												<option value="تزریقی عضلانی">تزریقی عضلانی</option>
												<option value="موضعی">موضعی</option>
												<option value="خوراکی">خوراکی</option>
												<option value="واژینال">واژینال</option>
												<option value="شسشتوی زخم">شسشتوی زخم</option>
												<option value="مقعدی">مقعدی</option>
												<option value="زیرزبانی">زیرزبانی</option>
												<option value="چشمی">چشمی</option>
												<option value="داخل مثانه">داخل مثانه</option>
												<option value="تزریق، پودر">تزریق، پودر</option>
												<option value="بینی">بینی</option>
												<option value="تزریقی عادی">تزریقی عادی</option>
												<option value="تنفسی">تنفسی</option>
											</select>
										</div>

										<div class="col-lg-3">
											<label>واحد مصرف:</label>
											<select class="form-control selectbox2" name="drug_category">
												<option value="cc">cc</option>
												<option value="mg">mg</option>
												<option value="عدد">عدد</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-lg-3">
											<label>تاریخ انقضا:</label>
											{!! Form::date('expire_date', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>قیمت خرید: (هر واحد)</label>
											{!! Form::text('buy_price', null, ['class' => 'form-control m-input']) !!}
										</div>

										<div class="col-lg-3">
											<label>قیمت فروش: (هر واحد)</label>
											{!! Form::text('sell_price', null, ['class' => 'form-control m-input']) !!}
										</div>

										<div class="col-lg-3">
											<label>موجودی:</label>
											@if(isset($model))
												{!! Form::text('amount', null, ['class' => 'form-control m-input','required' => true, 'readonly' => true]) !!}
											@else
												{!! Form::text('amount', null, ['class' => 'form-control m-input','required' => true]) !!}
											@endif	
										</div>

										
									</div>
									<div class="form-group row">

										<div class="col-lg-3">
											<label>نوع المنتج:</label>
											<select name="type" class="form-control m-input">
												<option value="1">داروی گیاهی</option>
												<option value="2">داروی شیمیایی</option>
												<option value="3">کالای مصرفی</option>
											</select>
										</div>

										
									</div>
								</div>

								<div class="kt-portlet__foot">

										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<button type="submit" class="btn btn-primary">@if(isset($model))به روزرسانی کالا @else ثبت کالا @endif</button>
													</div>
													
												</div>
											</div>
								</div>
							</form>
@stop