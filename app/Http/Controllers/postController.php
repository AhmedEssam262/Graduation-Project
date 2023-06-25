<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Reply;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class postController extends Controller
{
    public function post(Request $request)
    {
        $user_id = Auth::user()->id;
        $all_data = ($request->input('data'));
        $content = $all_data['content'];
        $img = isset($all_data['postImg']) ? $all_data['postImg'] : null;

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
            $comment = Comment::create([
                'user_id' => $user_id,
                'content' => $content,
                'post_id' => $post_id
            ]);
            $reply = Reply::create([
                'post_id' => $post_id,
                'reply_on'=>$comment->id,
                'reply_id'=>$comment->id
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
    public function get_posts(){
        $data = array();
        $all_posts=Post::all();
        if($all_posts) {
            foreach ($all_posts as $post) {
                $user = \App\Models\User::where([['id', '=', $post->user_id]])->first();
                $res = [
                    'post_id' => $post->id,
                    'user_id' => $post->user_id,
                    'content' => $post->content,
                    'issued_time' => $post->created_at,
                    'num_comments' => $post->num_comments,
                    'like_emoji' => $post->like_emoji,
                    'dislike' => $post->dislike,
                    'angry' => $post->angry,
                    'post_img' => $post->post_img,
                    'nick_name' => $user->name,
                    'img_url' => $user->img_url,
                ];
                array_push($data, $res);
            }
        }
        $state="good, ok";
        $message="your data added successfully";
        return response(compact('state', 'message', 'data'), 200);
    }

    public function get_comments()
    {
        if(isset($_GET['postId'])) {
            $post_id=($_GET['postId']);
            $all_comments=Comment::where([['post_id', '=', $post_id]])->get();
            $all_replies=Reply::where([['post_id', '=', $post_id]])->get();
            $state="good, ok";
            $message="your data added successfully";
            $data = array();

            foreach ($all_comments as $comment){
                $user=\App\Models\User::where([['id', '=', $comment->user_id]])->first();

                $res=[
                    'reply_on'=> null,
                    'comment_id'=> $comment->id,
                    'post_id'=> $comment->post_id,
                    'user_id'=> $comment->user_id,
                    'content'=> $comment->content,
                    'issued_time'=> $comment->created_at,
                    'num_replies'=> $comment->num_replies,
                    'like_emoji'=> $comment->like_emoji,
                    'dislike'=> $comment->dislike,
                    'angry'=> $comment->angry,
                    'nick_name'=>$user->name,
                    'img_url'=> $user->img_url
                ];
                array_push($data, $res);
            }
            foreach ($all_replies as $rep){
                $comm=Comment::where([['id', '=', $rep->reply_on]])->first();
                $user=\App\Models\User::where([['id', '=', $comm->user_id]])->first();

                $res=[
                    'reply_on'=> $rep->reply_on,
                    'comment_id'=> $rep->id,
                    'post_id'=> $comm->post_id,
                    'user_id'=> $comm->user_id,
                    'content'=> $comm->content,
                    'issued_time'=> $comm->created_at,
                    'num_replies'=> $comm->num_replies,
                    'like_emoji'=> $comm->like_emoji,
                    'dislike'=> $comm->dislike,
                    'angry'=> $comm->angry,
                    'nick_name'=>$user->name,
                    'img_url'=> $user->img_url
                ];
                array_push($data, $res);
            }

            return response(compact('state', 'message', 'data'), 200);
        }

    }

    }
