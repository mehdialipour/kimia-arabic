@extends('new.layout')
@section('title')
	افزودن موجودی
@stop

@section('content')
<div class="kt-portlet kt-portlet--mobile">
							<div class="kt-portlet__head kt-portlet__head--lg">
								<div class="kt-portlet__head-label">
									<span class="kt-portlet__head-icon">
										<i class="kt-font-brand flaticon2-plus-1"></i>
									</span>
									<h3 class="kt-portlet__head-title">
										افزودن موجودی
									</h3>
								</div>

							</div>

							
								{!! Form::open(['action' => ['DrugStorageController@submitTransfer'], 'class' => 'kt-form kt-form--label-right','id' => 'storage-create','files' => true]) !!}

								<input type="hidden" value="{{ $model->id }}" name="id">
							
								<div class="kt-portlet__body">
									<div class="form-group row">

										<div class="col-lg-3">
											<label>بارکد:</label>
											<p>{{ $model->code }}</p>
										</div>

										<div class="col-lg-3">
											<label>نام فارسی کالا:</label>
											<p>{{ $model->name_fa }}</p>
										</div>

										<div class="col-lg-3">
											<label>نام لاتین کالا:</label>
											<p>{{ $model->name_en }}</p>
										</div>

										<div class="col-lg-3">
											<label>نام تجاری:</label>
											<p>{{ $model->name_co }}</p>
										</div>
									</div>
									<div class="form-group row">

										<div class="col-lg-3">
											<label>نام شرکت تولید کننده:</label>
											<p>{{ $model->company_name }}</p>
										</div>

										<div class="col-lg-3">
											<label>نام شرکت توزیع کننده:</label>
											<p>{{ $model->distributer }}</p>
										</div>

										<div class="col-lg-3">
											<label>نوع دارو:</label>
											<p>{{ $model->drug_form }}</p>
										</div>

										<div class="col-lg-3">
											<label>دسته بندی دارو:</label>
											<p>{{ $model->drug_category }}</p>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-lg-3">
											<label>تاریخ انقضا:</label>
											<p>{{ $model->expire_date }}</p>
										</div>

										<div class="col-lg-3">
											<label>قیمت خرید:</label>
											<p>{{ $model->buy_price }}</p>
										</div>

										<div class="col-lg-3">
											<label>قیمت فروش:</label>
											
											<p>{{ $model->sell_price }}</p>
										</div>

										<div class="col-lg-3">
											<label>موجودی فعلی:</label>
											<p>{{ $model->amount }}</p>	
										</div>

										
									</div>
									<div class="form-group row">
										<div class="col-lg-3">
											<label>انتخاب انبار:</label>
											<select name="storage" class="form-control">
												<option value="1">قفسه‌ی داروخانه</option>
												<option value="2">انبار مرکز دارویی</option>
											</select>
										</div>	
										<div class="col-lg-3">
											<label>تعداد:</label>
											<input type="number" name="amount" value="0" min="0" class="form-control m-input" name="">
										</div>

										
									</div>
								</div>

								<div class="kt-portlet__foot">

										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<button onclick="return confirm('هل أنت واثق؟؟');" type="submit" class="btn btn-primary">انتقال </button>
													</div>
													
												</div>
											</div>
								</div>
							</form>
@stop