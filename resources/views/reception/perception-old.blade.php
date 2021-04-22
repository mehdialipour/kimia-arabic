@extends('layout')
@section('title')
@php $name = \App\Models\Patient::find(\App\Models\Reception::find($id)->patient_id)->name; @endphp
پرونده {{ $name }}
@stop

@section('content')
	<div class="m-content" style="width: 100%; background-color: white;">
		<h5 align="center"> ثبت نسخه برای پرونده‌ی {{ $name }}</h5>
		<hr>
		<div class="col-md-12">
			<div align="center">
				<form style="direction:rtl;">
					<input id="pencil" type="radio" name="tool" value="pencil" checked>
					<label for="pencil">نوشتن</label>
					<input id="eraser" type="radio" name="tool" value="eraser">
					<label for="eraser">پاک کردن</label>
				</form>
			</div>
		<style type="text/css">
			#s1 {
				background: url({{ url('assets/'.'note.png') }}) ;
				cursor: url({{ url('assets/'.'dott.png') }}), auto;
				border: 1px solid gray;
				position: relative;
			}
			#tmp_canvas {
				position: absolute;
				left: 0px; right: 0;
				bottom: 0; top: 0;
				cursor: {{ url('assets/'.'dott.png') }}, auto;
			}
		</style>
		<div id="s1">
			<canvas id='c1' width='802px' height='700'></canvas>
		</div>
		
	

		<form method="post" accept-charset="utf-8" name="form1">
		{!! csrf_field() !!}
		<input name="admission_id" type="hidden" value="{{ $id }}">
		 <input name="hidden_data" id='hidden_data' type="hidden"/>
		

		<script>
	            function uploadEx() {
	                var canvas = document.getElementById("c1");
	                var dataURL = canvas.toDataURL("image/png");
	                document.getElementById("hidden_data").value = dataURL;
	                var fd = new FormData(document.forms["form1"]);
	                var xhr = new XMLHttpRequest();
	                xhr.open('POST', '<?php echo url("receptions/upload");?>', true);

	 
	                xhr.upload.onprogress = function(e) {
	                    if (e.lengthComputable) {
	                        var percentComplete = (e.loaded / e.total) * 100;
	                        console.log(percentComplete + '% uploaded');

	                        window.location = "{{ url('receptions/'.$id) }}";
	                        


	                    }
	                };
	                xhr.send(fd);
	                console.log(document.getElementById("hidden_data").value);


	            };
	        </script>
	        <hr>
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
	        <textarea id="final_span" name="final" style="width: 900px; height: 300px;font-size: 20px; font-family: Vazir; direction: ltr;"></textarea>
	        <div>
	        
			<input class="btn btn-info" type="button" onclick="uploadEx();" value="ثبت نسخه" />
		</div>
		</div>
		

</form>
		</div>
	</div>
@stop
@section('scripts')

<script>
	
$(document).on('click','#plus', function() {  
	text = $("#final_span").val()+"\r"; 
    text_1 = $(".selectbox").val()+" ";
    text_2 = $("#dose").val()+" ";
    desc = $("#desc").val();


    final = text_1 + text_2 + desc;
$("#final_span").val(text + final);

document.getElementById("dose").value = '';
document.getElementById("desc").value = '';
$('.selectbox').val('0').change();
    
});

$(document).on('click','#new_plus', function() { 
	text = $("#final_span").val()+"\r"; 
    text_1 = $("#new_med").val()+" ";
    text_2 = $("#new_dose").val()+" ";
    desc = $("#new_desc").val();


    final = text_1 + text_2 + desc;
$("#final_span").val(text + final);

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
@stop	