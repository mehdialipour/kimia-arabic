@extends('new.layout')
@section('title')
کاربران
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__head kt-portlet__head--lg">
                                                <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon">
                                                        <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                                    </span>
                                                    <h3 class="kt-portlet__head-title">
                                                        کاربران سیستم
                                                    </h3>
                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="kt-portlet__head-wrapper">
                                                        <div class="kt-portlet__head-actions">
                                                            
                                                            &nbsp;
                                                            <a href="{{ url('users/create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                                                <i class="flaticon2-add-1"></i>
                                                                کاربر جدید
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-portlet__body">

                                                <form action="{{ url('users/search') }}" method="get">
                                                <div class="form-group row align-items-center"> 
                                                    <label class="col-md-1 col-form-label ">جستجو </label>
                                                    
                                                            <div class="col-md-3">
                                                                <div class="kt-form__group--inline">
                                                                    
                                                                    <div class="kt-form__control">
                                                                        <input type="text" name="name" class="form-control" placeholder="نام و نام خانوادگی" value="{{ request('name') }}"> 
                                                                    </div>
                                                                </div>
                                                                <div class="d-md-none kt-margin-b-10"></div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="kt-form__group--inline">
                                                                    
                                                                    <div class="kt-form__control">
                                                                        <input type="text" name="mobile" class="form-control" placeholder="شماره موبایل" value="{{ request('mobile') }}">   
                                                                    </div>
                                                                </div>
                                                                <div class="d-md-none kt-margin-b-10"></div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="kt-form__group--inline">
                                                                    
                                                                    <div class="kt-form__control">
                                                                        <select class="form-control selectbox" name="role">
                                                                            @if(request('role'))

                                                                            @else
                                                                            <option value="">انتخاب نقش</option>
                                                                            @endif
                                                                            @foreach(\App\Models\Role::all() as $row)
                                                                                <option value="{{ $row->id }}" @if(request('role') == $row->id) selected="" @endif>{{ $row->title }}</option>
                                                                            @endforeach
                                                                        </select>   
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

                                                <table id="users-table" class="table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr align="center">
                        <th>
                            #
                        </th>
                        <th>
                            نام 
                        </th>
                        <th>
                            نام خانوادگی
                        </th>
                        <th>
                            نام کاربری
                        </th>
                        <th>
                            شماره موبایل
                        </th>
                        <th>
                            نقش در سیستم
                        </th>
                        <th>
                            عملیات
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; ?>
                    @foreach($users as $row)
                    @if($row->username != 'admin')
                    <tr align="center">
                        <td>
                            {{ $i++ }}
                        </td>
                        <td>
                            {{ $row->firstname }}
                        </td>

                        <td>
                            {{ $row->lastname }}
                        </td>

                        <td>
                            {{ $row->username }}
                        </td>

                        <td>
                            {{ $row->mobile }}
                        </td>
                        <td>
                            @if($row->role_id > 0)
                            {{ \App\Models\Role::find($row->role_id)->title }}
                            @else
                            <button class="btn btn-danger" type="button">بدون نقش</button>
                            @endif

                        </td>
                        <td>


                            <button class="btn btn-brand" type="button" onclick="window.open('{{ url('users/'.$row->id) }}',null,'height=700,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no');" ><i class="fa fa-eye"></i></button>
                            <a href="{{ url('users/'.$row->id.'/toggle') }}" class="btn @if($row->active == 1) btn-primary @else btn-warning @endif" onclick="return confirm('هل أنت واثق؟؟')">@if($row->active == 1) فعال @else غیرفعال @endif</a>
                            <a class="btn btn-success" href="{{ url('users') }}/{{ $row->id }}/edit" onclick="return confirm('هل أنت واثق؟؟')">ویرایش <i class="fa fa-edit"></i></a>
                            
                        </td>
                        
                    </tr>
                    @endif
                    @endforeach

                
                </tbody>
            </table>
                                                <!--begin: Datatable -->
                                                <!--end: Datatable -->
                                            </div>
                                        </div>
@stop