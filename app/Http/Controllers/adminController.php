<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminController extends Controller
{
    public function verification(Request $request){
        if(!Auth::user()){
            $state="not authorized to access";
            $message="cannot access to api resources";
            $data = [
                'isUser'=>0
            ];
            return response(compact('state', 'message','data'),401);
        }
        $all_data = ($request->input('data'));
        $doctor_id=$all_data['doctorId'];
        $type=$all_data['type'];

        $doctor = Doctor::where('user_id', $doctor_id)->first();
        $doctor->type=$type;
        $doctor->save();
        $state= 'good, ok';
        $message = 'information retreived successfully';
        $data = [
            'isDone' => true
        ];
        return response(compact('state', 'message', 'data'), 200);
    }
    public function change_user(Request $request)
    {
        if (!Auth::user()) {
            $state = "not authorized to access";
            $message = "cannot access to api resources";
            $data = [
                'isUser' => 0
            ];
            return response(compact('state', 'message', 'data'), 401);
        }
        $all_data = ($request->input('data'));
        if (isset($all_data['userId']) and isset($all_data['type'])) {
            $type = $all_data['type'];
            $user_id = $all_data['userId'];
            if ($type == 'delete') {
                User::where('id', '=', $user_id)->delete();

            }
            $state = 'good, ok';
            $message = 'information retreived successfully';
            $data = [
                'isDone' => true
            ];
            return response(compact('state', 'message', 'data'), 200);

        }

        if (isset($all_data['chat_from']) and isset($all_data['chat_to'])) {
            if ($all_data['type'] == 'restrict') {
                $chat_from = $all_data['chat_from'];
                $chat_to = $all_data['chat_to'];
                $is_open = $all_data['is_open'];
                $type = $all_data['type'];
                $chats = Chat::where([['chat_from', '=', $chat_from], ['chat_to', '=', $chat_to]])->first();
                $chats->is_open = $is_open;
                $chats->save();

            }
        }
        $state= 'good, ok';
        $message = 'information retreived successfully';
        $data = [
            'isDone' => true
        ];
        return response(compact('state', 'message', 'data'), 200);
    }
}
