
<!DOCTYPE html>
<html prefix="og:">

<head prefix="my_namespace: http://congress.eccim.com/#">

    <!-- Public META -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- /Public META -->

    <!-- Title -->
    <title>پرونده‌ی پزشکی {{ $patient->name }} </title>
    <link rel="shortcut icon" href="" />
    <!-- /Title -->

    <!-- Bootstrap Core Css -->
    <link rel="stylesheet" type="text/css" href="{{ url('new/assets/print/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ url('new/assets/print/normalize.css') }}">
    <link rel="stylesheet" href="{{ url('new/assets/print/skeleton.css') }}">

    <!-- Template Pc Css -->
    <link rel="stylesheet" type="text/css" href="{{ url('new/assets/print/print-detailes.css') }}">

</head>

<body>

    <main class="main-body col-md-12 col-lg-12">
<?php $time = \App\Helpers\ConvertDate::today(date("Y-m-d")).' - '.date("H:i:s"); ?>  
        <div class="up-title">
            <div class="logo-kimia"><span>کیمیا طب</span><img src="{{ url('new/assets/print/logo.png') }}"></div>
            <div class="send-instruct"><span>دستور صدور پرینت توسط : </span><span>{{ \Session::get('name') }}</span></div>
            <div class="date"><span>تاریخ پرینت : </span><span>{{ \App\Helpers\ConvertNumber::convertToPersian($time) }}</span></div>
        </div>

        <div class="box-border col-md-12 col-lg-12">

            <div class="details col-md-12 col-lg-12">

                <div class="inner-det col-md-2 col-lg-2">
                    <span>نام :</span>
                    <span>{{ $patient->firstname }}</span>
                </div>
                <div class="inner-det col-md-2 col-lg-2">
                    <span>نام خانوادگی : </span>
                    <span>{{ $patient->lastname }}</span>
                </div>
                <div class="inner-det col-md-2 col-lg-2">
                    <span>سال تولد : </span>
                    <span>{{ $patient->birth_year }}</span>
                </div>
                <div class="inner-det col-md-2 col-lg-2">
                    <span>اسم الاب : </span>
                    <span>{{ $patient->father_name }}</span>
                </div>
                <div class="inner-det col-md-2 col-lg-2">
                    <span>کد ملی : </span>
                    <span>{{ $patient->national_id }}</span>
                </div>
                <div class="inner-det col-md-2 col-lg-2">
                    <span>جنسیت : </span>
                    <span>@if($patient->gender == 'male') مذکر @else مونث @endif</span>
                </div>
                
                <div class="inner-det col-md-2 col-lg-2">
                    <span>نوع بیمه : </span>
                    <span>{{ \App\Models\Insurance::find($patient->insurance_id)->name }}</span>
                </div>
                <div class="inner-det col-md-2 col-lg-2">
                    <span>شماره بیمه : </span>
                    <span>{{ $patient->insurance_code }}</span>
                </div>
                <div class="inner-det col-md-2 col-lg-2">
                    <span>شماره موبایل : </span>
                    <span>{{ $patient->mobile }}</span>
                </div>
                <div class="inner-det col-md-2 col-lg-2">
                    <span>شماره ثابت : </span>
                    <span>{{ $patient->phone }}</span>
                </div>
                <div class="inner-det col-md-6 col-lg-6">
                    <span>آدرس : </span>
                    <span>{{ $patient->address }}</span>
                </div>
                


            </div>

            <div class="print-page col-md-12 col-lg-12">
                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th scope="col">ردیف</th>
                            <th scope="col">تاریخ ثبت</th>
                            <th scope="col">سبب الارجاع</th>
                            <th scope="col">تشخیص اولیه</th>
                            <th scope="col">پیشنهاد پزشک</th>
                            <th scope="col">تشخیص پزشک</th>
                            <th scope="col">ثبت کننده</th>
                            <th scope="col">نسخه پزشک(داروها)</th>
                            <th scope="col">آزمایشات پزشک</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i=1; ?>
                        @foreach($diagnoses as $row)
                        <?php

$string = $row->diagnosis;

$str_0 = explode("تشخیص اولیه:", $string);
$cause = str_replace("<strong>سبب الارجاع:</strong>", '', $str_0[0]);
$str_1 = explode("پیشنهاد پزشک:", $str_0[1]);
$str_2 = explode("تشخیص پزشک:", $str_1[1]);
$str_3 = explode('آزمایش:', $str_2[1]);

$date = explode(" ", $row->created_at);
$jdate = \App\Helpers\ConvertDate::toJalali($date[0]);

?>  
                        <tr>
                            <td>{{ \App\Helpers\ConvertNumber::convertToPersian($i++) }}</td>
                            <td>{{ \App\Helpers\ConvertNumber::convertToPersian($jdate) }}</td>
                            <td>{!! $cause !!}</td>
                            <td>{!! $str_1[0] !!}</td>
                            <td>{!! $str_2[0] !!}</td>
                            <td>{!! $str_3[0] !!}</td>
                            <td>{{ $row->editor }}</td>
                            <td>
                                @foreach(\DB::table('file_receptions')->where('service_turn_id', $row->service_turn_id)->get() as $key)
                                    {!! $key->description !!}<br>
                                @endforeach
                            </td>
                            <td>{!! $str_3[1] !!}</td>
                        </tr>
                        @endforeach    
                    </tbody>

                </table>
            </div>

            <div class="sign-doctor">
                <span> تقدیم احترام </span><span>{{ \App\Models\Setting::first()->manager }}</span>
            </div>

        </div>

    </main>

    <script src="{{ url('new/assets/print/jquery-3.5.1.min.js') }}"></script>

    <script type="text/javascript" src="{{ url('new/assets/print/printThis.js') }}"></script>

  
    <!--
    <script>
        $(document).ready(function() {

            $('body').click(function() {
                var pageTitle = '...',
                    stylesheet = '//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css',
                    win = window.open('', 'Print', 'width=2480,height=3508');
                win.document.write('<html><head><title>' + pageTitle + '</title>' +
                    '<link rel="stylesheet" href="' + stylesheet + '">' + '<link rel="stylesheet" href="print.css">' +
                    '</head><body>' + $('.main-body')[0].outerHTML + '</body></html>');
                win.document.close();
                win.print();
                return false;
            });

        });

    </script>
-->

</body>

</html>
