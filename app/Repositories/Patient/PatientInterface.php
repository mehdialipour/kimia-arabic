<?php

namespace App\Repositories\Patient;

interface PatientInterface
{
    public function insurancesArray();

    public function all();

    public function create($firstname, $lastname, $name, $gender, $national_id, $insurance_id, $insurance_code, $mobile, $phone, $birth_year, $address, $disease_history, $files, $marriage, $father_name, $job, $all);

    public function uploadFiles($id, $files);

    public function delete($id);

    public function edit($id);

    public function update($id, $firstname, $lastname, $name, $gender, $national_id, $insurance_id, $insurance_code, $mobile, $phone, $birth_year, $address, $disease_history, $files, $marriage, $father_name, $job, $updater_id);

    public function search($name);

    public function searchTurn($name);

    public function changeInsurance($patient_id, $insurance_id, $insurance_code);

    public function nationalIdCheck($national_id);

    public function mobileCheck($mobile);
}
