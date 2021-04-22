@extends('new.layout')
@section('title')
	اطلاعات مرکز درمانی
@stop

@section('content')
<div class="kt-portlet kt-portlet--mobile">
							<div class="kt-portlet__head kt-portlet__head--lg">
								<div class="kt-portlet__head-label">
									<span class="kt-portlet__head-icon">
										<i class="kt-font-brand flaticon2-plus-1"></i>
									</span>
									<h3 class="kt-portlet__head-title">
										اطلاعات مرکز درمانی
									</h3>
								</div>

							</div>
								{!! Form::model($model, ['method' => 'PATCH', 'action' => ['SettingController@update', $model->id], 'class' => 'kt-form kt-form--label-right','files' => true]) !!}
								<div class="kt-portlet__body">
									<div class="form-group row">
										<div class="col-lg-3">
											<label>نام مرکز:</label>
											{!! Form::text('name', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>نام مدیر:</label>
											{!! Form::text('manager', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>تلفن:</label>
											{!! Form::text('phone', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>موبایل:</label>
											{!! Form::text('mobile', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>
									</div>
									
									<div class="form-group row">
										<div class="col-lg-3">
											<label>آدرس:</label>
											{!! Form::textarea('address', null, ['class' => 'form-control m-input','required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>وبسایت:</label>
											{!! Form::text('website', null, ['class' => 'form-control m-input']) !!}
										</div>

										<div class="col-lg-3">
											<label>ایمیل:</label>
											{!! Form::text('email', null, ['class' => 'form-control m-input']) !!}
										</div>

										<div class="col-lg-3">
											<label>شماره کارت:</label>
											{!! Form::text('card_number', null, ['class' => 'form-control m-input']) !!}
										</div>
									</div>

									<div class="form-group row">
										<div class="col-lg-3">
											<label>لینک پرداخت:</label>
											{!! Form::text('payment_link', null, ['class' => 'form-control m-input']) !!}
										</div>
									</div>
									
								</div>
								<hr>
								<div>
									<h5>نمایش در فیش پرینتر</h5>
									<table class="table table-bordered">
										<thead>
											<tr align="center">
												<th>
													نام مرکز
												</th>
												<th>
													نام مدیر
												</th>
												<th>
													تلفن
												</th>
												<th>
													موبایل
												</th>
												<th>
													آدرس
												</th>
												<th>
													وبسایت
												</th>
												<th>
													ایمیل
												</th>
											</tr>
										</thead>
										<tbody>
											<tr align="center">
												<td><input type="checkbox" @if(strpos($model->printer, 'name') !== false) checked="" @endif name="printer[]" value="name"></td>
												<td><input type="checkbox" @if(strpos($model->printer, 'manager') !== false) checked="" @endif name="printer[]" value="manager"></td>
												<td><input type="checkbox" @if(strpos($model->printer, 'phone') !== false) checked="" @endif name="printer[]" value="phone"></td>
												<td><input type="checkbox" @if(strpos($model->printer, 'mobile') !== false) checked="" @endif name="printer[]" value="mobile"></td>
												<td><input type="checkbox" @if(strpos($model->printer, 'address') !== false) checked="" @endif name="printer[]" value="address"></td>
												<td><input type="checkbox" @if(strpos($model->printer, 'website') !== false) checked="" @endif name="printer[]" value="website"></td>
												<td><input type="checkbox" @if(strpos($model->printer, 'email') !== false) checked="" @endif name="printer[]" value="email"></td>
											</tr>
										</tbody>	
									</table>
								</div>

								<div class="kt-portlet__foot">

										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<button type="submit" class="btn btn-primary">ثبت اطلاعات</button>
													</div>
													
												</div>
											</div>
								</div>
							</form>
@stop