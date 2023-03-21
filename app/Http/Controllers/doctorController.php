<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class doctorController extends Controller
{
    public function getDoctorData()
    {
        $spec=Null;
        $doc_name=null;
        if(isset($_GET['specialty'])) {
            $spec  =$_GET['specialty'];
        }

        if(isset($_GET['dname'])) {
            $doc_name  =$_GET['dname'];
        }

        $doctor = Doctor::all();
        if($spec!=null && $doc_name==null){
            $doctor = Doctor::where('specialty','=',$spec);
        }
        if($spec==null && $doc_name!=null){
            $doctor = Doctor::where('name','=',$doc_name);
        }

        if($spec!=null && $doc_name!=null){
            $doctor = Doctor::where(['name','=',$doc_name],['specialty','=',$spec]);
        }

        $data = array();
        $state= 'good, ok';
        $message = 'information retreived successfully';
        foreach ($doctor as $d) {
            $doctorData = [
                        'doctor_id' => $d->user_id,
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
