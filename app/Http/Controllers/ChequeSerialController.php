<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\ChequeSerial;
use Illuminate\Http\Request;

class ChequeSerialController extends Controller
{
    public function index()
    {
    	$query = ChequeSerial::where('status', '!=', 0)->get();
    	return view('new.serial.index', compact('query'));
    }

    public function create()
    {
    	$cheques = [];

    	$query = ChequeSerial::where('status', 0)->get();
    	foreach($query as $row) {
    		$bank = Cheque::find($row->cheque_id)->bank;
    		$cheques[$row->id] = $bank." - ".$row->number;
    	}

    	return view('new.serial.form', compact('cheques'));
    }

    public function store(Request $request)
    {
    	ChequeSerial::where('id', $request['cheque_id'])->update([
    		'receiver' => $request['receiver'],
    		'date' => $request['date'],
    		'cause' => $request['cause'],
    		'status' => 1,
            'amount' => $request['amount']
    	]);

    	return redirect('paid-cheques');
    }
}