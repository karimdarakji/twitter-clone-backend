<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tweets;
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
    function gettweets(Request $req){
       // $user = User::select('id')->first();
        $tweet = Tweets::select('id','tweet_id','name','text','picture')->orderBy('created_at','desc')->get();
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
