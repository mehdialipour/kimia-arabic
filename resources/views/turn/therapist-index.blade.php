@extends('layout')
@section('title')
نرم افزار مدیریت مطب کیمیا
@stop

@section('content')
<div class="row">
	<div class="col-xl-4">

		<!--begin:: Widgets/Blog-->
		<div class="m-portlet m-portlet--head-overlay m-portlet--full-height  m-portlet--rounded-force">
			<div class="m-portlet__head m-portlet__head--fit-">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text m--font-light">
							تعداد پرونده ها
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div class="m-widget27 m-portlet-fit--sides">
					<div class="m-widget27__pic">
						<img src="assets/app/media/img//bg/bg-4.jpg" alt="">
						<h3 class="m-widget27__title m--font-light">
							<span>{{ $patients }}</span>
						</h3>
					</div>
				</div>
			</div>
		</div>

		<!--end:: Widgets/Blog-->
	</div>
	<div class="col-xl-4">

		<!--begin:: Widgets/Blog-->
		<div class="m-portlet m-portlet--head-overlay m-portlet--full-height  m-portlet--rounded-force">
			<div class="m-portlet__head m-portlet__head--fit-">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text m--font-light">
							تعداد مراجعین امروز
						</h3>
					</div>
				</div>
			</div>
			<div class="m-portlet__body">
				<div class="m-widget27 m-portlet-fit--sides">
					<div class="m-widget27__pic">
						<img src="assets/app/media/img/bg/bg-7.jpg" alt="">
						<h3 class="m-widget27__title m--font-light">
							<span>{{ $turns }}</span>
						</h3>
					</div>
				</div>
			</div>
		</div>

		<!--end:: Widgets/Blog-->
	</div>
	
</div>
@stop