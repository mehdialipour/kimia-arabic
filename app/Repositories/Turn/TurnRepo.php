<?php

namespace App\Repositories\Turn;

use App\Helpers\ConvertDate as Date;
use App\Helpers\ConvertNumber as Number;
use App\Models\ActivityLog;
use App\Models\DrugStorage;
use App\Models\FileReception;
use App\Models\Insurance;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Reception;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Turn;
use App\Models\User;
use App\Services\Sms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use \Morilog\Jalali\Jalalian;

/**
*
*/
class TurnRepo implements TurnInterface
{
    public function services()
    {
        $services = Service::where('status', 'فعال')->where('name', 'like', "ویزیت%")->orderBy('name', 'asc')->get();

        $services_2 = Service::where('status', 'فعال')->where('name', 'like', "تدابیر مزاج%")->orderBy('name', 'asc')->get();

        $services_3 = Service::where('status', 'فعال')->where('name', 'not like', "تدابیر مزاج%")->where('name', 'not like', "ویزیت%")->orderBy('name', 'asc')->get();

        $services = $services->merge($services_2);

        return $services->merge($services_3);
    }
    public function today()
    {
        $date = Jalalian::now();
        $date = explode(" ", $date);

        return $date[0];
    }
    public function todayTurns($skip, $name = null)
    {
        $now = Carbon::now();
        $now_ex = explode(" ", $now);
        $today = $now_ex[0];

        $query = Turn::whereHas('reception', function ($q) use ($name) {
            $q->whereHas('patients', function ($p) use ($name) {
                $p->where('name', 'like', "%$name%");
            });
        })
            ->where('turn_time', 'like', "%$today%")
            ->orderBy('id', 'desc')
            ->skip($skip)
            ->take(10)
            ->get();
        foreach ($query as $row) {
            if (DB::table('service_turn')->where('turn_id', $row->id)->count() == 0) {
                Turn::where('id', $row->id)->delete();
            }
        }
        return $query;
    }

    public function showFutureTurns($skip, $name = null, $date, $filtered)
    {
        $query = Turn::whereHas('reception', function ($q) use ($name) {
            $q->whereHas('patients', function ($p) use ($name) {
                $p->where('name', 'like', "%$name%");
            });
        })
            ->whereIn('id', $filtered)
            ->where('turn_time', 'like', "%$date%")
            ->orderBy('turn_time', 'asc')
            ->skip($skip)
            ->take(10)
            ->get();
        foreach ($query as $row) {
            if (DB::table('service_turn')->where('turn_id', $row->id)->count() == 0) {
                Turn::where('id', $row->id)->delete();
            }
        }
        return $query;
    }



    public function patientsArray()
    {
        $patients = [];
        $query = Patient::orderBy('id', 'desc')->get();

        foreach ($query as $row) {
            $patients[$row->id] = $row->name." - اسم الاب:"." ".$row->father_name;
        }

        return $patients;
    }

    public function create($reception_id, $date, $time, $files, $services, $drugs, $discount, $paid, $doctor_id, $user_id, $all)
    {
        $g_date = Date::toGeorgian($date);
        $turn_time = $g_date[0]."-".$g_date[1]."-".$g_date[2]." ".$time;

        $query = Turn::create([
            'reception_id' => $reception_id,
            'number' => 1,
            'status' => 'فی انتظار',
            'turn_time' => $turn_time,
            'doctor_id' => $doctor_id,
            'user_id' => $user_id,
            'answers' => $all
        ]);

        $patient_mobile = Patient::find(Reception::find($reception_id)->patient_id)->mobile;

        $this->uploadFiles($reception_id, $files);
        $this->insertServices($query->id, $services);
        if (!is_null($drugs)) {
            $this->insertDrugs($query->id, $drugs);
        }

        
        $this->calculateInvoice($query->id, $services, $discount, $turn_time, $paid, 0, 0);
        

        if ($turn_time > Carbon::today()->addDays(1)) {
            $date = explode("-", $date);
            $date = $date[0]."/".$date[1]."/".$date[2];
            $name = Setting::first()->name;
            $name = str_replace(" ", "_", $name);
            \App\Services\Sms::futureTurn($patient_mobile, Number::convertToPersian($date), Number::convertToPersian($time), $name, "clinic");
        }

        return $query->id;
    }

