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
                                                        {{ \App\Helpers\ConvertNumber::convertToPersian($patient->birth_year) }} 
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
                                                                       ->where('id', $service_turn_id)
                                                                       ->first()
                                                                       ->turn_id;

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

                                                    $turn_id = \App\Models\Turn::where('reception_id', $reception_id)->orderBy('id', 'desc')->first()->id;
                                                    $service_id = \DB::table('service_turn')->where('id', $service_turn_id)->first()->service_id;

                                                ?>
                                                <a href="{{ url('turns/release/'.$service_turn_id) }}" class="btn btn-primary btn-lg btn-upper">ترخیص</a>
                                                
                                                <hr>
                                                <a href="{{ url('turns/toggle/'.$turn_id.'?service_id='.$service_id) }}" class="btn btn-success btn-lg btn-upper">برگشت به انتظار</a>
                                            </div>
                                                <br>
                                                <a target="_blank" href="{{ url('turns/print/'.$service_turn_id) }}" class="btn btn-primary"><i class="fa fa-print"></i> پرینت پرونده</a>

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
                            ->where('service_id', $service->service_id)
                            ->where('insurance_id', $patient_insurance_id)
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
                            ->where('service_id', $service->service_id)
                            ->where('insurance_id', $patient_insurance_id)
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
                                        <h5>مبلغ (به دینار)</h5>
                                        <form action="{{ url('turns/discount/'.$service_turn_id) }}" method="post">
                                            @csrf
                                            <input type="text" class="form-control m-input col-md-6" name="discount" placeholder="مبلغ به دینار" value="{{abs(@$discount)}}">
                                            <br>
                                            <input name="submit" type="submit" class="btn btn-warning col-md-3" value="اعمال تخفیف">
                                            <input name="submit" type="submit" class="btn btn-success col-md-3" value="افزایش مبلغ">
                                        </form>
                                    </div>
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
                                                ثبت مشاهدات و نسخه
                                            </h3>
                                        </div>

                                    </div>
                                    <div class="kt-portlet__body">

                                        <ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                                            
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#kt_widget6_tab6_content" role="tab" aria-selected="true">
                                                    سوابق بیمار
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#kt_widget6_tab8_content" role="tab" aria-selected="true">
                                                    پاسخ‌های پرسشنامه
                                                </a>
                                            </li>
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
                                            @if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 50)->count() == 1)
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#kt_widget6_tab5_content" role="tab" aria-selected="false">
                                                    نوشتن نسخه
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
                                            <div class="tab-pane active" id="kt_widget6_tab6_content" aria-expanded="true">

                                                @if($diagnoses->count() > 0)
            <br>
            <hr>
            <br>
            <h4>تشخیص‌های پزشک</h4>
            <?php $i=$newdiagnoses->count(); ?>
            @foreach($newdiagnoses->get() as $diagnosis)
            <?php $date = explode(" ", $diagnosis->created_at); ?>
            
            <div>
                        <div class="col-xl-12 col-lg-12 order-lg-2 order-xl-1">

                                <!--Begin::Portlet-->
                                <div class="kt-portlet kt-portlet--height-fluid">
                                    <div class="kt-portlet__head">
                                        <div class="kt-portlet__head-label">
                                            <h3 class="kt-portlet__head-title">
                                               مراجعه در تاریخ {{ \App\Helpers\ConvertDate::toJalali($date[0]) }}
                                            </h3>
                                        </div>
                                        <div class="kt-portlet__head-toolbar">
                                            <div class="dropdown dropdown-inline">
                                                <span class="text-primary" id="activity_log_button"><strong style="font-size: 24px;" id="plus{{ $diagnosis->id }}" class="">+</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="kt-portlet__body" id="activity_log{{ $diagnosis->id }}" style="display: none;">

                                        <table class="table table-bordered" id="" width="99%">
                <thead>
                    <tr class="table-info" align="center">
                        <th>
                            #
                        </th>
                        <th>
                            تشخیص پزشک
                        </th>
                        <th>
                            تاریخ ثبت
                        </th>

                        <th>
                            ثبت کننده
                        </th>

                        <th>
                            عملیات
                        </th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $date = explode(" ", $diagnosis->created_at); ?>
                        <tr align="center">
                            <td>{{ $i-- }}</td>
                            <td align="right">
                                <?php
                                    $string = $diagnosis->diagnosis;

                                    $str = explode("سبب الارجاع:", $string);

                                    $str_0 = explode("تشخیص اولیه:", $str[1]);
                                    $str_1 = explode("پیشنهاد پزشک:", $str_0[1]);
                                    $str_2 = explode("تشخیص پزشک:", $str_1[1]);
                                    $str_3 = explode('آزمایش:', @$str_2[1]);
                                    $d = strip_tags($str_3[0]);

                                    echo '<strong>سبب الارجاع: </strong>'.@$str_0[0].'<hr>تشخیص اولیه: '.@$str_1[0].'<hr>پیشنهاد پزشک:'.@$str_2[0]
                                    .'<hr>تشخیص پزشک:'.@$d.'<hr>آزمایش:'.@$str_3[1];
                                ?>
                            </td>
                            <td>{{ \App\Helpers\ConvertDate::toJalali($date[0]) }}</td>
                            <td>
                                {{ $diagnosis->editor }}
                            </td>
                            <td>
                                <a class="btn btn-success" href="{{ url('turns/clinic-edit/').'/'.$diagnosis->id }}">ویرایش</a>
                                <a class="btn btn-danger" href="{{ url('receptions/diagnosis/delete').'/'.$diagnosis->id }}">حذف</a>
                            </td>
                        </tr>
                    
                </tbody>
            </table> 
                                    </div>
                                </div>

                                <!--End::Portlet-->

                            </div>

                        </div>

                                    @endforeach
            <br>
            @endif
            <?php $suggestions = \App\Models\PatientSuggestion::where('service_turn_id', $service_turn_id); ?>

            @if($suggestions->count() > 0)
            <br>
            <hr>
            <br>
            <h4>پیشنهادات پزشک</h4>

            

            <table class="table table-bordered" id="" width="99%">
                <thead>
                    <tr class="table-info">
                        <th>
                            #
                        </th>
                        <th>
                            پیشنهاد
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
                        <th>
                            تاریخ
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; ?>
                    @foreach($suggestions->get() as $row)
                    <?php $date = explode(" ", $row->created_at); ?>
                        <tr align="center">
                            <td>{{ $i++ }}</td>
                            <td>{!! $row->service !!}</td>
                            <td>
                                {{ $row->count }}
                            </td>
                            <td>{{ $row->type }}</td>
                            <td>
                                {{ $row->description }}
                            </td>
                            <td>
                                {{ \App\Helpers\ConvertDate::toJalali($date[0]) }}
                            </td>
                        </tr>
                    @endforeach 
                    
                </tbody>
            </table>    
            <br>
            <br>

            @endif

            @if($perceptions->count() > 0)
            <br>
            <hr>
            <br>
            <h4>نسخه های پزشک</h4>

            <table class="table table-bordered" id="" width="99%">
                <thead>
                    <tr class="table-info">
                        <th>
                            #
                        </th>   
                        <th>
                            تاریخ ثبت
                        </th>
                        <th>
                            دارو
                        </th>
                        <th>
                            مقدار مصرف
                        </th>
                        <th>
                            توضیح
                        </th>
                        <th>
                            عملیات
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; ?>
                    @foreach($perceptions->get() as $perception)
                    <?php $date = explode(" ", $perception->created_at); ?>
                        <tr align="center">
                            <td>{{ $i++ }}</td>
                            <td>{{ \App\Helpers\ConvertDate::toJalali($date[0]) }}</td>
                            <td>{!! $perception->name !!}</td>
                            <td>{!! $perception->dose !!}</td>
                            <td>{!! $perception->description !!}</td>
                            <td>
                                <a class="" style="color: red;" href="{{ url('receptions/medicines/delete').'/'.$perception->id }}">حذف</a>
                            </td>
                        </tr>
                    @endforeach 
                    
                </tbody>
            </table>    
            <br>
            <br>
            @endif
            
            
            
            {!! Form::open(['action' => ['TurnController@submitDescription'], 'class' => 'kt-form kt-form--label-right','files' => true]) !!}
                <input name="service_turn_id" type="hidden" id="service_turn_id" value="{{ $service_turn_id }}">
                
                                            </div>
                                            <div class="tab-pane" id="kt_widget6_tab1_content" aria-expanded="true">
                                                <p class="text-center">علل مراجعه‌ی بیمار را یادداشت کنید</p>
                                                <div class="col-sm-12">
                                                    <textarea name="cause" class="form-control" id="cause"></textarea>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="kt_widget6_tab2_content" aria-expanded="false">
                                                <p class="text-center">تشخیض اولیه‌ی شما از بیماری</p>
                                                <div class="col-sm-12">
                                                    <textarea name="detection" id="detection" class="form-control"></textarea>
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
                                                        <input id="service_count" min="1" type="number" value="1" class="form-control" placeholder="تعداد">

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
                                                            <th>
                                                                عملیات
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="service_table">
                                                        
                                                    </tbody>
                                                </table>
                                                <div class="col-sm-12">
                                                    <textarea name="suggestion" class="form-control" id="suggestion" rows="10"></textarea>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="kt_widget6_tab4_content" aria-expanded="false">
                                                <p class="text-center">تشخیص شما چیست؟</p>
                                                <?php $newstring = ''; ?>
                                                @foreach($diagnoses->orderBy('id','desc')->get() as $diagnosis)
                    <?php $date = explode(" ", $diagnosis->created_at); ?>
                        
                                <?php
                                    $string = $diagnosis->diagnosis;

                                    $str_0 = explode("تشخیص اولیه:", $string);
                                    $str_1 = explode("پیشنهاد پزشک:", $str_0[1]);
                                    $str_2 = explode("تشخیص پزشک:", $str_1[1]);
                                    $str_3 = explode('آزمایش:', $str_2[1]);
                                    $strstr = $str_3[0];
                                    $strstr = str_replace("<br /><br />", "", $strstr);

                                    $newstring .=$strstr;
                                    ?>
                    @endforeach 
                                                <div class="col-sm-12">
                                                    <textarea name="perception" class="form-control" id="diagnosis" rows="10">{{ $newstring }}</textarea>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="kt_widget6_tab7_content" aria-expanded="false">
                                                <p class="text-center">آزمایش</p>
                                                <div class="col-sm-12">
                                                    <textarea name="test" class="form-control" id="test" rows="10"></textarea>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="kt_widget6_tab8_content" aria-expanded="false">
                                                @if(!is_null($answers_collection_2))
                                                <h4 dir="rtl">پرسشنامه پرونده:</h4>
                                                <?php
                                                $questions = \DB::table('questions')->where('location', 'patient')->get(); $i=1;
                                                $answers = json_decode($answers_collection_2) ?>

                                                @foreach($questions as $row)
                                                    <div class="m-portlet__body">   
                                                        <div class="form-group m-form__group">
                                                            <label for="">{{ \App\Helpers\ConvertNumber::convertToPersian($i++) }} - {{ $row->title }}</label>
                                                            <br><br>
                                                            
                                                            @if($row->type == 'radio')
                                                                <?php
                                                                    $options = \App\Models\Option::where('question_id', $row->id)->get();
                                                                ?>
                                                                @foreach($options as $option)
                                                                <?php $question = "question_".$row->id; ?>
                                                                    <input class="" type="radio" @if($answers->$question == $option->id) checked="" @endif name="question_{{ $row->id }}" value="{{ $option->id }}" style="margin-right: 20px"> {{ $option->title }}
                                                                @endforeach 

                                                            @elseif($row->type == 'checkbox')
                                                                <?php
                                                                    $options = \App\Models\Option::where('question_id', $row->id)->get();
                                                                ?>
                                                                @foreach($options as $option)
                                                                <?php $question = "question_".$row->id; ?>
                                                                    <input @if(in_array($option->id, $answers->$question)) checked="" @endif class="" type="checkbox" name="question_{{ $row->id }}[]" value="{{ $option->id }}" style="margin-right: 20px"> {{ $option->title }}
                                                                @endforeach 

                                                            @else
                                                            <?php $question = "question_".$row->id; ?>
                                                                <input type="text" class="form-control m-input" style="width: 50%;" name="question_{{ $row->id }}" value="{{ $answers->$question }}">
                                                            @endif
                                                            
                                                        </div>

                                                    </div>
                                            @endforeach
                                                @endif
                                                <hr>
                                                @foreach($answers_collection as $query)
                                                <?php $date = explode(" ", $query->turn_time);
                                                      $jDate = \App\Helpers\ConvertDate::toJalali($date[0]);
                                                ?>
                                                <h4 dir="rtl">پرسشنامه تاریخ {{ \App\Helpers\ConvertNumber::convertToPersian($jDate) }}</h4>
                                                <?php

                                                $questions = \DB::table('questions')->where('location', 'turn')->get(); $i=1;
                                                $answers = \DB::table('turns')->where('id', $query->id)->first()->answers;
                                                $answers = json_decode($answers)
                                                ?>
                                                @foreach($questions as $row)
                                                    <div class="m-portlet__body">   
                                                        <div class="form-group m-form__group">
                                                            <label for="">{{ \App\Helpers\ConvertNumber::convertToPersian($i++) }} - {{ $row->title }}</label>
                                                            <br><br>
                                                            
                                                            @if($row->type == 'radio')
                                                                <?php
                                                                    $options = \App\Models\Option::where('question_id', $row->id)->get();
                                                                ?>
                                                                @foreach($options as $option)
                                                                <?php $question = "question_".$row->id; ?>
                                                                    <input class="" type="radio" @if($answers->$question == $option->id) checked="" @endif name="question_{{ $row->id }}" value="{{ $option->id }}" style="margin-right: 20px"> {{ $option->title }}
                                                                @endforeach 

                                                            @elseif($row->type == 'checkbox')
                                                                <?php
                                                                    $options = \App\Models\Option::where('question_id', $row->id)->get();
                                                                ?>
                                                                @foreach($options as $option)
                                                                <?php $question = "question_".$row->id; ?>
                                                                    <input @if(in_array($option->id, $answers->$question)) checked="" @endif class="" type="checkbox" name="question_{{ $row->id }}[]" value="{{ $option->id }}" style="margin-right: 20px"> {{ $option->title }}
                                                                @endforeach 

                                                            @else
                                                            <?php $question = "question_".$row->id; ?>
                                                                <input type="text" class="form-control m-input" style="width: 50%;" name="question_{{ $row->id }}" value="{{ $answers->$question }}">
                                                            @endif
                                                            
                                                        </div>

                                                    </div>
                                            @endforeach
                                            <hr>
                                            @endforeach
                                            </div>
                                            <div class="tab-pane" id="kt_widget6_tab5_content" aria-expanded="false">
                                                <p class="text-center">داروهای مورد تجویز شما برای بیمار</p>
                                                @if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 54)->count() == 1)
                                                <div class="form-group row">
                                                    <label class="col-lg-1 col-form-label" style="font-size: 11px;">نام داروی شیمیایی:</label>
                                                    <div class="col-lg-3">
                                                        <!-- <input type="text" class="form-control" placeholder="مثال: AdultCold"> -->
                                                        <select class="form-control selectbox2 medicines" id="kt_select2_1" name="param">
                                                                <option selected="" disabled="" value="0">جستجو کنید</option>
                                                                @foreach($medicines as $row)
                                                                 <option value="{{ $row->name }}">{{ $row->name }}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>
                                                    <label class="col-lg-1 col-form-label">مقدار مصرف:</label>
                                                    <div class="col-lg-2">
                                                        <input id="dose" type="text" class="form-control" placeholder="مثال: هر ۸ ساعت ">

                                                    </div>
                                                    <label class="col-lg-1 col-form-label">توضیحات:</label>
                                                    <div class="col-lg-3">
                                                        <input id="desc" type="text" class="form-control" placeholder="مثال: همراه با آب فراوان">

                                                    </div>
                                                    <button type="button" id="plus" class="btn btn-primary btn-icon"><i class="fa fa-plus"></i></button>
                                                </div>
                                                @endif
                                                @if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 53)->count() == 1)
                                                <div class="form-group row">
                                                    <label class="col-lg-1 col-form-label" style="font-size: 11px;">نام داروی گیاهی:</label>
                                                    <div class="col-lg-3">
                                                        <!-- <input type="text" class="form-control" placeholder="مثال: AdultCold"> -->
                                                        <select class="form-control selectbox medicines2" id="kt_select2_2" name="param">
                                                            <option selected="" disabled="" value="0">جستجو کنید</option>
                                                            @foreach($iranian_drugs as $row)
                                                             <option value="{{ $row->name_fa }}">{{ $row->name_fa }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <label class="col-lg-1 col-form-label">دوز مصرفی:</label>
                                                    <div class="col-lg-2">
                                                        <input id="dose2" type="text" class="form-control" placeholder="مثال: هر ۸ ساعت ">

                                                    </div>
                                                    <label class="col-lg-1 col-form-label">توضیحات:</label>
                                                    <div class="col-lg-3">
                                                        <input id="desc2" type="text" class="form-control" placeholder="مثال: همراه با آب فراوان">

                                                    </div>
                                                    <button type="button" id="plus2" class="btn btn-primary btn-icon"><i class="fa fa-plus"></i></button>
                                                </div>
                                                @endif
                                                <div class="form-group row">
                                                    <label class="col-lg-1 col-form-label">نام دارو:</label>
                                                    <div class="col-lg-3">
                                                        <!-- <input type="text" class="form-control" placeholder="مثال: AdultCold"> -->
                                                        <input type="text" placeholder="داروی جدید (در صورت نبودن در لیست فوق)" id="new_med" name="new_med" class="form-control m-input">
                                                    </div>
                                                    <label class="col-lg-1 col-form-label">مقدار مصرف:</label>
                                                    <div class="col-lg-2">
                                                        <input id="new_dose" type="text" class="form-control" placeholder="مثال: هر ۸ ساعت ">

                                                    </div>
                                                    <label class="col-lg-1 col-form-label">توضیحات:</label>
                                                    <div class="col-lg-3">
                                                        <input id="new_desc" type="text" class="form-control" placeholder="مثال: همراه با آب فراوان">

                                                    </div>
                                                    <button type="button" id="new_plus" class="btn btn-primary btn-icon"><i class="fa fa-plus"></i></button>
                                                </div>
                                                @if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 54)->count() == 1)
                                                <p class="text-center">داروهای شیمیایی</p>
                                                <div class="col-sm-12">
                                                    <p id="conflict" style="display: none;" class="text-danger text-center">بین داروهای وارد شده تداخل دارویی وجود دارد.</p>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr align="center">
                                                                <th>
                                                                    نام دارو
                                                                </th>
                                                                <th>
                                                                    مقدار مصرف
                                                                </th>
                                                                <th>
                                                                    توضیح
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="medicines_table">
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <br>
                                                @endif

                                                <p class="text-center">داروهای گیاهی</p>
                                                <div class="col-sm-12">

                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr align="center">
                                                                <th>
                                                                    نام دارو
                                                                </th>
                                                                <th>
                                                                    مقدار مصرف
                                                                </th>
                                                                <th>
                                                                    توضیح
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="medicines2_table">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="kt-portlet__foot">
                                        <div class="row align-items-center">
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-success">ثبت تمامی موارد</button>

                                            </div>
                                        </div>
                                    </div>
                                    @if($nurse_descriptions->count() > 0 || $files->count() > 0)
                                        <hr>
    <h5 align="center">فایل‌ها</h5>
                                        <table align="center" class="table table-bordered">
                                            <thead>
                                                <tr align="center">
                                                    <th>#</th>
                                                    <th>تاریخ</th>
                                                    <th>نوع فایل</th>
                                                    <th>توضیحات</th>
                                                    <th>فایل</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1; ?>
                                                @if($nurse_descriptions->count() > 0)
                                                @foreach($nurse_descriptions->get() as $row)
                                                <tr align="center">
                                                    <td style="padding-top: 10px; padding-bottom:10px;">
                                                        {{ \App\Helpers\ConvertNumber::convertToPersian($i++) }}<br>
                                                    </td>
                                                    <td>
                                                        {{ \App\Helpers\ConvertDate::toJalali($row->created_at) }}
                                                    </td>
                                                    <td>تست</td>
                                                    <td style="padding-top: 10px; padding-bottom:10px;">
                                                        {!! strip_tags($row->description) !!}
                                                    </td>
                                                    <td style="padding-top: 10px; padding-bottom:10px;">
                                                        <a href="{{ url('nurse-description/edit/'.$row->id) }}" class="btn btn-sm btn-primary">ویرایش</a>
                                                        <button type="button" onclick="window.open('{{ url('uploads/'.$row->file_url) }}',null,'height=900,width=700,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no');" href="{{ url('uploads/'.$row->file_url) }}" class="btn btn-success">مشاهده فایل</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif

                                                @if($files->count() > 0)
                                                @foreach($files->get() as $row)
                                                <tr align="center">
                                                    <td style="padding-top: 10px; padding-bottom:10px;">
                                                        {{ \App\Helpers\ConvertNumber::convertToPersian($i++) }}<br>
                                                    </td>
                                                    <td>
                                                        {{ \App\Helpers\ConvertDate::toJalali($row->created_at) }}
                                                    </td>
                                                    <td>
                                                        پذیرش
                                                    </td>
                                                    <td style="padding-top: 10px; padding-bottom:10px;">
                                                        
                                                    </td>
                                                    <td style="padding-top: 10px; padding-bottom:10px;">
                                                        <button type="button" onclick="window.open('{{ url('uploads/'.$row->file_url) }}',null,'height=900,width=700,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no');" href="{{ url('uploads/'.$row->file_url) }}" class="btn btn-success">مشاهده فایل</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        <hr>
                                    @endif
                                    
                                    
                                </div>
                            </div>

                        </div>
                    </form>
