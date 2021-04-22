@extends('new.layout')
@section('title')
	ویرایش نوبت
@stop
@section('content')
@if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 2)->count() == 1)
@php
	$style = '';
@endphp
@else
@php
	$style = 'style=display:none;';	
@endphp
@endif
<div class="kt-portlet kt-portlet--mobile">
							<div class="kt-portlet__head kt-portlet__head--lg">
								<div class="kt-portlet__head-label">
									<span class="kt-portlet__head-icon">
										<i class="kt-font-brand flaticon2-plus-1"></i>
									</span>
									<h3 class="kt-portlet__head-title">
										ویرایش نوبت
									</h3>
								</div>

							</div>

								{!! Form::open(['action' => ['TurnController@updateTurn'], 'class' => 'kt-form kt-form--label-right turns-create','files' => true,'id' => 'myForm','onkeydown' => 'return event.key != "Enter";']) !!}
								<input type="hidden" name="id" value="{{ $id }}">
							
								<div class="kt-portlet__body">
									<div class="form-group row">
										<div class="col-lg-3">
											<label>نام و نام خانوادگی بیمار:</label>
											<h5><strong>{{ $name }}</strong></h5>
										</div>
										<div class="col-lg-3">
											<label class="">سبب الارجاع:</label>
											<select class="form-control" name="reception_id">
													@foreach($receptions as $row)
														<option value="{{ $row->id }}">{!! $row->cause !!}</option>
													@endforeach
											</select>
											<input type="hidden" id="patients" value="{{ $row->patient_id }}">
										</div>
										
										<div class="col-lg-3" {{ $style }}>
												<label class="">نوع بیمه:</label>
												<select class="form-control m-input" id="insurances" style="font-family: Vazir" required="required" placeholder="انتخاب کنید..">

													@foreach($insurances as $insurance) 
														<option value="{{ $insurance->id }}" @if($insurance->id == $insurance_id) selected="" @endif>
															{{ $insurance->name }}
														</option>
													@endforeach
													
												</select>
										</div>
										<div class="col-lg-3">
										</div>


										
									</div>
									<div class="form-group row" {{ $style }}>
										
											<div class="col-lg-3">
													<label class="">شماره بیمه:</label>
													<input type="text" class="form-control m-input" name="insurance_code" id="insurance_code" placeholder="شماره بیمه" autocomplete="off" value="{{ $insurance_code }}">
												</div>

												<div class="col-lg-3">
														<label class="">تاریخ:</label>
														{!! Form::text('date', $date[0], ['class' => 'form-control m-input', 'id' => 'datepicker', 'placeholder' => '', 'required' => true,'autocomplete' => 'off']) !!}
												<span style="font-size: 16px;" class="text-success" id="message"></span>
													</div>

													<div class="col-lg-3" id="datetimepicker3">
												<label for="">ساعت</label>

												<span class="add-on">
											      <i class="fa fa-clock">
											      </i>
											    </span>
											    <?php 
											    $time = explode(" ", $model->turn_time);
											    ?>
												<input data-format="hh:mm:ss" name="time" value="{{ $time[1] }}" type="text" class="form-control m-input">
											    
											</div>
											<div class="col-lg-3">
												<label for="">انتخاب پزشک پیش‌فرض خدمات کلینیکی</label>

												<select  name="doctor_id" class="form-control m-input selectbox" style="font-family: Vazir;">
													<option value="0">خدمات کلینیکی</option>
													@foreach($doctors as $doctor)
														<option value="{{ $doctor->id }}" @if($model->doctor_id == $doctor->id) selected="" @endif>{{ $doctor->name }}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-lg-6" id="append">
												<label for="">انتخاب خدمت </label>
												
												<?php 
																$arr = [];
																$query = \DB::table('service_turn')
																         ->where('turn_id', $id)
																         ->get(); 
															?>
															@foreach($query as $q)		
															<table style="width: max-content;" id="">
																<thead>
																	<tr align="center">
																		<th>	
																			
																		</th>
																		<th>
																			
																		</th>
																	</tr>
																</thead>
																<tbody>
																	<tr align="center">
																		<td>
												        	<?php $servicename = \App\Models\Service::find($q->service_id)->name; ?>
											        			<select style="width: 250px;" class="form-control m-input" id="medicines" style="font-family: Vazir" required="required" name="" placeholder="">
											        				 <option value="{{ $q->service_id }}">{{ $servicename }}</option>
											        			</select>
											        		</td>
											        		
											        		<td>
											        			<input type="number" @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 52)->count() == 1) step="0.1" @endif autocomplete="off" readonly="" placeholder="تعداد" min="0" value="{{ $q->count }}" id="dose" name="" class="form-control m-input">
											        		</td>
											        		<td>
											        			<?php $nursename = \App\Models\User::find($q->user_id)->name; ?>
											        						<select style="width: 250px;" name="" class="form-control m-input" style="font-family: Vazir;">
																					<option value="{{ $q->user_id }}" selected="">{{ $nursename }}</option>
																			</select>
											        		</td>
											        	</tr>
											        </tbody>
											    </table>
											    @endforeach
											    <table style="width: max-content;" id="tbl">
									<thead>
										<tr align="center">
											<th>	
												
											</th>
											<th>
												
											</th>
											<th>
												
											</th>
											<th>
												
											</th>
										</tr>
									</thead>
									<tbody>
										<tr align="center">
											<td>
					        	
				        			<select style="width: 250px;" class="form-control m-input" id="medicines" style="font-family: Vazir" required="required" name="services[]" placeholder="">
				        				<option selected="" disabled="" value="0">جستجو کنید</option>
				        				@foreach($services as $service)
				        				 <option value="{{ $service->id }}">{{ $service->name }}</option>
				        				@endforeach
				        			</select>
				        		</td>
				        		<td>
				        			<input type="number" @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 52)->count() == 1) step="0.1" @endif autocomplete="off" placeholder="تعداد" min="0" id="dose" value="1" name="count[]" class="form-control m-input">
				        		</td>

				        		<td>
				        						<select style="width: 250px;" name="user_id[]" class="form-control m-input " style="font-family: Vazir;">
				        							@if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 2)->count() == 1)
													@foreach($nurses as $nurse)
														<option value="{{ $nurse->id }}">{{\App\Models\Role::find($nurse->role_id)->title }} - {{ $nurse->name }}</option>
													@endforeach

													@else
														<option value="{{ \Session::get('user_id') }}">{{ \Session::get('name') }}</option>
													@endif
												</select>
				        		</td>
				        		<td>
				        			<button type="button" id="plus" class="btn btn-primary"><i class="fa fa-plus"></i></button>
				        		</td>
				        	</tr>
				        </tbody>
				    </table>
								
				 </div>
				 <div class="form-group row"> 
				 @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 22)->count() == 1)
				        	<div class="col-lg-4" id="append_drug">
									<label for="">انتخاب اقلام مصرفی</label>
								<table id="tbl_drug">
									<thead>
										<tr align="center">
											<th>
												
											</th>
											<th>
												
											</th>
											<th>
												
											</th>
										</tr>
									</thead>
									<tbody>
										<tr align="center">
											<td>
					        	
				        			<select class="form-control m-input" id="drugs" style="font-family: Vazir; width: 500px;" name="drugs[]" placeholder="">
				        				<option selected="" disabled="" value="0">جستجو کنید</option>
				        				@foreach($drugs as $row)
				        				 <option value="{{ $row->id }}">{{ $row->name_en }} - {{ $row->name_fa }}</option>
				        				@endforeach
				        			</select>
				        		</td>
				        		<td>
				        			<input type="number" @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 52)->count() == 1) step="0.1" @endif autocomplete="off" style="width: 60px;" min="0" placeholder="تعداد" value="1" name="count_drugs[]" class="form-control m-input">
				        		</td>
				        		<td>
				        			<button type="button" id="plus_drug" class="btn btn-primary"><i class="fa fa-plus"></i></button>
				        		</td>
				        	</tr>
				        </tbody>
				    </table>


				        	</div>
				        	@endif
				</div>
				<div class="form-group row">

				        	<div class="col-lg-3" {{ $style }}>
																	<label class="">هزینه خدمات:</label>

																	@if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 2)->count() == 1)
																	<div class="kt-radio-inline">
																		<label class="kt-radio kt-radio--solid">
																			<input type="radio" name="money_received" value="1" @if(\App\Models\Invoice::where('turn_id', $model->id)->first()->paid == 1) checked="" @endif> دریافت شد
																			<span></span>
																		</label>
																		<label class="kt-radio kt-radio--solid">
																			<input type="radio" name="money_received" value="0" @if(\App\Models\Invoice::where('turn_id', $model->id)->first()->paid == 0) checked="" @endif> دریافت نشد
																			<span></span>
																		</label>
																		<br>
																		<button type="button" id="calculate" class="btn-success">محاسبه هزینه خدمات</button><span class="text-primary" style="font-size: 20px;" id="price"></span>

																	</div>
																	</div>
																	@else
																	<div class="kt-radio-inline">
																		<label class="kt-radio kt-radio--solid">
																			<input type="radio" name="money_received" value="0" checked="" > دریافت نشد
																			<span></span>
																		</label>
																		<br>
																		<button type="button" id="calculate" class="btn-success">محاسبه هزینه خدمات</button><span class="text-primary" style="font-size: 20px;" id="price"></span>

																	</div>
																	</div>
																	@endif

																	
				        </div>

																		
																	</div>  
								<div class="kt-portlet__foot">

										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<button type="submit" class="btn btn-primary">@if(isset($model))به روزرسانی نوبت @else ثبت نوبت @endif</button>
													</div>
													
												</div>
											</div>
								</div>
							</form>



						</div>
