<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

if(! function_exists('creatorId')){
    function creatorId(){
        if(Session::has('user_type') == 'super admin' || Session::has('user_type') == 'company'){
            return Session()->get('user_id');
        }else{
            return Auth::user()->created_by;
        }
    }
}
if(! function_exists('PlanCheck'))
{
    function PlanCheck($id = null)
    {
        if(!empty($id))
        {
            $user= User::where('id',$id)->first();
            $id =$user->id;
        }else
        {
            $user = Session()->get('user_id') ?? Auth::user();
            $id =$user->id;
        }
        if($user->total_user >= 0){
            $users = User::where('created_by',$id)->get();
            if($users->count() >= $user->total_user){
                return false;
            }else{
                return true;
            }
        }elseif($user->total_user < 0){
            return true;
        }
    }
}
