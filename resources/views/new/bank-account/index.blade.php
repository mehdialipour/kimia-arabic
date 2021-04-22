@extends('new.layout')
@section('title')
حساب‌های بانکی
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__head kt-portlet__head--lg">
                                                <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon">
                                                        <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                                    </span>
                                                    <h3 class="kt-portlet__head-title">
                                                        حساب‌های بانکی
                                                    </h3>
                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="kt-portlet__head-wrapper">
                                                        <div class="kt-portlet__head-actions">
                                                            
                                                            &nbsp;
                                                            <a href="{{ url('bank-accounts/create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                                                <i class="flaticon2-add-1"></i>
                                                                حساب جدید
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-portlet__body">
                                                
                                                <!--begin: Datatable -->
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover table-checkable" id="patients-table">
                                                        <thead>
                                                            <tr align="center">
                                                                <th>ردیف</th>
                                                                <th>عنوان حساب</th>
                                                                <th>نام بانک</th>
                                                                <th>نام شعبه</th>
                                                                <th>کد شعبه</th>
                                                                <th>شماره حساب</th>
                                                                <th>شماره شبا</th>
                                                                <th>شماره کارت</th>
                                                                <th>صاحب حساب</th>
                                                                <th>نوع حساب</th>
                                                                <th>موجودی</th>
                                                                <th>عملیات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i=1; ?>
                                                            @foreach($query as $row)
                                                            <tr align="center">
                                                                <td>{{ $i++ }}</td>
                                                                <td>{{ $row->title }}</td>
                                                                <td>{{ $row->bank_name }}</td>
                                                                <td>{{ $row->branch_name }}</td>
                                                                <td>{{ $row->branch_code }}</td>
                                                                <td>{{ $row->account_number }}</td>
                                                                <td>{{ $row->sheba_number }}</td>
                                                                <td>{{ $row->card_number }}</td>
                                                                <td>{{ $row->owner_name }}</td>
                                                                <td>{{ $row->account_type }}</td>
                                                                <td>{{ $row->balance }}</td>
                                                                <td>

                                                                {!! Form::open(['method'  => 'DELETE', 'route' => ['bank-accounts.destroy', $row->id]]) !!}
                                                                
                                                                <a class="btn btn-success" href="{{ url('bank-accounts') }}/{{ $row->id }}/edit">ویرایش <i class="flaticon2-pen"></i></a>
                                                                 
                                                            </td>
                                                            </tr>
                                                            {!! Form::close() !!}
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                        </div>
@stop