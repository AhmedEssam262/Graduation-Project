<?php

namespace App\Http\Controllers;

use Error;
use Illuminate\Http\Request;
$stripeSecretKey="sk_test_51M9qWBLkzeNmV6Wx7H4pWNOFftLNYa2rCd5u3lFC8XEsApi8gMW0FW7zY4zNreicClve5Sj0Y7smYfCf3LcnbDk000lk8tZOuT";
\Stripe\Stripe::setApiKey($stripeSecretKey);


class paymentController extends Controller
{

    public function pay(Request $request){
        header('Content-Type: application/json');

        $jsonStr = file_get_contents('php://input');
        $jsonObj = json_decode($jsonStr);
        $all_data = ($request->input('data'));


        // Create a PaymentIntent with amount and currency
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => 5000,
            'currency' => 'usd',
            'description' => json_encode($all_data)
        ]);

        $output = [
            'clientSecret' => $paymentIntent->client_secret,
        ];
        echo json_encode($output);

    }
}
