<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class appointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function sched_appointment(Request $request)
    {
        $userid = $_GET['userid'];
        $doctor = Doctor::where('user_id', $userid)->first();
        $doctor_id = $doctor->id;
        $all_data = ($request->input('data'));
        $date = $all_data['date'];
        $total_slots = $all_data['totalSlots'];
        $date_delete = Appointment::where([['schedule_from', '=', $doctor_id], ['schedule_date', '=', $date], ['appointment_state', '=', 'free']]);
        $date_delete->delete();
        foreach ($total_slots as $s) {
            $user = Appointment::create([
                'schedule_date' => $date,
                'schedule_from' => $doctor_id,
                'slot_time' => $s,
            ]);
        }
        $a=Auth::user()->id;
        $msg = "done";
        return response(compact('msg','a'), 200);


    }

    /*
     * ******************** Book Appointment ********************
     */
    public function book_appointment(Request $request){
        $userid = $_GET['userid'];
        $user = User::where('id', $userid)->first();
        $user_id = $user->id;
        $all_data = ($request->input('data'));
        $date = $all_data['date'];
        $booked_slot = $all_data['bookedSlot'];
        $doc_user = $all_data['doctorId'];
        $doctor = Doctor::where('user_id', $doc_user)->first();
        $doctor_id = $doctor->id;
        $date_update = Appointment::where([['schedule_from', '=', $doctor_id], ['schedule_date', '=', $date], ['slot_time', '=', $booked_slot]])->first();

        if(empty($date_update)){
            $state="bad request";
            $message= "inf. not found";
            $data = [
                'isCanceled'=>true
            ];
            return response(compact('state', 'message','data'),400);
        }

        elseif ($date_update->appointment_state=='booked'){


            $state="bad request";
            $message= "inf. not found";
            $data = [
                'isBooked'=>true
            ];
            return response(compact('state', 'message','data'),400);
        }
        elseif ($date_update->appointment_state='free'){
            $date_update->appointment_state="booked";
            $date_update->booked_from=$user_id;
            $date_update->booked_time=\Carbon\Carbon::now()->toDateTimeString();;
            $date_update->save();

            $state="good, ok";
            $message= "your data added successfully";
            $data = [
                'isFirst'=>0
            ];
            return response(compact('state', 'message','data'),400);
        }
        $error="sfa";
        return response(compact('error'),400);

    }
    /*
     *
     **/
    public function get_slots(Request $request){

        $all_data = ($request->input('data'));
        $date = $all_data['date'];
        $doc_user = $all_data['doctorId'];
        $doctor = Doctor::where('user_id', $doc_user)->first();
        $doctor_id = $doctor->id;
        $totalSlots=array();
        $bookedSlots=array();
        $freeSlots=array();;
        $ts = Appointment::where([['schedule_from', '=', $doctor_id], ['schedule_date', '=', $date]])->get();
/*        return response(compact('ts'),200);*/

        $bs = Appointment::where([['schedule_from', '=', $doctor_id], ['schedule_date', '=', $date], ['appointment_state', '=', 'booked']])->get();
        $fs = Appointment::where([['schedule_from', '=', $doctor_id], ['schedule_date', '=', $date], ['appointment_state', '=', 'free']])->get();
        foreach ($ts as $t_s){
            array_push($totalSlots, $t_s->slot_time);
        }

        foreach ($bs as $b_s){
            array_push($bookedSlots, $b_s->slot_time);
        }
        $freeSlots=array();
        foreach ($fs as $f_s) {
            array_push($freeSlots, $f_s->slot_time);
        }
        if (empty($freeSlots)) {
            $freeSlots=null;
        }
        $state="good, ok";
        $message= "information retreived successfully";
        $data = [
            'totalSlots'=>$totalSlots,
            'bookedSlots'=>$bookedSlots,
            'freeSlots'=>$freeSlots
        ];
        return response(compact('state', 'message','data'),200);
    }
    public function cancel_appointment(Request $request){
        $all_data = ($request->input('data'));
        $date = $all_data['date'];
        $cancelFrom = $all_data['cancelFrom'];
        $bookedSlot = $all_data['bookedSlot'];
        $state="state";
        $message="information retreived successfully";
        if($cancelFrom=='doctor'){
            $doc_user = $_GET['userid'];;
            $doctor = Doctor::where('user_id', $doc_user)->first();
            $doctor_id = $doctor->id;
            $data_update = Appointment::where([['schedule_from', '=', $doctor_id], ['schedule_date', '=', $date], ['slot_time', '=', $bookedSlot]])->first();

            $data_update->appointment_state="cancelled";
            $data_update->save();
            $data = [
                'fromDoctor'=>$doc_user,
            ];
            return response(compact('state', 'message','data'),200);

        }
        $user_id = $_GET['userid'];
        $doc_user = $all_data['doctorId'];
        $doctor = Doctor::where('user_id', $doc_user)->first();

        $doctor_id = $doctor->id;
        $data_update = Appointment::where([['schedule_from', '=', $doctor_id],['booked_from', '=', $user_id], ['schedule_date', '=', $date], ['slot_time', '=', $bookedSlot]])->first();
/*        return response(compact('data_update'),200);*/
        $data_update->appointment_state="cancelled";
        $data_update->save();
        $data = [
            'fromPatient'=>$user_id,
        ];
        return response(compact('state', 'message','data'),200);

    }
}
