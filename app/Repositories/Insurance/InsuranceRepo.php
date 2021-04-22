<?php

namespace App\Repositories\Insurance;

use App\Models\Insurance;

/**
*
*/
class InsuranceRepo implements InsuranceInterface
{
    public function all()
    {
        return Insurance::paginate(10);
    }

    public function create($name)
    {
        Insurance::create(['name' => $name]);
        return redirect('insurances');
    }

    public function edit($id)
    {
        return Insurance::find($id);
    }

    public function update($id, $name)
    {
        Insurance::find($id)->fill(['name' => $name])->save();
        return redirect('insurances');
    }

    public function activate($id)
    {
        Insurance::find($id)->fill(['status' => 'فعال'])->save();
        return redirect()->back();
    }

    public function deactivate($id)
    {
        Insurance::find($id)->fill(['status' => 'غیر فعال'])->save();
        return redirect()->back();
    }
}
