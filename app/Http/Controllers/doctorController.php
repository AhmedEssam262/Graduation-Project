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
        $total=false;
        if(isset($_GET['total'])) {
            $total  =$_GET['total'];
        }
        if($total==true){
            if(isset($_GET['specialty'])) {
                $spec  =$_GET['specialty'];
            }

            if(isset($_GET['dname'])) {
                $doc_name  =$_GET['dname'];
            }

            $doctor = Doctor::all();
            if($spec!=null && $doc_name==null){
                $doctor = Doctor::where('specialty','=',$spec)->get();
            }
            if($spec==null && $doc_name!=null){
                $doctor = Doctor::where('name','LIKE','%'.$doc_name.'%')->get();
            }

            if($spec!=null && $doc_name!=null){
                $doctor = Doctor::where([['name','LIKE','%'.$doc_name.'%'],['specialty','=',$spec]])->get();
            }

            $data = array();
            $state= 'good, ok';
            $message = 'information retreived successfully';
            foreach ($doctor as $d) {
                $ver=null;
                if($d->type=="verified"){
                    $ver=1;
                }
                else if($d->type=="reject"){
                    $ver=0;
                }
                $doctorData = [
                    'doctor_id' => $d->user_id,
                    'user_name' => $d->username,
                    'rate' => $d->rate,
                    'specialty' => $d->specialty,
                    'is_verified' => $ver,
                    'nick_name' => $d->name,
                    'fees' => $d->salary,
                    'about' => $d->about,
                    'img_urls' => $d->img_url
                ];
                array_push($data, $doctorData);
            }
            return response(compact('state','message','data'), 200);
        }


        if(isset($_GET['specialty'])) {
            $spec  =$_GET['specialty'];
        }

        if(isset($_GET['dname'])) {
            $doc_name  =$_GET['dname'];
        }

        $doctor = Doctor::where('type','=','verified')->get();
        if($spec!=null && $doc_name==null){
            $doctor = Doctor::where('specialty','=',$spec)->get();
        }
        if($spec==null && $doc_name!=null){
            $doctor = Doctor::where('name','LIKE','%'.$doc_name.'%')->get();
        }

        if($spec!=null && $doc_name!=null){
            $doctor = Doctor::where([['name','LIKE','%'.$doc_name.'%'],['specialty','=',$spec]])->get();
        }

        $data = array();
        $state= 'good, ok';
        $message = 'information retreived successfully';
        foreach ($doctor as $d) {
            $ver=null;
            if($d->type=="verified"){
                $ver=1;
            }
            else if($d->type=="reject"){
                $ver=0;
            }
            $doctorData = [
                'doctor_id' => $d->user_id,
                'user_name' => $d->username,
                'rate' => $d->rate,
                'specialty' => $d->specialty,
                'is_verified' => $ver,
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
