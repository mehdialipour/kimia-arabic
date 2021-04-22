@extends('new.layout')
@section('title')
نوبت‌ها
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__head kt-portlet__head--lg">
                                                <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon">
                                                        <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                                    </span>
                                                    <h3 class="kt-portlet__head-title">
                                                        نوبت‌ها
                                                    </h3>
                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="kt-portlet__head-wrapper">
                                                        <div class="kt-portlet__head-actions">
                                                            
                                                            &nbsp;
                                                            <?php $value = request()->segment(3); ?>
                                                            <a href="{{ url('turns/create?date='.$value) }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                                                <i class="flaticon2-add-1"></i>
                                                                نوبت جدید
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{ url('turns/show-future/'.$date) }}" method="get">
                                                <div class="form-group row align-items-center"> 
                                                            <div class="col-md-2">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="kt-form__group--inline">
                                                                    
                                                                    <div class="kt-form__control">
                                                                        <input type="hidden" name="date" value="{{ $date }}">
                                                                        <input type="text" name="name" class="form-control" placeholder="نام و نام خانوادگی"> 
                                                                    </div>
                                                                </div>
                                                                <div class="d-md-none kt-margin-b-10"></div>
                                                            </div>
                                                            
                                                            <div class="col-md-2">
                                                                <input type="submit" class=" btn btn-label-brand btn-bold table__search__btn" value="جستجو">
                                                            </div>
                                                        
                                                    </div>
                                                </form>
                                                <form action="{{ url('turns/show-future/'.$date) }}" method="get">
                                                <div class="form-group row align-items-center"> 
                                                            <div class="col-md-2">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="kt-form__group--inline">
                                                                    
                                                                    <div class="kt-form__control">
                                                                        <?php

                                                                        $users = \DB::table('user_services')
                                                                                    ->leftjoin('users', 'user_services.user_id', '=', 'users.id')
                                                                                    ->where('users.role_id', '6')
                                                                                    ->select('user_services.user_id')
                                                                                    ->orderBy('users.name', 'asc')
                                                                                    ->get();

                                                                        $users_2 = \DB::table('user_services')
                                                                                    ->leftjoin('users', 'user_services.user_id', '=', 'users.id')
                                                                                    ->where('users.role_id', '!=', '6')
                                                                                    ->select('user_services.user_id')
                                                                                    ->orderBy('users.name', 'asc')
                                                                                    ->get();

                                                                        $users = $users->merge($users_2);
                                                                                                
                                                                        $nurses = [];
                                                                        $roles = \App\Models\Role::where('access_to', 'like', "%خدمات%")->select('id')->get();
                                                                        $user_roles = [];
                                                                        foreach ($users as $row) {
                                                                            array_push($nurses, $row->user_id);
                                                                        }

                                                                        foreach ($roles as $role) {
                                                                            array_push($user_roles, $role->id);
                                                                        }

                                                                        $nurses = \App\Models\User::whereIn('id', $nurses)->whereIn('role_id', $user_roles)->orderBy('role_id', 'asc')->orderBy('name', 'asc')->get();

                                                                        ?>
                                                                        <select name="user_id" class="form-control selectbox">
                                                                            @if(request('user_id'))
                                                                            
                                                                            @else
                                                                            <option selected="" disabled="">انتخاب خدمت دهنده</option>
                                                                            @endif
                                                                            @foreach($nurses as $row)
                                                                                <option value="{{ $row->id }}" @if(request('user_id') == $row->id) selected="" @endif>{{ \App\Models\Role::find($row->role_id)->title }} - {{ $row->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        
                                                                    </div>


                                                                </div>
                                                                <div class="d-md-none kt-margin-b-10"></div>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <div class="kt-form__group--inline">
                                                                    
                                                                    <div class="kt-form__control">
                                                                        <select name="service_id" class="form-control selectbox2">
                                                                            @if(request('service_id'))

                                                                            @else   
                                                                            <option selected="" disabled="">انتخاب خدمت</option>
                                                                            @endif
                                                                            @foreach(\App\Models\Service::orderBy('name','asc')->get() as $row)
                                                                                <option value="{{ $row->id }}" @if(request('service_id') == $row->id) selected="" @endif>{{ $row->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        
                                                                    </div>


                                                                </div>
                                                                <div class="d-md-none kt-margin-b-10"></div>
                                                            </div>


                                                            
                                                            <div class="col-md-2">
                                                                <input type="submit" class=" btn btn-label-brand btn-bold table__search__btn" value="جستجو">
                                                            </div>
                                                        
                                                    </div>
                                                </form>
                                             <div class="kt-portlet__body table-responsive">
                                                
                                                <!--begin: Datatable -->
                                                <table class="table table-bordered" id="turns-table" width="99%">
				<thead>
					<tr align="center">
						<th>
							شماره
						</th>
						<th>
							نام بیمار
						</th>
						<th>
							تصویر
						</th>
						<th style="">
							خدمات دهنده
						</th>
						<th>
							نوع خدمت
						</th>
						<th>
							ساعت
						</th>

						<th>
							هزینه
						</th>

                        <th>
                            صورتحساب
                        </th>

						<th style="width: 33%;">
							عملیات
						</th>
					</tr>
				</thead>
				<tbody id="status">
					
				
				</tbody>
			</table>
            <input type="hidden" id="page_number" @if(request('page')) value="{{ request('page') }}" @else value="1" @endif name="">

            <input type="hidden" id="search_name" @if(request('name')) value="{{ request('name') }}" @else value=" " @endif name="">

            <input type="hidden" id="search_user" @if(request('user_id')) value="{{ request('user_id') }}" @else value=" " @endif name="">
            <input type="hidden" id="search_service" @if(request('service_id')) value="{{ request('service_id') }}" @else value=" " @endif name="">
            <?php 
                  
                    $now = \Carbon\Carbon::now();
                    $now_ex = explode(" ", $now);
                    $today = $now_ex[0];
                    $paginate = \App\Models\Turn::with('reception.patients')
                                ->where('turn_time', 'like', "%$date%")
                                ->orderBy('id', 'desc')
                                ->paginate(10);
                                ?>
                    {!! $paginate->render(); !!}            
            

            
                                                <!--end: Datatable -->
                                            </div>
                                        </div>
@stop
@section('scripts')
<script>
        window.setInterval(function(){
            getStatus();
        }, 6000);
        function getStatus(){
            $.ajax({
                url: "{!! url('turns/future-status') !!}",
                type: "post",
                data: {
                    page: $("#page_number").val(),
                    name: $("#search_name").val(),
                    user: $("#search_user").val(),
                    service: $("#search_service").val(),
                    date: "{{ $date }}"
                },
                success: function (data) {
                    $("#status").html(data);
                }
            });
        }
        $(document).ready(function() {
            getStatus();
        });
    </script>
@stop