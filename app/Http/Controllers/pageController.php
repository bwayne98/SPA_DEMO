<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Auth;


class pageController extends Controller
{


    public function index(){
        
        return view("welcome");
    }

    public function newuser(Request $request){
        $user = new User;
        $user->name = $request->account;
        $user->email = $request->account;
        $user->password = Hash::make($request->password);

        $user->save();
        return true;
    }

    public function login(Request $request){

       
        // $request->validate([
        //     'account' => ['required', 'email'],
        //     'password' => ['required'],
        // ]);

        $credentials = [
            "email" => $request->account,
            "password" => $request->password
        ];

        
        if (Auth::attempt($credentials,true)) {
            // $credentials->session();

            return true;
        };

        return false;

    }

    public function getUser(){
        return Auth::user()->name;
    }
}
