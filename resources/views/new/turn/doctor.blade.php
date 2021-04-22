@extends('new.layout')
@section('title')
پرونده مراجعه‌ی {{ $patient->name }}
@stop

@section('content')
<div class="row">
                            <div class="col-lg-3">
                                <div class="kt-portlet kimia-patient">
                                    <div class="kt-portlet__head kt-portlet__head--lg">
                                        <div class="kt-portlet__head-label">
                                            <span class="kt-portlet__head-icon">
                                                <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                            </span>
                                            <h3 class="kt-portlet__head-title">
                                                مشخصات بیمار
                                            </h3>
                                        </div>
                                    </div>

                                    <div class="kt-portlet__body">
                                        <div class="kt-widget kt-widget--user-profile-2">
                                            <div class="kt-widget__head">
                                                <div class="kt-widget__media">

                                                    <div class="kt-widget__pic kt-widget__pic--info kt-font-info kt-font-boldest  kt-hidden-">
                                                        <i class="flaticon2-user-outline-symbol"></i>
                                                    </div>
                                                </div>
                                                <div class="kt-widget__info">
                                                    <a href="#" class="kt-widget__username">
                                                        {{ $patient->name }}
                                                    </a>
                                                    <span class="kt-widget__desc">
                                                        @if($patient->birth_year)
                                                        متواد {{ \App\Helpers\ConvertNumber::convertToPersian($patient->birth_year) }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="kt-widget__body mt-3">

                                                <div class="kt-widget__item">
                                                    <div class="kt-widget__contact">
                                                        <span class="kt-widget__label">شکایت بیمار:</span>
                                                        <a href="#" class="kt-widget__data">{!! $query->cause !!}</a>
                                                    </div>
                                                    <div class="kt-widget__contact">
                                                        <span class="kt-widget__label">دفعات مراجعه:</span>
                                                        <a href="#" class="kt-widget__data">@if($turn_count == 1) اولین مراجعه
                            @else {{ \App\Helpers\ConvertNumber::convertToPersian($turn_count) }} بار
                            @endif</a>
                                                    </div>
                                                    <div class="kt-widget__contact">
                                                        <span class="kt-widget__label">سابقه بیماری یا جراحی:</span>
                                                        <span class="kt-widget__data">{{ $patient->disease_history }}</span>
                                                    </div>

                                                    <?php 
                                                        $turn_id = \DB::table('service_turn')
                                                                       ->where('id',$service_turn_id)
                                                                       ->first()
                                                                       ->turn_id;

                                                        $doctor_id = \App\Models\Turn::find($turn_id)->doctor_id;
                                                        $doctor_name = \App\Models\User::find($doctor_id)->name;               
                                                    ?>

                                                    <div class="kt-widget__contact">
                                                        <span class="kt-widget__label">پزشک:</span>
                                                        <span class="kt-widget__data"> دکتر {{ $doctor_name }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="kt-widget__footer">
                                                <?php

                                                    $turn_id = \App\Models\Turn::where('reception_id',$reception_id)->orderBy('id','desc')->first()->id;

                                                ?>
                                                <a href="{{ url('turns/release/'.$service_turn_id) }}" class="btn btn-primary btn-lg btn-upper">ترخیص</a>
                                                
                                                <hr>
                                                <a href="{{ url('turns/toggle/'.$service_id) }}" class="btn btn-success btn-lg btn-upper">برگشت به انتظار</a>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    <div class="kt-widget__body mt-3">
                                        <h5>خدمات درخواستی بیمار</h5>
                                        <table class="table table-bordered" border="1" style="border: 1px solid #000 !important;">
        <thead style="border:1px solid #000 !important;">
            <tr align="center">
                <th style="border: 1px solid #000 !important;">#</th>
                <th style="border: 1px solid #000 !important;">نام خدمت</th>
                <th style="border: 1px solid #000 !important;">تعداد</th>
                <th style="border: 1px solid #000 !important;">مبلغ</th>
                <th style="border: 1px solid #000 !important;">وضعیت</th>
            </tr>
        </thead>
        <tbody>
            <?php $paid=0; $i=1;?>
            @foreach($paid_services as $service)
                <tr align="center">
                    <td style="border: 1px solid #000 !important;">{{ \App\Helpers\ConvertNumber::convertToPersian($i++) }}</td>
                    <td style="border: 1px solid #000 !important;">
                        {{ \App\Models\Service::find($service->service_id)->name }}
                    </td>
                    <td style="border: 1px solid #000 !important;">
                        {{ \App\Helpers\ConvertNumber::convertToPersian($service->count) }}
                    </td>
                    <td style="border: 1px solid #000 !important;">
                        <?php
                        $tariff = \DB::table('insurance_service')
                            ->where('service_id',$service->service_id)
                            ->where('insurance_id',$patient_insurance_id)
                            ->first()
                            ->tariff; 
                        $paid+=$tariff*$service->count;
                        $tariff = number_format($tariff*$service->count);   
                        
                        ?> 
                        {{ \App\Helpers\ConvertNumber::convertToPersian($tariff) }} دینار
                    </td>
                    <td class="text-success" style="border: 1px solid #000 !important;">
                        پرداخت شده
                    </td>
                </tr>
            @endforeach
            <?php $unpaid = 0; ?>
            @foreach($unpaid_services as $service)
                <tr align="center">
                    <td style="border: 1px solid #000 !important;">{{ \App\Helpers\ConvertNumber::convertToPersian($i++) }}</td>
                    <td style="border: 1px solid #000 !important;">
                        {{ \App\Models\Service::find($service->service_id)->name }}
                    </td>
                    <td style="border: 1px solid #000 !important;">
                        {{ \App\Helpers\ConvertNumber::convertToPersian($service->count) }}
                    </td>
                    <td style="border: 1px solid #000 !important;">
                        <?php
                        $tariff = \DB::table('insurance_service')
                            ->where('service_id',$service->service_id)
                            ->where('insurance_id',$patient_insurance_id)
                            ->first()
                            ->tariff; 
                        $unpaid+=$tariff*$service->count;
                        $tariff = number_format($tariff*$service->count);   
                        
                        ?> 
                        {{ \App\Helpers\ConvertNumber::convertToPersian($tariff) }} دینار
                    </td>
                    <td style="border: 1px solid #000 !important;" class="text-danger">
                        پرداخت نشده
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
                                    </div>
                                </div>
                                
                                @if($reception_count > 1)
                                <div class="kt-portlet kimia-patient">
                                    <div class="kt-portlet__head kt-portlet__head--lg">
                                        <div class="kt-portlet__head-label">
                                            <span class="kt-portlet__head-icon">
                                                    <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                                </span>
                                            <h3 class="kt-portlet__head-title">
                                                شکایت‌های قبلی بیمار
                                            </h3>
                                        </div>
                                    </div>

                                    <div class="kt-portlet__body">
                                        <div class="kt-widget kt-widget--user-profile-2">



                                            <div class="form-group">
                                                <div class="kt-checkbox-list">
                                                    @foreach($receptions as $reception)
                                                    
                                                    <label class="kt-checkbox kt-checkbox--brand">
                                                                    <input type="checkbox" checked="checked"> {!!$reception->cause!!}
                                                                    <span></span>
                                                                </label>
                                                    @endforeach            
                                                </div>
                                            </div>
                                            <div class="form-group"><input class="form-control" type="text" value="سبب الارجاع"></div>
                                            <button type="button" class="btn btn-label-primary">تجمیع علل انتخاب شده</button>
                                            <div class="kt-widget__footer">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>

                            <div class="col-lg-9">
                                <div class="kt-portlet kt-portlet--mobile kimia-perscriptions">
                                    <div class="kt-portlet__head kt-portlet__head--lg">
                                        <div class="kt-portlet__head-label">
                                            <span class="kt-portlet__head-icon">
                                                <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                            </span>
                                            <h3 class="kt-portlet__head-title">
                                                ثبت توضیحات
                                            </h3>
                                        </div>

                                    </div>
                                    <div class="kt-portlet__body">





                                        <div class="tab-content">
                                            
            {!! Form::open(['action' => ['TurnController@submitDescription'], 'class' => 'kt-form kt-form--label-right','files' => true]) !!}
                <input type="hidden" name="service_turn_id" value="{{ $service_turn_id }}">
                                            </div>
                                            <div class="tab-pane" id="kt_widget6_tab1_content" aria-expanded="true">
                                                <p class="text-center">توضیح دستیار</p>
                                                <div class="col-sm-12">
                                                    <textarea name="description" class="form-control" id="description"></textarea>
                                                </div>
                                            </div>
                                        
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="file" name="file" class="form-control">
                                        </div>

                                        <br>

                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-success">ثبت ملاحظات</button>

                                        </div>
                                        @if($descriptions->count() > 0)
                                        <hr>
                                        <h5 align="center">ملاحظات قبلی</h5>
                                        <table align="center" class="table table-bordered">
                                            <thead>
                                                <tr align="center">
                                                    <th>#</th>
                                                    <th>توضیحات</th>
                                                    <th>فایل</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1; ?>
                                                @foreach($descriptions->get() as $row)
                                                <tr align="center">
                                                    <td>
                                                        {{ \App\Helpers\ConvertNumber::convertToPersian($i++) }}
                                                    </td>
                                                    <td>
                                                        {!! $row->description !!}
                                                    </td>
                                                    <td>
                                                        <a target="_new" href="{{ url('uploads/'.$row->file_url) }}" class="btn btn-success">مشاهده فایل</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                    
                                    <div class="kt-portlet__foot">
                                        

                                    </div>

                                </form>

                            </div>

                            

                        </div>
@stop
@section('scripts')
    

    <script>
    window.onload = function() {
        CKEDITOR.replace('description');
    };
    </script>
@stop