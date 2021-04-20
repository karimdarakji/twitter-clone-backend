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
    function getowntweets($id)
    {
        $user = Tweets::select('name','text')->where('tweet_id',$id)->orderBy('created_at','desc')->get();
        return $user;
    }
    function gettweets($id){
    
       $user = Follow::select('receiver_id','sender_id')->where('sender_id',$id)->get();
       $user = collect($user->toArray())->flatten()->all();
       $tweet = DB::table('tweets')->groupBy('tweets.id','tweets.tweet_id','tweets.name','tweets.text','tweets.picture')

       ->select('tweets.id','tweets.tweet_id','tweets.name','tweets.text','tweets.picture',DB::raw('COUNT( DISTINCT likes.liked_by) as likes'),DB::raw('COUNT( distinct comments.comment_by) as comments'))
       ->leftjoin('likes','tweets.id','=','likes.tweet_id')
       ->leftjoin('comments','comments.tweet_id','=','tweets.id')
       
       
       ->whereIn('tweets.tweet_id',$user)
       ->orderBy('tweets.created_at','desc')
       ->distinct('tweets.id')
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
