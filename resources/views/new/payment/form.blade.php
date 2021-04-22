@extends('new.layout')
@section('title')
	افزایش اعتبار پیامکی
@stop

@section('content')
<div class="kt-portlet kt-portlet--mobile col-lg-6 mx-auto">
							<div class="kt-portlet__head kt-portlet__head--lg">
								<div class="kt-portlet__head-label">
									<span class="kt-portlet__head-icon">
										<i class="kt-font-brand flaticon2-plus-1"></i>
									</span>
									<h3 class="kt-portlet__head-title">
										افزایش اعتبار پیامکی
									</h3>
								</div>

							</div>


								
										{!! Form::open(['action' => ['PaymentController@gateway'], 'class' => 'kt-form kt-form--label-right','method' => 'GET']) !!}
									
								<div class="kt-portlet__body">
									<div class="form-group row">
										<div class="col-lg-11 mx-auto">
											<label> مبلغ مورد نظر را از لیست انتخاب کنید:</label><br><br>
											<input type="radio" name="amount" value="200000"> ۲,۰۰۰,۰۰۰ دینار (معادل ۵,۵۲۴ صفحه پیامک به ایرانسل یا ۷,۰۹۲ صفحه پیامک به همراه اول)<br><br>

											<input type="radio" name="amount" value="500000"> ۵,۰۰۰,۰۰۰ دینار (معادل ۱۳,۸۱۲ صفحه پیامک به ایرانسل یا ۱۷,۸۵۷ صفحه پیامک به همراه اول)<br><br>

											<input type="radio" name="amount" value="1000000"> ۱۰,۰۰۰,۰۰۰ دینار (معادل ۲۷,۶۲۴ صفحه پیامک به ایرانسل یا ۳۵,۴۶۰ صفحه پیامک به همراه اول)<br><br>

											<span class="text-danger">* توجه داشته باشید که از مبلغ فوق، ۹٪ مالیات بر ارزش افزوده توسط اپراتور پیامک کسر خواهد شد و تعداد پیامک‌ها، متناسب با مبلغ جدید محاسبه خواهند شد.</span>
										</div>
									</div>
									
								</div>
								<div class="kt-portlet__foot">

										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<button type="submit" class="btn btn-primary">پرداخت</button>
															
													</div>
													
												</div>
											</div>
								</div>
							</form>

							<div class="kt-portlet__foot">
								<p>در صورت تمایل به پرداخت هزینه‌های سالانه‌ی پشتیبانی یا سایر هزینه‌ها و بدهی‌ها به صورت غیرحضوری، از لینک زیر اقدام نمایید. توجه داشته باشید که در صفحه‌ی پرداخت حتما مشخصات کامل و علت پرداخت را بصورت دقیق ذکر کنید.</p>
										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<a target="_new" href="https://zarinp.al/@kimiacis"  class="btn btn-primary">اتصال به درگاه کیمیاطب</a>
															
													</div>
													
												</div>
											</div>
								</div>

						</div>


@stop