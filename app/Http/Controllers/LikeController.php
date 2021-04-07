<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Tweets;

class LikeController extends Controller
{
    function like(Request $req,$user)
    {
        $like = new Like;
        $like->tweet_id = $req->input('tweet_id');
        $like->liked_by = $user;
        $like->save();
        //$like = Like::insertOrIgnore(['tweet_id'=>$tweet,'liked_by'=>$user]);
      //  $tweetlike = Tweets::where('id',$req->tweet_id)->increment('likes');
        return $like;  

    }
    function getlike($user)
    {
        $getlike = Like::select('tweet_id')->where('liked_by',$user)->get();
        $getlike = collect($getlike->toArray())->flatten()->all();

        return $getlike; 
    }
    function deletelike($user,$tweet_id)
    {
        $delete = Like::where('tweet_id',$tweet_id)->where('liked_by',$user)->delete();
      //  $delete2 = Tweets::where('id',$tweet_id)->decrement('likes');
        if($delete)
        {
        return ["delete"=>"you unliked"];
        }
    }
}
