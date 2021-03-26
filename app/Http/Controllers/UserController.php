<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    function register(Request $req){
        $user = new User;
        $user->name =  $req->input('name');
        $user->email =  $req->input('email');
        $user->password =  Hash::make($req->input('password'));
        $user->save();
        return $user;
    }
    function login(Request $req){
        $user = User::where('email',$req->email)->first();
        if(!$user || !Hash::check($req->password,$user->password))
        {
            $error = "Email or password is incorrect";
            return $error;
        }
        return $user;
    }
    function uploadProfileImage(Request $req){
       $user = User::where('email',$req->email)->first();
       $user->profile_picture = $req->file('file')->storeAs('profile_image',$user->name.".jpg"); 
       $user->save();
       return $user;   
 }
 function getprofilepicture(Request $req)
 {
    // $user = User::where('email',$req->email)->first();
    $user = User::select('profile_picture')->first();
     return $user;
 }
 function getuser($id){
    // $user = User::select('name','profile_picture')->where('name',$req->name)->first();
     return User::find($id);
 }
 /*function searchuser($key)
 {
      return User::where('name','Like',"%$key%")->get();
 }*/
}
