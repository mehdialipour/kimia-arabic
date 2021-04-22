<?php

namespace App\Http\Controllers;

use App\Helpers\ConvertDate as Date;
use App\Helpers\ConvertNumber as Number;
use App\Helpers\ConvertNumber;
use App\Models\ActivityLog;
use App\Models\Diagnosis;
use App\Models\DrugStorage;
use App\Models\FileReception;
use App\Models\Fund;
use App\Models\Medicine;
use App\Models\MedicinePatient;
use App\Models\NurseDescription;
use App\Models\Patient;
use App\Models\PatientSuggestion;
use App\Models\Reception;
use App\Models\Role;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use App\Repositories\Turn\TurnRepo as Turn;
use App\Services\Sms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class TurnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $turn;

    public function __construct(Turn $turn)
    {
        $this->turn = $turn;
    }

    public function index()
    {
        $query = $this->turn->todayTurns(0);
        return view('new.turn.index', compact('query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Session::put('price', 0);
        $ins = $this->turn->insurancesArray();
        $today = $this->turn->today();
        $services = $this->turn->services();

        $drugs = DrugStorage::orderBy('name_fa')->get();
        
        $doctors = \App\Models\User::where('default_doctor', 1)->get();
        $users = DB::table('user_services')
                    ->leftjoin('users', 'user_services.user_id', '=', 'users.id')
                    ->where('users.role_id', '6')
                    ->where('users.active', 1)
                    ->select('user_services.user_id')
                    ->orderBy('users.name', 'asc')
                    ->get();

        $users_2 = DB::table('user_services')
                    ->leftjoin('users', 'user_services.user_id', '=', 'users.id')
                    ->where('users.role_id', '!=', '6')
                    ->where('users.active', 1)
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

        if ($request['patient']) {
            $id = $request['patient'];
            $patient = Patient::find($id);
            $patient_name = $this->turn->PatientNameById($id);
            $receptions = $this->turn->receptionsBypatientId($id);
            return view('new.turn.form', compact('today', 'services', 'ins', 'doctors', 'patient_name', 'receptions', 'id', 'nurses', 'drugs', 'patient'));
        } else {
            return view('new.turn.form', compact('today', 'services', 'ins', 'doctors', 'nurses', 'drugs'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request['new_reception'] != '') {
            $patient_id = $request['patient_id'];
            
            $new = \App\Models\Reception::create([
                'patient_id' => $patient_id,
                'cause' => $request['new_reception']
            ]);

            DB::table('patient_reception')->insert([
                'patient_id' => $patient_id,
                'reception_id' => $new->id
            ]);

            $id = $new->id;
        } else {
            $id = $request['reception_id'];
        }


        if (is_null($request['services'])) {
            return redirect('turns/create')->withErrors(['حداقل یک خدمت را اختر.']);
        } elseif (is_null($request['user_id'])) {
            return redirect('turns/create')->withErrors(['مسئول انتخاب خدمت را اختر.']);
        } elseif (is_null($request['doctor_id'])) {
            return redirect('turns/create')->withErrors(['پزشک را اختر.']);
        } else {
            $result = $this->turn->create(
                $id,
                $request['date'],
                $request['time'],
                $request['files'],
                $request['services'],
                $request['drugs'],
                $request['discount'],
                $request['money_received'],
                $request['doctor_id'],
                Session::get('user_id'),
                json_encode($request->all(), JSON_UNESCAPED_UNICODE)
            );

            if (request('redirect') == 1) {
                return redirect()->back();
            } else {
                $turn_time = \App\Models\Turn::find($result)->turn_time;
                $date = explode(" ", $turn_time);
                $date = $date[0];
                if ($date == date("Y-m-d")) {
                    return redirect('turns');
                } else {
                    return redirect('turns/show-future/'.$date);
                }
            }
        }
    }

    public function toggle($turn_id)
    {
        $status = DB::table('service_turn')->where('turn_id', $turn_id)->where('service_id', request('service_id'))->first()->status;
        if ($status == 'فی انتظار') {
            $reception_id = \App\Models\Turn::find($turn_id)->reception_id;
            $patient_id = \App\Models\Reception::find($reception_id)->patient_id;
            $patient = \App\Models\Patient::find($patient_id);

            if ($patient->birth_year == '' || $patient->father_name == '' || $patient->mobile == '' || $patient->national_id == '' || strlen($patient->mobile) != 11) {
                return redirect('patients/'.$patient_id.'/edit?redirect=toggle');
            }
            DB::table('service_turn')->where('turn_id', $turn_id)->where('service_id', request('service_id'))->update([
                'status' => 'داخل مطب'
            ]);
        } else {
            DB::table('service_turn')->where('turn_id', $turn_id)->where('service_id', request('service_id'))->update([
                'status' => 'فی انتظار'
            ]);
        }
        if (strpos(Session::get('name'), 'دکتر') !== false) {
            return redirect('/');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Session::put('price', 0);
        $insurances = $this->turn->allInsurances();
        $doctors = \App\Models\User::where('default_doctor', 1)->get();
        $users = DB::table('user_services')->select('user_id')->get();
        $nurses = [];
        $roles = Role::where('access_to', 'like', "%خدمات%")->select('id')->get();
        $user_roles = [];
        foreach ($users as $row) {
            array_push($nurses, $row->user_id);
        }

        foreach ($roles as $role) {
            array_push($user_roles, $role->id);
        }

        $nurses = User::whereIn('id', $nurses)->whereIn('role_id', $user_roles)->get();

        $user_id = \DB::table('service_turn')->where('turn_id', $id)->first()->user_id;

        $model = $this->turn->edit($id);
        $name = $this->turn->patientName($id);
        $patient_id = $this->turn->patientId($id);
        $services = $this->turn->services();
        $active_services = $this->turn->activeServices($id);
        $files = $this->turn->fetchFiles($id);
        $date = $this->turn->fetchDateTime($id);
        $discount = $this->turn->fetchDiscount($id);

        $reception_id = $this->turn->turnReceptionId($id);
        $patient_id = $this->turn->receptionPatientId($reception_id);
        $insurance_id = $this->turn->patientInsuranceId($patient_id);


        $receptions = $this->turn->receptionsBypatientId($patient_id);

        $insurance_code = \App\Models\Patient::find($patient_id)->insurance_code;
        $drugs = DrugStorage::orderBy('name_fa')->get();

        return view('new.turn.edit', compact('id', 'model', 'name', 'patient_id', 'services', 'active_services', 'files', 'date', 'discount', 'insurances', 'patient_id', 'insurance_id', 'insurance_code', 'doctors', 'receptions', 'nurses', 'user_id', 'drugs'));

        // return $files;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateTurn(Request $request)
    {
        $this->turn->updateTurn(
            $request['id'],
            $request['reception_id'],
            $request['date'],
            $request['time'],
            $request['files'],
            $request['services'],
            $request['drugs'],
            $request['discount'],
            $request['money_received'],
            $request['doctor_id']
        );
        if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 2)->count() == 1) {
            return redirect('turns');
        } else {
            return redirect('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->turn->destroy($id);
        return redirect()->back();
    }

    public function loadWaiters()
    {
        if (request()->ajax()) {
            $data = request()->all();

            $query = $this->turn->loadWaiters();

            $string = '';

            foreach ($query[1] as $row) {
                $unpaid = \DB::table('service_turn')->where('turn_id', $row->turn_id)->where('service_id', $row->service_id)->where('paid', 0)->count();
                if ($unpaid == 0) {
                    $invoice = ' <span class="text-success">(هزینه پرداخت شده)</span>';
                } else {
                    $invoice = ' <span class="text-danger">(هزینه پرداخت نشده)</span>';
                }
                $string.='<p align="right"><a href="'.url('turns/clinic/'.$row->id).'">'.$row->name.' - '.$row->service_name.' '.$invoice.'</a></p>';
            }
            
            return $string."|".Number::convertToPersian($query[0]);
        }
    }

    public function loadOffice()
    {
        if (request()->ajax()) {
            $data = request()->all();

            $query = $this->turn->loadOffice();

            $string = '';
            $i=0;

            foreach ($query[1] as $row) {
                if (strpos($row->service_name, 'ویزیت') !== false) {
                    $unpaid = \DB::table('service_turn')->where('turn_id', $row->turn_id)->where('service_id', $row->service_id)->where('paid', 0)->count();
                    if ($unpaid == 0) {
                        $invoice = ' <span class="text-success">(هزینه پرداخت شده)</span>';
                    } else {
                        $invoice = ' <span class="text-danger">(هزینه پرداخت نشده)</span>';
                    }
                    $string.='<p align="right"><a href="'.url('turns/clinic/'.$row->id).'">'.$row->name.' - '.$row->service_name.' '.$invoice.'</a></p>';
                    $i+=1;
                }
            }
            return $string."|".Number::convertToPersian($i);
        }
    }

    public function loadTherapist()
    {
        if (request()->ajax()) {
            $data = request()->all();

            $query = $this->turn->loadTherapist();

            $string = '';
            $i=0;

            foreach ($query[1] as $row) {
                if (strpos($row->service_name, 'ویزیت') === false) {
                    $unpaid = \DB::table('service_turn')->where('turn_id', $row->turn_id)->where('service_id', $row->service_id)->where('paid', 0)->count();
                    if ($unpaid == 0) {
                        $invoice = ' <span class="text-success">(هزینه پرداخت شده)</span>';
                    } else {
                        $invoice = ' <span class="text-danger">(هزینه پرداخت نشده)</span>';
                    }
                    $string.='<p align="right"><a href="'.url('turns/clinic/'.$row->id).'">'.$row->name.' - '.$row->service_name.' '.$invoice.'</a></p>';
                    $i+=1;
                }
            }
            
            return $string."|".Number::convertToPersian($i);
        }
    }

    public function loadRelease()
    {
        if (request()->ajax()) {
            $data = request()->all();

            $query = $this->turn->loadRelease();

            $string = '';

            foreach ($query[1] as $row) {
                $unpaid = \DB::table('service_turn')->where('turn_id', $row->turn_id)->where('service_id', $row->service_id)->where('paid', 0)->count();
                if ($unpaid == 0) {
                    $invoice = ' <span class="text-success">(هزینه پرداخت شده)</span>';
                } else {
                    $invoice = ' <span class="text-danger">(هزینه پرداخت نشده)</span>';
                }
                $string.='<p align="right"><a href="'.url('turns/clinic/'.$row->id).'">'.$row->name.' - '.$row->service_name.' '.$invoice.'</a></p>';
            }
            return $string."|".Number::convertToPersian($query[0]);
        }
    }

    public function future_turns(Request $request)
    {
        return $this->turn->futureTurns($request['p']);
    }

    public function turnFuture($id)
    {
        $insurances = $this->turn->allInsurances();
        $doctors = \App\Models\User::where('default_doctor', 1)->get();

        $users = DB::table('user_services')->select('user_id')->get();
        $nurses = [];
        $roles = Role::where('access_to', 'like', "%خدمات%")->select('id')->get();
        $user_roles = [];
        foreach ($users as $row) {
            array_push($nurses, $row->user_id);
        }

        foreach ($roles as $role) {
            array_push($user_roles, $role->id);
        }

        $nurses = User::whereIn('id', $nurses)->whereIn('role_id', $user_roles)->get();

        $name = $this->turn->patientName($id);
        $reception_id = $this->turn->turnReceptionId($id);
        $patient_id = $this->turn->receptionPatientId($reception_id);
        $insurance_id = $this->turn->patientInsuranceId($patient_id);
        $insurance_code = \App\Models\Patient::find($patient_id)->insurance_code;
        $services = $this->turn->services();

        return view('new.turn.form-future', compact('name', 'patient_id', 'services', 'id', 'insurances', 'insurance_code', 'insurance_id', 'doctors', 'nurses'));
    }

    public function countTurns()
    {
        if (request()->ajax()) {
            $data = request()->all();

            $date = \App\Helpers\ConvertDate::toGeorgian($data['date']);

            $turn_date = $date[0]."-".$date[1]."-".$date[2];

            $counter = \App\Models\Turn::where('turn_time', 'like', "%$turn_date%")->count();

            $count = \App\Helpers\ConvertNumber::convertToPersian($counter);

            if ($counter == 0) {
                $message = "نوبتی برای این روز درج نشده است.";
            } else {
                $message = $count." نوبت برای روز انتخابی شما درج شده است.";
            }

            return $message;
        }
    }

    public function receiveMoney($id)
    {
        $reception_id = \App\Models\Turn::find($id)->reception_id;
        $patient_id = Reception::find($reception_id)->patient_id;
        $insurance_id = Patient::find($patient_id)->insurance_id;

        if (request('service_id')) {
            $paid = DB::table('service_turn')
                            ->where('turn_id', $id)
                            ->where('service_id', request('service_id'))
                            ->first()
                            ->paid;
        
            if ($paid == 1) {
                DB::table('service_turn')
                            ->where('turn_id', $id)
                            ->where('service_id', request('service_id'))
                            ->update([
                                'paid' => 0
                            ]);
            } else {
                DB::table('service_turn')
                            ->where('turn_id', $id)
                            ->where('service_id', request('service_id'))
                            ->update([
                                'paid' => 1,
                                'receiver_id' => Session::get('user_id')
                            ]);
            }
        } else {
            $query = DB::table('service_turn')
                ->where('turn_id', $id)
                ->where('paid', 0)
                ->get();

            foreach ($query as $row) {
                DB::table('service_turn')
                            ->where('turn_id', $id)
                            ->where('service_id', $row->service_id)
                            ->update([
                                'paid' => 1,
                                'receiver_id' => Session::get('user_id')
                            ]);
            }
        }

        DB::table('service_turn')->whereNull('receiver_id')->where('paid', 1)->update([
            'receiver_id' => Session::get('user_id')
        ]);
        return redirect()->back();
    }

    public function therapist(Request $request, $id)
    {
        if (request()->method() == 'GET') {
            if ($request['action'] == 'send') {
                $name = $this->turn->patientName($id);
                if (\App\Models\Turn::where('id', $id)->first()->therapist == 0) {
                    return view('new.turn.therapist', compact('name', 'id'));
                } else {
                    \App\Models\Turn::where('id', $id)->update(['status' => 'روانشناس','therapist' => 1]);
                    return redirect('turns');
                }
            } else {
                \App\Models\Turn::where('id', $id)->update(['status' => 'فی انتظار','therapist' => 0]);
                \App\Models\Invoice::where('turn_id', $id)->update(['therapist' => 0]);
                return redirect()->back();
            }
        } else {
            \App\Models\Turn::where('id', $id)->update(['status' => 'روانشناس','therapist' => 1]);

            \App\Models\Invoice::where('turn_id', $id)->update(['therapist' => $request['therapist_fee']]);

            return redirect('turns');
        }
    }

    public function createClinic(Request $request)
    {
        $ins = $this->turn->insurancesArray();
        $today = $this->turn->today();
        $services = \App\Models\Service::where('status', 'فعال')->where('id', '!=', '1')->get();

        $query = "دکتر";
        
        $doctors = \App\Models\User::where('default_doctor', 1)->get();

        if ($request['patient']) {
            $id = $request['patient'];
            $patient_name = $this->turn->PatientNameById($id);
            $receptions = $this->turn->receptionsBypatientId($id);
            return view('new.turn.form', compact('today', 'services', 'ins', 'doctors', 'patient_name', 'receptions', 'id'));
        } else {
            return view('new.turn.form-clinic', compact('today', 'services', 'ins', 'doctors'));
        }
    }

    public function storeClinic(Request $request)
    {
        $g_date = \App\Helpers\ConvertDate::toGeorgian($request['date']);
        $turn_time = $g_date[0]."-".$g_date[1]."-".$g_date[2]." ".$request['time'];

        $query = \App\Models\Turn::create([
            'reception_id' => $request['reception_id'],
            'number' => 1,
            'status' => 'فی انتظار',
            'turn_time' => $turn_time
        ]);

        $patient_mobile = \App\Models\Patient::find(\App\Models\Reception::find($request['reception_id'])->patient_id)->mobile;

        // upload files
        if (!empty($request['files'])) {
            foreach ($request['files'] as $file) {
                if ($file != "" || $file != null) {
                    $imageName = str_random(10).time() .'.' . $file->getClientOriginalExtension();

                    $file->move('uploads', $imageName);

                    $file = $imageName;

                    \DB::table('file_patients')->insert([
                        'patient_id' => $id,
                        'file_url' => $file
                    ]);
                }
            }
        }

        // insert services

        $turn = \App\Models\Turn::find($query->id);
        foreach ($request['services'] as $key => $value) {
            \DB::table('service_turn')->insert([
                'turn_id' => $query->id,
                'service_id' => $value,
                'count' => $request['count_'.$value]
            ]);
        }

        // calculateInvoice

        $insurance_id = \App\Models\Turn::with('reception.patients')
                            ->find($query->id)
                            ->reception
                            ->patients[0]
                            ->insurance_id;

        $sum = 0;

        foreach ($request['services'] as $key => $value) {
            $tariff = \DB::table('insurance_service')
                        ->where('service_id', $value)
                        ->where('insurance_id', $insurance_id)
                        ->first()
                        ->tariff;

            $sum+= $tariff;
        }

        if ($request['discount'] == '') {
            $discount = 0;
        }
        \App\Models\Invoice::create([
            'turn_id' => $query->id,
            'amount' => $sum,
            'discount' => Number::convert($discount),
            'paid' => $request['money_received'],
            'created_at' => $turn_time
        ]);
        

        if ($turn_time > Carbon::today()->addDays(1)) {
            $date = explode("-", $request['date']);
            $date = $date[0]."/".$date[1]."/".$date[2];
            \App\Services\Sms::send($patient_mobile, Number::convertToPersian($date), Number::convertToPersian($time), '', 'بوعلی رامسر', "clinic");
        }

        return redirect('turns');
    }

    public function release($id)
    {
        \DB::table('service_turn')->where('id', $id)->update([
            'status' => 'انتهى'
        ]);

        return redirect('/');
    }

    public function invoiceDetails($turn_id)
    {
        $patient_name = $this->turn->PatientName($turn_id);
        if (request('service_id')) {
            $paid_services = \DB::table('service_turn')->where('service_id', request('service_id'))->where('id', request('service_turn_id'))->where('turn_id', $turn_id)->where('paid', 1)->get();
            $unpaid_services = \DB::table('service_turn')->where('service_id', request('service_id'))->where('id', request('service_turn_id'))->where('turn_id', $turn_id)->where('paid', 0)->get();
            $patient_id = \App\Models\Reception::find(\App\Models\Turn::find($turn_id)->reception_id)->patient_id;
            $patient_insurance_id = \App\Models\Patient::find($patient_id)->insurance_id;
        } else {
            $paid_services = \DB::table('service_turn')->where('turn_id', $turn_id)->where('paid', 1)->get();
            $unpaid_services = \DB::table('service_turn')->where('turn_id', $turn_id)->where('paid', 0)->get();
            $patient_id = \App\Models\Reception::find(\App\Models\Turn::find($turn_id)->reception_id)->patient_id;
            $patient_insurance_id = \App\Models\Patient::find($patient_id)->insurance_id;
        }

        $settings = Setting::first();

        return view('new.turn.invoice-details', compact('turn_id', 'paid_services', 'patient_name', 'patient_insurance_id', 'unpaid_services', 'settings'));
    }

    public function previousTurns(Request $request)
    {
        $now = Carbon::now()->subHours(6);
        $now_ex = explode(" ", $now);
        $today = $now_ex[0];

        $jalali_date = $request['date'];

        $date = Date::toGeorgian($jalali_date);
        $date = $date[0]."-".$date[1]."-".$date[2];

        $query = \App\Models\Turn::with('reception.patients')
            ->where('turn_time', 'like', "$date%")
            ->orderByRaw("FIELD(status, \"داخل مطب\", \"فی انتظار\", \"انتهى\")")
            ->orderBy('turn_time', 'desc')
            ->get();

        return view('new.turn.index', compact('query', 'jalali_date'));
    }

    public function calculateServices()
    {
        $data = request()->all();
        $insurance_id = Patient::find($data['patient'])->insurance_id;
        $price = 0;
        $i=0;
        $j=0;
        foreach ($data['q'] as $key) {
            $tariff = DB::table('insurance_service')->where('insurance_id', $insurance_id)->where('service_id', $key)->first();
            if (!is_null($tariff)) {
                $price+=($tariff->tariff*$data['count'][$i]);
            }
            $i+=1;
        }
        if (isset($data['drugs'])) {
            foreach ($data['drugs'] as $row) {
                $tariff = DrugStorage::where('id', $row)->first();
                if (!is_null($tariff)) {
                    $price+=($tariff->price*$data['count_drugs'][$j]);
                }
                $j+=1;
            }
        }
        return ' '.Number::convertToPersian(number_format($price)).' دینار';
    }

    public function updateStatus()
    {
        $data = request()->all();
        $now = \Carbon\Carbon::now();



        $turns = $data['page'] - 1;
        $name = $data['name'];
        $query = $this->turn->todayTurns($turns*10, $name);
        $string = '';
        $i=1;
        $confirm = "return confirm('هل أنت واثق؟؟')";
        foreach ($query as $row) {
            if ($row->reception->patients[0]->gender == 'male') {
                $image = 'male.png';
            } else {
                $image = 'female.png';
            }
            $servers = DB::table('service_turn')->where('turn_id', $row->id)->get();
            $nurses = [];


            $service_statuses = '<div class="span-td"><span>';

            $brs='';


            foreach ($servers as $key) {
                array_push($nurses, $key->user_id);
            }

            foreach (User::whereIn('id', $nurses)->get() as $user) {
                $service = DB::table('service_turn')->where('user_id', $user->id)->where('turn_id', $row->id)->get();
                foreach ($service as $s) {
                    $service_id = $s->service_id;
                    $service_status = $s->status;
                    $brs.='';
                    array_push($nurses, $key->user_id);
                
                    if ($service_status == 'فی انتظار' || $service_status == 'عيادة') {
                        $service_statuses.= '<button class="btn ';
                        if ($service_status == 'فی انتظار') {
                            $service_statuses.= 'btn-info';
                        } else {
                            $service_statuses.= 'btn-dark';
                        }
                        $service_statuses.='" >'.$service_status.'</button>';
                        if ($row->doctor_id > 0) {
                            $service_statuses.=' <a href="'.url('turns/toggle').'/'.$row->id.'?service_id='.$service_id.'" style="color: white;" class="btn btn-success ';
                            if (\DB::table('service_turn')->where('turn_id', $row->id)->where('service_id', $service_id)->where('paid', 0)->count() > 0) {
                                $service_statuses.= 'disabled ';
                            }
                            $service_statuses.= '" title="ارجاع به داخل مطب"><i class="fa fa-arrow-left"></i></a> ';
                        } else {
                            $service_statuses.= '<a href="'.url('patients').'/'.$row->id.'/to-therapist" style="color: white;" class="btn btn-success ';
                            if (\DB::table('service_turn')->where('turn_id', $row->id)->where('service_id', $service_id)->where('paid', 0)->count() > 0) {
                                $service_statuses.= 'disabled ';
                            }
                            $service_statuses.='" title="ارجاع به خدمات کلینیکی"><i class="fa fa-arrow-left"></i></a> ';
                        }
                    } elseif ($service_status == 'انتهى') {
                        $confirm = "return confirm('العودة إلى قائمة الانتظار؟')";
                        $service_statuses.= '<button class="btn btn-danger">'.$service_status.'</button>
                                           ';
                    } else {
                        $service_statuses.= '<button class="btn btn-dark">'.$service_status.'</button>';
                    }
                    $service_statuses.='</span></div><div class="span-td"><span>';
                }
            }
            $nurse_names = '<div class="span-td"><span>';
            $service_names = '<div class="span-td"><span>';
                
            $service_statuses = rtrim($service_statuses, '<div class="span-td"><span>');



            foreach (User::whereIn('id', $nurses)->get() as $user) {
                $service = DB::table('service_turn')->where('user_id', $user->id)->where('turn_id', $row->id)->get();

                foreach ($service as $s) {
                    $service_name = Service::find($s->service_id)->name;
                
                    $nurse_names.=Role::find($user->role_id)->title.'  '.$user->name.'</span></div><div class="span-td"><span>';
                    $service_names.=$service_name.'</span></div><div class="span-td"><span>';
                }
            }

            $service_names = rtrim($service_names, '<div class="span-td"><span>');
            $nurse_names = rtrim($nurse_names, '<div class="span-td"><span>');

            $service_id = \DB::table('service_turn')->where('turn_id', $row->id)->first()->service_id;
            $service_name = Service::find($service_id)->name;

            $string.= '<tr align="center">
                        <td>
                            '.$i++.'
                        </td>
                        <td>'.$row->reception->patients[0]->name.'
                        </td>
                        <td>
                        <img style="max-width:50px;" src="'.url('new/assets/images/'.$image).'"
                        </td>
                        <td>'.$nurse_names.'</td>
                        <td>'.$service_names.'</td>
                        <td>';
            $string.=$service_statuses;
            $string.= '</td>

                        <td>';
            foreach (User::whereIn('id', $nurses)->get() as $user) {
                $service = DB::table('service_turn')->where('user_id', $user->id)->where('turn_id', $row->id)->get();

                foreach ($service as $s) {
                    if (\DB::table('service_turn')->where('turn_id', $row->id)->where('service_id', $s->service_id)->where('paid', 0)->count() == 0) {
                        if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 30)->count() == 1) {
                            $string.=' <div class="span-td"><span><a href="turns" onclick="'.$confirm.'" class="btn btn-success"><i class="fa fa-check-circle"></i></a> ';
                        }
                    } else {
                        if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 30)->count() == 1) {
                            $string.= ' <div class="span-td"><span><a href="'.url('turns/'.$row->id.'/money?service_id='.$s->service_id).'" onclick="'.$confirm.'" class="btn btn-danger"><i class="fa fa-times-circle"></i></a> ';
                        }
                    }
                    $open = "window.open('".url('turns/'.$row->id.'/invoice-details?service_id='.$s->service_id)."&service_turn_id=".$s->id."',null,'height=700,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no');";
                    if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 30)->count() == 1) {
                        $string.=' <button class="btn btn-success" onclick="'.$open.'" style="background-color: purple !important;">$</button></span></div>';
                    } else {
                        $string.=' <div class="span-td"><span><button class="btn btn-success" onclick="'.$open.'" style="background-color: purple !important;">$</button></span></div>';
                    }
                }
            }
            $open = "window.open('".url('turns/'.$row->id.'/invoice-details')."',null,'height=700,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no');";
            $string.='
                        </td>
                        <td>';
            $string.='    
                        <button class="btn btn-dark" onclick="'.$open.'">صورتحساب</buttton>
                        ';
            $string.='</td>
                            <td>';

            foreach (User::whereIn('id', $nurses)->get() as $user) {
                $service = DB::table('service_turn')->where('user_id', $user->id)->where('turn_id', $row->id)->get();

                foreach ($service as $s) {
                    $reception_id = \App\Models\Turn::find($s->turn_id)->reception_id;

                    $future_turns = \App\Models\Turn::where('reception_id', $reception_id)->where('turn_time', '>', $now)->get();

                    $turn_ids = [];

                    foreach ($future_turns as $turn) {
                        array_push($turn_ids, $turn->id);
                    }

                    $count = DB::table('service_turn')
                                ->whereIn('turn_id', $turn_ids)
                                ->where('service_id', $s->service_id)
                                ->count();

                    $previous_turns = \App\Models\Turn::where('reception_id', $reception_id)->where('turn_time', '<', $now)->get();

                    $previous_turn_ids = [];

                    foreach ($previous_turns as $p_turn) {
                        array_push($previous_turn_ids, $p_turn->id);
                    }

                    $p_count = DB::table('service_turn')
                                ->whereIn('turn_id', $previous_turn_ids)
                                ->where('service_id', $s->service_id)
                                ->where('debt', '>', 0);
                                

                    if ($p_count->count() > 0 && \DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 58)->count() == 1) {
                        $debt = $p_count->sum('debt');
                        $p_debt = Number::convertToPersian(number_format($debt));
                        $open = "return confirm('در حال تسویه بدهی به مبلغ ".$p_debt." دینار هستید. آیا مطمئنید؟')";
                        $debt_button = '<a style="color: white;" href="'.url('turns/receive-debt/'.$s->id).'" class="btn btn-primary" onclick="'.$open.'" type="button">دریافت بدهی</a>';
                    } else {
                        $debt = 0;
                        $debt_button = '';
                    }
                                 

                    if ($count > 0) {
                        $count = Number::convertToPersian($count);
                              
                        $count = '('.$count.')';
                    } else {
                        $count = '';
                    }


                    if ($s->discount == 0) {
                        $discount_button = '';
                    } else {
                        if ($s->discount > 0) {
                            $discount_button = '<button class="btn btn-primary" type="button">تخفیف</button>';
                        } else {
                            $discount_button = '<button class="btn btn-primary" type="button">افزایش مبلغ</button>';
                        }
                    }

                    $string.=\Form::open(['method'  => 'DELETE', 'route' => ['turns.destroy', $row->id]]);
                    if (PatientSuggestion::where('service_turn_id', $s->id)->count() > 0) {
                        $open = "window.open('".url('turns/suggestion/'.$s->id)."',null,'height=700,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no');";
                        $suggestion = '<button type="button" class="btn btn-brand" onclick="'.$open.'">پیشنهاد</button>';
                    } else {
                        $suggestion = '';
                    }
                    if ($row->status != 'انتهى') {
                        $string.='<div class="span-td"><span>'.' '.$debt_button.' '.$suggestion.' '.$discount_button.' <a class="btn btn-success" href="'.url('turns').'/'.$row->id.'/edit">ویرایش <i class="fa fa-edit"></i></a>';
                        $string.=' <a class="btn btn-warning" href="'.url('turns/create?patient='.$row->reception->patients[0]->id).'&service_id='.$s->service_id.'&user_id='.$user->id.'&count='.$s->count.'">نوبت آینده '.$count.'<i class="fa fa-history"></i></a> </span></div>';
                    } else {
                        $string.=' <div class="span-td"><span><a class="btn btn-warning" href="'.url('turns/create?patient='.$row->reception->patients[0]->id).'&service_id='.$s->service_id.'&user_id='.$user->id.'&count='.$s->count.'">نوبت آینده '.$count.'<i class="fa fa-history"></i></a>';
                    }
                                    
                    if ($row->status == 'فی انتظار' && \DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 32)->count() == 1) {
                        $string = rtrim($string, '</span></div>');
                        $confirm = "return confirm('آیا از لغو نوبت مطمئنید؟')";
                        $string.= ' <a href="'.url('turns/delete'.'/'.$s->id).'" onclick="'.$confirm.'" class="btn btn-danger">لغو نوبت <i class="fa fa-trash"></i></a></span></div> ';
                        $patient_id = \App\Models\Reception::find($row->reception_id)->patient_id;
                        $query = \DB::table('turns')
                                                    ->join('receptions', 'turns.reception_id', '=', 'receptions.id')
                                                    ->join('patients', 'receptions.patient_id', '=', 'patients.id')
                                                    ->where('patients.id', $patient_id)
                                                    ->where('turns.turn_time', '>', \Carbon\Carbon::tomorrow())
                                                    ->select('turns.id');
                    }
                    $string.=\Form::close();
                }
            }
            
            $string.='</td></tr>';
        }
        return $string;
    }

    public function discount(Request $request, $service_turn_id)
    {
        if ($request['discount'] >= 0) {
            if ($request['submit'] == 'اعمال تخفیف') {
                DB::table('service_turn')->where('id', $service_turn_id)->update([
                    'discount' => Number::convert($request['discount'])
                ]);
            } else {
                DB::table('service_turn')->where('id', $service_turn_id)->update([
                    'discount' => Number::convert($request['discount']*(-1))
                ]);
            }
        }

        return redirect()->back();
    }

    public function userServices()
    {
        $data = request()->all();
        $query = DB::table('user_services')->where('service_id', $data['service'])->get();

        $users = [];

        foreach ($query as $row) {
            array_push($users, $row->user_id);
        }

        $users = User::whereIn('id', $users)->get();

        $string = '';

        foreach ($users as $row) {
            $string.='<option value"'.$row->id.'">'.$row->name.'</option>';
        }

        return $string;
    }

    public function clinic($service_turn_id)
    {
        $turn_id = DB::table('service_turn')->where('id', $service_turn_id)->first()->turn_id;
        $reception_id = \App\Models\Turn::find($turn_id)->reception_id;
        $patient_id = Reception::find($reception_id)->patient_id;

        $query = \App\Models\Turn::where('reception_id', $reception_id)->get();

        $arr = [];
        foreach ($query as $row) {
            array_push($arr, $row->id);
        }

        $answers_collection = \App\Models\Turn::whereIn('id', $arr)->whereNotNull('answers')->get();
        $answers_collection_2 = \App\Models\Patient::find($patient_id)->answers;

        $newquery = DB::table('service_turn')->whereIn('turn_id', $arr)->get();
        $newarr = [];

        foreach ($newquery as $row) {
            array_push($newarr, $row->id);
        }

        $patient = Patient::find($patient_id);
        $query1 = Reception::with(['patients'])->find($reception_id);
        $service_id = DB::table('service_turn')->where('id', $service_turn_id)->first()->service_id;

        $turn_count           = \App\Models\Turn::where('reception_id', $reception_id)->count();
        $reception_count      = Reception::where('patient_id', $patient->id)->count();
        $paid_services        = \DB::table('service_turn')->where('turn_id', $turn_id)->where('id', $service_turn_id)->where('paid', 1)->get();
        $unpaid_services      = \DB::table('service_turn')->where('turn_id', $turn_id)->where('id', $service_turn_id)->where('paid', 0)->get();
        $patient_insurance_id = \App\Models\Patient::find($patient->id)->insurance_id;

        $descriptions = NurseDescription::where('service_turn_id', $service_turn_id);

        $medicines = Medicine::orderBy('id', 'desc')->get();
        $iranian_drugs = DB::table('iranian_drugs')->get();
        $diagnoses = Diagnosis::whereIn('service_turn_id', $newarr);
        $newdiagnoses = Diagnosis::whereIn('service_turn_id', $newarr)->orderBy('id', 'desc')->withTrashed();
        $perceptions = MedicinePatient::where('service_turn_id', $service_turn_id);
        $discount = DB::table('service_turn')->where('id', $service_turn_id)->first()->discount;

        $services = Service::orderBy('name', 'asc')->get();

        $service_turn_ids = [];

        $query = DB::table('service_turn')->where('turn_id', $turn_id)->get();
        foreach ($query as $row) {
            array_push($service_turn_ids, $row->id);
        }
        $files = DB::table('file_patients')->where('patient_id', $patient_id);
        $descriptions = NurseDescription::whereIn('service_turn_id', $service_turn_ids);
        $nurse_descriptions = NurseDescription::whereIn('service_turn_id', $service_turn_ids)->whereNotNull('file_url');

        if (Session::get('role') != 6) {
            return view('new.turn.clinic', compact('turn_id', 'reception_id', 'patient', 'turn_count', 'reception_count', 'paid_services', 'unpaid_services', 'patient_insurance_id', 'query', 'service_id', 'service_turn_id', 'descriptions', 'files', 'services', 'descriptions', 'query1', 'newdiagnoses', 'nurse_descriptions'));
        } else {
            return view('new.reception.show', compact('turn_id', 'reception_id', 'patient', 'turn_count', 'reception_count', 'paid_services', 'unpaid_services', 'patient_insurance_id', 'query', 'service_id', 'service_turn_id', 'descriptions', 'medicines', 'diagnoses', 'perceptions', 'discount', 'services', 'files', 'iranian_drugs', 'descriptions', 'query1', 'answers_collection', 'answers_collection_2', 'newdiagnoses', 'nurse_descriptions'));
        }
    }

    public function editClinic($id)
    {
        $service_turn_id = Diagnosis::find($id)->service_turn_id;
        $turn_id = DB::table('service_turn')->where('id', $service_turn_id)->first()->turn_id;
        $reception_id = \App\Models\Turn::find($turn_id)->reception_id;
        $patient_id = Reception::find($reception_id)->patient_id;
        $patient = Patient::find($patient_id);
        $query = Reception::with(['patients'])->find($reception_id);
        $service_id = DB::table('service_turn')->where('id', $service_turn_id)->first()->service_id;

        $turn_count           = \App\Models\Turn::where('reception_id', $reception_id)->count();
        $reception_count      = Reception::where('patient_id', $patient->id)->count();
        $paid_services        = \DB::table('service_turn')->where('turn_id', $turn_id)->where('id', $service_turn_id)->where('paid', 1)->get();
        $unpaid_services      = \DB::table('service_turn')->where('turn_id', $turn_id)->where('id', $service_turn_id)->where('paid', 0)->get();
        $patient_insurance_id = \App\Models\Patient::find($patient->id)->insurance_id;

        $descriptions = NurseDescription::where('service_turn_id', $service_turn_id);

        $medicines = DB::table('iranian_drugs')->get();
        $diagnoses = Diagnosis::find($id);
        $perceptions = MedicinePatient::where('service_turn_id', $service_turn_id);
        $discount = DB::table('service_turn')->where('id', $service_turn_id)->first()->discount;

        $services = Service::orderBy('name', 'asc')->get();

        return view('new.reception.diagnosis-edit', compact('turn_id', 'reception_id', 'patient', 'turn_count', 'reception_count', 'paid_services', 'unpaid_services', 'patient_insurance_id', 'query', 'service_id', 'service_turn_id', 'descriptions', 'medicines', 'diagnoses', 'perceptions', 'discount', 'services', 'id'));
    }

    public function submitDescription(Request $request)
    {
        $perception = $request->get('perception');
        $perception = str_replace("\r\n", "", $perception);
        if (Session::get('role') != 6) {
            $query = NurseDescription::create([
                            'nurse_id' => Session::get('user_id'),
                            'service_turn_id' => $request['service_turn_id'],
                            'description' => $request['description']
                        ]);
            $file = $request['file'];
            if ($file != "" || $file != null) {
                $imageName = str_random(10).time() .'.' . $file->getClientOriginalExtension();
                $file->move('uploads', $imageName);
                NurseDescription::where('id', $query->id)->update([
                    'file_url' => $imageName
                ]);
            }
        } else {
            if ($request['cause'] == '') {
                $cause= ' ';
            } else {
                $cause = $request['cause'];
            }

            $string = '<strong>سبب الارجاع:</strong>'.$cause.'<br><strong>تشخیص اولیه: </strong>'.$request['detection'].'<br><strong>پیشنهاد پزشک: </strong>'.$request['suggestion'].'تشخیص پزشک: '.$perception.'آزمایش: </strong>'.$request['test'];

            $turn_id = DB::table('service_turn')->where('id', $request['service_turn_id'])->first()->turn_id;

            $reception_id = \App\Models\Turn::find($turn_id)->reception_id;
            $query = \App\Models\Turn::where('reception_id', $reception_id)->get();

            $turns_arr = [];

            foreach ($query as $row) {
                array_push($turns_arr, $row->id);
            }

            $query_2 = DB::table('service_turn')->whereIn('turn_id', $turns_arr)->get();

            $service_turn_arr = [];

            foreach ($query_2 as $row) {
                array_push($service_turn_arr, $row->id);
            }

            Diagnosis::whereIn('service_turn_id', $service_turn_arr)->delete();

            Diagnosis::create([
                'service_turn_id' => $request['service_turn_id'],
                'cause' => nl2br($cause),
                'diagnosis' => nl2br($string),
                'editor' => Session::get('name')
            ]);

            FileReception::create([
                'type' => 2,
                'service_turn_id' => $request['service_turn_id'],
                'description' => nl2br($request['diagnosis'])
            ]);
        }
        
        return redirect()->back();
    }

    public function updateDescription(Request $request)
    {
        if ($request['cause'] == '') {
            $cause= ' ';
        } else {
            $cause = $request['cause'];
        }

        $string = '<strong>سبب الارجاع:</strong>'.$cause.'<br><strong>تشخیص اولیه: </strong>'.$request['detection'].'<br><strong>پیشنهاد پزشک: </strong>'.$request['suggestion'].'<br><strong>تشخیص پزشک: </strong>'.$request['perception'].'<br><strong>آزمایش: </strong>'.$request['test'];
        Diagnosis::where('id', request('id'))->update([
                'cause' => nl2br($cause),
                'diagnosis' => nl2br($string),
                'editor' => Session::get('name')
            ]);
        
        return redirect('turns/clinic/'.$request['service_turn_id']);
    }

    public function addSuggestion()
    {
        $data = request()->all();

        $service_turn_id = $data['id'];
        $service = $data['service'];
        $count = $data['service_count'];
        $type = $data['service_type'];
        $desc = $data['service_desc'];

        $query = PatientSuggestion::create([
            'service_turn_id' => $service_turn_id,
            'service' => $service,
            'count' => $count,
            'type' => $type,
            'description' => $desc,
            'user_id' => Session::get('user_id')
        ]);

        return $query->id;
    }

    public function suggestion($id)
    {
        $turn_id = DB::table('service_turn')->where('id', $id)->first()->turn_id;
        $patient_name = \App\Models\Turn::with('reception.patients')
                            ->find($turn_id)
                            ->reception
                            ->patients[0]
                            ->name;
        $suggestions = PatientSuggestion::where('service_turn_id', $id)->get();
        return view('new.turn.suggestion', compact('suggestions', 'patient_name'));
    }

    public function serviceDiscount()
    {
        $data = request()->all();
        $discount = str_replace(",", "", $data['discount']);
        $debt = str_replace(",", "", $data['debt']);
        

        $old_discount = DB::table('service_turn')->where('id', $data['service_turn_id'])->first()->discount;



        DB::table('service_turn')->where('id', $data['service_turn_id'])->update([
            'discount' => Number::convert($discount),
            'description' => $data['description'],
            'debt' => Number::convert($debt)
        ]);



        $discount = Number::convert($discount);
    }
    public function printFile($service_turn_id)
    {
        $turn_id = DB::table('service_turn')->where('id', $service_turn_id)->first()->turn_id;
        $reception_id = \App\Models\Turn::find($turn_id)->reception_id;
        $patient_id = Reception::find($reception_id)->patient_id;
        $patient = Patient::find($patient_id);
        $diagnoses = Diagnosis::where('service_turn_id', $service_turn_id)->get();
        return view('new.turn.print', compact('diagnoses', 'patient'));
    }

    public function addMedicines()
    {
        $data = request()->all();

        $service_turn_id = $data['id'];
        $name = $data['name'];
        $dose = $data['dose'];
        $description = $data['desc'];

        $message = 'ok';
        
        MedicinePatient::create([
            'service_turn_id' => $service_turn_id,
            'name' => $name,
            'dose' => $dose,
            'description' => $description
        ]);

        return $message;
    }

    public function deleteSuggestion()
    {
        $data = request()->all();
        $id = explode("_", $data['id']);
        PatientSuggestion::find($id[1])->delete();
        return 'row_'.$id[1];
    }

    public function showFuture($date)
    {
        return view('new.turn.show-future', compact('date'));
    }

    public function futureStatus()
    {
        $data = request()->all();
        $now = \Carbon\Carbon::now();


        $date = $data['date'];
        $turns = $data['page'] - 1;
        $name = $data['name'];
        $ajax_user_id = $data['user'];

        if (strlen($data['service']) > 0) {
            $all_services_arr = [$data['service']];
        } else {
            $all_services = Service::all();
            $all_services_arr = [];

            foreach ($all_services as $row) {
                array_push($all_services_arr, $row->id);
            }
        }

        if (strlen($data['user']) > 0) {
            $all_users_arr = [$data['user']];
        } else {
            $all_users = User::all();
            $all_users_arr = [];

            foreach ($all_users as $row) {
                array_push($all_users_arr, $row->id);
            }
        }

        $filtered_turns = DB::table('service_turn')
                        ->whereIn('service_id', $all_services_arr)
                        ->whereIn('user_id', $all_users_arr)
                        ->get();

        $filtered_turns_arr = [];
        
        foreach ($filtered_turns as $f) {
            array_push($filtered_turns_arr, $f->turn_id);
        }

        $query = $this->turn->showFutureTurns($turns*10, $name, $date, $filtered_turns_arr);
        $string = '';
        $i=1;
        $confirm = "return confirm('هل أنت واثق؟؟')";
        foreach ($query as $row) {
            if ($row->reception->patients[0]->gender == 'male') {
                $image = 'male.png';
            } else {
                $image = 'female.png';
            }
            $servers = DB::table('service_turn')
                        ->where('turn_id', $row->id)
                        ->whereIn('service_id', $all_services_arr)
                        ->whereIn('user_id', $all_users_arr)
                        ->get();
            
            $nurses = [];


            $service_statuses = '<div class="span-td"><span>';

            $brs='';


            foreach ($servers as $key) {
                array_push($nurses, $key->user_id);
            }

            foreach (User::whereIn('id', $nurses)->get() as $user) {
                $service = DB::table('service_turn')->where('user_id', $user->id)->where('turn_id', $row->id)->get();
                foreach ($service as $s) {
                    $service_id = $s->service_id;
                    $service_status = $s->status;
                    $brs.='';
                    array_push($nurses, $key->user_id);
                
                    if ($service_status == 'فی انتظار' || $service_status == 'عيادة') {
                        $service_statuses.= '<button class="btn ';
                        if ($service_status == 'فی انتظار') {
                            $service_statuses.= 'btn-info';
                        } else {
                            $service_statuses.= 'btn-dark';
                        }
                        $service_statuses.='" >'.$service_status.'</button>';
                        if ($row->doctor_id > 0) {
                            $service_statuses.=' <a href="'.url('turns/toggle').'/'.$row->id.'?service_id='.$service_id.'" style="color: white;" class="btn btn-success ';
                            if (\DB::table('service_turn')->where('turn_id', $row->id)->where('service_id', $service_id)->where('paid', 0)->count() > 0) {
                                $service_statuses.= 'disabled ';
                            }
                            $service_statuses.= '" title="ارجاع به داخل مطب"><i class="fa fa-arrow-left"></i></a> ';
                        } else {
                            $service_statuses.= '<a href="'.url('patients').'/'.$row->id.'/to-therapist" style="color: white;" class="btn btn-success ';
                            if (\DB::table('service_turn')->where('turn_id', $row->id)->where('service_id', $service_id)->where('paid', 0)->count() > 0) {
                                $service_statuses.= 'disabled ';
                            }
                            $service_statuses.='" title="ارجاع به خدمات کلینیکی"><i class="fa fa-arrow-left"></i></a> ';
                        }
                    } elseif ($service_status == 'انتهى') {
                        $confirm = "return confirm('بازگشت به لیست انتظار؟')";
                        $service_statuses.= '<button class="btn btn-danger">'.$service_status.'</button>
                                           ';
                    } else {
                        $service_statuses.= '<button class="btn btn-dark">'.$service_status.'</button>';
                    }
                    $service_statuses.='</span></div><div class="span-td"><span>';
                }
            }
            $nurse_names = '<div class="span-td"><span>';
            $service_names = '<div class="span-td"><span>';
                
            $service_statuses = rtrim($service_statuses, '<div class="span-td"><span>');



            foreach (User::whereIn('id', $nurses)->get() as $user) {
                $service = DB::table('service_turn')->where('user_id', $user->id)->where('turn_id', $row->id)->get();

                foreach ($service as $s) {
                    $service_name = Service::find($s->service_id)->name;
                
                    $nurse_names.=Role::find($user->role_id)->title.'  '.$user->name.'</span></div><div class="span-td"><span>';
                    $service_names.=$service_name.'</span></div><div class="span-td"><span>';
                }
            }

            $service_names = rtrim($service_names, '<div class="span-td"><span>');
            $nurse_names = rtrim($nurse_names, '<div class="span-td"><span>');

            $service_id = \DB::table('service_turn')->where('turn_id', $row->id)->first()->service_id;
            $service_name = Service::find($service_id)->name;

            $string.= '<tr align="center">
                        <td>
                            '.$i++.'
                        </td>
                        <td>'.$row->reception->patients[0]->name.'
                        </td>
                        <td>
                        <img style="max-width:50px;" src="'.url('new/assets/images/'.$image).'"
                        </td>
                        <td>'.$nurse_names.'</td>
                        <td>'.$service_names.'</td>
                        <td>';
            $turn_time = \App\Models\Turn::find($row->id)->turn_time;
            $turn_time = explode(" ", $turn_time);
            $time = explode(":", $turn_time[1]);
            $string.= $time[0].":".$time[1];
            $string.= '</td>

                        <td>';
            foreach (User::whereIn('id', $nurses)->get() as $user) {
                $service = DB::table('service_turn')->where('user_id', $user->id)->where('turn_id', $row->id)->get();

                foreach ($service as $s) {
                    if (\DB::table('service_turn')->where('turn_id', $row->id)->where('service_id', $s->service_id)->where('paid', 0)->count() == 0) {
                        if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 30)->count() == 1) {
                            if ($date > Carbon::today()) {
                                $string.=' <div class="span-td"><span><a href="turns" onclick="'.$confirm.'" class="btn btn-success"><i class="fa fa-check-circle"></i></a> ';
                            } else {
                                $string.=' <div class="span-td"><span><a style="" href="turns" onclick="'.$confirm.'" class="btn btn-success"><i class="fa fa-check-circle"></i></a> ';
                            }
                        }
                    } else {
                        if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 30)->count() == 1) {
                            $string.= ' <div class="span-td"><span><a href="'.url('turns/'.$row->id.'/money?service_id='.$s->service_id).'" onclick="'.$confirm.'" class="btn btn-danger"><i class="fa fa-times-circle"></i></a> ';
                        }
                    }
                    $open = "window.open('".url('turns/'.$row->id.'/invoice-details?service_id='.$s->service_id)."&service_turn_id=".$s->id."',null,'height=700,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no');";
                    if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 30)->count() == 1) {
                        $string.=' <button class="btn btn-success" onclick="'.$open.'" style="background-color: purple !important;">$</button></span></div>';
                    } else {
                        $string.=' <div class="span-td"><span><button class="btn btn-success" onclick="'.$open.'" style="background-color: purple !important;">$</button></span></div>';
                    }
                }
            }
            $open = "window.open('".url('turns/'.$row->id.'/invoice-details')."',null,'height=700,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no');";
            $string.='
                        </td>
                        <td>';
            $string.='    
                        <button class="btn btn-dark" onclick="'.$open.'">صورتحساب</buttton>
                        ';
            $string.='</td>';
            if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 55)->count() == 1 && $row->turn_time < date("Y-m-d 00:00:00")) {
                $string.='<td>';
            } else {
                $string.='<td style="">';
            }

            foreach (User::whereIn('id', $nurses)->get() as $user) {
                $service = DB::table('service_turn')->where('user_id', $user->id)->where('turn_id', $row->id)->get();

                foreach ($service as $s) {
                    $reception_id = \App\Models\Turn::find($s->turn_id)->reception_id;

                    $future_turns = \App\Models\Turn::where('reception_id', $reception_id)->where('turn_time', '>', $now)->get();

                    $turn_ids = [];

                    foreach ($future_turns as $turn) {
                        array_push($turn_ids, $turn->id);
                    }

                    $count = DB::table('service_turn')
                                ->whereIn('turn_id', $turn_ids)
                                ->where('service_id', $s->service_id)
                                ->count();

                    if ($count > 0) {
                        $count = Number::convertToPersian($count);
                              
                        $count = '('.$count.')';
                    } else {
                        $count = '';
                    }


                    if ($s->discount == 0) {
                        $discount_button = '';
                    } else {
                        if ($s->discount > 0) {
                            $discount_button = '<button class="btn btn-primary" type="button">تخفیف</button>';
                        } else {
                            $discount_button = '<button class="btn btn-primary" type="button">افزایش مبلغ</button>';
                        }
                    }

                    $string.=\Form::open(['method'  => 'DELETE', 'route' => ['turns.destroy', $row->id]]);
                    if (PatientSuggestion::where('service_turn_id', $s->id)->count() > 0) {
                        $open = "window.open('".url('turns/suggestion/'.$s->id)."',null,'height=700,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no');";
                        $suggestion = '<button type="button" class="btn btn-brand" onclick="'.$open.'">پیشنهاد</button>';
                    } else {
                        $suggestion = '';
                    }
                    if ($row->status != 'انتهى') {
                        $string.='<div class="span-td"><span>'.$suggestion.' '.$discount_button.' <a class="btn btn-success" href="'.url('turns').'/'.$row->id.'/edit">ویرایش <i class="fa fa-edit"></i></a>';
                        $string.=' <a class="btn btn-warning" href="'.url('turns/create?patient='.$row->reception->patients[0]->id).'&service_id='.$s->service_id.'&user_id='.$user->id.'&count='.$s->count.'">نوبت آینده '.$count.'<i class="fa fa-history"></i></a> </span></div>';
                    } else {
                        $string.=' <div class="span-td"><span><a class="btn btn-warning" href="'.url('turns/create?patient='.$row->reception->patients[0]->id).'&service_id='.$s->service_id.'&user_id='.$user->id.'&count='.$s->count.'">نوبت آینده '.$count.'<i class="fa fa-history"></i></a>';
                    }
                                    
                    if ($row->status == 'فی انتظار' && \DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 55)->count() == 1 && $row->turn_time > date("Y-m-d 23:59:59")) {
                        $string = rtrim($string, '</span></div>');
                        $confirm = "return confirm('آیا از لغو نوبت مطمئنید؟')";
                        $string.= ' <a href="'.url('turns/delete'.'/'.$s->id).'" onclick="'.$confirm.'" class="btn btn-danger">لغو نوبت <i class="fa fa-trash"></i></a></span></div> ';
                        $patient_id = \App\Models\Reception::find($row->reception_id)->patient_id;
                        $query = \DB::table('turns')
                                                    ->join('receptions', 'turns.reception_id', '=', 'receptions.id')
                                                    ->join('patients', 'receptions.patient_id', '=', 'patients.id')
                                                    ->where('patients.id', $patient_id)
                                                    ->where('turns.turn_time', '>', \Carbon\Carbon::tomorrow())
                                                    ->select('turns.id');
                    }

                    if ($row->status == 'فی انتظار' && \DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 55)->count() == 1 && $row->turn_time < date("Y-m-d 00:00:00")) {
                        $string = rtrim($string, '</span></div>');
                        $confirm = "return confirm('آیا از لغو نوبت مطمئنید؟')";
                        $string.= ' <a href="'.url('turns/delete'.'/'.$s->id).'" onclick="'.$confirm.'" class="btn btn-danger">لغو نوبت <i class="fa fa-trash"></i></a></span></div> ';
                        $patient_id = \App\Models\Reception::find($row->reception_id)->patient_id;
                        $query = \DB::table('turns')
                                                    ->join('receptions', 'turns.reception_id', '=', 'receptions.id')
                                                    ->join('patients', 'receptions.patient_id', '=', 'patients.id')
                                                    ->where('patients.id', $patient_id)
                                                    ->where('turns.turn_time', '>', \Carbon\Carbon::tomorrow())
                                                    ->select('turns.id');
                    }
                    $string.=\Form::close();
                }
            }
            
            $string.='</td></tr>';
        }
        return $string;
    }

    public function iran()
    {
        $query = DB::table('insurance_service')->where('tariff', '')->get();
        foreach ($query as $row) {
            $service_id = $row->service_id;
            $tariff = DB::table('insurance_service')->where('service_id', $service_id)->first()->tariff;

            DB::table('insurance_service')->where('id', $row->id)->update([
                'tariff' => $tariff
            ]);
        }
    }

    public function receiveDebt($id)
    {
        $turn_id = DB::table('service_turn')->where('id', $id)->first()->turn_id;
        $reception_id = \App\Models\Turn::find($turn_id)->reception_id;

        $turns = \App\Models\Turn::where('reception_id', $reception_id)->get();

        $turn_ids = [];

        foreach ($turns as $turn) {
            array_push($turn_ids, $turn->id);
        }

        DB::table('service_turn')->whereIn('turn_id', $turn_ids)->update([
            'debt' => 0,
            'debt_received_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back();
    }

    public function receiveSingleDebt($id)
    {
        if (request('amount')) {
            $amount = str_replace(',', "", request('amount'));
            $amount = ConvertNumber::convert($amount);

            $debt = DB::table('service_turn')->where('id', $id)->first()->debt;
            $received_debt_amount = DB::table('service_turn')->where('id', $id)->first()->received_debt_amount;
            if ($amount > $debt) {
                return redirect()->back()->withErrors(['fail']);
            }
            DB::table('service_turn')->where('id', $id)->update([
                'debt' => $debt - $amount,
                'debt_received_at' => date('Y-m-d H:i:s'),
                'received_debt_amount' => $amount + $received_debt_amount
            ]);
        

            return redirect('debts');
        } else {
            $name = request('name');
            $debt = ConvertNumber::convertToPersian(number_format(request('debt')));

            return view('new.turn.receive-single-debt', compact('id', 'debt', 'name'));
        }
    }

    public function editNurseDescription($id)
    {
        $model = NurseDescription::find($id);
        if (request('description')) {
            NurseDescription::where('id', request('id'))->update([
                'description' => request('description')
            ]);
            return redirect('turns/clinic/'.$model->service_turn_id);
        } else {
            return view('new.turn.edit-nurse-description', compact('model'));
        }
    }

    public function sendDebtSms($id)
    {
        $count = DB::table('service_turn')->where('id', $id)->first()->sms;
        DB::table('service_turn')->where('id', $id)->update([
            'sms' => $count+1
        ]);
        $result = Sms::debt(request('mobile'), request('name'), request('amount'));
        return redirect()->back();
    }

    public function canceledTurns(Request $request)
    {
        if (request('from')) {
            $jalali_from = $request['from'];
            $jalali_to = $request['to'];

            $from = Date::toGeorgian($jalali_from);
            $from = $from[0]."-".$from[1]."-".$from[2]." 00:00:00";

            $to = Date::toGeorgian($jalali_to);
            $to = $to[0]."-".$to[1]."-".$to[2]." 23:59:59";

            $query = $query = ActivityLog::where('activity_type_id', 3)
                                          ->where('created_at', '>', $from)
                                          ->where('created_at', '<', $to)
                                          ->get();
        } else {
            $query = ActivityLog::where('activity_type_id', 3)->where('created_at', '>', date("Y-m-d").' '.'00:00:00')->get();
        }
        return view('new.turn.canceled_turns', compact('query'));
    }
}
