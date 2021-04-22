@extends('new.layout')
@section('title')
سوابق پذیرش
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__head kt-portlet__head--lg">
                                                <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon">
                                                        <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                                    </span>
                                                    <h3 class="kt-portlet__head-title">
                                                        سوابق پذیرش
                                                    </h3>
                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="kt-portlet__head-wrapper">
                                                        <div class="kt-portlet__head-actions">
                                                            
                                                            &nbsp;
                                                            <a href="{{ url('receptions/create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                                                <i class="flaticon2-add-1"></i>
                                                                پذیرش جدید
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-portlet__body">
                                                <!--begin: Datatable -->
                                                <table  class="table table-striped table-bordered table-hover table-checkable" id="kt_table_1">
													<thead>
														<tr align="center">
															<th>
																#
															</th>
															<th>
																نام بیمار
															</th>
															<th>
																سبب الارجاع
															</th>
																<th>
																	عملیات
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
																{{ $row->patients[0]->name }}
															</td>
															<td>
																{{ $row->cause }}
															</td>
																<td>

																	{{ Form::open(['method'  => 'DELETE', 'route' => ['receptions.destroy', $row->id]]) }}
																	<a class="btn btn-success" href="{{ url('receptions') }}/{{ $row->id }}/edit">ویرایش <i class="fa fa-edit"></i></a>
																	<button class="btn btn-danger" type="submit">حذف <i class="fa fa-trash"></i></button>
																</td>
																	{{ Form::close() }}	
														</tr>
														@endforeach

													
													</tbody>
												</table>
                                            <div align="center">{!! $query->render() !!}</div>
                                                <!--end: Datatable -->
                                            </div>
                                        </div>
@stop