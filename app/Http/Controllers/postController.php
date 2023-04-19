<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class postController extends Controller
{
    public function post(Request $request)
    {
        $user_id = Auth::user()->id;
        $all_data = ($request->input('data'));
        $content = $all_data['content'];
        $img = $all_data['postImg'];
        $img = null;
        if (isset($all_data['postImg'])) {
            $img = $all_data['postImg'];
        }
        $post = Post::create([
            'user_id' => $user_id,
            'content' => $content,
            'post_img' => $img
        ]);

        $state = "good, ok";
        $message = "your data added successfully";
        $data = [
            'post_id' => $post->id
        ];
        return response(compact('state', 'message', 'data'), 200);
    }

    public function comment(Request $request)
    {
        $user_id = Auth::user()->id;
        $all_data = ($request->input('data'));
        $content = $all_data['content'];
        $post_id = $all_data['postId'];
        $comment_id=null;
        if(isset($all_data['commentId'])){
            $comment_id=$all_data['commentId'];
            $reply = Reply::create([
                'content' => $content,
                'post_id' => $post_id,
                'reply_on'=>$comment_id,
                'reply_id'=>$comment_id
            ]);
            $state = "good, ok";
            $message = "your data added successfully";
            $data = [
                'comment_id' => $reply->id
            ];
            return response(compact('state', 'message', 'data'), 200);
        }
        $comment = Comment::create([
            'user_id' => $user_id,
            'content' => $content,
            'post_id' => $post_id
        ]);
        $state = "good, ok";
        $message = "your data added successfully";
        $data = [
            'comment_id' => $comment->id
        ];
        return response(compact('state', 'message', 'data'), 200);
    }
}
