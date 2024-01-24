<?php

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
