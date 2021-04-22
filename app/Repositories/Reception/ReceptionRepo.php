<?php

namespace App\Repositories\Reception;

use App\Helpers\ConvertNumber;
use App\Models\Diagnosis;
use App\Models\FileReception;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Reception;
use App\Models\Turn;
use App\Repositories\Turn\TurnRepo;
use DB;
use Session;

/**
*
*/
class ReceptionRepo implements ReceptionInterface
{
    public function all()
    {
        return Reception::with('patients')->orderBy('id', 'desc')->paginate(20);
    }

    public function patientsArray()
    {
        $patients = [];
        $query = Patient::orderBy('id', 'desc')->get();

        foreach ($query as $row) {
            $patients[$row->id] = $row->name;
        }

        return $patients;
    }

    public function create($patient_id, $cause)
    {
        $query = Reception::create([
            'patient_id' => $patient_id,
            'cause' => $cause
        ]);

        $reception = Reception::find($query->id);
        $reception->patients()->attach($patient_id);

        return true;
    }
    public function edit($id)
    {
        return Reception::findOrFail($id);
    }

    public function update($id, $patient_id, $cause)
    {
        $query = Reception::where('id', $id)->update([
            'patient_id' => $patient_id,
            'cause' => $cause
        ]);

        $reception = Reception::find($id);
        $reception->patients()->sync($patient_id);

        return true;
    }

    public function show($id)
    {
        $medicines = Medicine::orderBy('name')->get();
        $query = Reception::with(['patients'])->find($id);
        $patient = $query->patients[0];
        $receptions = Reception::where('patient_id', $query->patients[0]->id)->get();
        $files = \DB::table('file_patients')->where('patient_id', $patient->id)->get();

        $perceptions = FileReception::where('reception_id', $id)->where('type', 2);

        $turn_count = Turn::where('reception_id', $id)->count();
        $reception_count = Reception::where('patient_id', $patient->id)->count();

        $diagnoses = \DB::table('diagnoses')->where('reception_id', $id);

        $receptions_array = [];
        $reception = \App\Models\Reception::where('patient_id', $patient->id)->get();
        $reception_id = \App\Models\Reception::where('patient_id', $patient->id)->orderBy('id', 'desc')->first()->id;
        foreach ($reception as $row) {
            array_push($receptions_array, $row->id);
        }

        $turn_id = \App\Models\Turn::whereIn('reception_id', $receptions_array)->orderBy('id', 'desc')->first()->id;
        $discount = \DB::table('invoices')->where('turn_id', $turn_id)->first()->discount;
        $discount = ConvertNumber::convertToPersian($discount);

        $paid_services = \DB::table('service_turn')->where('turn_id', $turn_id)->where('paid', 1)->get();
        $unpaid_services = \DB::table('service_turn')->where('turn_id', $turn_id)->where('paid', 0)->get();
        $patient_insurance_id = \App\Models\Patient::find($patient->id)->insurance_id;

        return view('new.reception.show', compact('query', 'patient', 'receptions', 'files', 'turn_count', 'reception_count', 'id', 'perceptions', 'diagnoses', 'turn_id', 'medicines', 'paid_services', 'unpaid_services', 'discount', 'patient_insurance_id'));
    }

    public function delete($id)
    {
        Reception::find($id)->delete();
        return redirect()->back();
    }

    public function load($id)
    {
        $patient = Patient::find($id);

        if ($patient->birth_year == '' || $patient->father_name == '' || $patient->mobile == '' || $patient->national_id == '' || strlen($patient->mobile) != 11) {
            return 'oops!';
        } else {
            $query = Reception::where('patient_id', $id)->select('id', 'cause')->orderBy('id', 'desc');
            if ($query->count() > 0) {
                $query = $query->get();
                $string = '<label for="">سبب الارجاع</label><span id="add_new_reception" style="font-size: 20px; cursor: pointer;" class="text-primary">+</span></label>
                                            <input type="text" id="new_reception" name="new_reception" class="form-control" style="display: none;">
            <select class="form-control m-input selectbox2" style="font-family: Vazir" name="reception_id" id="reception_id">';

                if (Session::get('role') == 'doctor') {
                    foreach ($query as $row) {
                        $string.='<option value="'.$row->id.'">'.$row->cause.'</option>';
                    }
                } else {
                    foreach ($query as $row) {
                        $string.='<option value="'.$row->id.'">'.$row->cause.'</option>';
                    }
                }

                $string.='</select>';
            } else {
                $string = '<label for="">سبب الارجاع</label><span id="add_new_reception" style="font-size: 20px; cursor: pointer;" class="text-primary">+</span></label>
                                            <input type="text" id="new_reception" name="new_reception" class="form-control" style="">';
            }

            return $string.'|'.$patient->insurance_code.'|'.$patient->insurance_id;
        }
    }

