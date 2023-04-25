<?php

namespace App\Http\Controllers;

use Error;
use Illuminate\Http\Request;

class paymentController extends Controller
{
    public function pay(Request $request){
        header('Content-Type: application/json');

        try {
            // retrieve JSON from POST body
            $jsonStr = file_get_contents('php://input');
            $jsonObj = json_decode($jsonStr);

            $state = "good, ok";
            $message = "your data added successfully";
            $data = [
                'done' => true
            ];
            return response(compact('state', 'message', 'data'), 200);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
