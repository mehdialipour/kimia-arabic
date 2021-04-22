@extends('new.layout')
@section('title')
تحویل صندوق
@stop
@section('content')
<?php

$string = '<p><h3>موجودی صندوق: '. \App\Helpers\ConvertNumber::convertToPersian(number_format($fund-$discount-$debt-$added+$received_debt_amount)) .' دینار</h3></p>

											<p>مجموع صندوق: '. \App\Helpers\ConvertNumber::convertToPersian(number_format($fund)) .' دینار</h3></p>

											<p>مجموع بستانکاری ثبت شده: '. \App\Helpers\ConvertNumber::convertToPersian(number_format($debt)) .' دینار</h3></p>

											<p>مجموع تخفیف ثبت شده: '. \App\Helpers\ConvertNumber::convertToPersian(number_format($discount)) .' دینار</h3></p>

											<p>مجموع افزایش قیمت ثبت شده: '. \App\Helpers\ConvertNumber::convertToPersian(number_format($added*-1)) .' دینار</h3></p>

											<p>مجموع تسویه بدهی امروز: '. \App\Helpers\ConvertNumber::convertToPersian(number_format($received_debt_amount)) .' دینار</h3></p>';

?>
<div class="kt-portlet kt-portlet--mobile">
							<div class="kt-portlet__head kt-portlet__head--lg">
								<div class="kt-portlet__head-label">
									<span class="kt-portlet__head-icon">
										<i class="kt-font-brand flaticon2-plus-1"></i>
									</span>
									<h3 class="kt-portlet__head-title">
										تحویل صندوق
									</h3>
								</div>

							</div>
								{!! Form::open(['action' => ['AccountantController@deliver'], 'class' => 'kt-form kt-form--label-right','files' => true,'id' => 'myForm']) !!}
							
								<div class="kt-portlet__body">
									<div class="form-group row">
										
										<div class="col-lg-4">
											{!! $string !!}

											
										</div>
										<div class="col-lg-4">
											<label class="">نقد:</label>
											<input type="text" class="form-control m-input" name="cash" id="cash" placeholder="میزان پول نقد موجود در صندوق به دینار" autocomplete="off" required="">
										</div>
										<div class="col-lg-4">
											<label class="">کارتخوان:</label>
											<input type="text" class="form-control m-input" name="card" id="card" placeholder="میزان تراکنش کارت‌خوان به دینار" autocomplete="off" required="">
											<input type="hidden" name="fund" value="{{ $fund-$discount-$debt-$added+$received_debt_amount }}">
										</div>


										
									</div>

									<div class="form-group row">
										
										<div class="col-lg-4">
											<label>تحویل صندوق به: </label>
											{!! Form::select('delivered_to', $user, null, ['class' => 'form-control m-input selectbox', 'style' => 'font-family: Vazir','placeholder' => 'انتخاب کاربر', 'required']) !!}
										</div>
											

										<div class="col-lg-4">
											<label class="">توضیحات:</label>
											<textarea class="form-control m-input" name="description"></textarea>
										</div>		
										<input type="hidden" name="detail" value="{!! $string !!}">

										
									</div>
									

																		
								</div>  
								<div class="kt-portlet__foot">

										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<button type="submit" class="btn btn-primary">تحویل صندوق</button>
													</div>
													
												</div>
											</div>
								</div>
							</form>



						</div>
@stop
@section('scripts')
<script>
$(document).ready(function(){
    $("input[type='text']").keyup(function(event){
      // skip for arrow keys
      if(event.which >= 37 && event.which <= 40){
          event.preventDefault();
      }
      var $this = $(this);
      var num = $this.val().replace(/,/gi, "").split("").reverse().join("");
      
      var num2 = RemoveRougeChar(num.replace(/(.{3})/g,"$1,").split("").reverse().join(""));
      
      console.log(num2);
      
      
      // the following line has been simplified. Revision history contains original.
      $this.val(num2);
  });
});

function RemoveRougeChar(convertString){
    
    
    if(convertString.substring(0,1) == ","){
        
        return convertString.substring(1, convertString.length)            
        
    }
    return convertString;
    
}
</script>
@stop