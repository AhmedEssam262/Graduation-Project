<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Staff;
use App\Models\Feedback;
use Illuminate\Http\Request;

class feedbackController extends Controller
{
    public function filter_feedback()
    {
        $username=null;
        $limit=0;
        if(isset($_GET['username'])){
            $username=$_GET['username'];



            $doctor = Doctor::where('username', $username)->first();
            $doctor_user = User::where('username', $username)->first();
            $feedback = feedback::where('feedback_to', $doctor->user_id)->get()->limit(5);
            $res = array();
            foreach ($feedback as $f) {
                $userpat = User::where('id', $f->feedback_from)->first();
                $userData = [
                    'state' => 'good, ok',
                    'message' => 'information retreived successfully',
                    'data' => [
                        'user' => [
                            'feedback_from' => $f->feedback_from,
                            'feedback_to' => $f->feedback_to,
                            'rate' => $f->rate,
                            'issued_time' => $f->updated_at,
                            'feedback' => $f->feedback,
                            'uimgUrl' => $userpat->img_url,
                            'dimgUrl' => $doctor_user->img_url,
                            'username' => $userpat->username,
                            'doctorName' => $doctor->name,
                        ]
                    ]
                ];
                array_push($res, $userData);

            }
            return response(compact('res'), 200);
        }
        if(isset($_GET['limit'])){
            $limit=$_GET['limit'];
            $feedback = feedback::all()->get()->limit($limit);
            $res = array();
            foreach ($feedback as $f) {
                $userpat = User::where('id', $f->feedback_from)->first();
                $userpdoc = User::where('id', $f->feedback_to)->first();
                $userData = [
                    'state' => 'good, ok',
                    'message' => 'information retreived successfully',
                    'data' => [
                        'user' => [
                            'feedback_from' => $f->feedback_from,
                            'feedback_to' => $f->feedback_to,
                            'rate' => $f->rate,
                            'issued_time' => $f->updated_at,
                            'feedback' => $f->feedback,
                            'uimgUrl' => $userpat->img_url,
                            'dimgUrl' => $userpdoc->img_url,
                            'username' => $userpat->username,
                            'doctorName' => $userpdoc->name,
                        ]
                    ]
                ];
                array_push($res, $userData);

            }
            return response(compact('res'), 200);
        }

        $feedback = feedback::all()->get()->limit(5);
        $res = array();
        foreach ($feedback as $f) {
            $userpat = User::where('id', $f->feedback_from)->first();
            $userpdoc = User::where('id', $f->feedback_to)->first();
            $userData = [
                'state' => 'good, ok',
                'message' => 'information retreived successfully',
                'data' => [
                    'user' => [
                        'feedback_from' => $f->feedback_from,
                        'feedback_to' => $f->feedback_to,
                        'rate' => $f->rate,
                        'issued_time' => $f->updated_at,
                        'feedback' => $f->feedback,
                        'uimgUrl' => $userpat->img_url,
                        'dimgUrl' => $userpdoc->img_url,
                        'username' => $userpat->username,
                        'doctorName' => $userpdoc->name,
                    ]
                ]
            ];
            array_push($res, $userData);
        }
        return response(compact('res'), 200);

    }
}
