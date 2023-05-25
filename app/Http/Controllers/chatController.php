<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class chatController extends Controller
{
    public function add_msg(Request $request){
        if(!Auth::user()){
            $state="not authorized to access";
            $message="cannot access to api resources";
            $data = [
                'isUser'=>0
            ];
            return response(compact('state', 'message','data'),401);
        }
        $user1_id =Auth::user()->id;
        $all_data = ($request->input('data'));
        $content=$all_data['content'];
        $user2_id=$all_data['message_to'];
        $first=false;
        if(isset($all_data['isFirst'])){
            $first=$all_data['isFirst'];
        }
        if($first==true){
            $chat=  Chat::create([
                'chat_from'=>$user1_id,
                'chat_to'=>$user2_id,
            ]);
            $chat=  Chat::create([
                'chat_from'=>$user2_id,
                'chat_to'=>$user1_id,
            ]);
            $msg=Message::create([
                'message_from'=>$user1_id,
                'message_to'=>$user2_id,
                'content'=>$content,
                'issued_date'=>Carbon::now(),
                'issued_time'=>Carbon::now(),
            ]);
            $state="good, ok";
            $message="your data added successfully";
            $data = [
                'message_id' => $msg->id
            ];
            return response(compact('state', 'message', 'data'), 200);
        }
        $all_chat=Chat::where([['chat_from', '=', $user1_id],['chat_to', '=', $user2_id]])->first();
        if(empty($all_chat)) {
            $chat=  Chat::create([
                'chat_from'=>$user1_id,
                'chat_to'=>$user2_id,
            ]);
            $chat=  Chat::create([
                'chat_from'=>$user2_id,
                'chat_to'=>$user1_id,
            ]);
            $msg=Message::create([
                'message_from'=>$user1_id,
                'message_to'=>$user2_id,
                'content'=>$content,
                'issued_date'=>Carbon::now(),
                'issued_time'=>Carbon::now(),
            ]);
            $state="good, ok";
            $message="your data added successfully";
            $data = [
                'message_id' => $msg->id
            ];
            return response(compact('state', 'message', 'data'), 200);
        }
            $msg=Message::create([
            'message_from'=>$user1_id,
            'message_to'=>$user2_id,
            'content'=>$content,
            'issued_date'=>Carbon::now(),
            'issued_time'=>Carbon::now(),
        ]);
        $state="good, ok";
        $message="your data added successfully";
        $data = [
            'message_id' => $msg->id
        ];
        return response(compact('state', 'message', 'data'), 200);
    }

    public function get_msg()
    {
        if(!Auth::user()){
            $state="not authorized to access";
            $message="cannot access to api resources";
            $data = [
                'isUser'=>0
            ];
            return response(compact('state', 'message','data'),401);
        }
        $user1_id =Auth::user()->id;
        if(isset($_GET['message_to'])) {
            $user2_id = $_GET['message_to'];
        }

        $all_msg=Message::where([['message_from', '=', $user1_id],['message_to', '=', $user2_id]])
            ->orwhere([['message_from', '=', $user2_id],['message_to', '=', $user1_id]])->get();
        $data = array();
        foreach ($all_msg as $msg){
            $time=$msg->issued_time;
            $temp = explode(' ',$time);
            if($user1_id ==$msg->message_from) {
                $res = [
                    'message_id' => $msg->id,
                    'message_from' => $user1_id,
                    'message_to' => $user2_id,
                    'content' => $msg->content,
                    'issued_date' => $temp[0],
                    'issued_time' => $temp[1]
                ];
            }else{
                $res = [
                    'message_id' => $msg->id,
                    'message_from' => $user2_id,
                    'message_to' => $user1_id,
                    'content' => $msg->content,
                    'issued_date' => $temp[0],
                    'issued_time' => $temp[1]
                ];
            }
            array_push($data, $res);
        }
        $state="good, ok";
        $message="your data added successfully";
        return response(compact('state', 'message', 'data'), 200);
    }
    public function get_chat(){
        if(!Auth::user()){
            $state="not authorized to access";
            $message="cannot access to api resources";
            $data = [
                'isUser'=>0
            ];
            return response(compact('state', 'message','data'),401);
        }
        $user1_id =Auth::user()->id;
        $all_chat=Chat::where([['chat_from', '=', $user1_id]])->get();
        $data = array();
        foreach ($all_chat as $chat){
            $user2=User::where([['id', '=', $chat->chat_to]])->first();
            $spec=null;
            $rate=null;
            if($user2->user_type=="doctor"){
                $user2doctor=Doctor::where([['user_id', '=', $chat->chat_to]])->first();
                $spec=$user2doctor->specialty;
                $rate=$user2doctor->rate;
            }
            $res=[
                'chat_from'=> $user1_id,
                'chat_to'=> $user2->id,
                'nick_name'=> $user2->name,
                'user_name'=>$user2->username,
                'user_id'=>$user2->id,
                'img_url'=>$user2->img_url,
                'user_type'=>$user2->user_type,
                'specialty'=>$spec,
                'rate'=>$rate
            ];
            array_push($data, $res);
        }
        $state="good, ok";
        $message="your data added successfully";
        return response(compact('state', 'message', 'data'), 200);

    }

}
