@extends('new.layout')
@section('title')
@stop

@section('content')

					
						
<div align="center" style="background-color: white;">
	<div class="form-group row" align="center">
		<h3 align="center" class="text-primary" style="text-align: center;">{!! $error !!}</h3>
	</div>	
	<hr>	
	<button type="button" class="btn btn-warning" onclick="window.close();">بستن x</button>
	
</div>

@stop	