    public function uploadFiles($id, $files)
    {
        if (!empty($files)) {
            foreach ($files as $file) {
                if ($file != "" || $file != null) {
                    $imageName = str_random(10).time() .'.' . $file->getClientOriginalExtension();

                    $file->move('uploads', $imageName);

                    $file = $imageName;

                    FileReception::create([
                        'reception_id' => $id,
                        'file_url' => $file
                    ]);
                }
            }
        }
    }

    public function insertServices($turn_id, $services)
    {
        $request = request()->all();
        $turn = Turn::find($turn_id);
        $i=0;

        $reception_id = $turn->reception_id;
        $patient_id = Reception::find($reception_id)->patient_id;

        $insurance_id = Patient::find($patient_id)->insurance_id;

        if (!is_null($services)) {
            foreach ($services as $key => $value) {
                if ($request['user_id'][$i] == 0) {
                    return;
                } else {
                    $user_id = $request['user_id'][$i];
                }
                if ($request['count'][$i] > 0) {
                    $tariff = DB::table('insurance_service')->where('insurance_id', $insurance_id)->where('service_id', $value)->first()->tariff;
                    \DB::table('service_turn')->insert([
                    'turn_id' => $turn_id,
                    'service_id' => $value,
                    'count' => $request['count'][$i],
                    'user_id' => $user_id,
                    'paid' => $request['money_received'],
                    'net_price' => $tariff
                ]);
                }

                $i++;
            }
        }
    }

    public function insertDrugs($turn_id, $drugs)
    {
        $request = request()->all();
        $turn = Turn::find($turn_id);
        $i=0;

        
        foreach ($drugs as $key => $value) {
            if ($request['count'][$i] > 0) {
                \DB::table('drug_turn')->insert([
                    'turn_id' => $turn_id,
                    'drug_id' => $value,
                    'count' => $request['count_drugs'][$i]
                ]);
            }

            $drug = DrugStorage::find($value);

            DrugStorage::where('id', $value)->update([
                'amount' => $drug->amount - $request['count_drugs'][$i]
            ]);

            $i++;
        }
    }

    public function calculateInvoice($turn_id, $services, $discount, $turn_time, $paid, $therapist, $old_invoice)
    {
        $request = request()->all();
        $insurance_id = Turn::with('reception.patients')
                            ->find($turn_id)
                            ->reception
                            ->patients[0]
                            ->insurance_id;

        $sum = 0;
        $i=0;
        if (!is_null($services)) {
            foreach ($services as $key => $value) {
                $tariff = DB::table('insurance_service')
                        ->where('service_id', $value)
                        ->where('insurance_id', $insurance_id)
                        ->first()
                        ->tariff;

                $sum = ($request['count'][$i]*$tariff) + $sum;
                $i++;
            }
        }

        $this->insertInvoice($turn_id, $sum, $discount, $paid, $turn_time, $therapist, $old_invoice);
    }

    public function insertInvoice($turn_id, $amount, $discount, $paid, $created_at, $therapist, $old_invoice)
    {
        // dd($amount+$old_invoice);
        if ($discount == '') {
            $discount = 0;
        }
        Invoice::create([
            'turn_id' => $turn_id,
            'amount' => $amount+$old_invoice,
            'discount' => Number::convert($discount),
            'paid' => $paid,
            'created_at' => $created_at,
            'therapist' => $therapist
        ]);

        return true;
    }

    public function toggle($turn_id)
    {
        $query = Turn::find($turn_id);
        if ($query->status == "فی انتظار") {
            $query->fill(['status' => 'داخل مطب']);
        } else {
            $query->fill(['status' => 'فی انتظار']);
        }

        $query->save();
    }

    public function patientName($turn_id)
    {
        $name = Turn::with('reception.patients')
                    ->find($turn_id)
                    ->reception
                    ->patients[0]
                    ->name;

        return $name;
    }

