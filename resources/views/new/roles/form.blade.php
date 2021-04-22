@extends('new.layout')
@section('title')
	@if(isset($model))
	ویرایش نقش
	@else
	افزودن نقش جدید
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
											ویرایش نقش
										@else
											افزودن نقش جدید
										@endif
									</h3>
								</div>

							</div>

							@if(isset($model))
								{!! Form::model($model, ['method' => 'PATCH', 'action' => ['RoleController@update', $model->id], 'class' => 'kt-form kt-form--label-right','files' => true]) !!}
							@else	
								{!! Form::open(['action' => ['RoleController@store'], 'class' => 'kt-form kt-form--label-right','files' => true]) !!}
							@endif
								<div class="kt-portlet__body">
									<div class="form-group row">
										<div class="col-lg-3">
											<label>نام فارسی نقش:</label>
											{!! Form::text('title', null, ['class' => 'form-control m-input', 'placeholder' => 'فقط حروف فارسی','required' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>نام لاتین نقشی:</label>
											{!! Form::text('name', null, ['class' => 'form-control m-input', 'placeholder' => 'فقط حروف انگلیسی','required' => true]) !!}
										</div>
									</div>
									<div class="form-group row">
										<div class="col-lg-9">
											<label>دسترسی به: </label>
											<br>
											<table class="table table-bordered">
											<tr>
											@if(isset($model))
												<td><input class="" style="width: 15px; height: 15px;" type="checkbox" @if(strpos($model->access_to, 'مشاهده در انجام خدمات') !== false) checked="" @endif name="access[]" value="مشاهده در انجام خدمات"> <span style="font-size: 15px;"> مشاهده در انجام خدمات
												</td>

												<td><input class="" style="width: 15px; height: 15px;" type="checkbox" @if(strpos($model->access_to, 'مشاهده در تیکت') !== false) checked="" @endif name="access[]" value="مشاهده در تیکت"> <span style="font-size: 15px;"> مشاهده در تیکت
												</td>

												<td><input class="" style="width: 15px; height: 15px;" type="checkbox" @if(strpos($model->access_to, 'مشاهده در ارسال نامه') !== false) checked="" @endif name="access[]" value="مشاهده در ارسال نامه"> <span style="font-size: 15px;"> مشاهده در ارسال نامه
												</td>

												<td><input class="" style="width: 15px; height: 15px;" type="checkbox" @if(strpos($model->access_to, 'مشاهده در حسابداری') !== false) checked="" @endif name="access[]" value="مشاهده در حسابداری"> <span style="font-size: 15px;"> مشاهده در حسابداری
												</td>

												<td><input class="" style="width: 15px; height: 15px;" type="checkbox" @if(strpos($model->access_to, 'مشاهده در لیست مدیر') !== false) checked="" @endif name="access[]" value="مشاهده در لیست مدیر"> <span style="font-size: 15px;"> مشاهده در لیست مدیر</span></td>
											@else	
												<td><input class="" style="width: 15px; height: 15px;" type="checkbox" name="access[]" value="مشاهده در انجام خدمات"> <span style="font-size: 15px;"> مشاهده در انجام خدمات
												</td><td><input class="" style="width: 15px; height: 15px;" type="checkbox" name="access[]" value="مشاهده در تیکت"> <span style="font-size: 15px;"> مشاهده در تیکت
												</td><td><input class="" style="width: 15px; height: 15px;" type="checkbox" name="access[]" value="مشاهده در ارسال نامه"> <span style="font-size: 15px;"> مشاهده در ارسال نامه
												</td><td><input class="" style="width: 15px; height: 15px;" type="checkbox" name="access[]" value="مشاهده در حسابداری"> <span style="font-size: 15px;"> مشاهده در حسابداری
												</td><td><input class="" style="width: 15px; height: 15px;" type="checkbox" name="access[]" value="مشاهده در لیست مدیر"> <span style="font-size: 15px;"> مشاهده در لیست مدیر</span></td>
											@endif
										</tr>
									</table>
										</div>
									</div>
								</div>

								<div class="kt-portlet__foot">

										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<button type="submit" class="btn btn-primary">@if(isset($model))به روزرسانی نقش @else ثبت نقش @endif</button>
													</div>
													
												</div>
											</div>
								</div>
							</form>
@stop