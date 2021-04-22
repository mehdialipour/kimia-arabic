@extends('new.layout')
@section('title')
نسخه ها
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__head kt-portlet__head--lg">
                                                <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon">
                                                        <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                                    </span>
                                                    <h3 class="kt-portlet__head-title">
                                                        نسخه ها
                                                    </h3>
                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="kt-portlet__head-wrapper">
                                                        <div class="kt-portlet__head-actions">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-portlet__body table-responsive">

                                            	<form action="{{ url('drug-store') }}" method="get">
                                                <div class="form-group row align-items-center"> 
                                                    
                                                    
                                                            <div class="col-md-8">
                                                                <div class="kt-form__group--inline">
                                                                    
                                                                    <div class="kt-form__control">
                                                                        <input type="text" name="name" class="form-control" placeholder="نام و نام خانوادگی" @if(request('name')) value="{{ request('name') }}" @endif> 
                                                                    </div>
                                                                </div>
                                                                <div class="d-md-none kt-margin-b-10"></div>
                                                            </div>
                                                            
                                                            <div class="col-md-4">
                                                                <input type="submit" class=" btn btn-label-brand btn-bold table__search__btn" value="جستجو">
                                                                    
                                                                    <!-- <i class="flaticon2-magnifier-tool"></i> -->
                                                                </a>
                                                            </div>
                                                        
                                                    </div>
                                                </form>
                                                <!--begin: Datatable -->
                                                <table  class="table table-bordered table-hover table-checkable" id="storage-table">
													<thead>
														<tr align="center">
															<th>
																#
															</th>

															<th>
																پزشک معالج
															</th>

															<th>
																نام بیمار
															</th>

															<th>
																داروها
															</th>
															<th>
																بارکد
															</th>
															<th>
																قیمت فروش
															</th>
															<th>
																نحوه مصرف
															</th>
															<th>
																توضیحات
															</th>
															<th>
																تاریخ
															</th>
															<th>
																عملیات
															</th>
															
														</tr>
													</thead>
													<tbody>
		<?php $j=1; ?>												
		@for($i=0; $i<count($prescriptions); $i++)
			<?php
            $turn_id = \DB::table('service_turn')->where('id', $prescriptions[$i])->first()->turn_id;
            $reception_id = \DB::table('turns')->where('id', $turn_id)->first()->reception_id;
            $patient_id = \DB::table('receptions')->where('id', $reception_id)->first()->patient_id;
            $patient = \App\Models\Patient::find($patient_id);
            $drugs = \App\Models\MedicinePatient::where('service_turn_id', $prescriptions[$i])->get();

            $date = \App\Models\MedicinePatient::where('service_turn_id', $prescriptions[$i])->first()->created_at;
            $user_id = \DB::table('service_turn')->where('id', $prescriptions[$i])->first()->user_id;

            $date = explode(" ", $date);

            $time = $date[1];
            $date = \App\Helpers\ConvertDate::toJalali($date[0]);

            $date = \App\Helpers\ConvertNumber::convertToPersian($date);
            $time = \App\Helpers\ConvertNumber::convertToPersian($time);


            ?>
			<tr align="center">
				<td>{{ $j++ }}</td>
				<td>دکتر {{ \App\Models\User::find($user_id)->name }}</td>
				<td>{{ $patient->name }}</td>
				<td>
					@foreach($drugs as $row) 
						<p>{{ $row->name }}</p> 

					@endforeach
				</td>

				<td>
					@foreach($drugs as $row) 
					<?php
					$code = \App\Models\DrugStorage::where('name_fa', $row->name)->first();
					if(!is_null($code)) {
						$code = $code->code;
					} else {
						$code = 0;
					}
					?>
						<p>{{ $code }}</p> 

					@endforeach
				</td>

				<td>
					@foreach($drugs as $row)
					 	<?php

                    $price = \App\Models\DrugStorage::where('name_fa', $row->name)->first();

                    if(!is_null($price)) {
                    	$price = $price->sell_price;
                    } else {
                    	$price = 0;
                    }

                    if ($price > 0) {
                        $price = number_format($price);
                    }

                    $price = \App\Helpers\ConvertNumber::convertToPersian($price);
                    ?>
					 	<p>{{ $price }} دینار</p>
					 	

					@endforeach
				</td>

				<td>
					@foreach($drugs as $row) 
						<p>{{ $row->dose }}</p>
					@endforeach
				</td>
				<td>
					@foreach($drugs as $row) 
						<p>{{ $row->description }}</p>
					@endforeach
				</td>
				<td>
					 <p>{{ $date }}</p><p>{{ $time }}</p>
				</td>
				<td>
					<a href="{{ url('drug-store/'.$prescriptions[$i].'/seen') }}" class="btn btn-brand"><i class="fa fa-eye"></i></a>
					<button onclick="window.open('{{ url('drug-store/'.$prescriptions[$i].'/invoice') }}',null,'height=900,width=700,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no');" class="btn btn-warning">صورتحساب</button>
				</td>
			</tr>
		@endfor
													</tbody>
												</table>
                                                <!--end: Datatable -->
                                            </div>
                                        </div>
@stop