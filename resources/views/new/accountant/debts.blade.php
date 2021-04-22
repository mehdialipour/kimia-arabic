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
                                                بدهی مراجعین
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="kt-portlet__body">
                                        <div class="kt-widget12">
                                            <div class="kt-widget12__content">
                                                <div class="kt-widget12__item">
                                                    <div class="kt-widget12__info">
                                                        
                                                        <span class="kt-widget12__desc">مجموع بدهی بیماران تا امروز</span>
                                                        <span class="kt-widget12__value">{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($debt)) }} دینار</span>
                                                        
                                                        
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
                                                ‌لیست بدهکاران
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
                                                                    <th>شماره موبایل</th>
                                                                    <th>نام خدمت</th>
                                                                    <th>تعداد</th>
                                                                    <th>خدمت دهنده</th>
                                                                    <th>مبلغ پرداختی</th>
                                                                    <th>بدهی بیمار</th>
                                                                    <th>نوع بیمه</th>
                                                                    <th>وضعیت</th>
                                                                    
                                                                    @if(request('name'))
                                                                        <th>تاریخ</th>
                                                                    @endif  
                                                                    <th></th>  
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
                            <a href="tel:{{ $row->mobile }}">{{ $row->mobile }}</a>
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
						 <?php
                            $tariff = \DB::table('insurance_service')->where('insurance_id', $row->insurance_id)->where('service_id', $row->service_id)->first()->tariff;
                            
                         ?>
                         @if($tariff > 0)
                         {{ \App\Helpers\ConvertNumber::convertToPersian(number_format($tariff*$row->count)) }} دینار
                         @endif
						</td>

                        <td>{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($row->debt)) }} دینار</td>

						<td>
							{{ \App\Models\Insurance::find($row->insurance_id)->name }}
						</td>
						<td>
							<a href="{{ url('turns/receive-single-debt/'.$row->id) }}?name={{ $row->patient_name }}&debt={{ $row->debt }}">دریافت بدهی</a>	
						</td>
                        @if(request('name'))
                        <?php
                            $date = explode(" ", $row->turn_time);
                            $jdate = \App\Helpers\ConvertDate::toJalali($date[0]);
                        ?>
                            <td>{{ $jdate }} {{ $date[1] }}</td>
                        @endif  
                        <?php $debt = \App\Helpers\ConvertNumber::convertToPersian(number_format($row->debt)).' دینار'; ?>
                        <td><a class="btn btn-success" href="{{ url('debts/send-sms/'.$row->id.'?mobile='.$row->mobile.'&name='.$row->patient_name.'&amount='.$debt) }}">ارسال پیامک @if($row->sms > 0) ({{ \App\Helpers\ConvertNumber::convertToPersian($row->sms) }}) @endif</a></td>  

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