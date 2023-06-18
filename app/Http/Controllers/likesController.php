<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class likesController extends Controller
{
    public function add_like(Request $request){
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
        $likeType = $all_data['likeType'];
        $postId = $all_data['postId'];
        $isPost=null;
        if(isset($all_data['isPost'])){
            $isPost=$all_data['isPost'];
        }

        $commentId=null;
        if(isset($all_data['commentId'])){
            $commentId=$all_data['commentId'];
        }

        $like = Like::create([
            'post_id' => $postId,
            'comment_id' => $commentId,
            'user_id' => $user_id,
            'is_post' => $isPost,
            'like_type'=>$likeType
        ]);

        $state = "good, ok";
        $message = "your data added successfully";
        $data = [
            'like_id' => $like->id,
            'post_id' => $postId,
            'comment_id' => $commentId,
            'user_id' => $user_id,
            'is_post' => $isPost,
            'like_type' => $likeType,
        ];
        return response(compact('state', 'message', 'data'), 200);
    }
    public function get_like(){
        $post_id = $_GET['postId'];
        $user_id =Auth::user()->id;

        if(isset($_GET['commentId'])) {
            $comment_id = $_GET['commentId'];
            $like = Like::where([['post_id', $post_id],['comment_id',$comment_id]])->first();
            $state = "good, ok";
            $message = "information retreived successfully";
            if(!empty($like)){
                $data = [
                    'like_id' => $like->id,
                    'post_id' => $post_id,
                    'comment_id' => $like->comment_id,
                    'user_id' => $user_id,
                    'is_post' => $like->is_post,
                    'like_type' => $like->like_type,
                ];
            }
            else{
                $data=[];
            }
            return response(compact('state', 'message', 'data'), 200);
        }
        //only post
        $like = Like::where('post_id', $post_id)->first();
        $state = "good, ok";
        $message = "information retreived successfully";
        if(!empty($like)){
            $data = [
                'like_id' => $like->id,
                'post_id' => null,
                'comment_id' => $like->comment_id,
                'user_id' => $user_id,
                'is_post' => 1,
                'like_type' => $like->like_type,
            ];
        }
        else{
            $data=[];
        }
        return response(compact('state', 'message', 'data'), 200);

        }

}
