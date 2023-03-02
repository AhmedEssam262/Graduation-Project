<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class doctorController extends Controller
{
    public function getDoctorData()
    {
        $doctor = Doctor::all();

        $data = array();
        $state= 'good, ok';
        $message = 'information retreived successfully';
        foreach ($doctor as $d) {
            $doctorData = [
                        'doctor_id' => $d->id,
                        'user_name' => $d->username,
                        'rate' => $d->rate,
                        'specialty' => $d->specialty,
                        'nick_name' => $d->name,
                        'fees' => $d->salary,
                        'about' => $d->about,
                        'img_urls' => $d->img_url

            ];
            array_push($data, $doctorData);
        }
        return response(compact('state','message','data'), 200);
    }
}
