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
<<<<<<< HEAD
        $this->middleware('auth:api', ['except' => ['login','adduser','chkuname']]);
=======
        $this->middleware('auth:api', ['except' => ['login','adduser','chkuname','user']]);
>>>>>>> a4cccf7 (after all updates for version one submission)
    }


    public function adduser(Request $request)
    {

<<<<<<< HEAD
        $u = ($request->input('data'));
        $x=$u['username'];

=======
        $u= ($request->input('data'));
        $x=$u['username'];
>>>>>>> a4cccf7 (after all updates for version one submission)
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
<<<<<<< HEAD
=======
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

>>>>>>> a4cccf7 (after all updates for version one submission)

        $state="good, ok";
        $user = User::create([
            'name' => $u['nickname'],
<<<<<<< HEAD
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
=======
            'email' => $email,
            'username' => $u['username'],
            'password' => bcrypt($u['password']),
            'user_type' => $user_type,
            'bdate' =>$bdate,
            'gender' => $u['gender'],
            'prefix' =>$prefix,
            'phone' =>$phone,
            'img_url' =>$images,
>>>>>>> a4cccf7 (after all updates for version one submission)
        ]);

        $data = User::where('username',$x)->first();
        $user_id=$data->id;
<<<<<<< HEAD
        if($u['userType'] == "doctor") {

            $data = User::where('username',$x)->first();
            $user_id=$data->id;

            $doctors = Doctor::create([
                'name' => $data['nickname'],
=======
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
>>>>>>> a4cccf7 (after all updates for version one submission)
                'user_id'=>$user_id,
                'username' => $data['username'],
                'staff_type' => $u['userType'],
                'specialty' => $u['specialty'],
                'age' => Carbon::parse($u ['birth'])->age,
                /*                'num_rate' => $u['num_rate'],*/
                /*                'rate' => $u['rate'],*/
<<<<<<< HEAD
                'current_hospital' => $u['chospital'],
                'graduation_year' => $u['gyear'],
                'experience_years' => $u['eyears'],
                'experiences' =>$u['achievement'],
                'about' => $u['about'],
                'salary' => $u['salary'],
=======
                'current_hospital' => $chospital,
                'graduation_year' => $gyear,
                'experience_years' => $eyears,
                'experiences' =>$achievement,
                'about' => $about,
                'salary' => $salary,
>>>>>>> a4cccf7 (after all updates for version one submission)
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
<<<<<<< HEAD
        $token = $user->createToken('main')->plainTextToken;
=======
>>>>>>> a4cccf7 (after all updates for version one submission)
        return response(compact('state', 'message','data'),200);
    }
    /*
     * ******************************************** login ********************************************
     */
    public function login(Request $request){
        $credentials = ($request->input('data'));
        $username=$credentials['username'];
<<<<<<< HEAD
        if (Auth::attempt($credentials)) {
            $token=Auth::attempt($credentials);
=======
        $cred['username']=$username;
        $cred['password']=$credentials['password'];
        if (Auth::attempt($cred)) {
            $token=Auth::attempt($cred);
>>>>>>> a4cccf7 (after all updates for version one submission)
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

<<<<<<< HEAD
    /*
    * ******************************************** Check user ********************************************
     */
=======
    public function user()
    {
        if(!Auth::user()){
            $state = "not authorized to access";
            $message = "cannot access to api resources";
            $data = [
                'name'=>"JsonWebTokenError",
                'message'=>"invalid token"
            ];
            return response(compact('state', 'message','data'),401);
        }
        $state = "good, ok";
        $message = "information retreived successfully";
        $user=Auth::user();
        $data = [
            'user_id'=>$user->id,
            'user_name'=>$user->name,
            'user_type'=>$user->user_type,
            'nick_name'=>$user->name,
            'bdate'=>$user->bdate,
            'gender'=>$user->gender,
            'img_url'=>$user->img_url,
        ];
        return response(compact('state', 'message','data'),200);

    }
        /*
        * ******************************************** Check user ********************************************
         */
>>>>>>> a4cccf7 (after all updates for version one submission)
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
