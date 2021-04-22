@extends('new.layout')
@section('title')
تقييمات الدور
@stop
@section('content')
<div class="kt-portlet kt-portlet--mobile">
                                            <div class="kt-portlet__head kt-portlet__head--lg">
                                                <div class="kt-portlet__head-label">
                                                    <span class="kt-portlet__head-icon">
                                                        <i class="kt-font-brand flaticon2-files-and-folders"></i>
                                                    </span>
                                                    <h3 class="kt-portlet__head-title">
                                                        تقييمات الدور
                                                    </h3>
                                                </div>
                                                <div class="kt-portlet__head-toolbar">
                                                    <div class="kt-portlet__head-wrapper">
                                                        <div class="kt-portlet__head-actions">
                                                            
                                                            &nbsp;
                                                            <a href="{{ url('turns/create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                                                <i class="flaticon2-add-1"></i>
                                                                خلق منعطفات جديدة
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{ url('turns?page=1') }}" method="get">
                                                <div class="form-group row align-items-center"> 
                                                            <div class="col-md-2">
                                                            </div>
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
                                             <div class="kt-portlet__body table-responsive">
                                                
                                                <!--begin: Datatable -->
                                                <table class="table table-bordered" id="turns-table" width="99%">
				<thead>
					<tr align="center">
						<th>
							صف
						</th>
						<th>
							اسم المریض
						</th>
						<th>
							الصورة
						</th>
						<th style="">
							مقدم الخدمة
						</th>
						<th>
							نوع الخدمة
						</th>
						<th>
							شرط
						</th>

						<th>
							كلفة
						</th>

                        <th>
                            الفواتير
                        </th>

						<th style="width: 33%;">
							العملية
						</th>
					</tr>
				</thead>
				<tbody id="status">
					
				
				</tbody>
			</table>
            <input type="hidden" id="page_number" @if(request('page')) value="{{ request('page') }}" @else value="1" @endif name="">

            <input type="hidden" id="search_name" @if(request('name')) value="{{ request('name') }}" @else value=" " @endif name="">
            <?php 
                  
                    $now = \Carbon\Carbon::now();
                    $now_ex = explode(" ", $now);
                    $today = $now_ex[0];
                    $paginate = \App\Models\Turn::with('reception.patients')
                                ->where('turn_time', 'like', "%$today%")
                                ->orderBy('id', 'desc')
                                ->paginate(10);
                                ?>
                    {!! $paginate->render(); !!}            
            

            
                                                <!--end: Datatable -->
                                            </div>
                                        </div>
@stop
@section('scripts')
<script>
        window.setInterval(function(){
            getStatus();
        }, 6000);
        function getStatus(){
            $.ajax({
                url: "{!! url('status') !!}",
                type: "post",
                data: {
                    page: $("#page_number").val(),
                    name: $("#search_name").val()
                },
                success: function (data) {
                    $("#status").html(data);
                }
            });
        }
        $(document).ready(function() {
            getStatus();
        });
    </script>
@stop