@extends('layout')
@section('title')
	@if(isset($model))
	ویرایش خدمت
	@else
	ایجاد خدمت جدید
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
														ویرایش خدمت
														@else
														ایجاد خدمت جدید
														@endif
													</strong>
												</h3>
											</div>
										</div>
									</div>

									<!--begin::Form-->
									@if(isset($model))
										{!! Form::model($model, ['method' => 'PATCH', 'action' => ['ServiceController@update', $model->id], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
									@else	
										{!! Form::open(['action' => ['ServiceController@store'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
									@endif		
										<div class="m-portlet__body">	
											<div class="form-group m-form__group">
												<label for="">نام خدمت</label>

												{!! Form::text('name', null, ['class' => 'form-control m-input', 'placeholder' => 'نام خدمت']) !!}
											</div>
											
										</div>

										@foreach($insurances as $row)
											<div class="m-portlet__body">	
												<div class="form-group m-form__group">
													<label for="">تعرفه {{ $row->name }} (دینار)</label>

													{!! Form::text('tariff[]', @$tariffs[$row->id], ['class' => 'form-control m-input', 'placeholder' => 'تعرفه دیناری '.$row->name.' برای این خدمت']) !!}
												</div>
											
											</div>
										@endforeach

										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions">
												<button type="submit" class="btn btn-primary">@if(isset($model))به روزرسانی خدمت @else ثبت خدمت @endif</button>
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