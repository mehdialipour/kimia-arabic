@extends('new.layout')
@section('title')
	@if(isset($model))
	ویرایش پذیرش
	@else
	ایجاد پذیرش جدید
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
										ویرایش پرونده
										@else
										ایجاد پرونده جدید
										@endif
									</h3>
								</div>

							</div>

							@if(isset($model))
								{!! Form::model($model, ['method' => 'PATCH', 'action' => ['ReceptionController@update', $model->id], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
							@else	
								{!! Form::open(['action' => ['ReceptionController@store'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
							@endif
								<div class="kt-portlet__body">
									<div class="form-group row">
										<div class="col-lg-4">
											<label>نام بیمار</label>
											{!! Form::select('patient_id',$patients,null,['class' => 'form-control m-input selectbox', 'style' => 'font-family: Vazir']) !!}
										</div>
									</div>
									<div class="form-group row">
										<div class="col-lg-4">
											@if(isset($model) && $model->birth_year == '') 
													@php $style='border-color:red;' @endphp 
												@else 
													@php $style=''; @endphp
												@endif

												<label for="">سبب الارجاع:</label>
												{!! Form::text('cause', null, ['class' => 'form-control m-input', 'required' => true]) !!}
										</div>
									</div>
										
								<div class="kt-portlet__foot">

										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<button type="submit" class="btn btn-primary">@if(isset($model))به روزرسانی پذیرش @else ثبت پذیرش @endif</button>
													</div>
													
												</div>
											</div>
								</div>
							</form>



						</div>
@stop