<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPostsComments extends Controller
{
    //
    public function userPosts(){
        return Auth::user()->posts;
    }
    public function userComments(){
        return Auth::user()->comments;
    }

}