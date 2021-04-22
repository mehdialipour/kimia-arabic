<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ConvertDate;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Reception;
use App\Models\Turn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class InvoiceController extends Controller
{
    public function index($token, $invoice_id)
    {
    	$invoice = Invoice::find($invoice_id);

    	if(!$invoice) {
    		return Response::json([
    			'error' => 'invoice not found!'
    		], 404);
    	}

    	$turn = Turn::find($invoice->turn_id);
    	$patient = Reception::find($turn->reception_id);

    	$patient = Patient::find($patient->patient_id);
    	$time = explode(" ",$turn->turn_time);

    	$jalali_datetime = ConvertDate::toJalali($turn->turn_time).' '.$time[1];
    	if($token == 'kbq97ACHkHR7DVE4vfdWHt7iTMXYGt83JSYEtI94kXPQGbBt2m') {
    		return Response::json([
    			'patient_name' => $patient->name,
    			'patient_national_id' => $patient->national_id,
    			'amount' => $invoice->amount,
    			'datetime' => $turn->turn_time,
    			'jalali_datetime' => $jalali_datetime

    		]);
    	} else {
    		return Response::json([
    			'error' => 'unauthorized access!'
    		], 403);
    	}
    }

    public function visits()
    {
        
    }
}
