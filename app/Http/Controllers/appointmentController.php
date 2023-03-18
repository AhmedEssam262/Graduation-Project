<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class appointmentController extends Controller
{
/*    public function __construct()
    {
        $this->middleware('auth:api');
    }*/
    public function sched_appointment(Request $request)
    {
        if(!Auth::user()){
            $state="not authorized to access";
            $message="cannot access to api resources";
            $data = [
                'isUser'=>0
            ];
            return response(compact('state', 'message','data'),401);
        }
        $doctor_id =Auth::user()->id;

        $all_data = ($request->input('data'));
        $date = $all_data['date'];
        $addedAppointments = $all_data['addedAppointments'];
        $date_delete = Appointment::where([['schedule_from', '=', $doctor_id], ['schedule_date', '=', $date], ['appointment_state', '=', 'free']]);
        $date_delete->delete();
        foreach ($addedAppointments as $s) {
            $user = Appointment::create([
                'schedule_date' => $date,
                'schedule_from' => $doctor_id,
                'slot_time' => $s['slotTime'],
                'appointment_type'=> $s['appointmentType'],
                'duration'=>$s['appointmentDuration'],
            ]);
        }
        $msg = "done";
        return response(compact('msg','doctor_id'), 200);
    }

    /*
     * ******************** Book Appointment ********************
     */
    public function book_appointment(Request $request){
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
        $date = $all_data['date'];
        $booked_slot = $all_data['bookedSlot'];
        $doctor_id = $all_data['doctorId'];
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
    * ******************** get_slots ********************
    */
    public function get_slots(Request $request){

        $all_data = ($request->input('data'));
        $date = $all_data['date'];
        $doctor_id = $all_data['doctorId'];
        $totalSlots=array();
        $bookedSlots=array();
        $freeSlots=array();
        $ts = Appointment::where([['schedule_from', '=', $doctor_id], ['schedule_date', '=', $date]])->get();
/*        return response(compact('ts'),200);*/
        $slot=array('appointmentState'=>'0','appointmentType'=>'none','slotTime'=>'12:00 am','appointmentDuration'=>'0' );

        $bs = Appointment::where([['schedule_from', '=', $doctor_id], ['schedule_date', '=', $date], ['appointment_state', '=', 'booked']])->get();
        $fs = Appointment::where([['schedule_from', '=', $doctor_id], ['schedule_date', '=', $date], ['appointment_state', '=', 'free']])->get();
        foreach ($ts as $t_s){
            $slot['appointmentState']=$t_s->appointment_state;
            $slot['appointmentType']=$t_s->appointment_type;
            $slot['slotTime']=$t_s->slot_time;
            $slot['appointmentDuration']=$t_s->duration;
            array_push($totalSlots, $slot);
        }

        foreach ($bs as $b_s){
            $slot['appointmentState']=$b_s->appointment_state;
            $slot['appointmentType']=$b_s->appointment_type;
            $slot['slotTime']=$b_s->slot_time;
            $slot['appointmentDuration']=$b_s->duration;
            array_push($bookedSlots, $slot);
        }

        foreach ($fs as $f_s) {
            $slot['appointmentState']=$f_s->appointment_state;
            $slot['appointmentType']=$f_s->appointment_type;
            $slot['slotTime']=$f_s->slot_time;
            $slot['appointmentDuration']=$f_s->duration;
            array_push($freeSlots, $slot);
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
            $doctor_id = $_GET['userid'];
            $data_update = Appointment::where([['schedule_from', '=', $doctor_id], ['schedule_date', '=', $date], ['slot_time', '=', $bookedSlot]])->first();
            $data_update->appointment_state="cancelled";
            $data_update->save();
            $data = [
                'fromDoctor'=>$doctor_id,
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
