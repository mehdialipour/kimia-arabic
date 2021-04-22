@extends('new.layout')
@section('title')
	نوبت دهی آینده
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
							<div class="kt-portlet__head kt-portlet__head--lg">
								<div class="kt-portlet__head-label">
									<span class="kt-portlet__head-icon">
										<i class="kt-font-brand flaticon2-plus-1"></i>
									</span>
									<h3 class="kt-portlet__head-title">
										نوبت دهی آینده
									</h3>
								</div>

							</div>


							{!! Form::open(['action' => ['TurnController@store'], 'class' => 'm-form m-form--fit m-form--label-align-right','files' => true,'id' => 'myForm']) !!}
							<input type="hidden" name="id" value="{{ $id }}">
								<div class="kt-portlet__body">
									<div class="form-group row">
										<div class="col-lg-3">
											<label>نام و نام خانوادگی بیمار:</label>
											<h5><strong>{{ $name }}</strong></h5>
										</div>
										<div class="col-lg-3" id="causes">
											
										</div>
										<div class="col-lg-3">
												<label class="">نوع بیمه:</label>
												<select class="form-control m-input" id="insurances" required="required" placeholder="انتخاب کنید..">
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
									<div class="form-group row">
										
											<div class="col-lg-3">
													<label class="">شماره بیمه:</label>
													<input type="text" class="form-control m-input" name="insurance_code" id="insurance_code" placeholder="شماره بیمه" autocomplete="off" value="{{ $insurance_code }}">
												</div>

												<div class="col-lg-3">
														<label class="">تاریخ:</label>
														{!! Form::text('date', null, ['class' => 'form-control m-input', 'id' => 'datepicker', 'placeholder' => '', 'required' => true,'autocomplete' => 'off']) !!}
												<span style="font-size: 16px;" class="text-success" id="message"></span>
													</div>

													<div class="col-lg-3" id="datetimepicker3">
												<label for="">ساعت</label>

												<span class="add-on">
											      <i class="fa fa-clock">
											      </i>
											    </span>
												<input data-format="hh:mm:ss" name="time" value="" type="text" class="form-control m-input">
											    
											</div>
											<div class="col-lg-3">
												<label for="">انتخاب پزشک</label>

												<select  name="doctor_id" class="form-control m-input selectbox" style="font-family: Vazir;">
													<option value="0">خدمات کلینیکی</option>
													@foreach($doctors as $doctor)
														<option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ \App\Models\Role::find(\App\Models\User::find($doctor->id)->role_id)->title }}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="form-group row">
<div class="col-lg-6" id="append">
									<label for="">انتخاب خدمت</label>
								<table id="tbl">
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
					        	
				        			<select class="form-control m-input" id="medicines" style="font-family: Vazir" required="required" name="services[]" placeholder="">
				        				<option selected="" disabled="" value="0">جستجو کنید</option>
				        				@foreach($services as $service)
				        				 <option value="{{ $service->id }}">{{ $service->name }}</option>
				        				@endforeach
				        			</select>
				        		</td>
				        		<td>
				        			<input type="number" placeholder="تعداد" id="dose" name="count[]" class="form-control m-input">
				        		</td>

				        		<td>
				        						<select  name="user_id[]" class="form-control m-input" style="font-family: Vazir;">
													<option value="0">انتخاب مسئول</option>
													@foreach($nurses as $nurse)
														<option value="{{ $nurse->id }}">{{ $nurse->name }}</option>
													@endforeach
												</select>
				        		</td>
				        		<td>
				        			<button type="button" id="plus" class="btn btn-primary"><i class="fa fa-plus"></i></button>
				        		</td>
				        	</tr>
				        </tbody>
				    </table>


				        	</div>
				        	<div class="col-lg-3">
																	<label class="">هزینه خدمات:</label>
																	<div class="kt-radio-inline">
																		<label class="kt-radio kt-radio--solid">
																			<input type="radio" name="money_received" value="1" checked=""> دریافت شد
																			<span></span>
																		</label>
																		<label class="kt-radio kt-radio--solid">
																			<input type="radio" name="money_received" value="0"> دریافت نشد
																			<span></span>
																		</label>
																	</div>
																	</div>
																	<div class="col-lg-3">
												<label class="">آپلود فایل:</label>
												{!! Form::file('files[]',['class' => 'form-control m-input', 'id' => 'files','multiple' => true]) !!}
											</div>	
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
  		$('#append').append($services);
	});
</script>
<script type="text/javascript">
  $(function() {
    $('#datetimepicker3').datetimepicker({
      pickDate: false
    });
  });
</script>
	<script>
		$(document).ready(function () {
            $.ajax({
                url: "{!! url('receptions/load') !!}",
                type: "post",
                data: {
                    patient_id: {{ $patient_id }},
                },
                success: function (data) {
                	if(data == 'oops!') {
                		window.location.replace('{{ url('patients') }}'+'/'+{{$patient_id}}+'/edit?redirect=turns');
                	} else {
                    	$("#causes").html(data);
                    	$("#patient_name").val('');
                    }
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
                    patient_id: {{ $patient_id }},
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
@stop