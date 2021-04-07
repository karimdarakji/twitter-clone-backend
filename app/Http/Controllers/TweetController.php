<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tweets;
use App\Models\Follow;
use App\Models\Like;
use \Illuminate\Support\Facades\DB;
use App\Models\Comment;


class TweetController extends Controller
{
    function tweet(Request $req){
        $current_date_time = date('Y-m-d H:i:s');
        $user = User::select('id','name','profile_picture')->where('name',$req->name)->first();
        $tweet = new Tweets;
        $tweet->tweet_id =  $user->id;
        $tweet->name =  $user->name;
        $tweet->text =  $req->input('text');
        $tweet->created_at = $current_date_time;
        $tweet->picture = $user->profile_picture;
        $tweet->save();
        
        return $tweet;
    }
    function gettweets($id){
    
       $user = Follow::select('receiver_id','sender_id')->where('sender_id',$id)->get();
       $user = collect($user->toArray())->flatten()->all();
       $tweet = DB::table('tweets')->select('tweets.id','tweets.tweet_id','name','tweets.text','picture',DB::raw('COUNT(likes.liked_by) as likes'),DB::raw('COUNT(comments.comment_by) as comments'))
      
       ->leftjoin('comments','comments.tweet_id','=','tweets.id')
       ->leftjoin('likes','likes.tweet_id','=','tweets.id')
       ->groupBy('tweets.id','tweets.tweet_id','name','tweets.text','picture')
       
       ->whereIn('tweets.tweet_id',$user)
       ->orderBy('tweets.created_at','desc')
       ->get();
        return $tweet;
    }
    function delete($id)
    {
        $result = Tweets::where('id',$id)->delete();
        if($result)
        {
        return ["result"=>"product has been deleted"];
        }
    }
    function searchtweet($key)
    {
        return Tweets::where('text','Like',"%$key%")->get();

    }
    
    
}
