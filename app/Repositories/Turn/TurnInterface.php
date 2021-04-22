<?php

namespace App\Repositories\Turn;

interface TurnInterface
{
    public function services();

    public function today();

    public function todayTurns($skip, $name = null);

    public function showFutureTurns($skip, $name = null, $date, $filtered);

    public function patientsArray();

    public function create($reception_id, $date, $time, $files, $services, $drugs, $discount, $paid, $doctor_id, $user_id, $all);

    public function uploadFiles($id, $files);

    public function insertServices($turn_id, $services);

    public function insertDrugs($turn_id, $drugs);

    public function calculateInvoice($turn_id, $services, $discount, $turn_time, $paid, $therapist, $old_invoice);

    public function insertInvoice($turn_id, $amount, $discount, $paid, $created_at, $therapist, $old_invoice);

    public function toggle($turn_id);

    public function edit($turn_id);

    public function fetchHour($turn_id);

    public function fetchMinute($turn_id);

    public function updateTurn($id, $reception_id, $date, $time, $files, $services, $drugs, $discount, $paid, $doctor_id);
    
    public function patientName($turn_id);

    public function patientId($turn_id);

    public function activeServices($turn_id);

    public function fetchFiles($turn_id);

    public function fetchDateTime($turn_id);

    public function fetchDiscount($turn_id);

    public function loadWaiters();

    public function loadOffice();

    public function loadTherapist();

    public function futureTurns($p='');

    public function insurancesArray();

    public function allInsurances();

    public function patientNameById($patient_id);

    public function receptionsBypatientId($patient_id);

    public function patientInsuranceId($patient_id);

    public function turnReceptionId($turn_id);
}
