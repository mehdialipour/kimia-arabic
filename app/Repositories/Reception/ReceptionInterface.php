<?php

namespace App\Repositories\Reception;

interface ReceptionInterface
{
    public function all();

    public function patientsArray();

    public function create($patient_id, $cause);

    public function edit($id);

    public function update($id, $patient_id, $cause);

    public function show($id);

    public function delete($id);

    public function load($id);

    public function patientFiles();

    public function deleteFile($id);

    public function perception($id);

    public function diagnosis($id);

    public function doUpload($reception_id, $case, $typed);

    public function collect($patient_id, $cause, $causes);

    public function release($id);

    public function submitDiagnosis($reception_id, $sistol, $diastol, $cause, $final, $editor);

    public function updateDiagnosis($diagnosis_id, $reception_id, $sistol, $diastol, $cause, $final, $editor);
    
    public function updateReceptionByDiagnosis($reception_id, $cause);
}
