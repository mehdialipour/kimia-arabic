@extends('new.layout')
@section('title')
	@if(isset($model))
	ویرایش چک صادر شده
	@else
	صدور چک جدید
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
										ویرایش چک صادر شده
										@else
										صدور چک جدید
										@endif
									</h3>
								</div>

							</div>

							@if(isset($model))
								{!! Form::model($model, ['method' => 'PATCH', 'action' => ['ChequeSerialController@update', $model->id], 'class' => 'kt-form kt-form--label-right','files' => true]) !!}
							@else	
								{!! Form::open(['action' => ['ChequeSerialController@store'], 'class' => 'kt-form kt-form--label-right','files' => true]) !!}
							@endif
								<div class="kt-portlet__body">
									<div class="form-group row">
										<div class="col-lg-2">
											<label>انتخاب چک:</label>
											{!! Form::select('cheque_id',$cheques,null,['class' => 'form-control m-input selectbox', 'placeholder' => 'جستجو کنید..']) !!}
										</div>

										<div class="col-lg-2">
											<label>در وجه:</label>
											{!! Form::text('receiver', null, ['class' => 'form-control m-input','required' => true,'autocomplete' => 'off']) !!}
										</div>

										<div class="col-lg-2">
											<label>مبلغ به دینار:</label>
											{!! Form::text('amount', null, ['class' => 'form-control m-input','required' => true,'autocomplete' => 'off']) !!}
										</div>

										<div class="col-lg-3">
											<label>بابت:</label>
											{!! Form::text('cause', null, ['class' => 'form-control m-input','required' => true,'autocomplete' => 'off']) !!}
										</div>

										<div class="col-lg-3">
											<label>موعد چک:</label>
											{!! Form::text('date', null, ['class' => 'form-control m-input','id' => 'datepicker','autocomplete' => 'off','required' => true]) !!}
										</div>
									</div>
								</div>

								<div class="kt-portlet__foot">

										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<button type="submit" class="btn btn-primary">@if(isset($model))به روزرسانی چک @else صدور چک @endif</button>
													</div>
													
												</div>
											</div>
								</div>
							</form>
@stop