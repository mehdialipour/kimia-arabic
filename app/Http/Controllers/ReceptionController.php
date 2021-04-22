<?php

namespace App\Http\Controllers;

use App\Models\FileReception;
use App\Models\Medicine;
use App\Models\MedicinePatient;
use App\Models\Turn;
use App\Repositories\Reception\ReceptionRepo as Reception;
use Illuminate\Http\Request;

class ReceptionController extends Controller
{
    protected $reception;

    public function __construct(Reception $reception)
    {
        $this->reception = $reception;
    }

    public function index()
    {
        $query = $this->reception->all();
        return view('new.reception.index', compact('query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $patients = $this->reception->patientsArray();
        return view('new.reception.form', compact('patients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->reception->create($request['patient_id'], $request['cause']);
        return redirect('turns/create?patient='.$request['patient_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->reception->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patients = $this->reception->patientsArray();
        $model = $this->reception->edit($id);

        return view('new.reception.form', compact('patients', 'model'));
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
        $this->reception->update($id, $request['patient_id'], $request['cause']);
        return redirect('receptions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->reception->delete($id);
    }

    public function loadReceptions()
    {
        if (request()->ajax()) {
            $data = request()->all();
            return $this->reception->load($data['patient_id']);
        }
    }

    public function files()
    {
        $files = $this->reception->patientFiles();
        return view('new.reception.files', compact('files'));
    }

    public function deleteFile($id)
    {
        $this->reception->deleteFile($id);
        return redirect()->back();
    }

    public function perception($id)
    {
        return $this->reception->perception($id);
    }

    public function diagnosis($id)
    {
        return $this->reception->diagnosis($id);
    }

    public function doUpload(Request $request)
    {
        //
    }

    public function collect(Request $request)
    {
        return $this->reception->collect($request['patient_id'], $request['cause'], $request['causes']);
    }

    public function release($id)
    {
        return $this->reception->release($id);
    }

    public function submitDiagnosis(Request $request)
    {
        $editor = \Session::get('name');
        if ($request['cause'] == '') {
            $cause= ' ';
        } else {
            $cause = $request['cause'];
        }
        $string = '<strong>سبب الارجاع:</strong>'.$cause.'<br><strong>تشخیص اولیه: </strong>'.$request['detection'].'<br><strong>پیشنهاد پزشک: </strong>'.$request['suggestion'].'<br><strong>تشخیص پزشک: </strong>'.$request['perception'].'<br><strong>آزمایش: </strong>'.$request['test'];
        $this->reception->submitDiagnosis($request['reception_id'], $request['sistol'], $request['diastol'], $cause, $string, $editor);

        $reception_id = $request['reception_id'];
        $case         = 2;
        $typed        = $request['diagnosis'];
        if ($typed != '') {
            $this->reception->doUpload($reception_id, $case, $typed);
        }
        return redirect('receptions/'.$reception_id);
    }

    public function deleteDiagnosis($id)
    {
        $this->reception->deleteDiagnosis($id);
        return redirect()->back();
    }

    public function editDiagnosis($diagnosis_id)
    {
        $diagnosis = \DB::table('diagnoses')->where('id', $diagnosis_id)->first();
        $id = $diagnosis->reception_id;
        $blood_pressure = explode("<br>", $diagnosis->blood_pressure);
        $sistol_ex = explode("سیستول: ", $blood_pressure[0]);
        $sistol = $sistol_ex[1];
        $diastol_ex = explode("دیاستول: ", $blood_pressure[1]);
        $diastol = $diastol_ex[1];

        $medicines = Medicine::orderBy('name')->get();
        $query = \App\Models\Reception::with(['patients'])->find($id);
        $patient = $query->patients[0];
        $receptions = \App\Models\Reception::where('patient_id', $query->patients[0]->id)->get();
        $files = \DB::table('file_patients')->where('patient_id', $patient->id)->get();

        $perceptions = FileReception::where('reception_id', $id)->where('type', 2);

        $turn_count = Turn::where('reception_id', $id)->count();
        $reception_count = \App\Models\Reception::where('patient_id', $patient->id)->count();

        $diagnoses = \DB::table('diagnoses')->where('reception_id', $id);

        $receptions_array = [];
        $reception = \App\Models\Reception::where('patient_id', $patient->id)->get();
        $reception_id = \App\Models\Reception::where('patient_id', $patient->id)->orderBy('id', 'desc')->first()->id;

        if (strpos($diagnosis->diagnosis, "</strong>") !== false) {
            $string = explode("</strong>", $diagnosis->diagnosis);

            $cause_ex = explode("<br>", $string[1]);

            $cause = $cause_ex[0];

            $detection_ex = explode("<br>", $string[2]);

            $detection = $detection_ex[0];

            $suggestion_ex = explode("<br>", $string[3]);

            $suggestion = $suggestion_ex[0];

            $perception_ex = explode("<br>", $string[4]);

            $perception = $perception_ex[0];

            
            foreach ($reception as $row) {
                array_push($receptions_array, $row->id);
            }

            $turn_id = \App\Models\Turn::whereIn('reception_id', $receptions_array)->orderBy('id', 'desc')->first()->id;


            $medicines = \App\Models\Medicine::orderBy('name')->get();
            return view('new.reception.diagnosis-edit', compact('id', 'medicines', 'query', 'cause', 'detection', 'suggestion', 'perception', 'diagnosis_id', 'sistol', 'diastol', 'patient', 'turn_count', 'reception_count', 'files', 'diagnoses', 'perceptions', 'receptions'));
        } else {
            $cause = $diagnosis->cause;

            $detection = '';

            $suggestion = '';

            $perception = $diagnosis->diagnosis;

            $query = \App\Models\Medicine::orderBy('name')->get();
            return view('new.reception.diagnosis-edit', compact('id', 'medicines', 'cause', 'detection', 'suggestion', 'perception', 'diagnosis_id', 'sistol', 'diastol', 'patient', 'turn_count', 'reception_count', 'files', 'diagnoses', 'perceptions'));
        }
    }

    public function updateDiagnosis(Request $request, $diagnosis_id)
    {
        $editor = \App\Models\Role::find(\Session::get('role'))->title;
        $diagnosis = \DB::table('diagnoses')->where('id', $diagnosis_id)->first();
        $reception_id = $diagnosis->reception_id;

        if ($request['cause'] == '') {
            $cause= ' ';
        } else {
            $cause = $request['cause'];
        }
        $string = '<strong>سبب الارجاع:</strong>'.$cause.'<br><strong>تشخیص اولیه: </strong>'.$request['detection'].'<br><strong>پیشنهاد پزشک: </strong>'.$request['suggestion'].'<br><strong>تشخیص پزشک: </strong>'.$request['perception'];
        $this->reception->updateDiagnosis($diagnosis_id, $request['reception_id'], $request['sistol'], $request['diastol'], $cause, $string, $editor);

        return redirect('receptions/'.$reception_id);
    }

    public function editMedicine($medicine_id)
    {
        $query = \DB::table('iranian_drugs')->orderBy('name_fa')->get();

        $medicines = \DB::table('file_receptions')->where('id', $medicine_id)->first();

        $content = $medicines->description;

        $id = $medicines->service_turn_id;
        $breaks = array("<br />","<br>","<br/>");
        $content = str_ireplace($breaks, "\n", $content);

        return view('new.reception.medicine-edit', compact('query', 'id', 'medicine_id', 'content'));
    }

    public function updateMedicine(Request $request, $medicine_id)
    {
        $service_turn_id = \DB::table('file_receptions')->where('id', $medicine_id)->first()->service_turn_id;
        $reception_id = \DB::table('file_receptions')->where('id', $medicine_id)->first()->reception_id;
        \DB::table('file_receptions')->where('id', $medicine_id)->update([
            'description' => nl2br($request['diagnosis'])
        ]);
        return redirect('turns/clinic/'.$service_turn_id);
    }

    public function deleteMedicine($medicine_id)
    {
        MedicinePatient::find($medicine_id)->delete();

        return redirect()->back();
    }

    public function stats()
    {
        if (request('cause')) {
            $cause = request('cause');
            $query = \App\Models\Reception::where('cause', 'like', "%$cause%")->orderBy('cause', 'asc')->get();
        } else {
            $cause = '';
            $query = \App\Models\Reception::orderBy('cause', 'asc')->get();
        }

        $arr = [];

        foreach ($query as $row) {
            array_push($arr, $row->cause);
        }

        $arr = array_unique($arr);

        return view('new.reception.stats', compact('arr','cause'));
    }
}
