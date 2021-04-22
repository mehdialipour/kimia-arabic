@extends('new.layout')
@section('title')
	@if(isset($model))
	تحرير المنعطف
	@else
	خلق منعطفات جديدة
	@endif
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
							<div class="kt-portlet__head kt-portlet__head--lg">
								<div class="kt-portlet__head-label">
									<span class="kt-portlet__head-icon">
										<i class="ktxr-font-brand flaticon2-plus-1"></i>
									</span>
									<h3 class="kt-portlet__head-title">
										@if(isset($model))
										تحرير المنعطف
										@else
										خلق منعطفات جديدة
										@endif
									</h3>
								</div>

							</div>



									@if ($errors->any())
									    <div class="alert alert-danger">
									        <ul>
									            @foreach ($errors->all() as $error)
									                <li>{{ $error }}</li>
									            @endforeach
									        </ul>
									    </div>
									@endif


							@if(isset($model))
										{!! Form::model($model, ['method' => 'PATCH', 'action' => ['TurnController@update', $model->id], 'class' => 'kt-form kt-form--label-right turns-create','files' => true,'id' => 'myForm','onkeydown' => 'return event.key != "Enter";']) !!}
							@else	
								{!! Form::open(['action' => ['TurnController@store'], 'class' => 'kt-form kt-form--label-right turns-create','files' => true,'id' => 'myForm','onkeydown' => 'return event.key != "Enter";']) !!}
							@endif
							<input type="hidden" name="redirect" @if(request('service_id')) value="1" @else value="0" @endif>
								<div class="kt-portlet__body">
									<div class="form-group row">
										@if(isset($patient_name))
										<div class="col-lg-4">
											<label>اسم المريض:</label>
											<h5><strong>{{ $patient_name }}</strong></h5>
										</div>
										<div class="col-lg-4">
											<label class="">سبب الارجاع: <span id="add_new_reception" style="font-size: 20px;" class="text-primary">+</span></label>
											@if($receptions->count() > 0)
											<input type="text" id="new_reception" name="new_reception" class="form-control" style="display: none;">
											<select id="reception_id" class="form-control" name="reception_id">
													@foreach($receptions as $row)
														<option value="{{ $row->id }}">{{ $row->cause }}</option>
													@endforeach
											</select>
											@else
											<input type="text" id="new_reception" name="new_reception" class="form-control" style="">
											@endif
											<input type="hidden" id="patients" name="patient_id" value="{{ $id }}">
										</div>
										@else
										<div class="col-lg-3">
											<label>اسم المريض:</label>
											<input type="text" class="form-control m-input" id="patient_name" name="" placeholder="یبحث.." autocomplete="off" autofocus="">
										</div>
										<div class="col-lg-3" id="results2"></div>
										<div class="col-lg-3" id="causes"></div>	

										@endif
										<div class="col-lg-3">
											<?php
											if(isset($patient)) {
												$insurance = $patient->insurance_id;
												$insurance_code = $patient->insurance_code;
											} else {
												$insurance = null;
												$insurance_code = null;
											}
											?>

												<label class="">نوع التأمين:</label>
												{!! Form::select('insurance_id',$ins,$insurance,['class' => 'form-control m-input selectbox6','id' => 'insurances', 'style' => 'font-family: Vazir', 'required' => true]) !!}
											</div>


										
									</div>
									<div class="form-group row">
										
											<div class="col-lg-3">
													<label class="">رقم التأمين:</label>
													<input type="text" class="form-control m-input" name="insurance_code" id="insurance_code" placeholder="رقم التأمين" value="{{ $insurance_code }}" autocomplete="off">
												</div>
												<?php
												if(request('date')) {
													$today = \App\Helpers\ConvertDate::toJalali(request('date'));
												}
												?>
												<div class="col-lg-3">
														<label class="">تاریخ:</label>
														{!! Form::text('date', $today, ['class' => 'form-control m-input', 'id' => 'datepicker', 'placeholder' => '', 'required' => true,'autocomplete' => 'off']) !!}
												<span style="font-size: 16px;" class="text-success" id="message"></span>
													</div>

													<div class="col-lg-3" id="datetimepicker3">
												<label for="">الساعة</label>

												<span class="add-on">
											      <i class="fa fa-clock">
											      </i>
											    </span>
												<input data-format="hh:mm:ss" name="time" value="{{ date("H:i:s") }}" type="text" class="form-control m-input">
											    
											</div>
											<div class="col-lg-3">
												<label for="">حدد طبيب الخدمة السريرية الافتراضي</label>

												<select name="doctor_id" class="form-control m-input selectbox" style="font-family: Vazir;" required="">
													
													@foreach($doctors as $doctor)
														<option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ \App\Models\Role::find(\App\Models\User::find($doctor->id)->role_id)->title }}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="form-group row">
