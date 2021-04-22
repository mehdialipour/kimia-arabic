@extends('new.layout')
@section('title')
خدمات ارائه شده در مطب
@stop

@section('content')
<div class="kt-portlet kt-portlet--mobile">
				<div class="kt-portlet__head kt-portlet__head--lg">
					<div class="kt-portlet__head-label">
						<span class="kt-portlet__head-icon">
							<i class="kt-font-brand flaticon2-analytics-2"></i>
						</span>
						<h3 class="kt-portlet__head-title">
							خدمات ارائه شده در مطب
						</h3>
					</div>
					<div class="kt-portlet__head-toolbar">
						<div class="kt-portlet__head-wrapper">
							<div class="kt-portlet__head-actions">
								
								&nbsp;
								<a href="{{ url('services/create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
									<i class="flaticon2-add-1"></i>
									افزودن خدمت جدید
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="kt-portlet__body table-responsive">

					<!--begin: Datatable -->
					<table class="table table-striped table-hover table-checkable" id="services-table">
						<thead>
							<?php $insurances = \App\Models\Insurance::get(); ?>
							<tr align="center">
								<th>ردیف</th>
								<th>نام خدمت</th>
								@foreach($insurances as $s)
									<th>{{ $s->name }}</th>
								@endforeach
								<th>عملیات</th>
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

						@foreach($insurances as $ins)
							<td>
								<?php
									$tariff = \DB::table('insurance_service')
								       ->where('insurance_id', $ins->id)
								       ->where('service_id', $row->id)
								       ->first();
								    if(!is_null($tariff)) $tariff = $tariff->tariff;
								    else $tariff = 0;   
								?>
								@if($tariff > 0)
								{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($tariff)) }} دینار
								@endif
							</td>
						@endforeach
						
							<td>

								
								<a class="btn btn-success" href="{{ url('services') }}/{{ $row->id }}/edit">ویرایش <i class="fa fa-edit"></i></a>
								@if($row->status == 'فعال')
									<a class="btn btn-danger" href="{{ url('services') }}/{{ $row->id }}?action=deactivate">غیر فعال‌سازی <i class="fa fa-ban"></i></a>
								@else
									<a class="btn btn-info" href="{{ url('services') }}/{{ $row->id }}?action=activate">فعال‌سازی <i class="fa fa-check"></i></a>
								@endif	
							</td>
					</tr>
					@endforeach

				
				</tbody>
					</table>

					<!--end: Datatable -->
				</div>
			</div>
@stop					
