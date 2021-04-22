@extends('new.layout')
@section('title')
المواعيد الملغاة
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__head kt-portlet__head--lg">
                                                <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon">
                                                        <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                                    </span>
                                                    <h3 class="kt-portlet__head-title">
                                                        المواعيد الملغاة
                                                    </h3>
                                                </div>
                                                
                                            </div>
                                            <form  method="get">
                    
            <div class="row" style="margin-right: 37%;">
                    <div class="col-md-2">
                        <input type="text" name="from" placeholder="من تاریخ..." class="form-control m-input" id="datepicker" autocomplete="off" value="{{ request('from') }}">
                    </div>

                    <div class="col-md-2">
                        <input type="text" name="to" placeholder="الی تاریخ..." class="form-control m-input" id="datepicker2" autocomplete="off" value="{{ request('to') }}">
                    </div>  

                    <div class="col-md-2">
                        <input type="submit" class="btn btn-primary" value="يبحث">
                    </div>  

            </div>
                                            <div class="kt-portlet__body">

                                                
                                                <table class="table table-striped table-bordered table-hover table-checkable" id="roles-table">
                                                    <thead>
                                                        <tr align="center">
                                                            <th>
                                                                #
                                                            </th>
                                                            <th>
                                                                توضیح
                                                            </th>
                                                            <th>
                                                                المستعمل
                                                            </th>
                                                            <th>
                                                                تاریخ
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i=1; ?>
                                                        @foreach($query as $row)
                                                        <tr align="center">
                                                            <td style="height: 50px;">
                                                                {{ $i++ }}
                                                            </td>
                                                            <td style="height: 50px;">
                                                                {{ $row->content }}
                                                            </td>

                                                            <td style="height: 50px;">
                                                                {{ \App\Models\User::find($row->user_id)->firstname }} {{ \App\Models\User::find($row->user_id)->lastname }}
                                                            </td>

                                                            <?php
                                                               $date = explode(" ", $row->created_at);
                                                               $jdate = \App\Helpers\ConvertDate::toJalali($date[0]);
                                                            ?>
                                                           <td style="height: 50px;">{{ $date[1] }} {{ $jdate }} </td>
                                                            
                                                        </tr>
                                                        @endforeach

                                                    
                                                    </tbody>
                                                </table>
                                                <!--begin: Datatable -->
                                                <!--end: Datatable -->
                                            </div>
                                        </div>
@stop