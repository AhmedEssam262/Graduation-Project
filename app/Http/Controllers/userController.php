<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function getUserData($username)
    {
        $user = User::where('username', $username)->first();
        $doctor = Doctor::where('username', $username)->first();
        if($user->user_type=='doctor') {
            $userData = [
                'state' => 'good, ok',
                'message' => 'information retreived successfully',
                'data' => [
                    'user' => [
                        'user_id' => $user->id,
                        'nick_name' => $user->name,
                        'user_type' => $user->user_type,
                        'bdate' => $user->bdate,
                        'gender' => $user->gender,
                        'prefix' => $user->prefix,
                        'pnumber' => $user->pnumber,
                        'email' => $user->email,
                        'province' => $user->province,
                        'city' => $user->city,
                        'street' => $user->street,
                        'img_url' => $user->img_url,
                        'age' => $user->age,
                        'img_urls' => [
                            [
                                'img_url' => $user->img_url
                            ]
                        ]
                    ],
                    'doctor' => [
                        'doctor_id' => $user->id,
                        'current_hospital' => $doctor->current_hospital,
                        'graduation_year' => $doctor->graduation_year,
                        'experience_years' => $doctor->experience_years,
                        'about' => $doctor->about,
                        'specialty' => $doctor->specialty,
                        'experiences' => $doctor->experiences,
                        'salary' => $doctor->salary,
                        'fees' => $doctor->salary,
                        'certificate_count' => $doctor->certificate_count,
                        'rate' => $doctor->rate,
                        'num_rate' => $doctor->num_rate,
                    ]

                ]
            ];
            return response()->json($userData);
        }
        else{
            $userData = [
                'state' => 'good, ok',
                'message' => 'information retreived successfully',
                'data' => [
                    'user' => [
                        'user_id' => $user->id,
                        'nick_name' => $user->name,
                        'user_type' => $user->user_type,
                        'bdate' => $user->bdate,
                        'gender' => $user->gender,
                        'prefix' => $user->prefix,
                        'pnumber' => $user->pnumber,
                        'email' => $user->email,
                        'province' => $user->province,
                        'city' => $user->city,
                        'street' => $user->street,
                        'img_url' => $user->img_url,
                        'age' => $user->age,
                        'img_urls' => [
                            [
                                'img_url' => $user->img_url
                            ]
                        ]
                    ]
                ]
            ];
            return response()->json($userData);
        }
    }
}
