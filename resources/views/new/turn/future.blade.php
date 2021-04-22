@extends('new.layout')
@section('title')
نوبت‌های آینده
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                                <i class="kt-font-brand flaticon2-files-and-folders"></i>
                            </span>
            <h3 class="kt-portlet__head-title">
                نوبت‌های ماه {{ $month_name }}
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">

                    &nbsp;
                    <a href="/newfolder.html" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="flaticon2-add-1"></i> نوبت جدید
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">

        <!--begin: Datatable -->
        <div id="kt_calendar" class="fc fc-ltr fc-unthemed" style="">
            <div class="fc-toolbar fc-header-toolbar">
                <div class="fc-left">
                    <div class="fc-button-group">

        <?php $x = $p+1; ?>
        <a href="{{ url('turns/future?p='.$x) }}" class="btn btn-info">ماه بعد</a> 
        
        <?php $x=$p-1; ?>
            <a href="{{ url('turns/future?p='.$x) }}" class="btn btn-info">ماه قبل</a>
        
                    </div>
                </div>
                <div class="fc-center">
                    <h2>{{ $month_name }} {{ $current_year }}</h2>
                </div>
                <div class="fc-right">

                </div>
            </div>
            <div class="fc-view-container">
                <div class="fc-view fc-dayGridMonth-view fc-dayGrid-view" style="">
                    <table class="">
                        <thead class="fc-head">
                            <tr>
                                <td class="fc-head-container fc-widget-header">
                                    <div class="fc-row fc-widget-header" dir="rtl">
                                        
                                    </div>
                                </td>
                            </tr>
                        </thead>
                        <tbody class="fc-body" dir="rtl">
                            <tr>
                                <td class="fc-widget-content">
                                    <div class="fc-scroller fc-day-grid-container" style="overflow: hidden; height: 740px;">
                                        <div class="fc-day-grid">
                                            <div class="fc-row fc-week fc-widget-content fc-rigid" style="height: 123px;">
                                                <div class="fc-bg">
                                                    <table class="">
                                                        <tbody>
                                                            <tr>
                                                                <td class="fc-day fc-widget-content fc-sun fc-past" data-date="2019-07-28"></td>
                                                                <td class="fc-day fc-widget-content fc-mon fc-past" data-date="2019-07-29"></td>
                                                                <td class="fc-day fc-widget-content fc-tue fc-past" data-date="2019-07-30"></td>
                                                                <td class="fc-day fc-widget-content fc-wed fc-past" data-date="2019-07-31"></td>
                                                                <td class="fc-day fc-widget-content fc-thu fc-past" data-date="2019-08-01"></td>
                                                                <td class="fc-day fc-widget-content fc-fri fc-past" data-date="2019-08-02"></td>
                                                                <td class="fc-day fc-widget-content fc-sat fc-past" data-date="2019-08-03"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="fc-content-skeleton">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td class="fc-day-top fc-thu fc-past" data-date="2019-08-01"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-01&quot;,&quot;type&quot;:&quot;day&quot;}">1</a></td>
                                                                <td class="fc-day-top fc-fri fc-past" data-date="2019-08-02"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-02&quot;,&quot;type&quot;:&quot;day&quot;}">2</a></td>
                                                                <td class="fc-day-top fc-sat fc-past" data-date="2019-08-03"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-03&quot;,&quot;type&quot;:&quot;day&quot;}">3</a></td>

                                                                <td class="fc-day-top fc-sun fc-past" data-date="2019-08-04"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-04&quot;,&quot;type&quot;:&quot;day&quot;}">4</a></td>
                                                                <td class="fc-day-top fc-mon fc-past" data-date="2019-08-05"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-05&quot;,&quot;type&quot;:&quot;day&quot;}">5</a></td>
                                                                <td class="fc-day-top fc-tue fc-past" data-date="2019-08-06"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-06&quot;,&quot;type&quot;:&quot;day&quot;}">6</a></td>
                                                                <td class="fc-day-top fc-wed fc-past" data-date="2019-08-07"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-07&quot;,&quot;type&quot;:&quot;day&quot;}">7</a></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($ex[0]);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>

                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."02";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php

                                                                    $date = $ex[0]."-".$ex[1]."-"."03";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."04";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."05";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."06";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."07";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="fc-row fc-week fc-widget-content fc-rigid" style="height: 123px;">
                                                <div class="fc-bg">
                                                    <table class="">
                                                        <tbody>
                                                            <tr>
                                                                <td class="fc-day fc-widget-content fc-sun fc-past" data-date="2019-08-04">
                                                                    
                                                                </td>
                                                                <td class="fc-day fc-widget-content fc-mon fc-past" data-date="2019-08-05"></td>
                                                                <td class="fc-day fc-widget-content fc-tue fc-past" data-date="2019-08-06"></td>
                                                                <td class="fc-day fc-widget-content fc-wed fc-past" data-date="2019-08-07"></td>
                                                                <td class="fc-day fc-widget-content fc-thu fc-past" data-date="2019-08-08"></td>
                                                                <td class="fc-day fc-widget-content fc-fri fc-past" data-date="2019-08-09"></td>
                                                                <td class="fc-day fc-widget-content fc-sat fc-past" data-date="2019-08-10"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="fc-content-skeleton">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td class="fc-day-top fc-thu fc-past" data-date="2019-08-08"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-08&quot;,&quot;type&quot;:&quot;day&quot;}">8</a></td>
                                                                <td class="fc-day-top fc-fri fc-past" data-date="2019-08-09"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-09&quot;,&quot;type&quot;:&quot;day&quot;}">9</a></td>
                                                                <td class="fc-day-top fc-sat fc-past" data-date="2019-08-10"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-10&quot;,&quot;type&quot;:&quot;day&quot;}">10</a></td>

                                                                <td class="fc-day-top fc-sun fc-past" data-date="2019-08-11"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-11&quot;,&quot;type&quot;:&quot;day&quot;}">11</a></td>
                                                                <td class="fc-day-top fc-mon fc-past" data-date="2019-08-12"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-12&quot;,&quot;type&quot;:&quot;day&quot;}">12</a></td>
                                                                <td class="fc-day-top fc-tue fc-past" data-date="2019-08-13"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-13&quot;,&quot;type&quot;:&quot;day&quot;}">13</a></td>
                                                                <td class="fc-day-top fc-wed fc-past" data-date="2019-08-14"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-14&quot;,&quot;type&quot;:&quot;day&quot;}">14</a></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."08";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."09";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."10";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."11";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."12";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."13";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."14";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                            <div class="fc-row fc-week fc-widget-content fc-rigid" style="height: 123px;">
                                                <div class="fc-bg">
                                                    <table class="">
                                                        <tbody>
                                                            <tr>
                                                                <td class="fc-day fc-widget-content fc-sun fc-past" data-date="2019-08-11"></td>
                                                                <td class="fc-day fc-widget-content fc-mon fc-past" data-date="2019-08-12"></td>
                                                                <td class="fc-day fc-widget-content fc-tue fc-past" data-date="2019-08-13"></td>
                                                                <td class="fc-day fc-widget-content fc-wed fc-past" data-date="2019-08-14"></td>
                                                                <td class="fc-day fc-widget-content fc-thu fc-past" data-date="2019-08-15"></td>
                                                                <td class="fc-day fc-widget-content fc-fri fc-past" data-date="2019-08-16"></td>
                                                                <td class="fc-day fc-widget-content fc-sat fc-past" data-date="2019-08-17"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="fc-content-skeleton">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td class="fc-day-top fc-thu fc-past" data-date="2019-08-15"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-15&quot;,&quot;type&quot;:&quot;day&quot;}">15</a></td>
                                                                <td class="fc-day-top fc-fri fc-past" data-date="2019-08-16"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-16&quot;,&quot;type&quot;:&quot;day&quot;}">16</a></td>
                                                                <td class="fc-day-top fc-sat fc-past" data-date="2019-08-17"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-17&quot;,&quot;type&quot;:&quot;day&quot;}">17</a></td>
                                                                <td class="fc-day-top fc-sun fc-past" data-date="2019-08-18"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-18&quot;,&quot;type&quot;:&quot;day&quot;}">18</a></td>
                                                                <td class="fc-day-top fc-mon fc-past" data-date="2019-08-19"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-19&quot;,&quot;type&quot;:&quot;day&quot;}">19</a></td>
                                                                <td class="fc-day-top fc-tue fc-past" data-date="2019-08-20"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-20&quot;,&quot;type&quot;:&quot;day&quot;}">20</a></td>
                                                                <td class="fc-day-top fc-wed fc-past" data-date="2019-08-21"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-21&quot;,&quot;type&quot;:&quot;day&quot;}">21</a></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."15";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."16";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."17";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."18";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."19";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."20";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."21";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="fc-row fc-week fc-widget-content fc-rigid" style="height: 123px;">
                                                <div class="fc-bg">
                                                    <table class="">
                                                        <tbody>
                                                            <tr>
                                                                <td class="fc-day fc-widget-content fc-sun fc-past" data-date="2019-08-18"></td>
                                                                <td class="fc-day fc-widget-content fc-mon fc-past" data-date="2019-08-19"></td>
                                                                <td class="fc-day fc-widget-content fc-tue fc-past" data-date="2019-08-20"></td>
                                                                <td class="fc-day fc-widget-content fc-wed fc-past" data-date="2019-08-21"></td>
                                                                <td class="fc-day fc-widget-content fc-thu fc-past" data-date="2019-08-22"></td>
                                                                <td class="fc-day fc-widget-content fc-fri fc-past" data-date="2019-08-23"></td>
                                                                <td class="fc-day fc-widget-content fc-sat fc-past" data-date="2019-08-24"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="fc-content-skeleton">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                
                                                                <td class="fc-day-top fc-thu fc-past" data-date="2019-08-22"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-22&quot;,&quot;type&quot;:&quot;day&quot;}">22</a></td>
                                                                <td class="fc-day-top fc-fri fc-past" data-date="2019-08-23"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-23&quot;,&quot;type&quot;:&quot;day&quot;}">23</a></td>
                                                                <td class="fc-day-top fc-sat fc-past" data-date="2019-08-24"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-24&quot;,&quot;type&quot;:&quot;day&quot;}">24</a></td>

                                                                <td class="fc-day-top fc-sun fc-past" data-date="2019-08-25"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-25&quot;,&quot;type&quot;:&quot;day&quot;}">25</a></td>
                                                                <td class="fc-day-top fc-mon fc-past" data-date="2019-08-26"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-26&quot;,&quot;type&quot;:&quot;day&quot;}">26</a></td>
                                                                <td class="fc-day-top fc-tue fc-past" data-date="2019-08-27"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-27&quot;,&quot;type&quot;:&quot;day&quot;}">27</a></td>
                                                                <td class="fc-day-top fc-wed fc-past" data-date="2019-08-28"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-28&quot;,&quot;type&quot;:&quot;day&quot;}">28</a></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."22";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."23";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."24";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."25";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."26";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."27";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."28";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                            <div class="fc-row fc-week fc-widget-content fc-rigid" style="height: 123px;">
                                                <div class="fc-bg">
                                                    <table class="">
                                                        <tbody>
                                                            <tr>
                                                                <td class="fc-day fc-widget-content fc-sun fc-past" data-date="2019-08-25"></td>
                                                                <td class="fc-day fc-widget-content fc-mon fc-past" data-date="2019-08-26"></td>
                                                                <td class="fc-day fc-widget-content fc-tue fc-past" data-date="2019-08-27"></td>
                                                                <td class="fc-day fc-widget-content fc-wed fc-past" data-date="2019-08-28"></td>
                                                                <td class="fc-day fc-widget-content fc-thu fc-past" data-date="2019-08-29"></td>
                                                                <td class="fc-day fc-widget-content fc-fri fc-past" data-date="2019-08-30"></td>
                                                                <td class="fc-day fc-widget-content fc-sat fc-past" data-date="2019-08-31"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="fc-content-skeleton">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <td class="fc-day-top fc-thu fc-past" data-date="2019-08-29"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-29&quot;,&quot;type&quot;:&quot;day&quot;}">29</a></td>
                                                                @if($count_of_days > 29)
                                                                    <td class="fc-day-top fc-fri fc-past" data-date="2019-08-30"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-30&quot;,&quot;type&quot;:&quot;day&quot;}">30</a></td>
                                                                @endif
                                                                @if($count_of_days == 31)
                                                                    <td class="fc-day-top fc-sat fc-past" data-date="2019-08-31"><a class="fc-day-number" data-goto="{&quot;date&quot;:&quot;2019-08-31&quot;,&quot;type&quot;:&quot;day&quot;}">31</a></td>
                                                                @endif  
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."29";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                @if($count_of_days > 29)
                                                                    <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."30";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                @endif
                                                                @if($count_of_days == 31)
                                                                <?php
                                                                    $ex = explode(" ", $new_date);
                                                                    $ex = explode("-", $ex[0]);

                                                                    $date = $ex[0]."-".$ex[1]."-"."31";
                                                                    $date = \App\Helpers\ConvertDate::toGeorgian($date);
                                                                    $date = $date[0]."-".$date[1]."-".$date[2];

                                                                    $count = \DB::table('service_turn')
                                                                                ->leftjoin('turns','service_turn.turn_id','=','turns.id')
                                                                                ->where('turns.turn_time','like',"%$date%")
                                                                                ->count();
                                                                ?>
                                                                <td @if($count >= 0) class="fc-event-container" @endif>
                                                                    @if($count >= 0)
                                                                    <a href="{{ url('turns/show-future/'.$date) }}" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end @if($count < 25) fc-event-primary @elseif($count >= 25 && $count < 35) fc-event-solid-warning @else fc-event-solid-danger @endif"  data-original-title="" title="">
                                                                        <div class="fc-content"> <span class="fc-title">{{ $count }} خدمت</span></div>

                                                                    </a>
                                                                    @endif
                                                                </td>
                                                                @endif
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                @if($count_of_days == 31)
                                                                <td></td>
                                                                @elseif($count_of_days > 29)
                                                                <td></td>
                                                                <td></td>
                                                                @else
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                @endif
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="fc-row fc-week fc-widget-content fc-rigid" style="height: 125px;">
                                                <div class="fc-bg">
                                                    <table class="">
                                                        <tbody>
                                                            <tr>
                                                                <td class="fc-day fc-widget-content fc-sun fc-other-month fc-past" data-date="2019-09-01"></td>
                                                                <td class="fc-day fc-widget-content fc-mon fc-other-month fc-past" data-date="2019-09-02"></td>
                                                                <td class="fc-day fc-widget-content fc-tue fc-other-month fc-past" data-date="2019-09-03"></td>
                                                                <td class="fc-day fc-widget-content fc-wed fc-other-month fc-past" data-date="2019-09-04"></td>
                                                                <td class="fc-day fc-widget-content fc-thu fc-other-month fc-past" data-date="2019-09-05"></td>
                                                                <td class="fc-day fc-widget-content fc-fri fc-other-month fc-past" data-date="2019-09-06"></td>
                                                                <td class="fc-day fc-widget-content fc-sat fc-other-month fc-past" data-date="2019-09-07"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--end: Datatable -->
    </div>
</div>
@stop