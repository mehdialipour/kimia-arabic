@extends('new.layout')
@section('title')
الملفات
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__head kt-portlet__head--lg">
                                                <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon">
                                                        <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                                    </span>
                                                    <h3 class="kt-portlet__head-title">
                                                        الملفات
                                                    </h3>
                                                </div>
                                                
                                            </div>
                                            <div class="kt-portlet__body">
                                                <form action="{{ url('patients/search-patients') }}" method="get">
                                                <div class="form-group row align-items-center"> 
                                                    
                                                    
                                                            <div class="col-md-3">
                                                                <div class="kt-form__group--inline">
                                                                    
                                                                    <div class="kt-form__control">
                                                                        <input type="text" name="name" class="form-control" placeholder="اسم و الكنية" value="{{ @$name }}"> 
                                                                    </div>
                                                                </div>
                                                                <div class="d-md-none kt-margin-b-10"></div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="kt-form__group--inline">
                                                                    
                                                                    <div class="kt-form__control">
                                                                        <input type="text" name="national_id" class="form-control" placeholder="الرقم الوطني">   
                                                                    </div>
                                                                </div>
                                                                <div class="d-md-none kt-margin-b-10"></div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                    <div class="kt-form__group--inline">
                                                                        
                                                                        <div class="kt-form__control">
                                                                            <input type="text" name="mobile" class="form-control" placeholder="التليفون المحمول">   
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-md-none kt-margin-b-10"></div>
                                                                </div>
                                                            
                                                            <div class="col-md-2">
                                                                <input type="submit" class=" btn btn-label-brand btn-bold table__search__btn" value="بحث ">
                                                                    
                                                                    <!-- <i class="flaticon2-magnifier-tool"></i> -->
                                                                </a>
                                                            </div>
                                                        
                                                    </div>
                                                </form>
                                                <!--begin: Datatable -->
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover table-checkable" id="patients-table">
				<thead>
					<tr align="center">
						<th>
							#
						</th>
						<th>
							اسم
						</th>
						<th>
							نوع التأمين
						</th>
						<th>
							سبب الارجاع
						</th>
                        <th>
                            نوع الخدمة
                        </th>
						<th>
							تاریخ الإحالة
						</th>
						<th>
							استعراض الملف
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
							{{ $row->name }}
						</td>
						<td>
							{{ $row->ins_name }}
						</td>
						<td>
							{{ $row->cause }}
						</td>
                        <td>
                            {{ \App\Models\Service::find($row->service_id)->name }}
                        </td>
						<td>
							<?php $date = explode(" ", $row->turn_time); ?>
							{{ \App\Helpers\ConvertDate::toJalali($date[0]) }}
						</td>
						<td>
							<a href="{{ url('turns/clinic/'.$row->id) }}" class="btn btn-brand"><i class="fa fa-eye"></i></a>
						</td>
					</tr>
					@endforeach

				
				</tbody>
			</table>
                                                </div>
                                                <!--end: Datatable -->
                                            </div>
                                        </div>
@stop