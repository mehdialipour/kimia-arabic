@extends('new.layout')
@section('title')

@stop
@section('content')
<div class="row">
                            <div class="col-xl-4 col-lg-4">

                                <!--begin:: Widgets/Profit Share-->
                                <div class="kt-portlet kt-portlet--height-fluid">
                                    <div class="kt-widget14">
                                        <div class="kt-widget14__header">
                                            <h3 class="kt-widget14__title">
                                                الملفات
                                            </h3>
                                            
                                        </div>
                                        <div class="kt-widget14__content">
                                            <div class="kt-widget14__chart">
                                                <div class="kt-widget14__stat">{{ $patients }}</div>
                                                <canvas id="kt_chart_profit_share" style="height: 140px; width: 140px;"></canvas>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>

                                <!--end:: Widgets/Profit Share-->
                            </div>

                            <div class="col-xl-4 col-lg-4">

                                <!--begin:: Widgets/Profit Share-->
                                <div class="kt-portlet kt-portlet--height-fluid">
                                    <div class="kt-widget14">
                                        <div class="kt-widget14__header">
                                            <h3 class="kt-widget14__title">
                                                عدد دور اليوم
                                            </h3>
                                            <span class="kt-widget14__desc">
                                                                    
                                                                </span>
                                        </div>
                                        <div class="kt-widget14__content">
                                            <div class="kt-widget14__chart">
                                                <div class="kt-widget14__stat">{{ $turns }}</div>
                                                <canvas id="kt_chart_profit_share_2" style="height: 140px; width: 140px;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--end:: Widgets/Profit Share-->
                            </div>


                            <?php
                            $services_count = \DB::table('turns')
                                ->leftjoin('service_turn', 'turns.id', '=', 'service_turn.turn_id')
                                ->where('turns.turn_time', '>', date("Y-m-d").' 00:00:00')
                                ->where('turns.turn_time','<', date("Y-m-d").' 23:59:59')
                                ->count();
                            ?>
                            <div class="col-xl-4 col-lg-4">

                                <!--begin:: Widgets/Profit Share-->
                                <div class="kt-portlet kt-portlet--height-fluid">
                                    <div class="kt-widget14">
                                        <div class="kt-widget14__header">
                                            <h3 class="kt-widget14__title">
                                                الخدمات المقدمة اليوم
                                            </h3>
                                            <span class="kt-widget14__desc">
                                                                    
                                                                </span>
                                        </div>
                                        <div class="kt-widget14__content">
                                            <div class="kt-widget14__chart">
                                                <div class="kt-widget14__stat">{{ $services_count }}</div>
                                                <canvas id="kt_chart_profit_share_3" style="height: 140px; width: 140px;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--end:: Widgets/Profit Share-->
                            </div>

                        </div>
<?php

$sum_today = \App\Models\Fund::where('delivered', 0)->orderBy('id', 'desc')->first();

if (is_null($sum_today)) {
    $sum_today = 0;
} else {
    $sum_today = \App\Helpers\ConvertNumber::convertToPersian(number_format($sum_today->amount));
}

?>
<div class="row">
                            <div class="col-xl-4 col-lg-4">

                                <!--begin:: Widgets/Profit Share-->
                                <div class="kt-portlet kt-portlet--height-fluid">
                                    <div class="kt-widget14">
                                        <div class="kt-widget14__header">
                                            <h3 class="kt-widget14__title">
                                                إجمالي الصندوق
                                            </h3>
                                            <span class="kt-widget14__desc">
																
															</span>
                                        </div>
                                        <div class="kt-widget14__content">
                                            <div class="kt-widget14__chart">
                                                <div class="kt-widget14__stat">{{ $fund }} دینار</div>
                                                <canvas id="kt_chart_profit_share" style="height: 140px; width: 140px;"></canvas>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>

                                <!--end:: Widgets/Profit Share-->
                            </div>

                            

                        </div>
                        <div class="row">
                        <div class="col-xl-6 col-lg-6 order-lg-2 order-xl-1">

                                <!--Begin::Portlet-->
                                <div class="kt-portlet kt-portlet--height-fluid">
                                    <div class="kt-portlet__head">
                                        <div class="kt-portlet__head-label">
                                            <h3 class="kt-portlet__head-title">
                                                الوافدون والمغادرون مؤخرًا
                                            </h3>
                                        </div>
                                        <div class="kt-portlet__head-toolbar">
                                            <div class="dropdown dropdown-inline">
                                                <span class="text-primary" id="activity_log_button"><strong style="font-size: 24px;" id="plus">+</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-portlet__body" id="activity_log" style="display: none;">

                                        <!--Begin::Timeline 3 -->
                                        <div class="kt-timeline-v2">
                                            <div class="kt-timeline-v2__items  kt-padding-top-25 kt-padding-bottom-30">
                                                @foreach($logs as $log)
                                                <?php
                                                $title = \App\Models\ActivityType::find($log->activity_type_id)->title;
                                                ?>
                                                <div class="kt-timeline-v2__item">
                                                    <span class="kt-timeline-v2__item-time">
                                                        <?php $date = explode(" ", $log->created_at);
                                                              $time = explode(":", $date[1]);
                                                         ?>
                                                        {{ \App\Helpers\ConvertNumber::convertToPersian($time[0].':'.$time[1]) }}
                                                    <?php
                                                        $log_date = \Carbon\Carbon::parse($log->created_at);

                                                        $diff = $log_date->diffInDays(\Carbon\Carbon::now());

                                                        $days = '';

                                                        if ($diff > 0) {
                                                            $days = '('.\App\Helpers\ConvertNumber::convertToPersian($diff).' روز پیش)';
                                                        }
                                                    ?> 
                                                    </span>
                                                    <div class="kt-timeline-v2__item-cricle">
                                                        <i class="flaticon2-crisp-icons-1 @if($title == 'logout') kt-font-danger @else kt-font-success @endif"></i>
                                                    </div>
                                                    <div class="kt-timeline-v2__item-text  kt-padding-top-5">
                                                        {{ $log->content }} {{ $days }}
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="kt-widget11__action kt-align-right"x>
                                                        <a style="font-size: 22px;" href="{{ url('/') }}" class="btn btn-label-success btn-sm btn-bold">انظر التفاصيل</a>
                                                    </div>
                                        <!--End::Timeline 3 -->
                                    </div>
                                </div>

                                <!--End::Portlet-->
                            </div>
                        </div>
@stop
@section('scripts')
<script>
    $(document).on('click', '#activity_log_button', function () {
        if($("#plus").hasClass('minimize')) {
            $("#activity_log").hide();
            $("#plus").html('+');
            $("#plus").removeClass('minimize');
        } else {
            $("#activity_log").show();
            $("#plus").html('-');
            $("#plus").addClass('minimize');
        }

    })
</script>
@stop