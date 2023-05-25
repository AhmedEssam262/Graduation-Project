<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Feedback;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function getStatistics()
    {
        $state="good, ok";
        $message="information retreived successfully";
        $total_appointments=Appointment::count();
        $total_doctors=Doctor::count();
        $total_feedbacks=Feedback::count();

        $data = [
            'totalAppointments' => $total_appointments,
            'avgRate'=>4.7,
            'avgFees'=>200,
            'totalDoctors'=>$total_doctors,
            'totalReviews'=>$total_feedbacks
        ];
        return response(compact('state', 'message', 'data'), 200);


    }
}
