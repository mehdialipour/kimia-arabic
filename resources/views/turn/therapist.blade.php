@extends('layout')
@section('title')
	ارجاع به روانشناس
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
														ارجاع به روانشناس
													</strong>
												</h3>
											</div>
										</div>
									</div>

									<!--begin::Form-->	
										{!! Form::open(['action' => ['TurnController@therapist', $id], 'class' => 'm-form m-form--fit m-form--label-align-right','files' => true,'id' => 'myForm']) !!}

										<input type="hidden" name="id" value="{{ $id }}">
											
										<div class="m-portlet__body">	
											<div class="form-group m-form__group">
												<label for="">نام بیمار</label>

												<h5><strong>{{ $name }}</strong></h5>
											</div>

											<div class="form-group m-form__group">
												<label for="">مبلغ</label>

												<select name="therapist_fee" class="form-control m-input" style="width: 40%; font-family: Vazir;">
													<option value="0">{{\App\Helpers\ConvertNumber::convertToPersian(0)}} تومان</option>
													@for($i=2; $i<=12; $i++)
														<option value="{{ $i*5000 }}">{{ \App\Helpers\ConvertNumber::convertToPersian($i*5000) }} تومان</option>
													@endfor
												</select>
											</div>


											
										</div>
										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions">
												<button type="submit" class="btn btn-primary">ارجاع به روانشناس</button>
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