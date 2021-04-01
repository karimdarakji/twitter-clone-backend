<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tweets;
use App\Models\Follow;
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
       $tweet = Tweets::select('tweet_id','name','text','picture')->whereIn('tweet_id',$user)->orderBy('created_at','desc')->get();
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
