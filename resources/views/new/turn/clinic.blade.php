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
                                                        <a href="#" class="kt-widget__data">{!! $query1->cause !!}</a>
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

                                                        $service_id = \DB::table('service_turn')->where('id', $service_turn_id)->first()->service_id;               

                                                        $doctor_id = \App\Models\Turn::find($turn_id)->doctor_id;
                                                        $doctor_name = \App\Models\User::find($doctor_id)->name;               
                                                    ?>

                                                    <div class="kt-widget__contact">
                                                        <span class="kt-widget__label">پزشک:</span>
                                                        <span class="kt-widget__data"> دکتر {{ $doctor_name }}</span>
                                                    </div>

                                                    <div class="kt-widget__contact">
                                                        <span class="kt-widget__label">آدرس:</span>
                                                        <span class="kt-widget__data">  {{ $patient->address }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="kt-widget__footer">
                                                <?php

                                                    $turn_id = \App\Models\Turn::where('reception_id',$reception_id)->orderBy('id','desc')->first()->id;

                                                ?>
                                                <a href="{{ url('turns/release/'.$service_turn_id) }}" class="btn btn-primary btn-lg btn-upper">ترخیص</a>
                                                
                                                <hr>
                                                <a href="{{ url('turns/toggle/'.$turn_id.'?service_id='.$service_id) }}" class="btn btn-success btn-lg btn-upper">برگشت به انتظار</a>
                                            </div>
                                            <br>
                                            <a target="_blank" href="{{ url('turns/print/'.$service_turn_id) }}" class="btn btn-primary"><i class="fa fa-eye"></i> مشاهده پرونده</a>

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




                                        <div class="tab-pane" id="kt_widget6_tab3_content" aria-expanded="false">
                                                <p class="text-center">در صورت لزوم پیشنهادتان را بنویسید</p>
                                                <div class="form-group row">
                                                    <div class="col-lg-3">
                                                        <!-- <input type="text" class="form-control" placeholder="مثال: AdultCold"> -->
                                                        <select class="form-control selectbox services" id="kt_select2_1" name="param">
                                                                <option selected="" disabled="" value="0">جستجو کنید</option>
                                                                @foreach($services as $row)
                                                                 <option value="{{ $row->name }}">{{ $row->name }}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input id="service_count" type="number" value="1" class="form-control" placeholder="تعداد">

                                                    </div>
                                                    <div class="col-lg-2">
                                                        <input id="service_type" type="text" class="form-control" placeholder="نوع">

                                                    </div>
                                                    <div class="col-lg-3">
                                                        <input id="service_desc" type="text" class="form-control" placeholder="شرح">

                                                    </div>
                                                    <div class="col-lg-2">
                                                    <button type="button" id="service_plus" class="btn btn-primary btn-icon"><i class="fa fa-plus"></i></button>
                                                    </div>  
                                                </div>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr align="center">
                                                            <th>
                                                                خدمت
                                                            </th>
                                                            <th>
                                                                تعداد
                                                            </th>
                                                            <th>
                                                                نوع
                                                            </th>
                                                            <th>
                                                                شرح
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="service_table">
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        <div class="tab-content">
                                            
            {!! Form::open(['action' => ['TurnController@submitDescription'], 'class' => 'kt-form kt-form--label-right','files' => true]) !!}
                <input type="hidden" name="service_turn_id" value="{{ $service_turn_id }}">
                                            </div>
                                            <hr>
                                            <br>
                                            <br>
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
                                                    <th>خدمت مربوطه</th>
                                                    <th>توضیحات</th>
                                                    <th>تاریخ ثبت</th>
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
                                                        {{ \App\Models\Service::find(\DB::table('service_turn')->where('id', $row->service_turn_id)->first()->service_id)->name }}
                                                    </td>
                                                    <td>
                                                        {!! $row->description !!}
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $date = \App\Helpers\ConvertDate::toJalali($row->date);
                                                        ?>
                                                            {{ \App\Helpers\ConvertNumber::convertToPersian($date) }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('nurse-description/edit/'.$row->id) }}" class="btn btn-sm btn-primary">ویرایش</a>
                                                        <a target="_new" href="{{ url('uploads/'.$row->file_url) }}" class="btn btn-sm btn-success">مشاهده فایل</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                        @if($files->count() > 0)
                                        <hr>
                                        <h5 align="center">مدارک پزشکی</h5>
                                        <table align="center" class="table table-bordered">
                                            <thead>
                                                <tr align="center">
                                                    <th>#</th>
                                                    <th>نوع فایل</th>
                                                    <th>تصویر</th>
                                                    <th>تاریخ </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1; ?>
                                                @foreach($files->get() as $row)
                                                <tr align="center">
                                                    <td>
                                                        {{ \App\Helpers\ConvertNumber::convertToPersian($i++) }}
                                                    </td>
                                                    <td>
                                                        {{ \DB::table('file_types')->where('id', $row->file_type_id)->first()->type }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('uploads/'.$row->file_url) }}" target="_blank"><img style="max-width: 100px;" src="{{ url('uploads/'.$row->file_url) }}">
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $date = \App\Helpers\ConvertDate::toJalali($row->date);
                                                        ?>
                                                            {{ \App\Helpers\ConvertNumber::convertToPersian($date) }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                    
                                    <div class="kt-portlet__foot">
                                        

                                    </div>

                                    
                                    
                                    
                                </div>
                            </div>

                        </div>
                    </form>

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
    <script>
    $(document).on('click','#service_plus', function() {  
    services = $(".services").val()+" ";
    service_count = $("#service_count").val()+" ";
    service_type = $("#service_type").val();
    service_desc = $("#service_desc").val();

    document.getElementById("service_count").value = '1';
    document.getElementById("service_type").value = '';
    document.getElementById("service_desc").value = '';
    $('.services').val('0').change();


    $.ajax({
        url: "{!! url('turns/add-suggestion') !!}",
        type: "post",
        data: {
            id: {{ $service_turn_id }},
            service: services,
            service_count: service_count,
            service_type: service_type,
            service_desc: service_desc

        },
        success: function (data) {
            console.log(data);
        }
    });

    string = '<tr align="center"><td>'+services+'</td><td>'+service_count+'</td><td>'+service_type+'</td><td>'+service_desc+'</td></tr>';

    $("#service_table").append(string);
});
    </script>
@stop