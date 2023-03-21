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
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','adduser','chkuname']]);
    }


    public function adduser(Request $request)
    {

        $u= ($request->input('data'));
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
        $email=null;
        if(isset($u['email'])){
            $email=$u['email'];
        }
        $user_type="none";
        if(isset($u['userType'])){
            $user_type=$u['userType'];
        }
        $bdate=null;
        if(assert($u['birth'])){
            $bdate=$u['birth'];
        }
        $prefix=null;
        if(isset($u['prefix'])){
            $prefix=$u['prefix'];
        }

        $phone=null;
        if(isset($u['phone'])){
            $phone=$u['phone'];
        }
        $images=null;
        if(isset($u['images'])){
            $images=$u['images'];
        }


        $state="good, ok";
        $user = User::create([
            'name' => $u['nickname'],
            'email' => $email,
            'username' => $u['username'],
            'password' => bcrypt($u['password']),
            'user_type' => $user_type,
            'bdate' =>$bdate,
            'gender' => $u['gender'],
            'prefix' =>$prefix,
            'phone' =>$phone,
            'img_url' =>$images,
        ]);

        $data = User::where('username',$x)->first();
        $user_id=$data->id;
        $user_name=$data->name;

        if($u['userType'] == "doctor") {
            $moreInf=null;
            if(isset($u['moreInf'])){
                $moreInf=$u['moreInf'];
            }
            $data = User::where('username',$x)->first();
            $chospital=null;
            if(isset($u['chospital'])){
                $chospital=$u['chospital'];
            }
            $gyear=null;
            if(isset($u['gyear'])){
                $gyear=$u['gyear'];
            }
            $eyears=null;
            if(isset($u['eyears'])){
                $eyears=$u['eyears'];
            }

            $achievement=null;
            if(isset($u['achievement'])){
                $achievement=$u['achievement'];
            }
            $about=null;
            if(isset($u['about'])){
                $about=$u['about'];
            }

            $salary=null;
            if(isset($u['salary'])){
                $salary=$u['salary'];
            }
            $doctors = Doctor::create([
                'name' => $user_name,
                'user_id'=>$user_id,
                'username' => $data['username'],
                'staff_type' => $u['userType'],
                'specialty' => $u['specialty'],
                'age' => Carbon::parse($u ['birth'])->age,
                /*                'num_rate' => $u['num_rate'],*/
                /*                'rate' => $u['rate'],*/
                'current_hospital' => $chospital,
                'graduation_year' => $gyear,
                'experience_years' => $eyears,
                'experiences' =>$achievement,
                'about' => $about,
                'salary' => $salary,
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
        return response(compact('state', 'message','data'),200);
    }
    /*
     * ******************************************** login ********************************************
     */
    public function login(Request $request){
        $credentials = ($request->input('data'));
        $username=$credentials['username'];
        if (Auth::attempt($credentials)) {
            $token=Auth::attempt($credentials);
            $state= "good, ok";
            $message= "information retreived successfully";
            $user = User::where('username',$username)->first();
            $user_id=$user->id;
            $data = [
                'isVerified'=>1,
                "user_id"=> $user_id,
                "token"=>$token,
                "type"=>"bearer"
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

    /*
    * ******************************************** Check user ********************************************
     */
    public function chkuname($username)
    {
        $users = User::where('username',$username)->first();

        if($users){
            $state="bad request";
            $message="inf. not found";
            $data = [
                'isUser'=>true
            ];
            return response(compact('state','message','data'),400);
        }

        $state="good, ok";
        $message="information retreived successfully";
        $data = [
            'isUser'=>false
        ];
        return response(compact('state','message','data'),200);
    }
}
