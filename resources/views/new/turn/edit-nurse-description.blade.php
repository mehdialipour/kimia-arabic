@extends('new.layout')
@section('title')
    ویرایش ملاحظات
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
                            <div class="kt-portlet__head kt-portlet__head--lg">
                                <div class="kt-portlet__head-label">
                                    <span class="kt-portlet__head-icon">
                                        <i class="kt-font-brand flaticon2-plus-1"></i>
                                    </span>
                                    <h3 class="kt-portlet__head-title">
                                        ویرایش ملاحظات
                                    </h3>
                                </div>

                            </div>

                           
                               <form action="" method="get">
                           
                                <div class="kt-portlet__body">
                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label>مطلاحظات:</label>
                                            {!! Form::textarea('description', $model->description, ['class' => 'form-control m-input description','id' => 'description','required' => true]) !!}
                                        </div>
                                        <input type="hidden" value="{{ $model->id }}" name="id">
                                        
                                    </div>
                                </div>
                                <div class="kt-portlet__foot">

                                        <div class="kt-form__actions">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                            <button type="submit" class="btn btn-primary" id="submit">@if(isset($model))به روزرسانی ملاحظات @else ثبت پرونده @endif</button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                </div>
                            </form>



                        </div>
@stop
@section('scripts')
<script>
window.onload = function() {
    CKEDITOR.replace('description');
};
</script>
@stop