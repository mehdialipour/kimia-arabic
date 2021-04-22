<?php

namespace App\Http\Controllers;

use App\Models\FileType;
use App\Models\Question;
use App\Repositories\Patient\PatientRepo as Patient;
use App\Repositories\EncryptionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\CalendarUtils;
use Session;

class PatientController extends Controller
{
    protected $patients;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(Patient $patients)
    {
        $this->patients = $patients;
    }

    public function index()
    {
        // $key = "-----BEGIN PUBLIC KEY-----\r\nMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCvPhyW5hmoRHcXkAdPrNMMRdDJ\r\n67vySEm1USalRRDnqVo8Sid1BKiIOpC8ficPxvMihSmssjr1mGdqM5PH+qDgRT89\r\nogMX3BMA06TQ9HdJ2oVhUjsaRZ28XYTY90iuVADI5E1kliNVGRVDMklm3jMTxGQk\r\n/SOVxclyRs29V6OjsQIDAQAB\r\n-----END PUBLIC KEY-----";
        // $username = EncryptionRepository::encrypt('drtest', $key);
        // $password = EncryptionRepository::encrypt('123456', $key);


        // echo base64_encode($username).'<br>'.base64_encode($password);
        
        $query = $this->patients->all();
        return view('new.patient.index', compact('query'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $redirect = $request['redirect'];
        $insurances = $this->patients->insurancesArray();

        return view('new.patient.form', compact('insurances', 'redirect'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $patient = $this->patients->create(
            $request['firstname'],
            $request['lastname'],
            $request['firstname'].' '.$request['lastname'],
            $request['gender'],
            $request['national_id'],
            $request['insurance_id'],
            $request['insurance_code'],
            $request['mobile'],
            $request['phone'],
            $request['birth_year'],
            $request['address'],
            $request['disease_history'],
            $request['files'],
            $request['marriage'],
            $request['father_name'],
            $request['job'],
            json_encode($request->all(), JSON_UNESCAPED_UNICODE)
        );
        if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 2)->count() == 1) {
            return redirect('turns/create?patient='.$patient);
        } else {
            return redirect('patients');
        }
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
    public function edit(Request $request, $id)
    {
        if (isset($request['redirect'])) {
            if ($request['redirect'] == 'create') {
                $redirect = 'create';
            } elseif ($request['redirect'] == 'edit') {
                $last_turn = \App\Models\Turn::where('reception_id', \App\Models\Reception::where('patient_id', $id)->first()->id)->first()->id;
                $redirect = 'turns/'.$last_turn.'/edit?patient='.$id;
            } elseif ($request['redirect'] == 'toggle') {
                $redirect = 'turns';
            }
        } else {
            $redirect = 'nowhere';
        }
        $model = $this->patients->edit($id);
        $insurances = $this->patients->insurancesArray();

        $files = \DB::table('file_patients')->where('patient_id', $id)->get();

        return view('new.patient.form', compact('model', 'insurances', 'files', 'redirect'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->patients->update(
            $id,
            $request['firstname'],
            $request['lastname'],
            $request['firstname'].' '.$request['lastname'],
            $request['gender'],
            $request['national_id'],
            $request['insurance_id'],
            $request['insurance_code'],
            $request['mobile'],
            $request['phone'],
            $request['birth_year'],
            $request['address'],
            $request['disease_history'],
            $request['files'],
            $request['marriage'],
            $request['father_name'],
            $request['job'],
            Session::get('user_id')
        );

        if (!empty($request['patient_file'])) {
            foreach ($request['patient_file'] as $key => $value) {
                $query = \DB::table('file_patients')->where('id', $value);

                unlink(public_path('uploads/'.$query->first()->file_url));
                $query->delete();
            }
        }

        if ($request['redirect'] == 'nowhere') {
            return redirect('patients');
        } elseif ($request['redirect'] == 'create') {
            return redirect('turns/create?patient='.$id);
        } elseif ($request['redirect'] == 'toggle') {
            return redirect('turns');
        } else {
            return redirect($request['redirect']);
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
        return $this->patients->delete($id);
    }

    public function search()
    {
        $data = request()->all();
        $name = $data['q'];
        
        return $this->patients->search($name);
    }

    public function searchTurn()
    {
        $data = request()->all();
        $name = $data['q'];
        
        return $this->patients->searchTurn($name);
    }

    public function changeInsurance()
    {
        $data = request()->all();

        $patient_id = $data['patient_id'];
        $insurance_id = $data['insurance_id'];
        $insurance_code = $data['insurance_code'];

        return $this->patients->changeInsurance($patient_id, $insurance_id, $insurance_code);
    }

    public function nationalIdCheck()
    {
        if (request()->ajax()) {
            $data = request()->all();
            return $this->patients->nationalIdCheck($data['national_id']);
        }
    }

    public function mobileCheck()
    {
        if (request()->ajax()) {
            $data = request()->all();
            return $this->patients->mobileCheck($data['mobile']);
        }
    }

    public function questions(Request $request, $id)
    {
        if (request()->method() == 'GET') {
            $patient = \App\Models\Patient::find($id);

            $receptions = [];
            $reception = \App\Models\Reception::where('patient_id', $id)->get();
            $reception_id = \App\Models\Reception::where('patient_id', $id)->orderBy('id', 'desc')->first()->id;
            foreach ($reception as $row) {
                array_push($receptions, $row->id);
            }

            $turn_id = \App\Models\Turn::whereIn('reception_id', $receptions)->orderBy('id', 'desc')->first()->id;

            $name = $patient->name;

            if ($patient->gender == 'male') {
                $gender = 'آقای';
            } else {
                $gender = 'خانم';
            }

            $questions = Question::all();

            return view('new.patient.questions', compact('name', 'questions', 'gender', 'id', 'reception_id', 'turn_id'));
        } else {
            \DB::table('patient_questions')->insert([
                'patient_id' => $id,
                'answers' => json_encode($request->all(), JSON_UNESCAPED_UNICODE)
            ]);

            
            return redirect('/');
        }
    }

    public function answers(Request $request, $id)
    {
        if (request()->method() == 'GET') {
            $patient = \App\Models\Patient::find($id);
            $receptions = [];
            $reception = \App\Models\Reception::where('patient_id', $id)->get();
            $reception_id = \App\Models\Reception::where('patient_id', $id)->orderBy('id', 'desc')->first()->id;
            foreach ($reception as $row) {
                array_push($receptions, $row->id);
            }
            $turn_id = \App\Models\Turn::whereIn('reception_id', $receptions)->orderBy('id', 'desc')->first()->id;
            $name = $patient->name;
            if ($patient->gender == 'male') {
                $gender = 'آقای';
            } else {
                $gender = 'خانم';
            }
            $questions = Question::all();
            $answers = \DB::table('patient_questions')->where('patient_id', $id)->first();
            $question_id = $answers->id;

            $answers = json_decode($answers->answers);

            

            return view('new.patient.answers', compact('questions', 'answers', 'name', 'id', 'gender', 'question_id', 'reception_id', 'turn_id'));
        } else {
            \DB::table('patient_questions')->where('id', $request['question_id'])->delete();

            \DB::table('patient_questions')->insert([
                'patient_id' => $id,
                'answers' => json_encode($request->all(), JSON_UNESCAPED_UNICODE)
            ]);

            return redirect()->back();
        }
    }

    public function toWait($id)
    {
        \App\Models\Turn::where('id', $id)->update(['status' => 'فی انتظار']);
        return redirect('/');
    }

    public function toOffice($id)
    {
        \App\Models\Turn::where('id', $id)->update(['status' => 'داخل مطب']);
        return redirect('/');
    }

    public function toTherapist($id)
    {
        \App\Models\Turn::where('id', $id)->update(['status' => 'عيادة']);
        return redirect('turns');
    }

    public function patientSearch(Request $request)
    {
        $name = $request['name'];
        $national_id = \App\Helpers\ConvertNumber::convert($request['national_id']);
        $mobile = \App\Helpers\ConvertNumber::convert($request['mobile']);

        $query = \DB::table('patients');

        if ($name != '') {
            $query->orWhere('name', 'like', "%$name%");
        }

        if ($mobile != '') {
            $query->orWhere('mobile', 'like', "%$mobile%");
        }

        if ($national_id != '') {
            $query->orWhere('national_id', 'like', "%$national_id%");
        }

        $query = $query->paginate(10000);

        return view('new.patient.index', compact('query'));
    }

    public function deleteImage($id)
    {
        $file_url = \DB::table('file_patients')->where('id', $id)->first()->file_url;
        unlink(public_path('uploads/'.$file_url));
        \DB::table('file_patients')->where('id', $id)->delete();
        return redirect()->back();
    }

    public function scanFiles(Request $request, $id)
    {
        $patient = \App\Models\Patient::find($id);
        $types = FileType::all();
        $file_types = [];

        foreach ($types as $row) {
            $file_types[$row->id] = $row->type;
        }
        if (request()->method() == 'GET') {
            $files = DB::table('file_patients')->where('patient_id', $id)->get();
            return view('new.patient.scan-files', compact('patient', 'file_types', 'files'));
        } else {
            $date = explode("-", $request['date']);
            $g_date = CalendarUtils::toGregorian($date[0], $date[1], $date[2]);
            $g_date = $g_date['0'].'-'.$g_date[1].'-'.$g_date[2];

            if (!empty($request['files'])) {
                foreach ($request['files'] as $file) {
                    if ($file != "" || $file != null) {
                        $imageName = str_random(10).time() .'.' . $file->getClientOriginalExtension();

                        $file->move('uploads', $imageName);

                        $file = $imageName;

                        DB::table('file_patients')->insert([
                        'patient_id' => $id,
                        'file_url' => $file,
                        'file_type_id' => $request['file_type_id'],
                        'date' => $g_date,
                        'user_id' => Session::get('user_id')
                    ]);
                    }
                }
            }

            return redirect('patients/'.$id.'/scan-files')->withErrors(['فایل با موفقیت اضافه شد.']);
        }
    }

    public function beforeAfter(Request $request, $id)
    {
        $patient = \App\Models\Patient::find($id);
        
        if (request()->method() == 'GET') {
            $files = DB::table('before_afters')->where('patient_id', $id)->get();
            return view('new.patient.before-after', compact('patient', 'files'));
        } else {
            $date = explode("-", $request['date']);
            $g_date = CalendarUtils::toGregorian($date[0], $date[1], $date[2]);
            $g_date = $g_date['0'].'-'.$g_date[1].'-'.$g_date[2];

            if (!empty($request['files'])) {
                foreach ($request['files'] as $file) {
                    if ($file != "" || $file != null) {
                        $imageName = str_random(10).time() .'.' . $file->getClientOriginalExtension();

                        $file->move('uploads', $imageName);

                        $file = $imageName;

                        DB::table('before_afters')->insert([
                        'patient_id' => $id,
                        'file_url' => $file,
                        'file_type' => $request['file_type'],
                        'date' => $g_date,
                        'user_id' => Session::get('user_id')
                    ]);
                    }
                }
            }

            return redirect('patients/'.$id.'/before-after-files')->withErrors(['فایل با موفقیت اضافه شد.']);
        }
    }

    public function deleteBeforeAfter($id)
    {
        DB::table('before_afters')->where('id', $id)->delete();
        return redirect()->back();
    }

    public function searchPatients(Request $request)
    {
        $name  = $request['name'];
        if (strlen($name) > 0) {
            $query = DB::table('patients')
                    ->leftjoin('receptions', 'patients.id', '=', 'receptions.patient_id')
                    ->leftjoin('turns', 'receptions.id', '=', 'turns.reception_id')
                    ->leftjoin('service_turn', 'turns.id', '=', 'service_turn.turn_id')
                    ->leftjoin('insurances', 'patients.insurance_id', '=', 'insurances.id')
                    ->where('patients.name', 'like', "%$name%")
                    ->where('service_turn.paid', 1)
                    ->where('turns.doctor_id', Session::get('user_id'))
                    ->select('patients.name', 'receptions.cause', 'service_turn.id', 'turns.turn_time', 'insurances.name as ins_name', 'service_turn.service_id')
                    ->get();

            return view('new.patient.history', compact('query', 'name'));
        } else {
            $name = '';
            $query = [];
            return view('new.patient.history', compact('query', 'name'));
        }
    }
}
