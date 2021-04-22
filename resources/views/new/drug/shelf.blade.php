@extends('new.layout')
@section('title')
لیست داروها و اقلام پزشکی
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__head kt-portlet__head--lg">
                                                <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon">
                                                        <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                                    </span>
                                                    <h3 class="kt-portlet__head-title">
                                                        انبار مرکز درمانی
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

                                            	<form action="{{ url('storage/search') }}" method="get">
                                                <div class="form-group row align-items-center"> 
                                                    
                                                    
                                                            <div class="col-md-3">
                                                                <div class="kt-form__group--inline">
                                                                    
                                                                    <div class="kt-form__control">
                                                                        <input type="text" name="code" class="form-control" placeholder="بارکد"> 
                                                                    </div>
                                                                </div>
                                                                <div class="d-md-none kt-margin-b-10"></div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="kt-form__group--inline">
                                                                    
                                                                    <div class="kt-form__control">
                                                                        <input type="text" name="name_fa" class="form-control" placeholder="نام فارسی">   
                                                                    </div>
                                                                </div>
                                                                <div class="d-md-none kt-margin-b-10"></div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                    <div class="kt-form__group--inline">
                                                                        
                                                                        <div class="kt-form__control">
                                                                            <input type="text" name="name_en" class="form-control" placeholder="نام لاتین">   
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-md-none kt-margin-b-10"></div>
                                                                </div>
                                                            
                                                            <div class="col-md-2">
                                                                <input type="submit" class=" btn btn-label-brand btn-bold table__search__btn" value="جستجو">
                                                                    
                                                                    <!-- <i class="flaticon2-magnifier-tool"></i> -->
                                                                </a>
                                                            </div>
                                                        
                                                    </div>
                                                </form>
                                                <!--begin: Datatable -->
                                                <table  class="table table-striped table-bordered table-hover table-checkable" id="storage-table">
													<thead>
														<tr align="center">
															<th>
																#
															</th>

															<th>
																بارکد
															</th>

															<th>
																نام فارسی
															</th>
															<th>
																نام لاتین
															</th>
															<th>
																نام تجاری
															</th>
															<th>
																نوع دارو
															</th>
															<th>
																دسته بندی
															</th>
															<th>
																نام شرکت
															</th>
															<th>
																توزیع کننده
															</th>
															<th>
																قیمت خرید
															</th>
															<th>
																قیمت فروش
															</th>
															<th>
																موجودی
															</th>
															<th>
																تاریخ انقضا
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
																{{ $row->code }}
															</td>

															<td>
																{{ $row->name_fa }}
															</td>
															<td>
																{{ $row->name_en }}
															</td>
															<td>
																{{ $row->name_co }}
															</td>
															<td>
																{{ $row->drug_form }}
															</td>
															<td>
																{{ $row->drug_category }}
															</td>
															<td>
																{{ $row->company_name }}
															</td>
															<td>
																{{ $row->distributer }}
															</td>
															<td>
																{{ $row->buy_price }}
															</td>
															<td>
																{{ $row->sell_price }}
															</td>
															<td>
																{{ $row->amount }}
															</td>
															<td>
																{{ $row->expire_date }}
															</td>
														</tr>
														@endforeach

													
													</tbody>
												</table>
                                            <div align="center">{!! $query->render() !!}</div>
                                                <!--end: Datatable -->
                                            </div>
                                        </div>
@stop