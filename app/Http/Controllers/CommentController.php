<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use \Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    function comment(Request $req,$tweetid,$user)
    {
        $current_date_time = date('Y-m-d H:i:s');

        $comment = new Comment;
        $comment->tweet_id = $tweetid;
        $comment->comment_by = $user;
        $comment->text = $req->input('text');
        $comment->created_at = $current_date_time;
        $comment->save();
        return $comment;
    }
    function getcomment($tweetid)
    {
        $get = DB::table('comments')->select('text','comment_by','tweet_id','users.name','users.profile_picture')->join('users','users.id','=','comments.comment_by')->where('tweet_id',$tweetid)->get();
     //   $get = collect($get->toArray())->flatten()->all();

        return $get;
    }
    function deletecomment($user,$tweet_id)
    {
        $delete = Comment::where('tweet_id',$tweet_id)->where('comment_by',$user)->delete();
        if($delete)
        {
        return ["delete"=>"you unliked"];
        }
    }
}