    public function patientFiles()
    {
        return FileReception::with('reception.patients')->orderBy('id', 'desc')->paginate(20);
    }

    public function deleteFile($id)
    {
        $query = FileReception::find($id);
        unlink(public_path('uploads/'.$query->file_url));

        $query->delete();
    }

    public function perception($id)
    {
        $query = Medicine::orderBy('name')->get();
        return view('reception.perception', compact('id', 'query'));
    }

    public function diagnosis($id)
    {
        $query = Medicine::orderBy('name')->get();
        return view('reception.diagnosis', compact('id', 'query'));
    }

    public function oldDoUpload($image, $reception_id, $case, $typed)
    {
        $upload_dir = public_path('uploads');
        $info = request()->all();

        if (strpos($image, "CMelf2iA3G") !== false) {
            FileReception::create([
                'type' => $case,
                'reception_id' => $reception_id,
                'description' => nl2br($typed)
            ]);
        } else {
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $data = base64_decode($image);
            $image = time().".png";
            $file = $upload_dir ."/".$image;
            $success = file_put_contents($file, $data);
            print $success ? $file : 'Unable to save the file.';

            FileReception::create([
                'type' => $case,
                'reception_id' => $reception_id,
                'file_url'  => $image,
                'description' => nl2br($typed)
            ]);
        }

        return true;
    }

    public function doUpload($reception_id, $case, $typed)
    {
        FileReception::create([
            'type' => $case,
            'reception_id' => $reception_id,
            'description' => nl2br($typed)
        ]);
    }

    public function collect($patient_id, $cause, $causes)
    {
        $query = Reception::create([
            'patient_id' => $patient_id,
            'cause' => $cause
        ]);

        $reception = Reception::find($query->id);
        $reception->patients()->attach($patient_id);

        foreach ($causes as $key => $value) {
            Turn::where('reception_id', $value)->update([
                'reception_id' => $query->id
            ]);

            FileReception::where('reception_id', $value)->update([
                'reception_id' => $query->id
            ]);

            Reception::find($value)->delete();
        }



        return redirect('receptions/'.$query->id);
    }

    public function release($id)
    {
        Turn::where('reception_id', $id)->update(['status' => 'انتهى']);
        return redirect('/');
    }

    public function submitDiagnosis($reception_id, $sistol, $diastol, $cause, $final, $editor)
    {
        Diagnosis::create([
            'reception_id' => $reception_id,
            'blood_pressure' => "سیستول: ".$sistol."<br>"."دیاستول: ".$diastol,
            'cause' => nl2br($cause),
            'diagnosis' => nl2br($final),
            'editor' => $editor
        ]);

        $this->updateReceptionByDiagnosis($reception_id, $cause);
    }

    public function updateDiagnosis($diagnosis_id, $reception_id, $sistol, $diastol, $cause, $final, $editor)
    {
        Diagnosis::where('id', $diagnosis_id)->update([
            'blood_pressure' => "سیستول: ".$sistol."<br>"."دیاستول: ".$diastol,
            'cause' => nl2br($cause),
            'diagnosis' => nl2br($final),
            'editor' => $editor
        ]);

        $this->updateReceptionByDiagnosis($reception_id, $cause);
    }

    public function updateReceptionByDiagnosis($reception_id, $cause)
    {
        // return Reception::where('id', $reception_id)->update([
        //     'cause' => $cause
        // ]);
    }

    public function deleteDiagnosis($id)
    {
        Diagnosis::where('id', $id)->delete();
    }
}
