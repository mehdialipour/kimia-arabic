@extends('layout')
@section('title')
	@if(isset($model))
	ویرایش کاربر
	@else
	افزودن کاربر جدید
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
															ویرایش کاربر
															@else
															افزودن کاربر جدید
														@endif
													</strong>
												</h3>
											</div>
										</div>
									</div>

									@if ($errors->any())
									    <div class="alert alert-danger">
									        <ul>
									            @foreach ($errors->all() as $error)
									                <li>{{ $error }}</li>
									            @endforeach
									        </ul>
									    </div>
									@endif

									<!--begin::Form-->
									@if(isset($model))
										{!! Form::model($model, ['method' => 'PATCH', 'action' => ['UserController@update', $model->id], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
									@else	
										{!! Form::open(['action' => ['UserController@store'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
									@endif	
										<div class="m-portlet__body">	
											<div class="form-group m-form__group">
												<label for="">نام و نام خانوادگی</label>

												{!! Form::text('name', null, ['class' => 'form-control m-input','required' => true, 'autocomplete' => 'off']) !!}
											</div>

											
											<div class="form-group m-form__group">
												<label for="">نام کاربری</label>

												{!! Form::text('username', null, ['class' => 'form-control m-input', 'placeholder' => 'فقط حروف لاتین','required' => true, 'autocomplete' => 'off']) !!}
											</div>
											
										

											
											<div class="form-group m-form__group">
												<label for="">رمز عبور</label>

												<input type="password" class="form-control m-input" name="password" required="">
											</div>
											
										

											
											<div class="form-group m-form__group">
												<label for="">تکرار رمز عبور</label>

												<input type="password" class="form-control m-input" name="password_confirmation" required="">
											</div>
											
											<div class="form-group m-form__group">
												<label for="">نقش در سیستم</label>

												<select class="form-control m-input" required="" name="role_id">
													@foreach($roles as $role)
														<option value="{{ $role->id }}">{{ $role->title }}</option>
													@endforeach
												</select>
											</div>

											
											<div class="form-group m-form__group">
												<label for="">شماره موبایل</label>

												{!! Form::text('mobile', null, ['class' => 'form-control m-input', 'required' => true]) !!}
											</div>
											
										

											
											<div class="form-group m-form__group">
												<label for="">ایمیل</label>

												{!! Form::email('email', null, ['class' => 'form-control m-input']) !!}
											</div>
											
										
									</div>		
										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions">
												<button type="submit" class="btn btn-primary">@if(isset($model))به روزرسانی کاربر @else افزودن کاربر @endif</button>
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