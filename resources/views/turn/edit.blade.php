@extends('layout')
@section('title')
	ویرایش نوبت
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
														ویرایش نوبت
													</strong>
												</h3>
											</div>
										</div>
									</div>

									<!--begin::Form-->	
										{!! Form::open(['action' => ['TurnController@updateTurn'], 'class' => 'm-form m-form--fit m-form--label-align-right','files' => true,'id' => 'myForm']) !!}

										<input type="hidden" name="id" value="{{ $id }}">
											
										<div class="m-portlet__body">	
											<div class="form-group m-form__group">
												<label for="">نام بیمار</label>

												<h5><strong>{{ $name }}</strong></h5>
											</div>
											<div class="form-group m-form__group">
												<label for="">سبب الارجاع</label>

												<select name="reception_id" class="form-control m-input" style="font-family: Vazir;">
													@foreach($receptions as $row)
														<option value="{{ $row->id }}">{{ $row->cause }}</option>
													@endforeach
												</select>
											</div>

											<div class="form-group m-form__group">
												<label for="">نوع بیمه</label>
												<select class="form-control m-input" id="insurances" style="font-family: Vazir" required="required" placeholder="انتخاب کنید..">

													@foreach($insurances as $insurance) 
														<option value="{{ $insurance->id }}" @if($insurance->id == $insurance_id) selected="" @endif>
															{{ $insurance->name }}
														</option>
													@endforeach
													
												</select>
												
											</div>

											<div class="form-group m-form__group">
												<label for="">شماره بیمه</label>

												<input type="text" class="form-control m-input" name="insurance_code" id="insurance_code" placeholder="شماره بیمه" autocomplete="off" value="{{ $insurance_code }}">
											</div>

											<div class="form-group m-form__group">
												<label for="">تاریخ</label>

												{!! Form::text('date', $date[0], ['class' => 'form-control m-input', 'id' => 'datepicker', 'placeholder' => '','style' => 'width:50%;', 'required' => true]) !!}
												<span style="font-size: 16px;" class="text-success" id="message"></span>
											</div>

											<div class="form-group m-form__group" id="datetimepicker3">
												<label for="">ساعت</label>

												<span class="add-on">
											      <i class="fa fa-clock">
											      </i>
											    </span>
											    <?php 
											    $time = explode(" ", $model->turn_time);
											    ?>
												<input data-format="hh:mm:ss" name="time" value="{{ $time[1] }}" type="text" class="form-control m-input" style="width:50%;">
											    
											</div>

											<div class="form-group m-form__group" id="append">
									<label for="">انتخاب خدمت <span id="plus" class=""><i class="fa fa-plus"></i></span></label>
								<?php 
									$arr = [];
									$query = \DB::table('service_turn')
									         ->where('turn_id', $id)
									         ->get(); 
								?>
								@foreach($query as $q)		
								<table id="tbl">
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
					        	
				        			<select class="form-control m-input" id="medicines" style="font-family: Vazir" required="required" name="services[]" placeholder="">
				        				<option selected="" disabled="" value="0">جستجو کنید</option>
				        				@foreach($services as $service)
				        				 <option value="{{ $service->id }}" @if($service->id == $q->service_id) selected="" @endif>{{ $service->name }}</option>
				        				@endforeach
				        			</select>
				        		</td>
				        		
				        		<td>
				        			<input type="number" placeholder="تعداد" value="{{ $q->count }}" id="dose" name="count[]" class="form-control m-input">
				        		</td>
				        		<td>
				        						<select  name="user_id[]" class="form-control m-input" style="font-family: Vazir;">
													<option value="0">انتخاب مسئول</option>
													@foreach($nurses as $nurse)
														<option value="{{ $nurse->id }}" @if($nurse->id == $q->user_id) selected="" @endif>{{ $nurse->name }}</option>
													@endforeach
												</select>
				        		</td>
				        	</tr>
				        </tbody>
				    </table>
				    @endforeach


				        	</div>

											<div class="form-group m-form__group">
												<label for="">انتخاب پزشک</label>

												<select name="doctor_id" class="form-control m-input" style="font-family: Vazir;">
													<option value="0">خدمات کلینیکی</option>
													@foreach($doctors as $doctor)
														<option value="{{ $doctor->id }}" @if($model->doctor_id == $doctor->id) selected="" @endif>{{ $doctor->name }}</option>
													@endforeach
												</select>
											</div>
											<div class="form-group m-form__group">
												<label for="">هزینه</label><br>

												<input type="radio" name="money_received" value="1" @if(\App\Models\Invoice::where('turn_id', $model->id)->first()->paid == 1) checked="" @endif> دریافت شد
												<input type="radio" name="money_received" value="0" @if(\App\Models\Invoice::where('turn_id', $model->id)->first()->paid == 0) checked="" @endif> دریافت نشد
											</div>
											<div class="form-group m-form__group">
												<label for="">افزودن فایلهای جدید</label>
												{!! Form::file('files[]',['class' => 'form-control m-input', 'id' => 'files','multiple' => true]) !!}
													<output id="list"></output>
											</div>		
											
										</div>
										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions">
												<button type="submit" class="btn btn-primary">به روزرسانی نوبت</button>
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