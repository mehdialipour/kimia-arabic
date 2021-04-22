@extends('layout')
@section('title')
پرسشنامه {{ $gender }} {{ $name }}
@stop

@section('content')
<div class="m-content" style="width: 100%;">
						<div class="row">
							<div class="col-md-3">
							</div>	
							<div class="col-md-6">
								<div align="center">
									<a style="margin: 0px 0px 0px;" href="{{ url('receptions/'.$reception_id) }}" class="btn btn-success">مشاهده پرونده</a>
												<a style="margin: 0px 0px 0px;" href="{{ url('patients/'.$turn_id.'/to-wait') }}" class="btn btn-success">ارجاع به انتظار</a>
												<a style="margin: 0px 0px 0px;" href="{{ url('patients/'.$turn_id.'/to-office') }}" class="btn btn-success">ارجاع به مطب</a>
												<hr>
								</div>
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
														پرسشنامه {{ $gender }} {{ $name }}
													</strong>
												</h3>
											</div>
										</div>
									</div>
									<?php $i=1; ?>

									<!--begin::Form-->
										{!! Form::open(['action' => ['PatientController@questions', $id], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
										@foreach($questions as $row)
										<div class="m-portlet__body">	
											<div class="form-group m-form__group">
												<label for="">{{ \App\Helpers\ConvertNumber::convertToPersian($i++) }} - {{ $row->title }}</label>
												<br><br>
												
												@if($row->type == 'radio')
													<?php 
														$options = \App\Models\Option::where('question_id', $row->id)->get();
													?>
													@foreach($options as $option)
														<input class="" type="radio" name="question_{{ $row->id }}" value="{{ $option->id }}" style="margin-right: 20px"> {{ $option->title }}
													@endforeach	

												@elseif($row->type == 'checkbox')
													<?php 
														$options = \App\Models\Option::where('question_id', $row->id)->get();
													?>
													@foreach($options as $option)
														<input class="" type="checkbox" name="question_{{ $row->id }}[]" value="{{ $option->id }}" style="margin-right: 20px"> {{ $option->title }}
													@endforeach	

												@else
													<input type="text" class="form-control m-input" name="question_{{ $row->id }}">
												@endif
												
											</div>

										</div>
										@endforeach
										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions">
												<button type="submit" class="btn btn-primary">ثبت پرسشنامه</button>
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