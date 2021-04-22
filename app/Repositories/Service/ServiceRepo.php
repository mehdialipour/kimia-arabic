<?php

namespace App\Repositories\Service;

use App\Helpers\ConvertNumber as Number;

use App\Models\Service;
use App\Models\Insurance;
use DB;

/**
*
*/
class ServiceRepo implements ServiceInterface
{
    public function all()
    {
        return Service::orderBy('name','asc')->get();
    }

    public function insurances()
    {
        return Insurance::all();
    }

    public function create($name, $tariffs)
    {
        $query = Service::create(['name' => $name]);

        $insurances_count = Insurance::count();

        for ($i=0; $i<$insurances_count; $i++) {
            DB::table('insurance_service')->insert([
                'insurance_id' => $i+1,
                'service_id' => $query->id,
                'tariff' => Number::convert($tariffs[$i])
            ]);
        }
        return redirect('services');
    }

    public function edit($id)
    {
        return Service::find($id);
    }

    public function returnTariffs($id)
    {
        $query = DB::table('insurance_service')
                    ->where('service_id', $id)
                    ->select('insurance_id', 'tariff')
                    ->get();
        $tariffs = [];
        foreach ($query as $row) {
            $tariffs[$row->insurance_id] = $row->tariff;
        }

        return $tariffs;
    }

    public function update($id, $name, $tariffs)
    {
        Service::find($id)->fill(['name' => $name])->save();

        DB::table('insurance_service')->where('service_id', $id)->delete();

        $insurances_count = Insurance::count();

        for ($i=0; $i<$insurances_count; $i++) {
            DB::table('insurance_service')->insert([
                'insurance_id' => $i+1,
                'service_id' => $id,
                'tariff' => Number::convert($tariffs[$i])
            ]);
        }

        return redirect('services');
    }

    public function activate($id)
    {
        Service::find($id)->fill(['status' => 'فعال'])->save();
        return redirect()->back();
    }

    public function deactivate($id)
    {
        Service::find($id)->fill(['status' => 'غیر فعال'])->save();
        return redirect()->back();
    }
}
