<?php

namespace App\Http\Controllers;

use App\Helpers\ConvertDate as Date;
use App\Helpers\ConvertNumber as Number;
use App\Helpers\ConvertNumber;
use App\Models\Fund;
use App\Models\Insurance;
use App\Models\Invoice;
use App\Models\Role;
use App\Models\Service;
use App\Models\Turn;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AccountantController extends Controller
{
    public function index()
    {
        if (request('name')) {
            $name = request('name');
            $from = "2000-01-01 00:00:00";
            $to = "2040-01-01 00:00:00";
        } else {
            $name = " ";
            $from = Carbon::today();
            $to = Carbon::tomorrow();
        }
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
                ->select('service_turn.net_price', 'patients.name as patient_name', 'services.name as service_name', 'patients.insurance_id', 'service_turn.paid', 'users.name as user_name', 'service_turn.service_id', 'insurances.name as insurance_name', 'service_turn.discount', 'service_turn.debt', 'turns.turn_time', 'service_turn.paid', 'service_turn.count','service_turn.received_debt_amount')
                ->get();

        $discount = 0;
        foreach ($query as $row) {
            if ($row->discount > 0 && $row->paid == 1) {
                $discount+=$row->discount;
            }
        }


        $sum = Invoice::where('paid', 1)->where('created_at', '<', Carbon::tomorrow()->addHours(5))->sum('amount');
        $sum = Number::convertToPersian(number_format($sum));

        $sum_today = Invoice::where('created_at', '>', Carbon::today()->addHours(0))
                            ->where('created_at', '<', Carbon::tomorrow()->addHours(0))
                            ->sum('amount');
        $date = date("Y-m-d");                    
        $received_debt = \DB::table('service_turn')->where('debt_received_at','like',"%$date%")->sum('received_debt_amount'); 

       

        $added = 0;

        foreach ($query as $row) {
            if ($row->discount < 0 && $row->paid == 1) {
                $added+=$row->discount;
            }
        }

        $debt = 0;
        foreach ($query as $row) {
            if ($row->debt > 0 && $row->paid == 1) {
                $debt+=$row->debt;
            }
        }

        $sum_today = 0;
        foreach ($query as $row) {
            if ($row->paid == 1) {
                $sum_today+= \DB::table('insurance_service')->where('insurance_id', $row->insurance_id)->where('service_id', $row->service_id)->first()->tariff*$row->count;
            }
        }

        $total = Number::convertToPersian(number_format($sum_today));

        $sum_today = Number::convertToPersian(number_format($sum_today - $discount - $debt - $added + $received_debt));

        $discount = Number::convertToPersian(number_format($discount));

        return view('new.accountant.index', compact('sum', 'sum_today', 'query', 'discount', 'total', 'added', 'debt','received_debt'));
    }

    public function insurancesDailyDetail()
    {
        $insurances = Insurance::all();

        if (request('name')) {
            $name = request('name');
            $from = "2000-01-01 00:00:00";
            $to = "2040-01-01 00:00:00";
        } else {
            $name = " ";
            $from = Carbon::today();
            $to = Carbon::tomorrow();
        }
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
                ->select('service_turn.net_price', 'patients.name as patient_name', 'services.name as service_name', 'patients.insurance_id', 'service_turn.paid', 'users.name as user_name', 'service_turn.service_id', 'insurances.name as insurance_name', 'service_turn.discount', 'turns.turn_time', 'service_turn.paid', 'service_turn.count')
                ->get();

        $discount = 0;
        foreach ($query as $row) {
            if ($row->discount > 0 && $row->paid == 1) {
                $discount+=$row->discount;
            }
        }


        $sum = Invoice::where('paid', 1)->where('created_at', '<', Carbon::tomorrow()->addHours(5))->sum('amount');
        $sum = Number::convertToPersian(number_format($sum));

        $sum_today = Invoice::where('created_at', '>', Carbon::today()->addHours(0))
                            ->where('created_at', '<', Carbon::tomorrow()->addHours(0))
                            ->sum('amount');

        

        $sum_today = 0;
        foreach ($query as $row) {
            if ($row->paid == 1) {
                $sum_today+= \DB::table('insurance_service')->where('insurance_id', $row->insurance_id)->where('service_id', $row->service_id)->first()->tariff*$row->count;
            }
        }

        $total = Number::convertToPersian(number_format($sum_today - $discount));

        $sum_today = Number::convertToPersian(number_format($sum_today));

        $discount = Number::convertToPersian(number_format($discount));

        return view('new.accountant.insurance-daily', compact('sum', 'sum_today', 'query', 'discount', 'total', 'insurances'));
    }

    public function insurancesDetail(Request $request)
    {
        if (request()->method() == 'GET') {
            return view('new.accountant.insurance-all');
        } else {
            $jalali_from = $request['from'];
            $jalali_to = $request['to'];

            $from = Date::toGeorgian($jalali_from);
            $from = $from[0]."-".$from[1]."-".$from[2]." 00:00:00";

            $to = Date::toGeorgian($jalali_to);
            $to = $to[0]."-".$to[1]."-".$to[2]." 23:59:59";

            $insurances = Insurance::all();

            $sum_all = 0;
            $discount_all = 0;
            $count_all = 0;

            foreach ($insurances as $insurance) {
                $sum[$insurance->id] = \DB::table('turns')
                ->leftjoin('invoices', 'turns.id', '=', 'invoices.turn_id')
                ->leftjoin('receptions', 'turns.reception_id', '=', 'receptions.id')
                ->leftjoin('patients', 'receptions.patient_id', '=', 'patients.id')
                ->where('invoices.created_at', '>=', $from)
                ->where('invoices.created_at', '=<', $to)
                ->where('patients.insurance_id', $insurance->id)
                ->select('invoices.*')
                ->sum('amount');

                $sum_all += $sum[$insurance->id];

                $discount[$insurance->id] = \DB::table('turns')
                ->leftjoin('service_turn', 'turns.id', '=', 'service_turn.turn_id')
                ->leftjoin('invoices', 'turns.id', '=', 'invoices.turn_id')
                ->leftjoin('receptions', 'turns.reception_id', '=', 'receptions.id')
                ->leftjoin('patients', 'receptions.patient_id', '=', 'patients.id')
                ->where('invoices.created_at', '>', $from)
                ->where('invoices.created_at', '<', $to)
                ->where('patients.insurance_id', $insurance->id)
                ->select('invoices.*')
                ->sum('service_turn.discount');

                $discount_all += $discount[$insurance->id];


                $count[$insurance->id] = \DB::table('turns')
                ->leftjoin('invoices', 'turns.id', '=', 'invoices.turn_id')
                ->leftjoin('receptions', 'turns.reception_id', '=', 'receptions.id')
                ->leftjoin('patients', 'receptions.patient_id', '=', 'patients.id')
                ->where('invoices.created_at', '>', $from)
                ->where('invoices.created_at', '<', $to)
                ->where('patients.insurance_id', $insurance->id)
                ->select('invoices.*')
                ->count();

                $count_all += $count[$insurance->id];
            }

            $jalali_from = Number::convertToPersian($jalali_from);
            $jalali_to = Number::convertToPersian($jalali_to);

            $jalali_from = explode("-", $jalali_from);
            $jalali_from = $jalali_from[0]."/".$jalali_from[1]."/".$jalali_from[2];

            $jalali_to = explode("-", $jalali_to);
            $jalali_to = $jalali_to[0]."/".$jalali_to[1]."/".$jalali_to[2];

            $sum_all = Number::convertToPersian(number_format($sum_all));
            $discount_all = Number::convertToPersian(number_format($discount_all));
            $count_all = Number::convertToPersian(number_format($count_all));

            return view('new.accountant.insurance-all', compact('sum', 'discount', 'insurances', 'jalali_from', 'jalali_to', 'sum_all', 'discount_all', 'count', 'count_all'));
        }
    }

    public function dailyFundByDoctors(Request $request)
    {
        $users = DB::table('user_services')
                    ->leftjoin('users', 'user_services.user_id', '=', 'users.id')
                    ->where('users.role_id', '6')
                    ->select('user_services.user_id')
                    ->orderBy('users.name', 'asc')
                    ->get();

        $users_2 = DB::table('user_services')
                    ->leftjoin('users', 'user_services.user_id', '=', 'users.id')
                    ->where('users.role_id', '!=', '6')
                    ->select('user_services.user_id')
                    ->orderBy('users.name', 'asc')
                    ->get();

        $users = $users->merge($users_2);
                                
        $nurses = [];
        $roles = Role::where('access_to', 'like', "%خدمات%")->select('id')->get();
        $user_roles = [];
        foreach ($users as $row) {
            array_push($nurses, $row->user_id);
        }

        foreach ($roles as $role) {
            array_push($user_roles, $role->id);
        }

        $nurses = User::whereIn('id', $nurses)->whereIn('role_id', $user_roles)->orderBy('role_id', 'asc')->orderBy('name', 'asc')->get();

        if (!request('user_id')) {
            return view('accountant.doctors-daily', compact('nurses'));
        } else {
            $jalali_from = $request['from'];
            $jalali_to = $request['to'];

            $from = Date::toGeorgian($jalali_from);
            $from = $from[0]."-".$from[1]."-".$from[2]." 00:00:00";

            $to = Date::toGeorgian($jalali_to);
            $to = $to[0]."-".$to[1]."-".$to[2]." 23:59:59";

            $user = User::find($request['user_id']);
            $name = Role::find($user->role_id)->title.' '.$user->name;

            $sum = 0;
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
                ->where('service_turn.user_id', $request['user_id'])
                ->select('service_turn.net_price', 'patients.name as patient_name', 'services.name as service_name', 'patients.insurance_id', 'service_turn.paid', 'users.name as user_name', 'service_turn.service_id', 'insurances.name as insurance_name', 'turns.doctor_id', 'turns.turn_time', 'service_turn.discount', 'service_turn.count')
                ->get();



            

            return view('accountant.doctors-daily', compact('nurses', 'name', 'jalali_from', 'jalali_to', 'query'));
        }
    }

    public function hourlyFundByDoctors(Request $request)
    {
        // dd($request['time_from']);
        $users = DB::table('user_services')
                    ->leftjoin('users', 'user_services.user_id', '=', 'users.id')
                    ->where('users.role_id', '6')
                    ->select('user_services.user_id')
                    ->orderBy('users.name', 'asc')
                    ->get();

        $users_2 = DB::table('user_services')
                    ->leftjoin('users', 'user_services.user_id', '=', 'users.id')
                    ->where('users.role_id', '!=', '6')
                    ->select('user_services.user_id')
                    ->orderBy('users.name', 'asc')
                    ->get();

        $users = $users->merge($users_2);
                                
        $nurses = [];
        $roles = Role::where('access_to', 'like', "%خدمات%")->select('id')->get();
        $user_roles = [];
        foreach ($users as $row) {
            array_push($nurses, $row->user_id);
        }

        foreach ($roles as $role) {
            array_push($user_roles, $role->id);
        }

        $nurses = User::whereIn('id', $nurses)->whereIn('role_id', $user_roles)->orderBy('role_id', 'asc')->orderBy('name', 'asc')->get();

        if (!request('user_id')) {
            return view('accountant.doctors-hourly', compact('nurses'));
        } else {
            $jalali_date = $request['date'];

            $date = Date::toGeorgian($jalali_date);
            $date = $date[0]."-".$date[1]."-".$date[2];


            $hour_from = $request['time_from'];
            $hour_to   = $request['time_to'];



            $user = User::find($request['user_id']);
            $name = Role::find($user->role_id)->title.' '.$user->name;

            $sum = 0;
            $query = DB::table('service_turn')
                ->leftjoin('services', 'service_turn.service_id', '=', 'services.id')
                ->leftjoin('insurance_service', 'services.id', '=', 'insurance_service.tariff')
                ->leftjoin('insurances', 'insurance_service.insurance_id', '=', 'insurances.id')
                ->leftjoin('turns', 'service_turn.turn_id', '=', 'turns.id')
                ->leftjoin('receptions', 'turns.reception_id', '=', 'receptions.id')
                ->leftjoin('patients', 'receptions.patient_id', '=', 'patients.id')
                ->leftjoin('users', 'service_turn.user_id', '=', 'users.id')
                ->where('turns.turn_time', '>', $date.' '.$hour_from)
                ->where('turns.turn_time', '<', $date.' '.$hour_to)
                ->where('service_turn.user_id', $request['user_id'])
                ->select('service_turn.net_price', 'patients.name as patient_name', 'services.name as service_name', 'patients.insurance_id', 'service_turn.paid', 'users.name as user_name', 'service_turn.service_id', 'insurances.name as insurance_name', 'turns.doctor_id', 'turns.turn_time', 'service_turn.discount', 'service_turn.count')
                ->orderBy('services.name', 'asc')
                ->get();



            

            return view('accountant.doctors-hourly', compact('nurses', 'name', 'jalali_date', 'hour_from', 'hour_to', 'query'));
        }
    }

    public function dailyFundByServices(Request $request)
    {
        $services = \App\Models\Service::where('status', 'فعال')->orderBy('name', 'asc')->get();
        if (request()->method() == 'GET') {
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
                ->where('service_turn.paid', 1)
                ->where('patients.name', 'like', "%$name%")
                ->select('service_turn.net_price', 'patients.name as patient_name', 'services.name as service_name', 'patients.insurance_id', 'service_turn.paid', 'users.name as user_name', 'service_turn.service_id', 'insurances.name as insurance_name', 'service_turn.discount', 'turns.turn_time', 'service_turn.paid', 'service_turn.count')
                ->get();

            $discount = 0;
            foreach ($query as $row) {
                if ($row->discount > 0 && $row->paid) {
                    $discount+=$row->discount;
                }
            }


            $sum = Invoice::where('paid', 1)->where('created_at', '<', Carbon::tomorrow()->addHours(5))->sum('amount');
            $sum = Number::convertToPersian(number_format($sum));

            $sum_today = Invoice::where('created_at', '>', Carbon::today()->addHours(0))
                            ->where('created_at', '<', Carbon::tomorrow()->addHours(0))
                            ->sum('amount');

        

            $sum_today = 0;
            foreach ($query as $row) {
                if ($row->paid == 1) {
                    $sum_today+= \DB::table('insurance_service')->where('insurance_id', $row->insurance_id)->where('service_id', $row->service_id)->first()->tariff*$row->count;
                }
            }

            $total = Number::convertToPersian(number_format($sum_today - $discount));

            $sum_today = Number::convertToPersian(number_format($sum_today));

            $discount = Number::convertToPersian(number_format($discount));

            return view('accountant.services-daily', compact('sum', 'sum_today', 'query', 'discount', 'total', 'services'));
        } else {
            $jalali_from = $request['from'];
            $jalali_to = $request['to'];

            $from_time = $request['from_time'];
            $to_time   = $request['to_time'];

            $from = Date::toGeorgian($jalali_from);
            $from = $from[0]."-".$from[1]."-".$from[2]." ".$request['from_time'].":00";

            $to = Date::toGeorgian($jalali_to);
            $to = $to[0]."-".$to[1]."-".$to[2]." ".$request['to_time'].":00";

            $name = " ";
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
                ->where('service_turn.paid', 1)
                ->where('patients.name', 'like', "%$name%")
                ->select('service_turn.net_price', 'patients.name as patient_name', 'services.name as service_name', 'patients.insurance_id', 'service_turn.paid', 'users.name as user_name', 'service_turn.service_id', 'insurances.name as insurance_name', 'service_turn.discount', 'turns.turn_time', 'service_turn.paid', 'service_turn.count')
                ->get();


            $sum = Invoice::where('paid', 1)->where('created_at', '<', Carbon::tomorrow()->addHours(5))->sum('amount');
            $sum = Number::convertToPersian(number_format($sum));

            $sum_today = Invoice::where('created_at', '>', Carbon::today()->addHours(0))
                            ->where('created_at', '<', Carbon::tomorrow()->addHours(0))
                            ->sum('amount');

        
            $discount = 0;
            foreach ($query as $row) {
                if ($row->discount > 0 && $row->paid == 1) {
                    $discount+=$row->discount;
                }
            }

        

            $sum_today = 0;
            foreach ($query as $row) {
                if ($row->paid == 1) {
                    $sum_today+= \DB::table('insurance_service')->where('service_id', $row->service_id)->first()->tariff*$row->count;
                }
            }

            $total = Number::convertToPersian(number_format($sum_today - $discount));

            $sum_today = Number::convertToPersian(number_format($sum_today));

            $discount = Number::convertToPersian(number_format($discount));

            $jalali_from = Number::convertToPersian($jalali_from);
            $jalali_to = Number::convertToPersian($jalali_to);

            $jalali_from = explode("-", $jalali_from);
            $jalali_from = $jalali_from[0]."/".$jalali_from[1]."/".$jalali_from[2];

            $jalali_to = explode("-", $jalali_to);
            $jalali_to = $jalali_to[0]."/".$jalali_to[1]."/".$jalali_to[2];

            return view('accountant.services-all', compact('sum', 'sum_today', 'query', 'discount', 'total', 'services', 'jalali_from', 'jalali_to', 'from_time', 'to_time'));
        }
    }

    public function deliver(Request $request)
    {
        if (request()->method() == 'GET') {
            $roles = [];
            $query = DB::table('permission_roles')->where('permission_id', 15)->get();
            foreach ($query as $row) {
                array_push($roles, $row->role_id);
            }

            $users = User::whereIn('role_id', $roles)->get();

            $user = [];

            foreach ($users as $key) {
                $user[$key->id] = $key->name;
            }

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
                ->select('service_turn.net_price', 'patients.name as patient_name', 'services.name as service_name', 'patients.insurance_id', 'service_turn.paid', 'users.name as user_name', 'service_turn.service_id', 'insurances.name as insurance_name', 'service_turn.discount', 'service_turn.debt', 'turns.turn_time', 'service_turn.paid', 'service_turn.count','service_turn.received_debt_amount')
                ->get();
   

            $discount = 0;
            foreach ($query as $row) {
                if ($row->discount > 0 && $row->paid == 1) {
                    $discount+=$row->discount;
                }
            }

            $added = 0;

            foreach ($query as $row) {
                if ($row->discount < 0 && $row->paid == 1) {
                    $added+=$row->discount;
                }
            }

            $debt = 0;
            foreach ($query as $row) {
                if ($row->debt > 0 && $row->paid == 1) {
                    $debt+=$row->debt;
                }
            }

            $received_debt_amount = 0;
            foreach ($query as $row) {
                if ($row->received_debt_amount > 0 && $row->paid == 1) {
                    $received_debt_amount+=$row->received_debt_amount;
                }
            }

            $sum_today = 0;
            foreach ($query as $row) {
                if ($row->paid == 1) {
                    $sum_today+= \DB::table('insurance_service')->where('insurance_id', $row->insurance_id)->where('service_id', $row->service_id)->first()->tariff*$row->count;
                }
            }

            $fund = $sum_today;
            

            return view('new.accountant.deliver', compact('user', 'fund', 'discount', 'debt', 'added','received_debt_amount'));
        } else {
            Fund::create([
                'user_id' => Session::get('user_id'),
                'amount' => $request['fund'],
                'description' => $request['detail'].'<br><hr> نقد: '.$request['cash'].' دینار<br>کارت‌خوان: '.$request['card'].' دینار<br><hr>توضیحات: '.$request['description'],
                'delivered'   => 2,
                'delivered_to' => $request['delivered_to']
            ]);

            $fund_id = Fund::orderBy('id', 'desc')->first();
            Fund::where('id', $fund_id->id)->where('delivered', 0)->update([
                'description' => $request['detail'].'<br><hr> نقد: '.$request['cash'].' دینار<br>کارت‌خوان: '.$request['card'].' دینار<br><hr>توضیحات: '.$request['description'],
                'delivered'   => 2,
                'delivered_to' => $request['delivered_to']
            ]);

            Session::flush();
            return redirect(route('home'));
        }
    }
    public function receive(Request $request)
    {
        if (request()->method() == 'GET') {
            if (Fund::where('delivered_to', Session::get('user_id'))->where('delivered', 2)->count() > 0) {
                $query = Fund::where('delivered_to', Session::get('user_id'))->where('delivered', 2)->first();
                return view('new.accountant.receive', compact('query'));
            }
        } else {
            Fund::where('delivered_to', Session::get('user_id'))->where('delivered', 2)->update([
                'rejected' => $request['reject'],
                'reject_reason' => $request['reject_reason'],
                'delivered' => 1
            ]);

            return redirect('/');
        }
    }

    public function collect()
    {
        $query = Fund::where('delivered_to_admin', 0)->where('delivered', 1)->where('rejected', 0)->get();

        $fund  = Fund::where('delivered_to_admin', 0)->where('delivered', 1)->where('rejected', 0)->orderBy('id', 'desc')->first();

        if (!is_null($fund)) {
            $sum = $fund->amount;
        } else {
            $sum=0;
        }

        if (request()->method() == 'GET') {
            return view('new.accountant.collect', compact('query', 'sum'));
        } else {
            Fund::where('delivered_to_admin', 0)->update([
                'delivered_to_admin' => 1
            ]);

            $total = DB::table('main_fund')->first()->total;
            DB::table('main_fund')->update([
                'total' => $sum+$total
            ]);

            Fund::where('id', '>', 0)->delete();
            return redirect('/');
        }
    }

    public function users()
    {
        $services = \App\Models\Service::where('status', 'فعال')->orderBy('name', 'asc')->get();
        $from = Carbon::today();
        $to = Carbon::tomorrow();
        $query = DB::table('service_turn')
                ->leftjoin('services', 'service_turn.service_id', '=', 'services.id')
                ->leftjoin('insurance_service', 'services.id', '=', 'insurance_service.tariff')
                ->leftjoin('insurances', 'insurance_service.insurance_id', '=', 'insurances.id')
                ->leftjoin('turns', 'service_turn.turn_id', '=', 'turns.id')
                ->leftjoin('users', 'service_turn.user_id', '=', 'users.id')
                ->where('turns.turn_time', '>', $from)
                ->where('turns.turn_time', '<', $to)
                ->select('services.name as service_name', 'service_turn.paid', 'users.name as user_name', 'service_turn.service_id', 'service_turn.user_id', 'insurances.name as insurance_name', 'service_turn.discount', 'turns.turn_time', 'service_turn.paid', 'service_turn.count')
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
                $sum_today+= \DB::table('insurance_service')->where('service_id', $row->service_id)->first()->tariff*$row->count;
            }
        }

        $total = Number::convertToPersian(number_format($sum_today - $discount));

        $sum_today = Number::convertToPersian(number_format($sum_today));

        $discount = Number::convertToPersian(number_format($discount));

        $users = User::orderBy('firstname', 'asc')->where('role_id', 6)->get();
        $users_2 = User::orderBy('firstname', 'asc')->where('role_id', '!=', 6)->get();

        $users = $users->merge($users_2);

        return view('accountant.users', compact('sum_today', 'query', 'discount', 'total', 'services', 'users'));
    }

    public function doctors()
    {
        $services = \App\Models\Service::where('status', 'فعال')->orderBy('name', 'asc')->get();
        $from = Carbon::today();
        $to = Carbon::tomorrow();
        $query = DB::table('service_turn')
                ->leftjoin('services', 'service_turn.service_id', '=', 'services.id')
                ->leftjoin('insurance_service', 'services.id', '=', 'insurance_service.tariff')
                ->leftjoin('insurances', 'insurance_service.insurance_id', '=', 'insurances.id')
                ->leftjoin('turns', 'service_turn.turn_id', '=', 'turns.id')
                ->leftjoin('users', 'service_turn.user_id', '=', 'users.id')
                ->where('turns.turn_time', '>', $from)
                ->where('turns.turn_time', '<', $to)
                ->select('services.name as service_name', 'service_turn.paid', 'users.name as user_name', 'service_turn.service_id', 'service_turn.user_id', 'insurances.name as insurance_name', 'service_turn.discount', 'turns.turn_time', 'turns.doctor_id', 'service_turn.paid', 'service_turn.count')
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
                $sum_today+= \DB::table('insurance_service')->where('service_id', $row->service_id)->first()->tariff*$row->count;
            }
        }

        $total = Number::convertToPersian(number_format($sum_today - $discount));

        $sum_today = Number::convertToPersian(number_format($sum_today));

        $discount = Number::convertToPersian(number_format($discount));

        $users = User::orderBy('firstname', 'asc')->where('role_id', 6)->get();
        $users_2 = User::orderBy('firstname', 'asc')->where('role_id', '!=', 6)->get();

        $users = $users->merge($users_2);

        return view('accountant.doctors', compact('sum_today', 'query', 'discount', 'total', 'services', 'users'));
    }

    public function myWallet(Request $request)
    {
        $services = \App\Models\Service::where('status', 'فعال')->orderBy('name', 'asc')->get();
        if (request()->method() == 'GET') {
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
                ->where('service_turn.paid', 1)
                ->where('service_turn.user_id', session('user_id'))
                ->where('patients.name', 'like', "%$name%")
                ->select('service_turn.net_price', 'patients.name as patient_name', 'services.name as service_name', 'patients.insurance_id', 'service_turn.paid', 'users.name as user_name', 'service_turn.service_id', 'insurances.name as insurance_name', 'service_turn.discount', 'turns.turn_time', 'service_turn.paid', 'service_turn.count')
                ->get();

            $discount = 0;
            foreach ($query as $row) {
                if ($row->discount > 0 && $row->paid) {
                    $discount+=$row->discount;
                }
            }


            $sum = Invoice::where('paid', 1)->where('created_at', '<', Carbon::tomorrow()->addHours(5))->sum('amount');
            $sum = Number::convertToPersian(number_format($sum));

            $sum_today = Invoice::where('created_at', '>', Carbon::today()->addHours(0))
                            ->where('created_at', '<', Carbon::tomorrow()->addHours(0))
                            ->sum('amount');

        

            $sum_today = 0;
            foreach ($query as $row) {
                if ($row->paid == 1) {
                    $sum_today+= \DB::table('insurance_service')->where('insurance_id', $row->insurance_id)->where('service_id', $row->service_id)->first()->tariff*$row->count;
                }
            }

            $total = Number::convertToPersian(number_format($sum_today - $discount));

            $sum_today = Number::convertToPersian(number_format($sum_today));

            $discount = Number::convertToPersian(number_format($discount));

            return view('accountant.my-wallet-daily', compact('sum', 'sum_today', 'query', 'discount', 'total', 'services'));
        } else {
            $jalali_from = $request['from'];
            $jalali_to = $request['to'];

            $from_time = $request['from_time'];
            $to_time   = $request['to_time'];

            $from = Date::toGeorgian($jalali_from);
            $from = $from[0]."-".$from[1]."-".$from[2]." ".$request['from_time'].":00";

            $to = Date::toGeorgian($jalali_to);
            $to = $to[0]."-".$to[1]."-".$to[2]." ".$request['to_time'].":00";

            $name = " ";
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
                ->where('service_turn.paid', 1)
                ->where('service_turn.user_id', Session::get('user_id'))
                ->select('service_turn.net_price', 'patients.name as patient_name', 'services.name as service_name', 'patients.insurance_id', 'service_turn.paid', 'users.name as user_name', 'service_turn.service_id', 'insurances.name as insurance_name', 'service_turn.discount', 'turns.turn_time', 'service_turn.paid', 'service_turn.count')
                ->get();


            $sum = Invoice::where('paid', 1)->where('created_at', '<', Carbon::tomorrow()->addHours(5))->sum('amount');
            $sum = Number::convertToPersian(number_format($sum));

            $sum_today = Invoice::where('created_at', '>', Carbon::today()->addHours(0))
                            ->where('created_at', '<', Carbon::tomorrow()->addHours(0))
                            ->sum('amount');

        
            $discount = 0;
            foreach ($query as $row) {
                if ($row->discount > 0 && $row->paid == 1) {
                    $discount+=$row->discount;
                }
            }

        

            $sum_today = 0;
            foreach ($query as $row) {
                if ($row->paid == 1) {
                    $sum_today+= \DB::table('insurance_service')->where('service_id', $row->service_id)->first()->tariff*$row->count;
                }
            }

            $total = Number::convertToPersian(number_format($sum_today - $discount));

            $sum_today = Number::convertToPersian(number_format($sum_today));

            $discount = Number::convertToPersian(number_format($discount));

            $jalali_from = Number::convertToPersian($jalali_from);
            $jalali_to = Number::convertToPersian($jalali_to);

            $jalali_from = explode("-", $jalali_from);
            $jalali_from = $jalali_from[0]."/".$jalali_from[1]."/".$jalali_from[2];

            $jalali_to = explode("-", $jalali_to);
            $jalali_to = $jalali_to[0]."/".$jalali_to[1]."/".$jalali_to[2];

            return view('accountant.my-wallet-all', compact('sum', 'sum_today', 'query', 'discount', 'total', 'services', 'jalali_from', 'jalali_to', 'from_time', 'to_time'));
        }
    }

    public function debts()
    {
        if (request('name')) {
            $name = request('name');
            $from = "2000-01-01 00:00:00";
            $to = "2040-01-01 00:00:00";
        } else {
            $name = " ";
            $from = "2000-01-01 00:00:00";
            $to = "2040-01-01 00:00:00";
        }
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
                ->where('service_turn.debt','>',0)
                ->select('service_turn.net_price', 'patients.name as patient_name', 'patients.mobile', 'services.name as service_name', 'patients.insurance_id', 'service_turn.paid', 'users.name as user_name', 'service_turn.service_id', 'insurances.name as insurance_name', 'service_turn.discount', 'service_turn.debt', 'turns.turn_time', 'service_turn.paid', 'service_turn.count','service_turn.id','service_turn.sms')
                ->get();        
                  
        $debt = \DB::table('service_turn')->sum('debt');
        

        return view('new.accountant.debts', compact('query', 'debt'));
    }
}
