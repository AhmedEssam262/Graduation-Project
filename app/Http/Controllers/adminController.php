<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminController extends Controller
{
    public function verification(Request $request){
        if(!Auth::user()){
            $state="not authorized to access";
            $message="cannot access to api resources";
            $data = [
                'isUser'=>0
            ];
            return response(compact('state', 'message','data'),401);
        }
        $all_data = ($request->input('data'));
        $doctor_id=$all_data['doctorId'];
        $type=$all_data['type'];

        $doctor = Doctor::where('user_id', $doctor_id)->first();
        $doctor->type=$type;
        $doctor->save();
        $state= 'good, ok';
        $message = 'information retreived successfully';
        $data = [
            'isDone' => true
        ];
        return response(compact('state', 'message', 'data'), 200);


    }
}
