<?php

namespace App\Http\Controllers;

use App\Models\DrugStorage;
use App\Models\InternalStorage;
use App\Models\ShelfStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DrugStorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = DrugStorage::paginate(20);
        return view('new.drug.index', compact('query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('new.drug.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DrugStorage::create($request->all());

        $internal = InternalStorage::create($request->all());
        $shelf    = ShelfStorage::create($request->all());

        InternalStorage::where('id', $internal->id)->update([
            'amount' => 0
        ]);

        ShelfStorage::where('id', $shelf->id)->update([
            'amount' => 0
        ]);

        return redirect('storage');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = DrugStorage::find($id);
        return view('new.drug.form', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = DrugStorage::find($id);
        $model->fill($request->all());
        $model->save();

        return redirect('storage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DrugStorage::find($id)->delete();
        return redirect()->back();
    }

    public function add($id)
    {
        $model = DrugStorage::find($id);
        return view('new.drug.add', compact('model'));
    }

    public function updateDrug(Request $request)
    {
        $count = DrugStorage::find($request['id'])->amount;
        $amount = $count + $request['amount'];
        DrugStorage::where('id', $request['id'])->update([
            'amount' => $amount
        ]);

        return redirect('storage');
    }

    public function search(Request $request)
    {
        $code = $request['code'];
        $name_fa = $request['name_fa'];
        $name_en = $request['name_en'];

        $query = DrugStorage::where('id', '>', 0);

        if (strlen($request['code']) > 0) {
            $query->where('code', 'like', "%$code%");
        }
        if (strlen($request['name_fa']) > 0) {
            $query->where('name_fa', 'like', "%$name_fa%");
        }

        if (strlen($request['name_en']) > 0) {
            $query->where('name_en', 'like', "%$name_en%");
        }
        $query = $query->paginate(20);
        return view('new.drug.index', compact('query'));
    }

    public function internalStorage()
    {
        $query = DB::table('internal_storage')->where('amount', '>', 0)->where('active', 1)->paginate(20);
        return view('new.drug.internal', compact('query'));
    }

    public function shelfStorage()
    {
        $query = DB::table('shelf_storage')->where('amount', '>', 0)->where('active', 1)->paginate(20);
        return view('new.drug.shelf', compact('query'));
    }

    public function transfer($id)
    {
        $model = DrugStorage::find($id);
        return view('new.drug.transfer', compact('model'));
    }

    public function submitTransfer(Request $request)
    {
        $amount = DrugStorage::find($request['id'])->amount;
        if ($request['amount'] > $amount) {
            $error = '<span class="text-danger">مقدار وارد شده بیشتر از مقدار موجودی انبار است</span>';
            return view('new.drug.success', compact('error'));
        } else {
            DrugStorage::where('id', $request['id'])->update([
            'amount' => $amount - $request['amount']
        ]);

            if ($request['storage'] == 1) {
                $amount = InternalStorage::find($request['id'])->amount;
                InternalStorage::where('id', $request['id'])->update([
                'amount' => $amount + $request['amount']
            ]);
            } else {
                $amount = ShelfStorage::find($request['id'])->amount;
                ShelfStorage::where('id', $request['id'])->update([
                'amount' => $amount + $request['amount']
            ]);
            }
            $error = '<span class="text-primary">انتقال با موفقیت انجام شد.</span>';
            return view('new.drug.success', compact('error'));
        }
    }

    public function transferToShelf($id)
    {
        $model = InternalStorage::find($id);
        return view('new.drug.transfer-to-shelf', compact('model'));
    }

    public function submitTransferToShelf(Request $request)
    {
        $amount = InternalStorage::find($request['id'])->amount;
        if ($request['amount'] > $amount) {
            $error = '<span class="text-danger">مقدار وارد شده بیشتر از مقدار موجودی انبار است</span>';
            return view('new.drug.success', compact('error'));
        } else {
            InternalStorage::where('id', $request['id'])->update([
                'amount' => $amount - $request['amount']
            ]);
            $amount = ShelfStorage::find($request['id'])->amount;
            ShelfStorage::where('id', $request['id'])->update([
                'amount' => $amount + $request['amount']
            ]);
            $error = '<span class="text-primary">انتقال با موفقیت انجام شد.</span>';
            return view('new.drug.success', compact('error'));
        }
    }
}
