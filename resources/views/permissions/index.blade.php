@extends('new.layout')
@section('title')
اعطای دسترسی به کاربران سیستم
@stop

@section('content')
<div class="m-content" style="width: 100%;">
						<div class="row">	
							<div class="col-md-12">

								<!--begin::Portlet-->
								<div class="m-portlet m-portlet--tab">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
												<h3 class="m-portlet__head-text">
													<strong>
														اعطای دسترسی به کاربران سیستم
													</strong>
												</h3>
											</div>
										</div>
									</div>
									

									<!--begin::Form-->
										{!! Form::open(['action' => ['PermissionController@update'], 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}

										<table class="table table-bordered">
											<thead>
												<tr align="center" class="table-success">
													<th>
														نقش
													</th>
													@foreach($permissions as $permission)
														<th>{{ $permission->name }}</th>
													@endforeach
												</tr>
											</thead>
											<tbody>
												@foreach($roles as $role)
													<tr align="center">
														<td>
															<strong>{{ $role->title }}</strong>
														</td>
														@foreach($permissions as $permission)
														<?php 
															$count = \DB::table('permission_roles')
															             ->where('role_id', $role->id)
															             ->where('permission_id', $permission->id)
															             ->count();
														?>
															<td><input type="checkbox" @if($count > 0) checked="" @endif name="permissions_{{ $role->id }}_{{ $permission->id }}[]"></td>
														@endforeach
													</tr>
												@endforeach
											</tbody>
										</table>
										
										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions">
												<button type="submit" class="btn btn-primary">به روزرسانی دسترسی ها</button>
											</div>
										</div>
									</form>

									<!--end::Form-->
								</div>

								<!--end::Portlet-->

							</div>
						</div>
					</div>
@stop