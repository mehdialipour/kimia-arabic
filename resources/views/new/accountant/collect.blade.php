@extends('new.layout')
@section('title')
تجمیع موجودی صندوق جاری به صندوق اصلی
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
                            <div class="kt-portlet__head kt-portlet__head--lg">
                                <div class="kt-portlet__head-label">
                                    <span class="kt-portlet__head-icon">
                                        <i class="kt-font-brand flaticon2-plus-1"></i>
                                    </span>
                                    <h3 class="kt-portlet__head-title">
                                        تجمیع موجودی صندوق جاری به صندوق اصلی
                                    </h3>
                                </div>

                            </div>
                                {!! Form::open(['action' => ['AccountantController@collect'], 'class' => 'kt-form kt-form--label-right','files' => true,'id' => 'myForm']) !!}
                            
                                <div class="kt-portlet__body">
                                    <div class="form-group row">
                                        
                                        <div class="col-lg-4">
                                            <label>موجودی جاری صندوق</label>
                                            <p><h3>{{ \App\Helpers\ConvertNumber::convertToPersian(number_format($sum)) }} دینار</h3></p>
                                        </div>
                                        


                                        
                                    </div>

                                    <div class="form-group row">
                                        
                                        <table class="table table-bordered">
                                            <thead>
                                                <th>
                                                    ردیف
                                                </th>
                                                <th>
                                                    موجودی
                                                </th>
                                                <th>
                                                    تحویل دهنده
                                                </th>
                                                <th>
                                                    تحویل گیرنده
                                                </th>
                                                <th>
                                                    وضعیت
                                                </th>
                                            </thead>
                                            <tbody>
                                                <?php $i=1; ?>
                                                @foreach($query as $row)
                                                <tr align="center">
                                                    <td>{{ \App\Helpers\ConvertNumber::convertToPersian($i++) }}</td>
                                                    <td>
                                                        {{ \App\Helpers\ConvertNumber::convertToPersian(number_format($row->amount)) }}
                                                    </td>
                                                    <td>
                                                        {{ \App\Models\User::find($row->user_id)->name }}
                                                    </td>
                                                    <td>
                                                        {{ \App\Models\User::find($row->delivered_to)->name }}
                                                    </td>
                                                    <td>
                                                        @if($row->rejected == 1) <span class="text-danger">رد شده - {{ $row->reject_reason }}</span>
                                                        @else               <span class="text-success">تایید شده</span>
                                                        @endif

                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>    


                                        
                                    </div>
                                    

                                                                        
                                </div>  
                                <div class="kt-portlet__foot">

                                        <div class="kt-form__actions">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                            <button type="submit" class="btn btn-primary">تایید صندوق</button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                </div>
                            </form>



                        </div>
@stop