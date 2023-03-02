<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Util\Xml\Validator;

class authController extends Controller
{



    public function adduser(Request $request)
    {

        $u = ($request->input('data'));
        $x=$u['username'];

        $users = User::where('username',$x)->first();

        if($users){
            $state="bad request";
            $message="inf. not found";
            $data = [
                'err' => [
                'code' => "ER_DUP_ENTRY"
                ]

            ];
            return response(compact('state','message','data'),400);
        }

        $state="good, ok";
        $user = User::create([
        'name' => $u['nickname'],
        'email' => $u['email'],
        'username' => $u['username'],
        'password' => bcrypt($u['password']),
            'user_type' => $u['userType'],
            'bdate' =>$u ['birth'],
            'gender' => $u['gender'],
            'prefix' =>$u['prefix'],
            'phone' =>$u['phone'],
            'moreInf' =>$u['moreInf'],
            'img_url' =>$u['images']
        ]);

        $data = User::where('username',$x)->first();
        $user_id=$data->id;
        if($u['userType'] == "doctor") {

            $data = User::where('username',$x)->first();
            $user_id=$data->id;

            $doctors = Doctor::create([
                'name' => $data['nickname'],
                'user_id'=>$user_id,
                'username' => $data['username'],
                'staff_type' => $u['userType'],
                'specialty' => $u['specialty'],
                'age' => Carbon::parse($u ['birth'])->age,
/*                'num_rate' => $u['num_rate'],*/
/*                'rate' => $u['rate'],*/
                'current_hospital' => $u['chospital'],
                'graduation_year' => $u['gyear'],
                'experience_years' => $u['eyears'],
                'experiences' =>$u['achievement'],
                'about' => $u['about'],
                'salary' => $u['salary'],
/*                'certificate_count' => $request->data->certificate_count,*/
            ]);
            $token = $user->createToken('main')->plainTextToken;
            $message="information retreived successfully";
            $data = [
                'user_id'=>$user_id
                ];

            return response(compact('state', 'message','data'),200);
        }
        $data = [
            'user_id'=>$user_id
        ];
        $message="information retreived successfully";
        $token = $user->createToken('main')->plainTextToken;
        return response(compact('state', 'message','data'),200);
    }
/*
 * ******************************************** login ********************************************
 */
    public function login(Request $request){
        $credentials = ($request->input('data'));
        $username=$credentials['username'];
        if (Auth::attempt($credentials)) {
            $state= "good, ok";
            $message= "information retreived successfully";
            Auth::loginUsingId(1);
            $user = User::where('username',$username)->first();
            $user_id=$user->id;
            $data = [
                'isVerified'=>1,
                "user_id"=> $user_id
            ];
            return response(compact('state','message','data'),200);
        }
        $user = User::where('username',$username)->first();
        if(!$user) {
            $state = "bad request";
            $message = "Incorrect username";
            $data = [
                'isExist'=>0
            ];
            return response(compact('state', 'message','data'),400);
        }
        $state = "bad request";
        $message = "Incorrect password";
        $data = [
            'isVerified'=>0
        ];
        return response(compact('state', 'message','data'),400);
    }
}