@stop
@section('scripts')
    <script src="{{ url('new/assets/js/demo1/pages/crud/forms/widgets/bootstrap-markdown.js') }}" type="text/javascript"></script>
    <script>
    
$(document).on('click','#plus', function() {  
    
    text_1 = $(".medicines").val()+" ";
    text_2 = $("#dose").val()+" ";
    desc = $("#desc").val();


    $.ajax({
        url: "{!! url('turns/add-medicines') !!}",
        type: "post",
        data: {
            id: $("#service_turn_id").val(),
            name: text_1,
            dose: text_2,
            desc: desc
        },
        success: function (data) {
            if(data == 'nok') {
                $("#conflict").show();
            } else {
                $("#conflict").hide();
            }
        }
    });

    string = '<tr align="center"><td>'+text_1+'</td><td>'+text_2+'</td><td>'+desc+'</td></tr>';

    $("#medicines_table").append(string);


    final = text_1 + text_2 + desc;


document.getElementById("dose").value = '';
document.getElementById("desc").value = '';
$('.medicines').val('0').change();
    
});

$(document).on('click','#plus2', function() {  
    
    text_1 = $(".medicines2").val()+" ";
    text_2 = $("#dose2").val()+" ";
    desc = $("#desc2").val();

    $.ajax({
        url: "{!! url('turns/add-medicines') !!}",
        type: "post",
        data: {
            id: $("#service_turn_id").val(),
            name: text_1,
            dose: text_2,
            desc: desc
        },
        success: function (data) {
            console.log(data);
        }
    });

    string = '<tr align="center"><td>'+text_1+'</td><td>'+text_2+'</td><td>'+desc+'</td></tr>';

    $("#medicines2_table").append(string);


    final = text_1 + text_2 + desc;


document.getElementById("dose2").value = '';
document.getElementById("desc2").value = '';
$('.medicines2').val('0').change();
    
});