@stop
@section('scripts')

<script>
	$("#plus").click(function() {
		var $services = $('#tbl').clone(true);
		$($services).find('#dose').val('1');
  		$('#append').append($services);
	});
</script>
<script>
	$(document).on('click','#calculate', function() {
		$.ajax({
	        url: "{!! url('turns/calculate-services') !!}",
	        type: "post",
	        data: {
	            q: $('select[name="services[]"]').map(function(){ 
                    return this.value; 
                }).get(),
                patient: $('#patients').val(),
                count: $('input[name="count[]"]').map(function(){ 
                    return this.value; 
                }).get(),
                drugs: $('select[name="drugs[]"]').map(function(){ 
                    return this.value; 
                }).get(),
                count_drugs: $('input[name="count_drugs[]"]').map(function(){ 
                    return this.value; 
                }).get(),
	        },
	        success: function (data) {
	            $("#price").html(data);
	        }
	    });
	})
</script>
<script type="text/javascript">
  $(function() {
    $('#datetimepicker3').datetimepicker({
      pickDate: false
    });
  });
</script>	
	<script>
		$(document).on('keydown', '#patient_name', function(e){
		    if(e.which == 13) {
		    $.ajax({
		        url: "{!! url('search-turn') !!}",
		        type: "post",
		        data: {
		            q: $("#patient_name").val(),
		        },
		        success: function (data) {
		            $("#results2").html(data);
		            $('#patients').attr('size',4);
		        }
		    });
		}


	});

	</script>	

	<script>
		$(document).on("change", "#patients", function () {

		    $('#patients').attr('size',1);
            $.ajax({
                url: "{!! url('receptions/load') !!}",
                type: "post",
                data: {
                    patient_id: $('#patients').val(),
                },
                success: function (data) {
                	if(data == 'oops!') {
                		window.location.replace('{{ url('patients') }}'+'/'+$('#patients').val()+'/edit?redirect=create');
                	} else {
                    	$("#causes").html(data);
                    	$("#patient_name").val('');
                    }
                }
            });
        });
	</script>

	<script>
		$(document).on("change", "#datepicker", function () {
            $.ajax({
                url: "{!! url('turns/count-turns') !!}",
                type: "post",
                data: {
                    date: $('#datepicker').val(),
                },
                success: function (data) {
                    $("#message").html(data);
                }
            });
        });
	</script>

	<script>
		$(document).on("change", "#insurances", function () {
            $.ajax({
                url: "{!! url('patients/change-insurance') !!}",
                type: "post",
                data: {
                    patient_id: $('#patients').val(),
                    insurance_id: $('#insurances').val(),
                    insurance_code: $("#insurance_code").val()
                },
                success: function (data) {
                    console.log('insurance changed!');
                }
            });
        });
	</script>

	<script>
		$(document).on("keyup", "#insurance_code", function () {
            $.ajax({
                url: "{!! url('patients/change-insurance') !!}",
                type: "post",
                data: {
                    patient_id: $('#patients').val(),
                    insurance_id: $('#insurances').val(),
                    insurance_code: $("#insurance_code").val()
                },
                success: function (data) {
                    console.log('insurance changed!');
                }
            });
        });
	</script>


<script>
	$(document).on('click','#files', function() {
		$("#list").html("");		
	});
  function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.createElement('span');
          span.innerHTML = ['<img class="thumb" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
          document.getElementById('list').insertBefore(span, null);
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }

  document.getElementById('files').addEventListener('change', handleFileSelect, false);

</script>	
<script>
	$("#plus_drug").click(function() {
		var $drugs = $('#tbl_drug').clone(true);
  		$('#append_drug').append($drugs);
	});
</script>
@stop