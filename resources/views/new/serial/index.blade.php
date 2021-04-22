@extends('new.layout')
@section('title')
چک‌های صادر شده
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__head kt-portlet__head--lg">
                                                <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon">
                                                        <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                                    </span>
                                                    <h3 class="kt-portlet__head-title">
                                                        چک‌های صادر شده
                                                    </h3>
                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="kt-portlet__head-wrapper">
                                                        <div class="kt-portlet__head-actions">
                                                            
                                                            &nbsp;
                                                            <a href="{{ url('paid-cheques/create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                                                <i class="flaticon2-add-1"></i>
                                                                صدور چک جدید
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-portlet__body">
                                                <!--begin: Datatable -->
                                                <table  class="table table-striped table-bordered table-hover table-checkable" id="services-table">
													<thead>
														<tr align="center">
															<th>
																#
															</th>
															<th>
																نام بانک
															</th>
															<th>
																سدینار چک
															</th>
															<th>
																تاریخ صدور
															</th>
															<th>
																تاریخ چک
															</th>
															<th>
																مبلغ چک
															</th>
															<th>
																در وجه
															</th>
															<th>
																از بابت
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
																{{ \App\Models\Cheque::find($row->cheque_id)->bank }}
															</td>
															<td>
																{{ $row->number }}
															</td>
															<td>
																<?php $date = explode(" ", $row->created_at); ?>
																{{ \App\Helpers\ConvertDate::toJalali($date[0]) }}
															</td>
															<td>
																{{ $row->date }}
															</td>
															<td>
																{{ number_format($row->amount) }} دینار
															</td>

															<td>
																{{ $row->receiver }}
															</td>
															<td>
																{{ $row->cause }}
															</td>

														</tr>
														@endforeach

													
													</tbody>
												</table>
                                                <!--end: Datatable -->
                                            </div>
                                        </div>
@stop