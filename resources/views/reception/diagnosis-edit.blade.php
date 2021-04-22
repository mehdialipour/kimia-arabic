@extends('layout')
@section('title')
@php $name = \App\Models\Patient::find(\App\Models\Reception::find($id)->patient_id)->name; @endphp

پرونده {{ $name }}
@stop

@section('content')


	<div class="m-content" align="" style="width: 100%; background-color: white;">
		<h5 align="center">ثبت مشاهدات برای پرونده‌ی {{ $name }}</h5>
	<hr>
	<br>
		<form action="{{ url('receptions/diagnosis/update'.'/'.$diagnosis_id) }}" method="post">
	{!! csrf_field() !!}
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8" align="center">	
				<div class="form-group m-form__group">
					<h4>سبب الارجاع</h4>
					<textarea required="" id="diagnosis" name="cause" class="form-control m-input" style="">{!! @$cause !!}</textarea>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8" align="center">	
				<div class="form-group m-form__group">
					<h4>تشخیص اولیه</h4>
					<textarea required="" id="detection" name="detection" class="form-control m-input" style="">{!! @$detection !!}</textarea>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-2">	
				<div class="form-group m-form__group">
					<input type="text" name="sistol" class="form-control m-input" placeholder="سیستول" value="{{ @$sistol }}">
				</div>
			</div>
			<div class="col-md-2">	
				<div class="form-group m-form__group">
					<input type="text" name="diastol" class="form-control m-input" placeholder="دیاستول" value="{{ @$diastol }}">
				</div>
			</div>
			<div class="col-md-4"></div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8" align="center">	
				<div class="form-group m-form__group">
					<h4>پیشنهاد پزشک</h4>
					<textarea required="" id="suggestion" name="suggestion" class="form-control m-input" style="">{!! @$suggestion !!}</textarea>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
		
		
	<input type="hidden" name="reception_id" value="{{ $id }}">
<br><br>
<h4 align="center">تشخیص پزشک</h4>
<br>
<div align="center" id="speech">
  <h5> <a href="#speech" class="btn btn-info" id="start_button" onclick="startDictation(event)"><i class="fa fa-microphone"></i></a> 
  	<input type="radio" name="lang" value="en-US" id="en">انگلیسی
  	<input type="radio" name="lang" value="fa-IR" id="fa">فارسی

  	<input type="hidden" name="language" id="lang">
  	
  	   
  			<br>
	        <span style="" id="interim_span" class="interim"></span>
  </h5>
	        <textarea required="" id="final_span" name="perception" class="form-control m-input">{!! @$perception !!}</textarea>
	        <div>
	        <br>
			<hr>
	        
			<input class="btn btn-info" type="submit" value="به روز رسانی مشاهدات" />
		</div>
		</div>
		

</form>
</div>
		</div>
	</div>
@stop
@section('scripts')

<script>
	
$(document).on('click','#plus', function() {  
	text = $("#result_span").val()+"\r"; 
    text_1 = $(".selectbox").val()+" ";
    text_2 = $("#dose").val()+" ";
    desc = $("#desc").val();


    final = text_1 + text_2 + desc;
$("#result_span").val(text + final);

document.getElementById("dose").value = '';
document.getElementById("desc").value = '';
$('.selectbox').val('0').change();
    
});

$(document).on('click','#new_plus', function() { 
	text = $("#result_span").val()+"\r"; 
    text_1 = $("#new_med").val()+" ";
    text_2 = $("#new_dose").val()+" ";
    desc = $("#new_desc").val();


    final = text_1 + text_2 + desc;
$("#result_span").val(text + final);

$.ajax({
    url: "{!! url('medicines/add') !!}",
    type: "post",
    data: {
        medicine: $('#new_med').val(),
    },
    success: function (data) {
        console.log(data);
    }
});

document.getElementById("new_dose").value = '';
document.getElementById("new_desc").value = '';
document.getElementById("new_med").value = '';


    
});


</script>

<script type="text/javascript">
var final_transcript = '';
var recognizing = false;

if ('webkitSpeechRecognition' in window) {

  var recognition = new webkitSpeechRecognition();

  recognition.continuous = true;
  recognition.interimResults = true;

  recognition.onstart = function() {
    recognizing = true;
  };

  recognition.onerror = function(event) {
    console.log(event.error);
  };

  recognition.onend = function() {
    recognizing = false;
  };

  recognition.onresult = function(event) {
    var interim_transcript = '';
    for (var i = event.resultIndex; i < event.results.length; ++i) {
      if (event.results[i].isFinal) {
        final_transcript += event.results[i][0].transcript;
      } else {
        interim_transcript += event.results[i][0].transcript;
      }
    }
    final_transcript = capitalize(final_transcript);
    final_span.innerHTML = linebreak(final_transcript);
    interim_span.innerHTML = linebreak(interim_transcript);
    
  };
}

var two_line = /\n\n/g;
var one_line = /\n/g;
function linebreak(s) {
  return s.replace(two_line, '<p></p>').replace(one_line, '<br>');
}

function capitalize(s) {
  return s.replace(s.substr(0,1), function(m) { return m.toUpperCase(); });
}

function startDictation(event) {
  if (recognizing) {
    recognition.stop();
    return;
  }
  recognition.lang = document.getElementById("lang").value;
  recognition.start();
}

$(document).on('click','#en', function() {
	document.getElementById("lang").value = "en-US";
	if(recognizing) {
		recognition.stop();
		recognition.start();
	}
});

$(document).on('click','#fa', function() {
	document.getElementById("lang").value = "fa-IR";
	if(recognizing) {
		recognition.stop();
		recognition.start();
	}
});
</script>

<script>
    window.onload = function() {
        CKEDITOR.replace( 'final_span' );
        CKEDITOR.replace( 'diagnosis' );
        CKEDITOR.replace( 'detection' );
        CKEDITOR.replace( 'suggestion' );
    };
</script>
@stop	