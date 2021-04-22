@extends('new.layout')
@section('title')
 
@stop
@section('content')

<div class="kt-portlet kt-portlet--mobile">
                            <div class="kt-portlet__head kt-portlet__head--lg">
                                <div class="kt-portlet__head-label">
                                    <span class="kt-portlet__head-icon">
                                        <i class="kt-font-brand flaticon2-plus-1"></i>
                                    </span>
                                    <h3 class="kt-portlet__head-title">
                                        
                                    </h3>
                                </div>

                            </div>
                                <div class="kt-portlet__body">
                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label>نام:</label>
                                            <span>{{ $user->firstname }}</span>
                                        </div>

                                        <div class="col-lg-3">
                                            <label>نام خانوادگی:</label>
                                            <span>{{ $user->lastname }}</span>
                                        </div>

                                        <div class="col-lg-3">
                                            <label>اسم الاب:</label>
                                            <span>{{ $user->father_name }}</span>
                                           
                                        </div>

                                        <div class="col-lg-3">
                                            <label>تاریخ تولد:</label>
                                            <span>{{ $user->birthday }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label>کد ملی:</label>
                                            <span>{{ $user->national_id }}</span>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>نام کاربری:</label>
                                            <span>{{ $user->username }}</span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label>نقش در سیستم:</label>
                                            <span>{{ \App\Models\Role::find($user->role_id)->title }}</span></span>
                                        </div>

                                        @if(!is_null($user->speciality))
                                            <div class="col-lg-3">
                                            <label>تخصص:</label>
                                            <span>{{ $user->speciality }}</span></span>
                                            </div>
                                        @endif

                                        <div class="col-lg-3">
                                            <label>شماره موبایل:</label>
                                            <span>{{ $user->mobile }}</span></span>
                                        </div>

                                        <div class="col-lg-3">
                                            <label>شماره تلفن:</label>
                                            <span>{{ $user->phone }}</span>
                                        </div>

                                        <div class="col-lg-3">
                                            <label>ایمیل:</label>
                                            <span>{{ $user->email }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label>کد پرسنلی:</label>
                                            <span>{{ $user->personal_code }}</span>
                                        </div>
                                        <div class="col-lg-3">
                                            <label>آدرس:</label>
                                            <span>{{ $user->address }}</span>
                                        </div>
                                    </div>



                        </div>
@stop