    public function patientId($turn_id)
    {
        $id = Turn::with('reception.patients')
                    ->find($turn_id)
                    ->reception
                    ->patients[0]
                    ->id;

        return $id;
    }

    public function activeServices($turn_id)
    {
        $query = DB::table('service_turn')->where('turn_id', $turn_id)->get();
        $services = [];

        foreach ($query as $row) {
            array_push($services, $row->service_id);
        }

        return $services;
    }

    public function edit($turn_id)
    {
        $model = Turn::find($turn_id);
        $explode_turn_time = explode(" ", $model->turn_time);

        $explode_hour_and_minute = explode(":", $explode_turn_time[1]);

        $hour = $explode_hour_and_minute[0];
        $minute = $explode_hour_and_minute[1];

        return $model;
    }

    public function fetchHour($turn_id)
    {
        $model = Turn::find($turn_id);

        $explode_turn_time = explode(" ", $model->turn_time);

        $explode_hour_and_minute = explode(":", $explode_turn_time[1]);

        $hour = $explode_hour_and_minute[0];

        return $hour;
    }

    public function fetchMinute($turn_id)
    {
        $model = Turn::find($turn_id);
        $explode_turn_time = explode(" ", $model->turn_time);

        $explode_hour_and_minute = explode(":", $explode_turn_time[1]);

        $minute = $explode_hour_and_minute[1];

        return $minute;
    }

    public function updateTurn($id, $reception_id, $date, $time, $files, $services, $drugs, $discount, $paid, $doctor_id)
    {
        $turn = Turn::find($id);
        $status = $turn->status;

        $invoice = Invoice::where('turn_id', $id);

        if ($invoice->count() > 0) {
            $therapist = $invoice->first()->therapist;
        } else {
            $therapist = 0;
        }

        $old_invoice = Invoice::where('turn_id', $id)->first()->amount;


        $g_date = Date::toGeorgian($date);
        $turn_time = $g_date[0]."-".$g_date[1]."-".$g_date[2]." ".$time;

        if ($doctor_id == 0) {
            $doctor_id = null;
        }
        $query = Turn::create([
            'reception_id' => $reception_id,
            'number' => 1,
            'status' => $status,
            'turn_time' => $turn_time,
            'doctor_id' => $doctor_id
        ]);


        \DB::table('service_turn')->where('turn_id', $id)->update([
            'turn_id' => $query->id
        ]);
        $turn->delete();

        $patient_mobile = Patient::find(Reception::find($reception_id)->patient_id)->mobile;

        $this->uploadFiles($reception_id, $files);
        $this->insertServices($query->id, $services);
        
        if (!is_null($drugs)) {
            $this->insertDrugs($query->id, $drugs);
        }

        
        $this->calculateInvoice($query->id, $services, $discount, $turn_time, $paid, $therapist, $old_invoice);
        

        if ($turn_time > Carbon::today()->addDays(1)) {
            $date = explode("-", $date);
            $date = $date[0]."/".$date[1]."/".$date[2];
            Sms::send($patient_mobile, "عيادة", Number::convertToPersian($date), Number::convertToPersian($time), "turn");
        }
    }

    public function destroy($id)
    {
        $turn_id = DB::table('service_turn')->where('id', $id)->first()->turn_id;
        $reception_id = \App\Models\Turn::find($turn_id)->reception_id;
        $patient_id = \App\Models\Reception::find($reception_id)->patient_id;
        $patient = \App\Models\Patient::find($patient_id);

        $service_id = DB::table('service_turn')->where('id', $id)->first()->service_id;
        $server_id = DB::table('service_turn')->where('id', $id)->first()->user_id;

        $mobile = \App\Models\User::find($server_id)->mobile;

        $service = Service::find($service_id);

        $user = User::where('username', Session::get('username'))->first();
        $content = 'کاربر "'.$user->firstname.'" '.$user->lastname.' نوبت مراجعه کننده "'.$patient->name.'" که برای خدمت "'.$service->name.'" ثبت شده بود را لغو کرد.';

        ActivityLog::create([
            'content' => $content,
            'activity_type_id' => 3,
            'user_id' => $user->id
        ]);

        $turn_time = \App\Models\Turn::find($turn_id)->turn_time;

        $turn_time = explode(" ", $turn_time);

        $date = Date::toJalali($turn_time[0]);

        $time = $turn_time[1];

        DB::table('service_turn')->where('id', $id)->delete();

        if (DB::table('service_turn')->where('turn_id', $turn_id)->count() == 0) {
            \App\Models\Turn::find($turn_id)->delete();
        }

        Sms::canceledTurn($patient, $service, $date, $time, $mobile);
    }

