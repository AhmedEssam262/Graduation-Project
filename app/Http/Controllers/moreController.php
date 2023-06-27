<?php

namespace App\Http\Controllers;

use App\Models\Clinic_detail;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class moreController extends Controller
{
    public function submit_clinic(Request $request){
        if(!Auth::user()){
            $state="not authorized to access";
            $message="cannot access to api resources";
            $data = [
                'isUser'=>0
            ];
            return response(compact('state', 'message','data'),401);
        }
        $user_id =Auth::user()->id;
        $all_data = ($request->input('data'));
        $phone=$all_data['phone'];
        $telephone=$all_data['telephone'];
        $prefix=$all_data['prefix'];
        $isEdit=true;
        if(isset($all_data['isEdit'])){
            $isEdit=$all_data['isEdit'];
        }

        $name=false;
        if(isset($all_data['clinic_name'])){
            $name=$all_data['clinic_name'];
        }
        $address=$all_data['address'];
        $city=$address['city'];
        $street=$address['street'];
        if(!$isEdit){
            $state = "bad request";
            $message = "inf. not found";
            $data = [
                'is_exist' => true,
            ];
            return response(compact('state', 'message', 'data'), 200);
        }
        else{
            $like = Clinic_detail::create([
                'doctor_id' => $user_id,
                'clinic_name' => $name,
                'city' => $city,
                'street' => $street,
                'prefix'=>$prefix,
                'pnumber'=>$phone,
                'tnumber'=>$telephone,
            ]);
        }
        $state = "good, ok";
        $message = "your data added successfully";
        $data = [
            'isFirst' => false,
        ];
        return response(compact('state', 'message', 'data'), 200);
    }
}
