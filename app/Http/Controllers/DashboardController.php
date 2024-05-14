<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //Through this i can get all the users except the logged in user !
        $users = User::where('id' , '!=' , auth()->user()->id)->with('userActivity')->get();
        return view('dashboard', compact('users'));
    }   
}