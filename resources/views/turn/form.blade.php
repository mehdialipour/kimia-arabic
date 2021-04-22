@extends('layout')
@section('title')
	@if(isset($model))
	ویرایش نوبت
	@else
	ایجاد نوبت جدید
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
														ویرایش نوبت
														@else
														ایجاد نوبت جدید
														@endif
													</strong>
												</h3>
											</div>
										</div>
									</div>

									<!--begin::Form-->
									@if(isset($model))
										{!! Form::model($model, ['method' => 'PATCH', 'action' => ['TurnController@update', $model->id], 'class' => 'm-form m-form--fit m-form--label-align-right','files' => true,'id' => 'myForm','onkeydown' => 'return event.key != "Enter";']) !!}
									@else	
										{!! Form::open(['action' => ['TurnController@store'], 'class' => 'm-form m-form--fit m-form--label-align-right','files' => true,'id' => 'myForm','onkeydown' => 'return event.key != "Enter";']) !!}
									@endif		
										<div class="m-portlet__body">
										@if(isset($patient_name))
											<div class="form-group m-form__group">
												<label for="">نام بیمار</label>

												<h5><strong>{{ $patient_name }}</strong></h5>
											</div>

											<div class="form-group m-form__group">
												<label for="">سبب الارجاع</label>

												<select name="reception_id" class="form-control m-input" style="font-family: Vazir;">
													@foreach($receptions as $row)
														<option value="{{ $row->id }}">{{ $row->cause }}</option>
													@endforeach
												</select>
												<input type="hidden" id="patients" value="{{ $id }}">
											</div>
										@else	
											<div class="form-group m-form__group">
												<input type="text" class="form-control m-input" id="patient_name" name="" placeholder="جستجو کنید.." autocomplete="off" autofocus="">

												
												
											</div>

											<div class="form-group m-form__group" id="results2">

											</div>	
											<div class="form-group m-form__group" id="causes">
												
												
											</div>
										@endif	
											<div class="form-group m-form__group">
												<label for="">نوع بیمه</label>

												{!! Form::select('insurance_id',$ins,null,['class' => 'form-control m-input','id' => 'insurances', 'style' => 'font-family: Vazir', 'required' => true, 'placeholder' => 'انتخاب کنید..']) !!}
											</div>

											<div class="form-group m-form__group">
												<label for="">شماره بیمه</label>

												<input type="text" class="form-control m-input" name="insurance_code" id="insurance_code" placeholder="شماره بیمه" autocomplete="off">
											</div>

											<div class="form-group m-form__group">
												<label for="">تاریخ</label>

												{!! Form::text('date', $today, ['class' => 'form-control m-input', 'id' => 'datepicker', 'placeholder' => '', 'style' => 'width:50%;', 'required' => true,'autocomplete' => 'off']) !!}
												<span style="font-size: 16px;" class="text-success" id="message"></span>
											</div>

											<div class="form-group m-form__group" id="datetimepicker3">
												<label for="">ساعت</label>

												<span class="add-on">
											      <i class="fa fa-clock">
											      </i>
											    </span>
												<input data-format="hh:mm:ss" name="time" value="{{ date("H:i:s") }}" type="text" class="form-control m-input" style="width:50%;">
											    
											</div>

								<div class="form-group m-form__group" id="append">
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
				        						<select  name="user_id[]" class="form-control m-input selectbox" style="font-family: Vazir;">
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

											<div class="form-group m-form__group">
												<label for="">انتخاب پزشک</label>

												<select required="" name="doctor_id" class="form-control m-input selectbox" style="font-family: Vazir;">
													@foreach($doctors as $doctor)
														<option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ \App\Models\Role::find(\App\Models\User::find($doctor->id)->role_id)->title }}</option>
													@endforeach
												</select>
											</div>

											<div class="form-group m-form__group">
												<label for="">هزینه</label><br>

												<input type="radio" name="money_received" value="1" checked=""> دریافت شد
												<input type="radio" name="money_received" value="0"> دریافت نشد
											</div>

											<div class="form-group m-form__group">
												<label for="">انتخاب فایلها</label>
												{!! Form::file('files[]',['class' => 'form-control m-input', 'id' => 'files','multiple' => true]) !!}
													<output id="list"></output>
											</div>	
											
										</div>
										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions">
												<button type="submit" class="btn btn-primary">@if(isset($model))به روزرسانی نوبت @else ثبت نوبت @endif</button>
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
@stop