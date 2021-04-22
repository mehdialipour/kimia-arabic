@extends('new.layout')
@section('title')
پرونده مراجعه‌ی {{ $patient->name }}
@stop

@section('content')
<div class="row">

<?php

$string = $diagnoses->diagnosis;

$str_0 = explode("تشخیص اولیه:", $string);
$cause = str_replace("<strong>سبب الارجاع:</strong>", '', $str_0[0]);
$str_1 = explode("پیشنهاد پزشک:", $str_0[1]);
$str_2 = explode("تشخیص پزشک:", $str_1[1]);
$str_3 = explode('آزمایش:', $str_2[1]);



?>    
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
                                                <a href="{{ url('turns/toggle/'.$service_turn_id) }}" class="btn btn-success btn-lg btn-upper">برگشت به انتظار</a>
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
    <hr>
    <div class="kt-widget__body mt-3" align="center">
                                        
                                    </div>
                                    </div>
                                </div>
                                
                                

                            </div>

                            <div class="col-lg-9">
                                <div class="kt-portlet kt-portlet--mobile kimia-perscriptions">
                                    <div class="kt-portlet__head kt-portlet__head--lg">
                                        <div class="kt-portlet__head-label">
                                            <span class="kt-portlet__head-icon">
                                                <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                            </span>
                                            <h3 class="kt-portlet__head-title">
                                                ویرایش
                                            </h3>
                                        </div>

                                    </div>
                                    <div class="kt-portlet__body">

                                        <ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                                            @if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 45)->count() == 1)
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#kt_widget6_tab1_content" role="tab" aria-selected="true">
                                                    سبب الارجاع
                                                </a>
                                            </li>
                                            @endif
                                            @if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 46)->count() == 1)
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#kt_widget6_tab2_content" role="tab" aria-selected="false">
                                                    تشخیص اولیه
                                                </a>
                                            </li>
                                            @endif
                                            @if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 47)->count() == 1)
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#kt_widget6_tab3_content" role="tab" aria-selected="false">
                                                    پیشنهاد پزشک
                                                </a>
                                            </li>
                                            @endif
                                            @if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 48)->count() == 1)
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#kt_widget6_tab4_content" role="tab" aria-selected="false">
                                                    تشخیص پزشک
                                                </a>
                                            </li>
                                            @endif
                                           @if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 49)->count() == 1)
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#kt_widget6_tab7_content" role="tab" aria-selected="false">
                                                    آزمایش
                                                </a>
                                            </li>
                                            @endif
                                        </ul>




                                        <div class="tab-content">
                                            <div class="tab-pane" id="kt_widget6_tab6_content" aria-expanded="true">
            
            
            
            {!! Form::open(['action' => ['TurnController@updateDescription'], 'class' => 'kt-form kt-form--label-right','files' => true]) !!}
                <input name="service_turn_id" type="hidden" id="service_turn_id" value="{{ $service_turn_id }}">
                <input name="id" type="hidden" id="service_turn_id" value="{{ $id }}">
                
                                            </div>
                                            <div class="tab-pane active" id="kt_widget6_tab1_content" aria-expanded="true">
                                                <p class="text-center">علل مراجعه‌ی بیمار را یادداشت کنید</p>
                                                <div class="col-sm-12">
                                                    <textarea name="cause" class="form-control" id="cause">{!! $cause !!}</textarea>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="kt_widget6_tab2_content" aria-expanded="false">
                                                <p class="text-center">تشخیض اولیه‌ی شما از بیماری</p>
                                                <div class="col-sm-12">
                                                    <textarea name="detection" id="detection" class="form-control">{!! $str_1[0] !!}</textarea>
                                                </div>
                                            </div>
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
                                                    <div class="col-lg-1">
                                                        <input id="service_count" type="number" value="1" class="form-control" placeholder="تعداد">

                                                    </div>
                                                    <div class="col-lg-3">
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
                                                <div class="col-sm-12">
                                                    <textarea name="suggestion" class="form-control" id="suggestion" rows="10">{!! $str_2[0] !!}</textarea>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="kt_widget6_tab4_content" aria-expanded="false">
                                                <p class="text-center">تشخیص شما چیست؟</p>
                                                <div class="col-sm-12">
                                                    <textarea name="perception" class="form-control" id="diagnosis" rows="10">{!! $str_3[0] !!}</textarea>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="kt_widget6_tab7_content" aria-expanded="false">
                                                <p class="text-center">آزمایش</p>
                                                <div class="col-sm-12">
                                                    <textarea name="test" class="form-control" id="test" rows="10">{!! $str_3[1] !!}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="kt-portlet__foot">
                                        <div class="row align-items-center">
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-success">به روزرسانی</button>

                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>

                        </div>
                    </form>
@stop
@section('scripts')
    <script src="{{ url('new/assets/js/demo1/pages/crud/forms/widgets/bootstrap-markdown.js') }}" type="text/javascript"></script>
    <script>
    
$(document).on('click','#plus', function() {  
    text = CKEDITOR.instances['result_span'].getData(); 
    text_1 = $(".medicines").val()+" ";
    text_2 = $("#dose").val()+" ";
    desc = $("#desc").val();


    final = text_1 + text_2 + desc;
CKEDITOR.instances.result_span.setData(text + final);

document.getElementById("dose").value = '';
document.getElementById("desc").value = '';
$('.medicines').val('0').change();
    
});

$(document).on('click','#service_plus', function() {  
    services = $(".services").val()+" ";
    service_count = $("#service_count").val()+" ";
    service_type = $("#service_type").val();
    service_desc = $("#service_desc").val();

    $.ajax({
        url: "{!! url('turns/add-suggestion') !!}",
        type: "post",
        data: {
            id: $("#service_turn_id").val(),
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



$('.services').val('0').change();
document.getElementById("new_dose").value = '';
document.getElementById("new_desc").value = '';
document.getElementById("new_med").value = '';   
});

$(document).on('click','#new_plus', function() { 
    text = CKEDITOR.instances['result_span'].getData(); 
    text_1 = $("#new_med").val()+" ";
    text_2 = $("#new_dose").val()+" ";
    desc = $("#new_desc").val();


    final = text_1 + text_2 + desc;
CKEDITOR.instances.result_span.setData(text + final);

$.ajax({
    url: "{!! url('medicines/add') !!}",
    type: "post",
    data: {
        medicine: $('#new_med').val(),
    },
    success: function (data) {
        console.log(data);
    }
});

document.getElementById("new_dose").value = '';
document.getElementById("new_desc").value = '';
document.getElementById("new_med").value = '';


    
});


</script>

    <script>
    window.onload = function() {
        CKEDITOR.replace( 'final_span' );
        CKEDITOR.replace( 'diagnosis' );
        CKEDITOR.replace( 'detection' );
        CKEDITOR.replace( 'suggestion' );
        CKEDITOR.replace( 'cause' );
        CKEDITOR.replace( 'result_span' );
        CKEDITOR.replace( 'test' );
        CKEDITOR.config.autoParagraph = false;
    };
    </script>
@stop