<div class="col-lg-6" id="append">
									<label for="">اختيار الخدمة</label>
								<table id="tbl">
									<thead>
										<tr>
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
										<tr>
											<td>

									@if(request('service_id')) 
										<select class="form-control m-input " id="medicines" style="font-family: Vazir" required="required" name="services[]" placeholder="">
				        				
				        				 <option value="{{ request('service_id') }}">{{ \App\Models\Service::find(request('service_id'))->name }}</option>
				        			</select>
									@else			
				        			<select class="form-control m-input " id="medicines" style="font-family: Vazir" required="required" name="services[]" placeholder="">
				        				<option selected="" disabled="" value="0">یبحث</option>
				        				@foreach($services as $service)
				        				 <option value="{{ $service->id }}">{{ $service->name }}</option>
				        				@endforeach
				        			</select>

				        			@endif
				        		</td>
				        		<td>
				        			<input type="number" @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 52)->count() == 1) step="0.1" @endif autocomplete="off" placeholder="عدد" min="0" id="dose" name="count[]" class="form-control m-input" @if(request('count')) value="{{ request('count') }}" @endif>
				        		</td>

				        		<td>			
				        			@if(!request('user_id'))
				        						<select name="user_id[]" class="form-control m-input" style="font-family: Vazir;">
													<option value="0">اختيار مسؤول</option>
													@foreach($nurses as $nurse)
														<option value="{{ $nurse->id }}">{{\App\Models\Role::find($nurse->role_id)->title }} - {{ $nurse->name }}</option>
													@endforeach
												</select>
												@else
												<select name="user_id[]" class="form-control m-input selectbox4" style="font-family: Vazir;">
													<option value="0">اختيار مسؤول</option>
													@foreach($nurses as $nurse)
														<option value="{{ $nurse->id }}" @if($nurse->id == request('user_id')) selected="" @endif>{{\App\Models\Role::find($nurse->role_id)->title }} - {{ $nurse->name }}</option>
													@endforeach
												</select>
												@endif

				        		</td>
				        		<td>
				        			<button type="button" id="plus" class="btn btn-primary"><i class="fa fa-plus"></i></button>
				        		</td>
				        	</tr>
				        </tbody>
				    </table>
				        	</div>
				        	@if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 22)->count() == 1)
				        	<div class="col-lg-6" id="append_drug">
									<label for="">اختيار المواد الاستهلاكية</label>
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
				        				<option selected="" disabled="" value="0">یبحث</option>
				        				@foreach($drugs as $row)
				        				 <option value="{{ $row->id }}">{{ $row->name_en }} - {{ $row->name_fa }}</option>
				        				@endforeach
				        			</select>
				        		</td>
				        		<td>
				        			<input type="number" @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 52)->count() == 1) step="0.1" @endif autocomplete="off" placeholder="عدد" min="0" value="1" name="count_drugs[]" class="form-control m-input">
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
				        	<div class="col-lg-3">
																	<label class="">رسوم الخدمة:</label>
																	<div class="kt-radio-inline">
																		<label class="kt-radio kt-radio--solid">
																			<input type="radio" name="money_received" value="1" > تم الاستلام
																			<span></span>
																		</label>
																		<label class="kt-radio kt-radio--solid">
																			<input type="radio" name="money_received" checked="" value="0"> لم يتم الاستلام
																			<span></span>
																		</label>
																	</div>
																	<div>
																		<br>
																		<button type="button" id="calculate" class="btn-success">احسب تكلفة الخدمات</button><span class="text-primary" style="font-size: 20px;" id="price"></span>
																	</div>
																	</div>
@if(request('service_id'))
																	<div class="col-lg-3">
																			
																	</div>

																	<div class="col-lg-3 table-responsive" id="future-turns">

																	<h5>يتحول المستقبل</h5>	

<?php 

$reception_ids = [];
$receptions = \App\Models\Reception::where('patient_id',request('patient'))->get();

foreach($receptions as $reception) {
	array_push($reception_ids, $reception->id);
}

$now = \Carbon\Carbon::now();

$turn_ids = [];

$turns = \App\Models\Turn::whereIn('reception_id', $reception_ids)
                          ->where('turn_time','>', $now)
                          ->get();

foreach($turns as $turn) {
	array_push($turn_ids, $turn->id);
}

