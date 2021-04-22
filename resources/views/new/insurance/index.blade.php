@extends('new.layout')
@section('title')
بیمه های طرف قرارداد
@stop

@section('content')
<div class="kt-portlet kt-portlet--mobile">
				<div class="kt-portlet__head kt-portlet__head--lg">
					<div class="kt-portlet__head-label">
						<span class="kt-portlet__head-icon">
							<i class="kt-font-brand flaticon2-analytics-2"></i>
						</span>
						<h3 class="kt-portlet__head-title">
							لیست بیمه‌های طرف قرارداد
						</h3>
					</div>
					<div class="kt-portlet__head-toolbar">
						<div class="kt-portlet__head-wrapper">
							<div class="kt-portlet__head-actions">
								
								&nbsp;
								<a href="{{ url('insurances/create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
									<i class="flaticon2-add-1"></i>
									بیمه جدید
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="kt-portlet__body table-responsive">

					<!--begin: Datatable -->
					<table class="table table-striped table-hover table-checkable" id="kt_table_1">
						<thead>
							<tr align="center">
								<th>ردیف</th>
								<th>نام بیمه</th>
								
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
						
							<td>

								
								<a class="btn btn-success" href="{{ url('insurances') }}/{{ $row->id }}/edit">ویرایش <i class="fa fa-edit"></i></a>
								@if($row->status == 'فعال')
									<a class="btn btn-danger" href="{{ url('insurances') }}/{{ $row->id }}?action=deactivate">غیر فعال‌سازی <i class="fa fa-ban"></i></a>
								@else
									<a class="btn btn-info" href="{{ url('insurances') }}/{{ $row->id }}?action=activate">فعال‌سازی <i class="fa fa-check"></i></a>
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
