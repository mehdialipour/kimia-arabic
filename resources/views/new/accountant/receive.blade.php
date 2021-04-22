@extends('new.layout')
@section('title')
تایید صندوق
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
							<div class="kt-portlet__head kt-portlet__head--lg">
								<div class="kt-portlet__head-label">
									<span class="kt-portlet__head-icon">
										<i class="kt-font-brand flaticon2-plus-1"></i>
									</span>
									<h3 class="kt-portlet__head-title">
										تایید صندوق
									</h3>
								</div>

							</div>
								{!! Form::open(['action' => ['AccountantController@receive'], 'class' => 'kt-form kt-form--label-right','files' => true,'id' => 'myForm']) !!}
							
								<div class="kt-portlet__body">
									<div class="form-group row">
										
										<div class="col-lg-4">
											<label>موجودی صندوق</label>
											<p><h3>{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($query->amount)) }} دینار</h3></p>
										</div>
										<div class="col-lg-4">
										<label>شرح صندوق</label>
										<p><h5>{!! \App\Helpers\ConvertNumber::convertToPersian($query->description) !!}</h5></p>
										</div>

										<div class="col-lg-4">
										<label>تحویل دهنده</label>
										<p><h5>{!! \App\Models\User::find($query->user_id)->name !!}</h5></p>
										</div>


										
									</div>
									<hr>
									<div class="form-group row">
										

										<div class="col-lg-4">
											<label for="">عملیات</label><br>

											<input type="radio" name="reject" value="0" checked=""> تایید موجودی
											<input type="radio" name="reject" value="1"> رد موجودی
										</div>

										<div class="col-lg-4">
										<label>علت عدم پذیرش</label>
										<textarea class="form-control" name="reject_reason"></textarea>
										</div>


										
									</div>
									

																		
								</div>  
								<div class="kt-portlet__foot">

										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<button type="submit" class="btn btn-primary" onclick="return confirm('هل أنت واثق؟؟');">ثبت</button>
													</div>
													
												</div>
											</div>
								</div>
							</form>



						</div>
@stop