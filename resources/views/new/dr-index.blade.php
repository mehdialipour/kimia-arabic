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
                                                بیماران امروز
                                            </h3>
                                            <span class="kt-widget14__desc">
																تعداد کل پرونده‌ها
															</span>
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
                                                تعداد نوبت های امروز
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



                            <div class="col-xl-4 col-lg-4">

                                <!--begin:: Widgets/Profit Share-->
                                <div class="kt-portlet kt-portlet--height-fluid">
                                    <div class="kt-widget14">
                                        <div class="kt-widget14__header">
                                            <h3 class="kt-widget14__title">
                                                صندوق جاری شما
                                            </h3>
                                            <span class="kt-widget14__desc">
																	
																</span>
                                        </div>
                                        <div class="kt-widget14__content">
                                            <div class="kt-widget14__chart">
                                                <div class="kt-widget14__stat">{{ $fund }}</div>
                                                <canvas id="kt_chart_profit_share_2" style="height: 140px; width: 140px;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--end:: Widgets/Profit Share-->
                            </div>

                        </div>
@stop