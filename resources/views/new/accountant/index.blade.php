@extends('new.layout')
@section('title')

@stop

@section('content')
	<div class="row">

                            <div class="col-xl-3 col-lg-3 order-lg-1 order-xl-1">
                                <!--begin:: Widgets/Finance Summary-->
                                <div class="kt-portlet kt-portlet--height-fluid">
                                    <div class="kt-portlet__head">
                                        <div class="kt-portlet__head-label">
                                            <h3 class="kt-portlet__head-title">
                                                آمار عددی صندوق
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="kt-portlet__body">
                                        <div class="kt-widget12">
                                            <div class="kt-widget12__content">
                                                <div class="kt-widget12__item">
                                                    <div class="kt-widget12__info">
                                                        <span class="kt-widget12__desc"><h3>مجموع دریافتی امروز</h3></span>
                                                        <span class="kt-widget12__value"><h3>{{ $sum_today }} دینار</h3></span>
                                                        <br>
                                                        <span class="kt-widget12__desc">مجموع کل صندوق</span>
                                                        <span class="kt-widget12__value">{{ $total }} دینار</span>
                                                        <br>
                                                        <span class="kt-widget12__desc">مجموع تخفیف</span>
                                                        <span class="kt-widget12__value">{{ $discount }} دینار</h3></span>
                                                        <br>
                                                        <span class="kt-widget12__desc">مجموع بستانکاری</span>
                                                        <span class="kt-widget12__value">{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($debt)) }} دینار</span>
                                                        <br>
                                                        <span class="kt-widget12__desc">مجموع افزایش هزینه دریافتی</span>
                                                        <span class="kt-widget12__value">{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($added*-1)) }} دینار</span>
                                                        <br>

                                                        <span class="kt-widget12__desc">مجموع بدهی تسویه شده</span>
                                                        <span class="kt-widget12__value">{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($received_debt)) }} دینار</span>
                                                        
                                                    </div>


                                                </div>
                                                

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end:: Widgets/Finance Summary-->
                            </div>
                            <div class="col-xl-12 col-lg-12 fund-table order-lg-2 order-xl-1">
                                <!--begin:: Widgets/Application Sales-->
                                <div class="kt-portlet kt-portlet--height-fluid">
                                    <div class="kt-portlet__head">
                                        <div class="kt-portlet__head-label">
                                            <h3 class="kt-portlet__head-title">
                                                ‌صندوق امروز به تفکیک بیمار
                                            </h3>
                                        </div>
                                        <!-- <div class="kt-portlet__head-toolbar">
                                            <a href="#" class="btn btn-label-success btn-sm btn-bold dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
													خروجی
												</a>
                                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(421px, 46px, 0px);">
                                                <ul class="kt-nav">
                                                    <li class="kt-nav__item">
                                                        <a href="#" class="kt-nav__link">
                                                            <i class="kt-nav__link-icon flaticon2-line-chart"></i>
                                                            <span class="kt-nav__link-text">اکسل</span>
                                                        </a>
                                                    </li>
                                                    <li class="kt-nav__item">
                                                        <a href="#" class="kt-nav__link">
                                                            <i class="kt-nav__link-icon flaticon2-send"></i>
                                                            <span class="kt-nav__link-text">pdf</span>
                                                        </a>
                                                    </li>
                                                    <li class="kt-nav__item">
                                                        <a href="#" class="kt-nav__link">
                                                            <i class="kt-nav__link-icon flaticon2-pie-chart-1"></i>
                                                            <span class="kt-nav__link-text">چاپ</span>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="kt-portlet__body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="kt_widget11_tab1_content">
                                                <form action="" method="get">
                                                <div class="form-group row align-items-center"> 
                                                            
                                                            <div class="col-md-2">
                                                                <div class="kt-form__group--inline">
                                                                    
                                                                    <div class="kt-form__control">
                                                                        <input type="text" name="name" class="form-control" placeholder="نام و نام خانوادگی"> 
                                                                    </div>
                                                                </div>
                                                                <div class="d-md-none kt-margin-b-10"></div>
                                                            </div>
                                                            
                                                            <div class="col-md-2">
                                                                <input type="submit" class=" btn btn-label-brand btn-bold table__search__btn" value="جستجو">
                                                                    
                                                                    <!-- <i class="flaticon2-magnifier-tool"></i> -->
                                                                
                                                            </div>
                                                        
                                                    </div>
                                                </form>
                                                <!--begin::Widget 11-->
                                                <div class="kt-widget11">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered table-hover table-checkable" id="fund-table">
                                                            <thead>
                                                                <tr align="center">

                                                                    <th>ردیف</th>
                                                                    <th>نام بیمار</th>
                                                                    <th>نام خدمت</th>
                                                                    <th>تعداد</th>
                                                                    <th>خدمت دهنده</th>
                                                                    <th>مبلغ پرداختی</th>
                                                                    <th>تخفیف</th>
                                                                    <th>نوع بیمه</th>
                                                                    <th>وضعیت</th>
                                                                    @if(request('name'))
                                                                        <th>تاریخ</th>
                                                                    @endif    
                                                                </tr>
                                                            </thead>
                                                            <?php $i=1; ?>
				<tbody>
					@foreach($query as $row)
					<tr align="center">
						<td>
							{{ \App\Helpers\ConvertNumber::convertToPersian($i++) }}
						</td>
						<td>
							{{ $row->patient_name }}
						</td>
                        <td>
                            {{ $row->service_name }}
                        </td>
                        <td>
                            {{ $row->count }}
                        </td>
                        <td>
                            {{ $row->user_name }}
                        </td>
						<td>
						 
                         {{ \App\Helpers\ConvertNumber::convertToPersian(number_format($row->net_price*$row->count)) }} دینار
                         
						</td>

                        <td>{{ \App\Helpers\ConvertNumber::convertToPersian($row->discount) }} دینار</td>

						<td>
							{{ \App\Models\Insurance::find($row->insurance_id)->name }}
						</td>
						<td>
							@if($row->paid == 1)
								<span class="text-success">پرداخت شده</span>
							@else
								<span class="text-danger">پرداخت نشده</span>	
							@endif	
						</td>
                        @if(request('name'))
                        <?php
                            $date = explode(" ", $row->turn_time);
                            $jdate = \App\Helpers\ConvertDate::toJalali($date[0]);
                        ?>
                            <td>{{ $jdate }} {{ $date[1] }}</td>
                        @endif    
					</tr>
					@endforeach
				</tbody>
                                                        </table>
                                                    </div>

                                                </div>

                                                <!--end::Widget 11-->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--end:: Widgets/Application Sales-->
                            </div>




                        </div>
@stop