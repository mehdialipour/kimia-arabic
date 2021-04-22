@extends('new.layout')
@section('title')
اسباب الارجاع
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__head kt-portlet__head--lg">
                                                <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon">
                                                        <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                                    </span>
                                                    <h3 class="kt-portlet__head-title">
                                                        اسباب الارجاع
                                                    </h3>
                                                </div>
                                                
                                            </div>
                                            <form action="" method="get">
                                                <div class="form-group row" align="center"> 
                                                    
                                                    		<div class="col-md-2">
                                                    		</div>
                                                    		<div class="col-md-2">
                                                    		</div>
                                                            <div class="col-md-2">
                                                                <div class="kt-form__group--inline">
                                                                    
                                                                    <div class="kt-form__control">
                                                                        <input type="text" name="cause" class="form-control" placeholder="سبب الارجاع" value="{{ $cause }}"> 
                                                                    </div>
                                                                </div>
                                                                <div class="d-md-none kt-margin-b-10"></div>
                                                            </div>
                                                            
                                                            <div class="col-md-2">
                                                                <input type="submit" class=" btn btn-label-brand btn-bold table__search__btn" value="يبحث">
                                                                    
                                                                    <!-- <i class="flaticon2-magnifier-tool"></i> -->
                                                                </a>
                                                            </div>
                                                            <div class="col-md-2">
                                                    		</div>
                                                    		<div class="col-md-2">
                                                    		</div>
                                                        
                                                    </div>
                                                </form>
                                            <div class="kt-portlet__body">
                                                <!--begin: Datatable -->
                                                <table  class="table table-striped table-bordered table-hover table-checkable" id="kt_table_1">
													<thead>
														<tr align="center">
															<th>
																#
															</th>
															<th>
																سبب الارجاع
															</th>
																<th>
																	عدد
																</th>
														</tr>
													</thead>
													<tbody>
														<?php $i=1; ?>
														@foreach($arr as $key => $value)
														<tr align="center">
															<td>
																{{ $i++ }}
															</td>
															<td>
																{{ $value }}
															</td>
															<td>
																{{ \App\Models\Reception::where('cause', $value)->count() }} مرة
															</td>
																
														</tr>
														@endforeach

													
													</tbody>
												</table>
                                        </div>
@stop