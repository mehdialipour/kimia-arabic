@extends('new.layout')
@section('title')
اطلاعات مرکز درمانی
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__head kt-portlet__head--lg">
                                                <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon">
                                                        <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                                    </span>
                                                    <h3 class="kt-portlet__head-title">
                                                       اطلاعات مرکز درمانی
                                                    </h3>
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
                                                                نام مرکز درمانی
                                                            </th>
                                                            <th>
                                                                نام مدیر
                                                            </th>
                                                            <th>
                                                                تلفن
                                                            </th>
                                                            <th>
                                                                موبایل
                                                            </th>
                                                            <th>
                                                                آدرس
                                                            </th>
                                                            <th>
                                                                وبسایت
                                                            </th>
                                                            <th>
                                                                ایمیل
                                                            </th>
                                                            <th>
                                                                عملیات
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        <tr align="center">
                                                            <td>
                                                                ۱
                                                            </td>
                                                            <td>
                                                                {{ $query->name }}
                                                            </td>

                                                            <td>
                                                                {{ $query->manager }}
                                                            </td>

                                                            <td>
                                                                {{ $query->phone }}
                                                            </td>

                                                            <td>
                                                                {{ $query->mobile }}
                                                            </td>

                                                            <td>
                                                                {{ $query->address }}
                                                            </td>

                                                            <td>
                                                                {{ $query->website }}
                                                            </td>

                                                            <td>
                                                                {{ $query->email }}
                                                            </td>
                                                        
                                                            <td>
                                                                <a class="btn btn-success" href="{{ url('settings/1/edit') }}">ویرایش <i class="fa fa-edit"></i></a>
                                                            </td>
                                                            
                                                        </tr>

                                                    
                                                    </tbody>
                                                </table>
                                                <!--begin: Datatable -->
                                                <!--end: Datatable -->
                                            </div>
                                        </div>
@stop