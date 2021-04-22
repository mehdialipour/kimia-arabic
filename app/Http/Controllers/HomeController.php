<?php

namespace App\Http\Controllers;

use App\Helpers\ConvertNumber as Number;
use App\Models\ActivityLog;
use App\Models\ActivityType;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Turn;
use App\Models\User;
use App\Services\Sms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class HomeController extends Controller
{
    public function index()
    {
        $patients = Number::convertToPersian(Patient::count());
        $turns = Turn::where('turn_time','>',Carbon::today())
            ->where('turn_time','<',Carbon::tomorrow())
            ->count();

        $turns =  Number::convertToPersian($turns); 

        $last_login = User::where('username', Session::get('username'))->first()->last_login;

        $name = " ";
            $from = Carbon::today();
            $to = Carbon::tomorrow();

            $query = DB::table('service_turn')
                ->leftjoin('services', 'service_turn.service_id', '=', 'services.id')
                ->leftjoin('insurance_service', 'services.id', '=', 'insurance_service.tariff')
                ->leftjoin('insurances', 'insurance_service.insurance_id', '=', 'insurances.id')
                ->leftjoin('turns', 'service_turn.turn_id', '=', 'turns.id')
                ->leftjoin('receptions', 'turns.reception_id', '=', 'receptions.id')
                ->leftjoin('patients', 'receptions.patient_id', '=', 'patients.id')
                ->leftjoin('users', 'service_turn.user_id', '=', 'users.id')
                ->where('turns.turn_time', '>', $from)
                ->where('turns.turn_time', '<', $to)
                ->where('patients.name', 'like', "%$name%")
                ->where('service_turn.receiver_id', Session::get('user_id'))
                ->select('patients.name as patient_name', 'services.name as service_name', 'patients.insurance_id', 'service_turn.paid', 'users.name as user_name', 'service_turn.service_id', 'insurances.name as insurance_name', 'service_turn.discount', 'turns.turn_time', 'service_turn.paid', 'service_turn.count')
                ->get();
   

            $discount = 0;
            foreach ($query as $row) {
                if ($row->discount > 0 && $row->paid == 1) {
                    $discount+=$row->discount;
                }
            }

        

            $sum_today = 0;
            foreach ($query as $row) {
                if ($row->paid == 1) {
                    $sum_today+= \DB::table('insurance_service')->where('insurance_id', $row->insurance_id)->where('service_id', $row->service_id)->first()->tariff*$row->count;
                }
            }

            $fund = $sum_today-$discount;
            $fund = number_format($fund);

        $login_id = ActivityType::where('title', 'login')->first()->id;
        $logout_id= ActivityType::where('title', 'logout')->first()->id;

        $arr = [$logout_id, $login_id];
        
        $logs = ActivityLog::whereIn('activity_type_id', $arr)->orderBy('id','desc')->take(10)->get();  

        return (Session::get('role') == 'doctor') ? view('new.dr-index',compact('patients','turns','fund')) : view('new.nurse-index',compact('patients','turns','fund','logs'));
    }
}
