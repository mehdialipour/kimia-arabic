@extends('new.layout')
@section('title')
الملفات
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__head kt-portlet__head--lg">
                                                <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon">
                                                        <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                                    </span>
                                                    <h3 class="kt-portlet__head-title">
                                                        الملفات
                                                    </h3>
                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="kt-portlet__head-wrapper">
                                                        <div class="kt-portlet__head-actions">
                                                            
                                                            &nbsp;
                                                            <a href="{{ url('patients/create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                                                <i class="flaticon2-add-1"></i>
                                                                أضف ملفًا جديدًا
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kt-portlet__body">
                                                <form action="{{ url('patients/search') }}" method="get">
                                                <div class="form-group row align-items-center"> 
                                                    <label class="col-md-2 col-form-label ">البحث عن طريق:</label>
                                                    
                                                            <div class="col-md-2">
                                                                <div class="kt-form__group--inline">
                                                                    
                                                                    <div class="kt-form__control">
                                                                        <input type="text" name="name" class="form-control" placeholder="اسم و الكنية"> 
                                                                    </div>
                                                                </div>
                                                                <div class="d-md-none kt-margin-b-10"></div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="kt-form__group--inline">
                                                                    
                                                                    <div class="kt-form__control">
                                                                        <input type="text" name="national_id" class="form-control" placeholder="الرقم الوطني">   
                                                                    </div>
                                                                </div>
                                                                <div class="d-md-none kt-margin-b-10"></div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                    <div class="kt-form__group--inline">
                                                                        
                                                                        <div class="kt-form__control">
                                                                            <input type="text" name="mobile" class="form-control" placeholder="التليفون المحمول">   
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-md-none kt-margin-b-10"></div>
                                                                </div>
                                                            
                                                            <div class="col-md-2">
                                                                <input type="submit" class=" btn btn-label-brand btn-bold table__search__btn" value="بحث ">
                                                                    
                                                                    <!-- <i class="flaticon2-magnifier-tool"></i> -->
                                                                </a>
                                                            </div>
                                                        
                                                    </div>
                                                </form>
                                                <!--begin: Datatable -->
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover table-checkable" id="patients-table">
                                                        <thead>
                                                            <tr align="center">
                                                                <th>صف</th>
                                                                <th>اسم </th>
                                                                <th>الكنية</th>
                                                                <th>اسم الاب</th>
                                                                <th>الرقم الوطني</th>
                                                                <th>جنس</th>
                                                                <th>نوع التأمين</th>
                                                                <th>التليفون المحمول</th>
                                                                <th>آخر تحديث بواسطة</th>
                                                                <th>العملية</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i=1; ?>
                                                            @foreach($query as $row)
                                                            <tr align="center">
                                                                <td>{{ $i++ }}</td>
                                                                <td>{{ $row->firstname }}</td>
                                                                <td>{{ $row->lastname }}</td>
                                                                <td>{{ $row->father_name }}</td>
                                                                <td>{{ $row->national_id }}</td>
                                                                <td>@if($row->gender == 'male') مذکر @else مونث @endif</td>
                                                                <td>{{ \App\Models\Insurance::find($row->insurance_id)->name }}</td>
                                                                <td>{{ $row->mobile }}</td>
                                                                <td>
                                                                    @if($row->updater_id > 0) 
                                                                        @if(!is_null(\App\Models\User::find($row->updater_id)))
                                                                            {{ \App\Models\User::find($row->updater_id)->name }}
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                                <td>

                                                                {!! Form::open(['method'  => 'DELETE', 'route' => ['patients.destroy', $row->id]]) !!}
                                                                @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 19)->count() == 1)
                                                                <a class="btn btn-success" href="{{ url('patients') }}/{{ $row->id }}/edit">يحرر <i class="flaticon2-pen"></i></a>
                                                                @endif
                                                                <?php 
                                                                    $count = \DB::table('patients')
                                                                                 ->join('receptions','patients.id','=','receptions.patient_id')
                                                                                 ->join('turns','receptions.id','=','turns.reception_id')
                                                                                 ->where('receptions.patient_id', $row->id)
                                                                                 ->count();
                                                                ?>
                                                                @if(\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 20)->count() == 1)
                                                                    @if($count == 0)
                                                                        <button class="btn btn-danger" type="submit">حذف <i class="flaticon2-trash"></i></button>
                                                                    @else
                                                                        <button class="btn btn-dark" type="button">قبلت</button>   
                                                                    @endif
                                                                @endif  
                                                                <a href="{{ url('patients/'.$row->id.'/scan-files') }}" class="btn btn-primary">مسح المستندات ضوئيًا <i class="fa fa-clipboard-check"></i></a> 

                                                                <a href="{{ url('patients/'.$row->id.'/before-after-files') }}" class="btn btn-warning">before / after <i class=""></i></a> 

                                                            </td>
                                                            </tr>
                                                            {!! Form::close() !!}
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <div align="center">{!! $query->render() !!}</div>
                                                <!--end: Datatable -->
                                            </div>
                                        </div>
@stop