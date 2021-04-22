@extends('new.layout')
@section('title')
نقش‌ها
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__head kt-portlet__head--lg">
                                                <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon">
                                                        <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                                    </span>
                                                    <h3 class="kt-portlet__head-title">
                                                        نقش‌های سیستم
                                                    </h3>
                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="kt-portlet__head-wrapper">
                                                        <div class="kt-portlet__head-actions">
                                                            
                                                            &nbsp;
                                                            <a href="{{ url('roles/create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                                                <i class="flaticon2-add-1"></i>
                                                                نقش جدید
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-portlet__body">

                                                
                                                <table class="table table-striped table-bordered table-hover table-checkable" id="roles-table">
                                                    <thead>
                                                        <tr align="center">
                                                            <th>
                                                                #
                                                            </th>
                                                            <th>
                                                                نام لاتین نقش
                                                            </th>
                                                            <th>
                                                                نام فارسی نقش
                                                            </th>
                                                            <th>
                                                                عملیات
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i=1; ?>
                                                        @foreach($roles as $row)
                                                        <tr align="center">
                                                            <td>
                                                                {{ $i++ }}
                                                            </td>
                                                            <td>
                                                                {{ $row->name }}
                                                            </td>

                                                            <td>
                                                                {{ $row->title }}
                                                            </td>
                                                        
                                                            <td>

                                                                {{ Form::open(['method'  => 'DELETE', 'route' => ['roles.destroy', $row->id]]) }}
                                                                <a class="btn btn-success" href="{{ url('roles') }}/{{ $row->id }}/edit">ویرایش <i class="fa fa-edit"></i></a>
                                                                <button class="btn btn-danger" type="submit">حذف <i class="fa fa-trash"></i></button>
                                                                {{ Form::close() }}
                                                            </td>
                                                            
                                                        </tr>
                                                        @endforeach

                                                    
                                                    </tbody>
                                                </table>
                                                <!--begin: Datatable -->
                                                <!--end: Datatable -->
                                            </div>
                                        </div>
@stop