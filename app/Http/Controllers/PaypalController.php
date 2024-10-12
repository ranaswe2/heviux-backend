<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    public function payment($processId)
    {
        $trx= Transaction::where('process_id', $processId)->first();
        $totalAmount=$trx->total_amount;

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken= $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal-success', ['processId' => $processId]),
                "cancel_url" => route('paypal-cancel')
            ],
            "purchase_units" => [
                [
                    "amount" => [
                    "currency_code" => "EUR",
                    "value" => $totalAmount
                    ]
                ]
            ]
        ]);

        if(isset($response['id']) && $response['id'] != null){
            foreach($response['links'] as $link){
                if($link['rel']==='approve'){
                    
                    return redirect()->away($link['href']);
                }
            }
        }
        else{
            return redirect()->route('paypal-cancel');
        }
    }

    public function success(Request $request)
    {   
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        
        $paypalToken= $provider->getAccessToken();
        $processId = $request->processId;
        $response= $provider->capturePaymentOrder($request->token);

        
        if(isset($response['status']) && $response['status'] == "COMPLETED"){
            

            Transaction::where('process_id', $processId)
            ->update([
                'transaction_id' => $response['id'],
                'status' => 'completed',
            ]);

            return "Payment has done!";
        }
        else{
            return redirect()->route('paypal-cancel');
        }
    }

    public function cancel()
    { 
        return "Payment has cancelled!";
    }

}
