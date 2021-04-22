<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

	public function form()
	{
		return view('new.payment.form');
	}
    public function gateway(Request $request)
    {
        $MerchantID = '3fcf16da-0f82-11ea-9cb2-000c295eb8fc'; //Required
        $Amount = $request['amount']; //Amount will be based on Toman - Required
        $Description = 'افزایش اعتبار پیامکی'; // Required
        $Email = 'UserEmail@Mail.Com'; // Optional
        $Mobile = '09338708767'; // Optional
        $CallbackURL = url('callback?user_id=' . $request['user_id'] . '&amount=' . $Amount); // Required


        $client = new \SoapClient('https://zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

        $result = $client->PaymentRequest(
            [
                'MerchantID' => $MerchantID,
                'Amount' => $Amount,
                'Description' => $Description,
                'Email' => $Email,
                'Mobile' => $Mobile,
                'CallbackURL' => $CallbackURL,
            ]
        );

        //Redirect to URL You can do it also by creating a form
        if ($result->Status == 100) {
            return redirect('https://zarinpal.com/pg/StartPay/' . $result->Authority);
        } else {
            echo 'ERR: ' . $result->Status;
        }
    }

    public function callback(Request $request)
    {
        $user_id = $request['user_id'];
        $credit = Setting::first()->credit;

        $Amount = $request['amount'];

        $client = new \SoapClient('https://zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

        $result = $client->PaymentVerification(
            [
                'MerchantID' => '3fcf16da-0f82-11ea-9cb2-000c295eb8fc',
                'Authority' => $request['Authority'],
                'Amount' => $Amount,
            ]
        );

        if ($request['Status'] == 'OK') {
            if ($result->Status == 100) {
                Setting::where('id','>',0)->update([
                    'credit' => $credit + $Amount*0.91*10
                ]);
                $ref_id = $result->RefID;

                return redirect('/');
            } else {
                return redirect('/');
            }
        } else {
            return redirect('/');
        }
    }


}