$(document).on('change','.services', function() {
    if($('.services').val() == 'طب سوزنی ( درمان )') {
        document.getElementById("service_count").value = '4';
    }
});

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
            id: $("#service_turn_id").val(),
            service: services,
            service_count: service_count,
            service_type: service_type,
            service_desc: service_desc

        },
        success: function (data) {
            string = '<tr id="row_'+data+'" align="center"><td>'+services+'</td><td>'+service_count+'</td><td>'+service_type+'</td><td>'+service_desc+'</td><td><p style="color:red;" class="delete" id="delete_'+data+'">حذف</p></td></tr>';

            $("#service_table").append(string);
        }
    });

    $(document).on('click', '.delete', function() {
        $delete_id = $(this).attr('id');
        $.ajax({
        url: "{!! url('turns/delete-suggestion') !!}",
        type: "post",
        data: {
            id: $delete_id
        },
        success: function (data) {
            $("#"+data).hide();
        }
        });
        
    });

    



$('.services').val('0').change();
document.getElementById("new_dose").value = '';
document.getElementById("new_desc").value = '';
document.getElementById("new_med").value = '';   
});

$(document).on('click','#new_plus', function() { 
    
    text_1 = $("#new_med").val()+" ";
    text_2 = $("#new_dose").val()+" ";
    desc = $("#new_desc").val();


    final = text_1 + text_2 + desc;


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
        CKEDITOR.config.autoParagraph = false;
        CKEDITOR.replace( 'final_span' );
        var diag = CKEDITOR.replace( 'diagnosis' );
        CKEDITOR.replace( 'detection' );
        CKEDITOR.replace( 'suggestion' );
        CKEDITOR.replace( 'cause' );
        CKEDITOR.replace( 'test' );

        /*console.log(diag);
        diag.dataProcessor.writer.setRules('br',
         {
             indent: false,
             breakBeforeOpen: false,
             breakAfterOpen: false,
             breakBeforeClose: false,
             breakAfterClose: false
         });*/
        //console.log(CKEDITOR.ENTER_BR);
        //CKEDITOR.config.enterMode = CKEDITOR.ENTER_P;
        //CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;

    };

    @foreach($newdiagnoses->get() as $diagnosis)
        $(document).on('click','#plus{{ $diagnosis->id }}', function() {
            $('#activity_log{{ $diagnosis->id }}').toggle();
        })
    @endforeach
</script>
@stop