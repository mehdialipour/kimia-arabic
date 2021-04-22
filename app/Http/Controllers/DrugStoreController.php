<?php

namespace App\Http\Controllers;

use App\Models\MedicinePatient;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DrugStoreController extends Controller
{
    public function index()
    {
        if (request('name')) {
            $query = DB::table('medicine_patients')
                    ->leftjoin('service_turn', 'medicine_patients.service_turn_id', '=', 'service_turn.id')
                    ->leftjoin('turns', 'service_turn.turn_id', '=', 'turns.id')
                    ->leftjoin('receptions', 'turns.reception_id', '=', 'receptions.id')
                    ->leftjoin('patients', 'receptions.patient_id', '=', 'patients.id')
                    ->orderBy('medicine_patients.id', 'desc')
                    ->select('medicine_patients.*','service_turn.user_id')
                    ->get();

            $arr = [];
            foreach ($query as $row) {
                array_push($arr, $row->service_turn_id);
            }
         
            $prescriptions = array_unique($arr);
            return view('new.drug-store.index', compact('prescriptions'));
        } else {
            $query = MedicinePatient::orderBy('id', 'desc')->where('created_at', '>', Carbon::today())->get();
         
            $arr = [];
            foreach ($query as $row) {
                array_push($arr, $row->service_turn_id);
            }
         
            $prescriptions = array_unique($arr);
         
            return view('new.drug-store.index', compact('prescriptions'));
        }
    }

    public function seen($service_turn_id)
    {
        MedicinePatient::where('service_turn_id', $service_turn_id)->update([
            'seen' => 1
        ]);

        return redirect()->back();
    }

    public function invoice($service_turn_id)
    {
        $settings = Setting::first();
        $drugs = MedicinePatient::where('service_turn_id', $service_turn_id)->get();
        return view('new.drug-store.invoice', compact('drugs', 'service_turn_id', 'settings'));
    }
}
