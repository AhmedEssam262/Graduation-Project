<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;

class deleteAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete_past_appointments';

    protected $description = 'delete the free past appointments';

    public function handle()
    {
        $appointments=Appointment::all();
        $date= \Carbon\Carbon::now()->addHours(1)->format('Y-m-d ');
        $time=\Carbon\Carbon::now()->addHours(1)->format('g:i A');
            Appointment::where([['schedule_date', '<', $date],['slot_time','<',$time],['appointment_state','=','free']])->delete();

    }
}
