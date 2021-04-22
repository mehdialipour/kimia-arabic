@extends('new.layout')
@section('title')
	@if(isset($model))
	ویرایش کاربر
	@else
	افزودن کاربر جدید
	@endif
@stop
@section('content')
<?php 
$permission = \DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 13)->count();
?>
<div class="kt-portlet kt-portlet--mobile">
							<div class="kt-portlet__head kt-portlet__head--lg">
								<div class="kt-portlet__head-label">
									<span class="kt-portlet__head-icon">
										<i class="kt-font-brand flaticon2-plus-1"></i>
									</span>
									<h3 class="kt-portlet__head-title">
										@if(isset($model))
											@if($permission == 1)
												ویرایش کاربر
											@else
												پروفایل
											@endif
										@else
											افزودن کاربر جدید
										@endif
									</h3>
								</div>

							</div>
							<div class="alert alert-primary" style="font-size: 18px;">
							        <ul>
							                <li>کاربر محترم توجه نمایید که فقط یک بار امکان ویرایش پروفایل وجود دارد. نسبت به صحت اطلاعات وارده اطمینان حاصل نمایید..</li>
							        </ul>
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

							@if(isset($model))
								{!! Form::model($model, ['method' => 'PATCH', 'action' => ['UserController@update', $model->id], 'class' => 'kt-form kt-form--label-right', 'id' => 'users-create', 'files' => true]) !!}
							@else	
								{!! Form::open(['action' => ['UserController@store'], 'class' => 'kt-form kt-form--label-right', 'id' => 'users-create', 'files' => true]) !!}
							@endif
								<div class="kt-portlet__body">
									<div class="form-group row">
										<div class="col-lg-3">
											<label>نام:</label>
											@if(isset($model) && $model->updated_by_user == 1)
											{!! Form::text('firstname', null, ['class' => 'form-control m-input', 'placeholder' => 'نام','required' => true , 'readonly' => true]) !!}
											@else
											{!! Form::text('firstname', null, ['class' => 'form-control m-input', 'placeholder' => 'نام','required' => true]) !!}
											@endif
										</div>

										<div class="col-lg-3">
											<label>نام خانوادگی:</label>
											@if(isset($model) && $model->updated_by_user == 1)
											{!! Form::text('lastname', null, ['class' => 'form-control m-input', 'placeholder' => 'نام خانوادگی','required' => true, 'readonly' => true]) !!}
											@else
											{!! Form::text('lastname', null, ['class' => 'form-control m-input', 'placeholder' => 'نام خانوادگی','required' => true]) !!}
											@endif
										</div>

										<div class="col-lg-3">
											<label>اسم الاب:</label>
											@if(isset($model) && $model->updated_by_user == 1)
											{!! Form::text('father_name', null, ['class' => 'form-control m-input', 'placeholder' => 'اسم الاب','required' => true, 'readonly' => true]) !!}
											@else
											{!! Form::text('father_name', null, ['class' => 'form-control m-input', 'placeholder' => 'اسم الاب','required' => true]) !!}
											@endif
										</div>

										<div class="col-lg-3">
											<label>تاریخ تولد:</label>
											@if(isset($model) && $model->updated_by_user == 1)
											{!! Form::text('birthday', null, ['class' => 'form-control m-input', 'placeholder' => 'تاریخ تولد - مثال: ۱۳۶۰/۰۱/۱۲','required' => true, 'readonly' => true]) !!}
											@else
											{!! Form::text('birthday', null, ['class' => 'form-control m-input', 'placeholder' => 'تاریخ تولد - مثال: ۱۳۶۰/۰۱/۱۲','required' => true]) !!}
											@endif
										</div>
									</div>
									<div class="form-group row">
										<div class="col-lg-3">
											<label>کد ملی:</label>
											@if(isset($model) && $model->updated_by_user == 1)
											{!! Form::text('national_id', null, ['class' => 'form-control m-input', 'placeholder' => 'کد ملی','required' => true, 'readonly' => true]) !!}
											@else
											{!! Form::text('national_id', null, ['class' => 'form-control m-input', 'placeholder' => 'کد ملی','required' => true]) !!}
											@endif
										</div>
										<div class="col-lg-3">
											<label>نام کاربری:</label>
											@if(isset($model) && $model->updated_by_user == 1)
											{!! Form::text('username', null, ['class' => 'form-control m-input', 'placeholder' => 'نام کاربری','required' => true, 'readonly' => true]) !!}
											@else
											{!! Form::text('username', null, ['class' => 'form-control m-input', 'placeholder' => 'نام کاربری','required' => true]) !!}
											@endif
										</div>
										<div class="col-lg-3">
											<label>رمز عبور:</label>
											<input type="password" class="form-control m-input" name="password" required="">
										</div>
										<div class="col-lg-3">
											<label>تکرار رمز عبور:</label>
											<input type="password" class="form-control m-input" name="password_confirmation" required="">
										</div>
									</div>

									<div class="form-group row">
										<div class="col-lg-3">
											@if($permission == 1)
											<label>نقش در سیستم:</label>
												@if(isset($model))
													<select id="role" class="form-control m-input" required="" name="role_id">
														@foreach($roles as $role)
															<option @if($model->role_id == $role->id) selected="" @endif value="{{ $role->id }}">{{ $role->title }}</option>
														@endforeach
													</select>
												@else
													<select id="role" class="form-control m-input" required="" name="role_id">
														@foreach($roles as $role)
															<option value="{{ $role->id }}">{{ $role->title }}</option>
														@endforeach
													</select>
												@endif
											@elseif($permission == 0 && isset($model))
											<label>نقش در سیستم:</label>
											<select id="role" class="form-control m-input" required="" name="role_id">
													<option value="{{ $model->role_id }}">{{ \App\Models\Role::find($model->role_id)->title }}</option>
											</select>
											@endif
										</div>

										<div class="col-lg-3">
											<label>تخصص: </label>
											@if(isset($model) && $model->updated_by_user == 1)
											{!! Form::text('speciality', null, ['class' => 'form-control m-input','readonly' => true, 'id' => 'speciality']) !!}
											@else
											{!! Form::text('speciality', null, ['class' => 'form-control m-input','readonly' => true, 'id' => 'speciality']) !!}
											@endif
										</div>

										<div class="col-lg-3">
											<label>شماره موبایل:</label>
											@if(isset($model) && $model->updated_by_user == 1)
											{!! Form::text('mobile', null, ['class' => 'form-control m-input', 'required' => true, 'readonly' => true]) !!}
											@else
											{!! Form::text('mobile', null, ['class' => 'form-control m-input', 'required' => true]) !!}
											@endif
										</div>

										<div class="col-lg-3">
											<label>شماره تلفن:</label>
											@if(isset($model) && $model->updated_by_user == 1)
											{!! Form::text('phone', null, ['class' => 'form-control m-input', 'required' => true, 'readonly' => true]) !!}
											@else
											{!! Form::text('phone', null, ['class' => 'form-control m-input', 'required' => true]) !!}
											@endif
										</div>
									</div>
									<div class="form-group row">
										<div class="col-lg-3">
											<label>ایمیل:</label>
											@if(isset($model) && $model->updated_by_user == 1)
											{!! Form::email('email', null, ['class' => 'form-control m-input', 'readonly' => true]) !!}
											@else
											{!! Form::email('email', null, ['class' => 'form-control m-input']) !!}
											@endif
										</div>
										<div class="col-lg-3">
											@if($permission == 1)
											<label>کد پرسنلی:</label>
											{!! Form::text('personal_code', null, ['class' => 'form-control m-input', 'placeholder' => 'کد پرسنلی']) !!}
											@else
											<label>کد پرسنلی:</label>
											{!! Form::text('personal_code', null, ['class' => 'form-control m-input', 'placeholder' => 'کد پرسنلی', 'readonly' => true]) !!}
											@endif
										</div>
										<div class="col-lg-3">
											<label>آدرس:</label>
											@if(isset($model) && $model->updated_by_user == 1)
											{!! Form::textarea('address', null, ['class' => 'form-control m-input','rows' => 4, 'readonly' => true]) !!}
											@else
											{!! Form::textarea('address', null, ['class' => 'form-control m-input','rows' => 4]) !!}
											@endif
										</div>
										
										<div class="col-lg-3" @if($permission == 0) style="display: none;" @endif>
											<label style="color: #f00;">پزشک پیشفرض کلینیک:</label>
											<br>
											<input id="default_doctor" name="default_doctor" disabled="" type="checkbox" @if(isset($model)) @if($model->default_doctor == 1) checked="" @endif @endif value="1" style="height: 15px; width: 15px;" name="">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-lg-3">
											<label>آپلود عکس:</label>
											<input type="file" name="profile_image">
										</div>

									</div>
									<table @if($permission == 0) style="display: none;" @endif class="table table-bordered" style="font-size: 11px;">
										<thead>

											

											@foreach($services->chunk(6) as $chunk)

											<tr align="center">
												@if(isset($model))
												@foreach($chunk as $service)
												<td><input style="" type="checkbox" name="services[]" @if(\DB::table('user_services')->where('user_id', $model->id)->where('service_id', $service->id)->count() > 0) checked="" @endif value="{{ $service->id }}"> {{ $service->name }}</td>

												@endforeach	
												@else
												@foreach($chunk as $service)
												<td><input style="" type="checkbox" name="services[]" value="{{ $service->id }}"> {{ $service->name }}</td>

												@endforeach	
												@endif

											</tr>
											@endforeach
										</thead>
									</table>

								<div class="kt-portlet__foot">

										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<button type="submit" class="btn btn-primary">@if(isset($model))به روزرسانی کاربر @else ثبت کاربر @endif</button>
													</div>
													
												</div>
											</div>
								</div>
							</form>



						</div>
@stop
@section('scripts')
<script>
$(document).on('change', '#role', function() {
	role = $("#role option:selected").text();
	if(role == 'پزشک') {
		$("#speciality").removeAttr('readonly');
		$("#default_doctor").removeAttr('disabled');
	} else {
		$("#speciality").attr('readonly','readonly');
		$("#default_doctor").attr('disabled','disabled');
		$("#default_doctor").removeAttr('checked');
	}
});
</script>

@if(isset($model))
<script>
$(document).ready(function() {
	if($("#role option:selected").text() == 'پزشک') {
		$("#speciality").removeAttr('readonly');
		$("#default_doctor").removeAttr('disabled');
	} else {
		$("#speciality").attr('readonly','readonly');
		$("#default_doctor").attr('disabled','disabled');
		$("#default_doctor").removeAttr('checked');
	}
});
</script>
@endif	
@stop