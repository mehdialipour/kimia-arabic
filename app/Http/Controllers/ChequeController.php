<?php

namespace App\Http\Controllers;

use App\Helpers\ConvertNumber;
use App\Models\Cheque;
use App\Models\ChequeSerial;
use Illuminate\Http\Request;

class ChequeController extends Controller
{
    public function index()
    {
        $query = Cheque::all();
        return view('new.cheque.index', compact('query'));
    }

    public function create()
    {
        return view('new.cheque.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $query = Cheque::create(ConvertNumber::convert($request->all()));
        
        $papers = ConvertNumber::convert($request['papers']);
        $number = ConvertNumber::convert($request['number']);

        for($i=1; $i<=$papers; $i++) {
        	ChequeSerial::create([
        		'cheque_id' => $query->id,
        		'number' => $number
        	]);

        	$number++;
        }
        return redirect('cheques');
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
        $model = Cheque::find($id);
        return view('new.cheque.form', compact('model'));
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
        $model = Cheque::find($id);
        $model->fill($request->all());
        $model->save();

        return redirect('cheques');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cheque::find($id)->delete();
        return redirect()->back();
    }
}
