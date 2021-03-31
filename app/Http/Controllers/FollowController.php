<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;

class FollowController extends Controller
{
    function follow( $id_sender, $id_receiver)
    {
        $follow = Follow::updateOrCreate(['sender_id'=>$id_sender,'receiver_id'=>$id_receiver]);
        return $follow;
    }
    function check($id_sender, $id_receiver)
    {
        $check = Follow::where('sender_id',$id_sender)->where('receiver_id',$id_receiver)->first();
        if($check)
        {
            return $check;
        }
        else return ["error"=>"error we cant this shit"];
    }
    function unfollow($id_sender, $id_receiver)
    {
        $delete = Follow::where('sender_id',$id_sender)->where('receiver_id',$id_receiver)->delete();
        if($delete)
        {
            return ["unfollow"=>"you unfollowed this user"];
        }
    }
}
