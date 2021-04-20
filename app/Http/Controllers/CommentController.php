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
    function getowncomments($id)
    {
      $get = DB::table('comments')->select('comments.tweet_id',DB::raw('tweets.name,tweets.text,tweets.picture'))
      ->leftjoin('tweets','comments.tweet_id','=','tweets.id')
      ->where('comment_by',$id)
      ->get();
      return $get;

    }
    function getcomment($tweetid)
    {
        $get = DB::table('comments')->select('comments.id','text','comment_by','tweet_id','users.name','users.profile_picture')->join('users','users.id','=','comments.comment_by')->where('tweet_id',$tweetid)->get();
     //   $get = collect($get->toArray())->flatten()->all();

        return $get;
    }
    function deletecomment($id)
    {
       // $delete = Comment::where('tweet_id',$tweet_id)->where('comment_by',$user)->take(1)->delete();
       $delete = Comment::where('id',$id)->take(1)->delete();
        if($delete)
        {
        return ["delete"=>"you unliked"];
        }
    }
}
