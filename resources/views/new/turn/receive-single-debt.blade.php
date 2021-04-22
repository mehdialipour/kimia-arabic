@extends('new.layout')
@section('title')
	دریافت بدهی 
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
							<div class="kt-portlet__head kt-portlet__head--lg">
								<div class="kt-portlet__head-label">
									<span class="kt-portlet__head-icon">
										<i class="kt-font-brand flaticon2-plus-1"></i>
									</span>
									<h3 class="kt-portlet__head-title">
										دریافت بدهی
									</h3>
								</div>

							</div>

								

							<form action="" method="get">
								<div class="form-group row">
									<div class="col-lg-4">
									</div>
									<div class="col-lg-4">
										@if($errors->any())
											<p class="text-danger">مبلغ تسویه بیشتر از مبلغ بدهی است.</p>
										@endif
									</div>
									<div class="col-lg-4">
									</div>
									</div>
								<div class="kt-portlet__body">
									
									<div class="form-group row">
										<div class="col-lg-3">
											<label>نام بیمار:</label>
											{!! Form::text('', $name, ['class' => 'form-control m-input', 'placeholder' => 'نام بیمار','readonly' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>میزان بدهی:</label>
											{!! Form::text('', $debt.' دینار', ['class' => 'form-control m-input', 'placeholder' => 'نام خانوادگی بیمار','readonly' => true]) !!}
										</div>

										<div class="col-lg-3">
											<label>میزان تسویه به دینار:</label>
											{!! Form::text('amount', $debt, ['class' => 'form-control m-input format', 'placeholder' => '','required' => true]) !!}
										</div>

										
									</div>
								<div class="kt-portlet__foot">

										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<button type="submit" class="btn btn-primary" id="submit">دریافت بدهی</button>
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
                $(".format").keyup(function(event){
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