    public function fetchFiles($turn_id)
    {
        $reception_id = Turn::with('reception.patients')
                    ->find($turn_id)
                    ->reception->id;

        $query = FileReception::where('reception_id', $reception_id)->select('file_url', 'id')->get();
        return $query;
    }

    public function fetchDateTime($turn_id)
    {
        $date = Turn::find($turn_id)->turn_time;

        $date = explode(" ", $date);

        $jDate = Date::toJalali($date[0]);

        $time = explode(":", $date[1]);

        return [$jDate, $time[0].":".$time[1]];
    }

    public function fetchDiscount($turn_id)
    {
        if (Invoice::where('turn_id', $turn_id)->count() > 0) {
            return Invoice::where('turn_id', $turn_id)->first()->discount;
        } else {
            return 0 ;
        }
    }

    public function loadRelease()
    {
        $now = Carbon::now();
        $now_ex = explode(" ", $now);
        $today = $now_ex[0];



        $query = DB::table('service_turn')
                    ->leftjoin('turns', 'service_turn.turn_id', '=', 'turns.id')
                    ->leftjoin('receptions', 'turns.reception_id', '=', 'receptions.id')
                    ->leftjoin('patients', 'receptions.patient_id', '=', 'patients.id')
                    ->leftjoin('services', 'service_turn.service_id', '=', 'services.id')
                    ->where('turns.turn_time', 'like', "%$today%")
                    ->where('service_turn.user_id', Session::get('user_id'))
                    ->where('service_turn.status', 'انتهى')
                    ->select('patients.name', 'services.name as service_name', 'service_turn.id', 'service_turn.service_id', 'service_turn.turn_id');



        return [$query->count(), $query->get()];
    }

    public function loadWaiters()
    {
        $now = Carbon::now();
        $now_ex = explode(" ", $now);
        $today = $now_ex[0];



        $query = DB::table('service_turn')
                    ->leftjoin('turns', 'service_turn.turn_id', '=', 'turns.id')
                    ->leftjoin('receptions', 'turns.reception_id', '=', 'receptions.id')
                    ->leftjoin('patients', 'receptions.patient_id', '=', 'patients.id')
                    ->leftjoin('services', 'service_turn.service_id', '=', 'services.id')
                    ->where('turns.turn_time', 'like', "%$today%")
                    ->where('service_turn.user_id', Session::get('user_id'))
                    ->where('service_turn.status', 'فی انتظار')
                    ->select('patients.name', 'services.name as service_name', 'service_turn.id', 'service_turn.service_id', 'service_turn.turn_id');



        return [$query->count(), $query->get()];
    }

    public function loadOffice()
    {
        $now = Carbon::now();
        $now_ex = explode(" ", $now);
        $today = $now_ex[0];


        if (Session::get('role') == 6) {
            $query = DB::table('service_turn')
                ->leftjoin('turns', 'service_turn.turn_id', '=', 'turns.id')
                ->leftjoin('receptions', 'turns.reception_id', '=', 'receptions.id')
                ->leftjoin('patients', 'receptions.patient_id', '=', 'patients.id')
                ->leftjoin('services', 'service_turn.service_id', '=', 'services.id')
                ->where('turns.turn_time', 'like', "%$today%")
                ->where('service_turn.user_id', Session::get('user_id'))
                ->where('service_turn.status', 'داخل مطب')
                ->select('patients.name', 'services.name as service_name', 'service_turn.id', 'service_turn.service_id', 'service_turn.turn_id');
            return [$query->count(), $query->get()];
        }
    }

