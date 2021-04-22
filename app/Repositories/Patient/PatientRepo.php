<?php

namespace App\Repositories\Patient;

use App\Helpers\ConvertNumber as Number;
use App\Helpers\MobileNumber;
use App\Helpers\NationalId;
use App\Models\FileReception;
use App\Models\Insurance;
use App\Models\Patient;
use App\Models\Reception;
use Session;
use Carbon;

class PatientRepo implements PatientInterface
{
    public function insurancesArray()
    {
        $query = Insurance::all();
        $insurances = [];

        foreach ($query as $row) {
            $insurances[$row->id] = $row->name;
        }

        return $insurances;
    }

    public function all()
    {
        return Patient::orderBy('name', 'asc')->paginate(10);
    }

    public function create($firstname, $lastname, $name, $gender, $national_id, $insurance_id, $insurance_code, $mobile, $phone, $birth_year, $address, $disease_history, $files, $marriage, $father_name, $job, $all)
    {
        $patient = Patient::create([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'name' => $firstname.' '.$lastname,
            'gender' => $gender,
            'national_id' => Number::convert($national_id),
            'insurance_id' => $insurance_id,
            'insurance_code' => $insurance_code,
            'mobile' => Number::convert($mobile),
            'phone' => Number::convert($phone),
            'birth_year' => Number::convert($birth_year),
            'address' => $address,
            'disease_history' => $disease_history,
            'marriage' => $marriage,
            'father_name' => $father_name,
            'job' => $job,
            'answers' => $all
        ]);

        $this->uploadFiles($patient->id, $files);

        return $patient->id;
    }

    public function uploadFiles($id, $files)
    {
        if (!empty($files)) {
            foreach ($files as $file) {
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
    }

    public function delete($id)
    {
        Patient::findOrFail($id)->delete();
        return redirect()->back();
    }

    public function edit($id)
    {
        $model = Patient::findOrFail($id);
        return $model;
    }

    public function update($id, $firstname, $lastname, $name, $gender, $national_id, $insurance_id, $insurance_code, $mobile, $phone, $birth_year, $address, $disease_history, $files, $marriage, $father_name, $job, $updater_id)
    {
        Patient::where('id', $id)->update([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'name' => $firstname.' '.$lastname,
            'gender' => $gender,
            'national_id' => Number::convert($national_id),
            'insurance_id' => $insurance_id,
            'insurance_code' => $insurance_code,
            'mobile' => Number::convert($mobile),
            'phone' => Number::convert($phone),
            'birth_year' => Number::convert($birth_year),
            'address' => $address,
            'disease_history' => $disease_history,
            'marriage' => $marriage,
            'father_name' => $father_name,
            'job' => $job,
            'updater_id' => $updater_id
        ]);

        $this->uploadFiles($id, $files);

        return true;
    }

    public function search($name)
    {
        $string = "<hr><br>";

        $query = Patient::where('name', 'like', "%$name%")->get();

        foreach ($query as $row) {
            if (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 7)->count() == 1) {
                $id = Reception::where('patient_id', $row->id)->first()->id;
                $string.="<p><a href='".url('receptions/'.$id)."'>".$row->name." - اسم الاب: ".$row->father_name."</a></p>";
            } elseif (\DB::table('permission_roles')->where('role_id', \Session::get('role'))->where('permission_id', 1)->count() == 1) {
                $id = Patient::where('id', $row->id)->first()->id;
                $string.="<p><a href='".url('patients/'.$id.'/edit')."'>".$row->name." - اسم الاب: ".$row->father_name."</a></p>";
            } else {
                $string.="<p>".$row->name." - اسم الاب: ".$row->father_name."</p>";
            }
        }

        if (count($query) == 0) {
            $string .= 'نتیجه ای یافت نشد.';
        }

        return $string;
    }

    public function searchTurn($name)
    {
        $query = Patient::where('name', 'like', "%$name%")->get();

        if ($query->count() == 0) {
            return '<label>اسم المریض</label><br><span>نتیجه ای یافت نشد.</span>';
        }

        $string = "<label for=''>اسم المریض</label><select style='font-family: Vazir; height: 60%;' class='form-control m-input selectbox' id='patients'><option value='0' selected='' disabled=''>اختر..</option>";
        foreach ($query as $row) {
            $id = Patient::where('id', $row->id)->first()->id;
            $string.="<option value='".$row->id."'>".$row->name." - اسم الاب: ".$row->father_name."</option>";
        }

        $string.='</select><input name="patient_id" type="hidden" value="'.$id.'">';

        if (count($query) == 0) {
            $string = 'نتیجه ای یافت نشد.';
        }

        return $string;
    }

    public function changeInsurance($patient_id, $insurance_id, $insurance_code)
    {
        Patient::where('id', $patient_id)->update([
            'insurance_id' => $insurance_id,
            'insurance_code' => Number::convert($insurance_code)
        ]);

        return 'insurance of '.Patient::find($patient_id)->name.' has changed!';
    }

    public function nationalIdCheck($national_id)
    {
        return NationalId::isValid($national_id);
    }

    public function mobileCheck($mobile)
    {
        return MobileNumber::isValid($mobile);
    }
}
