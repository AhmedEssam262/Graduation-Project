<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class appointmentController extends Controller
{
    public function sched_appointment(Request $request, $userid)
    {
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
        $msg = "done";
        return response(compact('msg'), 200);


    }

    /*
     * ******************** Book Appointment ********************
     */
    public function book_appointment(Request $request, $userid){
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
}