    public function loadTherapist()
    {
        $now = Carbon::now();
        $now_ex = explode(" ", $now);
        $today = $now_ex[0];



        $query = DB::table('service_turn')
                    ->leftjoin('turns', 'service_turn.turn_id', '=', 'turns.id')
                    ->leftjoin('receptions', 'turns.reception_id', '=', 'receptions.id')
                    ->leftjoin('patients', 'receptions.patient_id', '=', 'patients.id')
                    ->leftjoin('services', 'service_turn.service_id', '=', 'services.id')
                    ->where('turns.turn_time', 'like', "%$today%")
                    ->where('service_turn.user_id', Session::get('user_id'))
                    ->where('service_turn.status', 'داخل مطب')
                    ->select('patients.name', 'services.name as service_name', 'service_turn.id', 'service_turn.service_id', 'service_turn.turn_id');



        return [$query->count(), $query->get()];
    }

    public function futureTurns($p='')
    {
        $now = Jalalian::now();
        $ex_now = explode(" ", $now);
        $ex_now = explode("-", $ex_now[0]);
        $day = $ex_now[2];
        if ($day > 1) {
            $this_month = Jalalian::now()->subDays($day - 1);
        } else {
            $this_month = Jalalian::now();
        }

        $only_date = explode(" ", $this_month);

        if (!isset($p)) {
            $new_date = $this_month;
        } else {
            if ($p > 0) {
                $new_date = $this_month->addMonths($p);
            } elseif ($p<0) {
                $new_date = $this_month->subMonths($p*-1);
            } else {
                $new_date = $this_month;
            }
        }
        

        $new_date_ex = explode(" ", $new_date);
        $month = explode("-", $new_date_ex[0]);

        if ($month[1] < 7) {
            $count_of_days = 31;
        } elseif ($month[1] > 6 && $month[1] < 12) {
            $count_of_days = 30;
        } else {
            $count_of_days = 29;
        }

        $explode_new_date = explode(" ", $new_date);
        $explode_new_date = explode("-", $explode_new_date[0]);

        $current_month = $explode_new_date[1];
        $current_year  = $explode_new_date[0];

        if ($current_month == 1) {
            $month_name = 'فروردین';
        } elseif ($current_month == 2) {
            $month_name = 'اردیبهشت';
        } elseif ($current_month == 3) {
            $month_name = 'خرداد';
        } elseif ($current_month == 4) {
            $month_name = 'تیر';
        } elseif ($current_month == 5) {
            $month_name = 'مرداد';
        } elseif ($current_month == 6) {
            $month_name = 'شهریور';
        } elseif ($current_month == 7) {
            $month_name = 'مهر';
        } elseif ($current_month == 8) {
            $month_name = 'آبان';
        } elseif ($current_month == 9) {
            $month_name = 'آذر';
        } elseif ($current_month == 10) {
            $month_name = 'دی';
        } elseif ($current_month == 11) {
            $month_name = 'بهمن';
        } elseif ($current_month == 12) {
            $month_name = 'اسفند';
        }

        $current_year = Number::convertToPersian($current_year);

        return view('new.turn.future', compact('month_name', 'count_of_days', 'current_year', 'p', 'new_date'));
    }

    public function insurancesArray()
    {
        $insurances = [];
        $query = Insurance::where('status', 'فعال')->get();

        foreach ($query as $row) {
            $insurances[$row->id] = $row->name;
        }

        return $insurances;
    }

    public function allInsurances()
    {
        return Insurance::all();
    }

    public function patientNameById($patient_id)
    {
        return Patient::find($patient_id)->name;
    }

    public function receptionsBypatientId($patient_id)
    {
        return Reception::where('patient_id', $patient_id)->orderBy('id', 'desc')->get();
    }

    public function patientInsuranceId($patient_id)
    {
        return Patient::find($patient_id)->insurance_id;
    }

    public function turnReceptionId($turn_id)
    {
        return Turn::find($turn_id)->reception_id;
    }

    public function receptionPatientId($reception_id)
    {
        return Reception::find($reception_id)->patient_id;
    }
}
