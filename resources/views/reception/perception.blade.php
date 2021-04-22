@extends('layout')
@section('title')
@php $name = \App\Models\Patient::find(\App\Models\Reception::find($id)->patient_id)->name; @endphp
پرونده {{ $name }}
@stop

@section('content')
	<div class="m-content" style="width: 100%; background-color: white;">
		<h5 align="center"> پرونده‌ی {{ $name }}</h5>
		<hr>
		<div class="col-md-12">
			
	

		<form method="post" action="{{ url('receptions/upload') }}">
		@csrf
		<input name="reception_id" type="hidden" value="{{ $id }}">
	        <div class="row" id="">
	        	<div class="col-md-4">
        			<select class="form-control m-input selectbox" id="medicines" style="font-family: Vazir" required="required" placeholder="">
        				<option selected="" disabled="" value="0">جستجو کنید</option>
        				@foreach($query as $row)
        				 <option value="{{ $row->name }}">{{ $row->name }}</option>
        				@endforeach
        			</select>
		        </div>
		        <div class="col-md-3">
        			<input type="text" placeholder="دوز مصرفی" id="dose" name="daily_dose" class="form-control m-input">
        		</div>

        		<div class="col-md-3">
        			<input type="text" placeholder="سایر توضیحات" id="desc" name="desc" class="form-control m-input">
        		</div>

        		<div class="col-md-2">
        			<button type="button" id="plus" class="btn btn-primary"><i class="fa fa-plus"></i></button>
        		</div>


        	</div>
        	<br>
        	<div class="row" id="">
	        	<div class="col-md-4">
        			<input type="text" placeholder="داروی جدید (در صورت نبودن در لیست فوق)" id="new_med" name="new_med" class="form-control m-input">
		        </div>
		        <div class="col-md-3">
        			<input type="text" placeholder="دوز مصرفی" id="new_dose" name="new_daily_dose" class="form-control m-input">
        		</div>

        		<div class="col-md-3">
        			<input type="text" placeholder="سایر توضیحات" id="new_desc" name="new_desc" class="form-control m-input">
        		</div>

        		<div class="col-md-2">
        			<button type="button" id="new_plus" class="btn btn-primary"><i class="fa fa-plus"></i></button>
        		</div>


        	</div>
	    </div>
	        <hr>
	        <div align="center" id="speech">
  <h5> <a href="#speech" class="btn btn-info" id="start_button" onclick="startDictation(event)"><i class="fa fa-microphone"></i></a> 
  	<input type="radio" name="lang" value="en-US" id="en">انگلیسی
  	<input type="radio" name="lang" value="fa-IR" id="fa">فارسی

  	<input type="hidden" name="language" id="lang">

  			<br>
	        <span style="" id="interim_span" class="interim"></span>
  </h5>
	        <textarea id="result_span" name="final" style="width: 900px; height: 300px;font-size: 20px; font-family: Vazir; direction: ltr;"></textarea>
	        <div>
	        
			<input class="btn btn-info" type="submit" value="ثبت نسخه" />
		</div>
		</div>
		

</form>
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

	<script src="{{ url('assets/vendors/base/canvas.js') }}" type="text/javascript"></script>


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
    result_span.innerHTML = linebreak(final_transcript);
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
@stop	