@extends('new.layout')
@section('title')
پرسشنامه
@stop

@section('content')
<div class="kt-portlet kt-portlet--mobile">
				<div class="kt-portlet__head kt-portlet__head--lg">
					<div class="kt-portlet__head-label">
						<span class="kt-portlet__head-icon">
							<i class="kt-font-brand flaticon2-analytics-2"></i>
						</span>
						<h3 class="kt-portlet__head-title">
							پرسشنامه
						</h3>
					</div>
					<div class="kt-portlet__head-toolbar">
						<div class="kt-portlet__head-wrapper">
							<div class="kt-portlet__head-actions">
								
								&nbsp;
								<a href="{{ url('questions/create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
									<i class="flaticon2-add-1"></i>
									افزودن پرسش جدید
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="kt-portlet__body table-responsive">

					<!--begin: Datatable -->
					<table class="table table-striped table-hover table-checkable" id="services-table">
				<thead>
					<tr>
						<th>
							#
						</th>
						<th>
							عنوان سوال
						</th>
						<th>
							محل سوال
						</th>
						<th>
							عملیات
						</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; ?>
					@foreach($query as $row)
					<tr>
						<td>
							{{ $i++ }}
						</td>
						<td>
							{{ $row->title }}
						</td>
						<td>
							@if($row->location == 'turn') نوبت دهی @else تشکیل پرونده @endif
						</td>
						<td>

							{{ Form::open(['method'  => 'DELETE', 'route' => ['questions.destroy', $row->id]]) }}
							<a class="btn btn-success" href="{{ url('questions') }}/{{ $row->id }}/edit">ویرایش <i class="fa fa-pencil"></i></a>
							<button class="btn btn-danger" type="submit">حذف <i class="fa fa-trash"></i></button>
							{{ Form::close() }}
						</td>
						
					</tr>
					@endforeach

				
				</tbody>
			</table>

		</tbody>
					</table>

				
	<div align="center">{!! $query->render() !!}</div>
				</div>
			</div>
@stop				