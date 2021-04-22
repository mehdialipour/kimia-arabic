<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$query = Setting::first();
        return view('new.setting.index', compact('query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $model = Setting::first();

        return view('new.setting.form', compact('model'));
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
    	$printer = '';
    	foreach($request['printer'] as $key => $value) {
    		$printer.=$value.'-';
    	}

    	$printer = rtrim($printer,'-');
        $query = Setting::find(1)->update([
        	'name' => $request['name'],
        	'manager' => $request['manager'],
        	'phone' => $request['phone'],
        	'mobile' => $request['mobile'],
        	'address' => $request['address'],
        	'website' => $request['website'],
        	'email' => $request['email'],
        	'printer' => $printer,
            'card_number' => $request['card_number'],
            'payment_link' => $request['payment_link']
        ]);

        return redirect('settings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
