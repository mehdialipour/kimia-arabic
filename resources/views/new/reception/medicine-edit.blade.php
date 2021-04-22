@extends('new.layout')
@section('title')

@stop

@section('content')


  
    <form action="{{ url('receptions/medicines/update'.'/'.$medicine_id) }}" method="post">
  {!! csrf_field() !!}
    
<div class="col-md-12" id="patient_medicines">
    @csrf
    <input name="reception_id" type="hidden" value="{{ $id }}">
          <div class="row" id="">
            <div class="col-md-4">
              <select class="form-control m-input selectbox" id="medicines" style="font-family: Vazir" required="required" placeholder="">
                <option selected="" disabled="" value="0">جستجو کنید</option>
                @foreach($query as $row)
                 <option value="{{ $row->name_fa }}">{{ $row->name_fa }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <input type="text" placeholder="دوز مصرفی" id="dose" name="daily_dose" class="form-control m-input">
            </div>

            <div class="col-md-3">
              <input type="text" placeholder="سایر توضیحات" id="desc" name="desc" class="form-control m-input">
            </div>

            <div class="col-md-1">
              <button type="button" id="plus" class="btn btn-primary"><i class="fa fa-plus"></i></button>
            </div>


          </div>
          <br>
          <div class="row" id="">
            <div class="col-md-4">
              <input type="text" placeholder="داروی جدید (در صورت نبودن در لیست فوق)" id="new_med" name="new_med" class="form-control m-input">
            </div>
            <div class="col-md-4">
              <input type="text" placeholder="دوز مصرفی" id="new_dose" name="new_daily_dose" class="form-control m-input">
            </div>

            <div class="col-md-3">
              <input type="text" placeholder="سایر توضیحات" id="new_desc" name="new_desc" class="form-control m-input">
            </div>

            <div class="col-md-1">
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
          <?php $content = str_replace("\r", "<br>", $content) ;?>
          <textarea id="result_span" name="diagnosis" style="width: 900px; height: 300px;font-size: 20px; font-family: Vazir; direction: ltr;">{!! $content !!}</textarea>
          <div>
          
      <input class="btn btn-info" type="submit" value="به روزرسانی نسخه" />
    </div>
    </div>
    

</form>
</div>
    </div>
  </div>
@stop
@section('scripts')
    <script src="{{ url('new/assets/js/demo1/pages/crud/forms/widgets/bootstrap-markdown.js') }}" type="text/javascript"></script>
    <script>
    
$(document).on('click','#plus', function() {  
    text = CKEDITOR.instances['result_span'].getData(); 
    text_1 = $(".selectbox").val()+" ";
    text_2 = $("#dose").val()+" ";
    desc = $("#desc").val();


    final = text_1 + text_2 + desc;
CKEDITOR.instances.result_span.setData(text + final);

document.getElementById("dose").value = '';
document.getElementById("desc").value = '';
$('.selectbox').val('0').change();
    
});

$(document).on('click','#new_plus', function() { 
    text = CKEDITOR.instances['result_span'].getData(); 
    text_1 = $("#new_med").val()+" ";
    text_2 = $("#new_dose").val()+" ";
    desc = $("#new_desc").val();


    final = text_1 + text_2 + desc;
CKEDITOR.instances.result_span.setData(text + final);

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

    <script>
    window.onload = function() {
        CKEDITOR.replace( 'result_span' );
        CKEDITOR.config.autoParagraph = false;
    };
  </script>
@stop