$future = \DB::table('service_turn')->whereIn('turn_id', $turn_ids)->where('service_id', request('service_id'))->get(); 
?>																		
																		<table class="table table-bordered">
																			<thead>
																				<tr>
																					<th>
																						صف
																					</th>
																					<th>
																						تاریخ
																					</th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php $i=1; ?>
																			@foreach($future as $row)
							@php
								$turn_time = \App\Models\Turn::find($row->turn_id)->turn_time;
								$turn_time = \App\Helpers\ConvertDate::toJalali($turn_time);
							@endphp	
																				<tr>
							<td>
								{{ \App\Helpers\ConvertNumber::convertToPersian($i++) }}
							</td>
							<td>
								{{ \App\Helpers\ConvertNumber::convertToPersian($turn_time) }}
							</td>
																				</tr>
																			@endforeach	
																			</tbody>
																		</table>	
																	</div>	
						@endif											
				        </div>



																		
					</div>  
								<div class="kt-portlet__foot">
									<?php $questions = \DB::table('questions')->where('location','turn')->get(); $i=1;?>

									
										@foreach($questions as $row) 
										<div class="row">
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
									</div>
									<hr>
										@endforeach
								</div>
								<div class="kt-portlet__foot">
										<div class="kt-form__actions">
												<div class="row">
													<div class="col-lg-6">
															<button type="submit" class="btn btn-primary">@if(isset($model))تحديث @else سجل يتحول @endif</button>

															<a href="{{ url('turns') }}" class="btn btn-success">العودة</a>
													</div>
													
												</div>
											</div>
								</div>
							</form>



						</div>
						<?php
							if(request('date')) {
							$name = " ";
							$today = request('date');	
							$query = \App\Models\Turn::whereHas('reception', function ($q) use ($name) {
					            $q->whereHas('patients', function ($p) use ($name) {
					                $p->where('name', 'like', "%$name%");
					            });
					        })
					            ->where('turn_time', 'like', "%$today%")
					            ->orderBy('turn_time', 'asc')
					            ->take(10)
					            ->get();	
						?>
						<div class="row">

		<div class="col-md-12">
			<table class="table table-hovered" id="" width="99%">
				<thead>
					<tr align="center">
						<th>
							صف
						</th>
						<th>
							اسم المریض
						</th>
						<th>
							نوع التأمين
						</th>
						<th>
							سبب الارجاع
						</th>
						<th style="width: 15%;">
							طبيب
						</th>
						<th>
							ساعة الارجاع
						</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; ?>
					@foreach($query as $row)
					<tr align="center">
						<td>
							{{ $i++ }}
						</td>
						<td>
							{{ $row->reception->patients[0]->name }}
						</td>
						<td>
							{{ \App\Models\Insurance::find($row->reception->patients[0]->insurance_id)->name }} 
						</td>
						<td>
							{!! $row->reception->cause !!}
						</td>
						<td>
							@if($row->doctor_id > 0)
							{{ \App\Models\User::find($row->doctor_id)->name }} ({{ \App\Models\Role::find(\App\Models\User::find($row->doctor_id)->role_id)->title }})
							@else
							الخدمات السريرية
							@endif
						</td>

						<td>
							<?php
								$time = explode(" ", $row->turn_time);
								$time = explode(":",  $time[1]);
								echo $time[0].":".$time[1];
							?>
						</td>
						
					</tr>
					@endforeach

				
				</tbody>
			</table>

		</div>
	</div>
						<?php } ?>
@stop
@section('scripts')
<script>
	$(document).on('change','#medicines', function() {
		
		$.ajax({
	        url: "{!! url('turns/user-services') !!}",
	        type: "post",
	        data: {
	            service: $('#medicines').val()
	        },
	        success: function (data) {
	            $('#users').html(data);
	        }
	    });
	});
</script>
<script>
	$("#plus").click(function() {
		var $services = $('#tbl').clone(true);
		$('.medicines').removeAttr('id');
		$('.users').removeAttr('id');
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

<script>
	$("#plus_drug").click(function() {
		var $drugs = $('#tbl_drug').clone(true);
  		$('#append_drug').append($drugs);
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
                		data = data.split("|");
                    	$("#causes").html(data[0]);
                    	$("#patient_name").val('');
                    	$("#insurance_code").val(data[1]);
                    	$("#insurances").val(data[2]);
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
	$(document).on('click', '#add_new_reception', function() {
		$('#reception_id').hide();
		$('#new_reception').show();
	});
</script>
@stop