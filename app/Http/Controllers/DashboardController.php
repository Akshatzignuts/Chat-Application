<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::where('id' , '!=' , auth()->user()->id)->with('userActivity')->get();
        return view('dashboard', compact('users'));
    }   
    public function updateActivity(Request $request, UserActivity $userActivity)
    {
        dd('hii');
        $userActivity->last_activity = now();
        $userActivity->save();

        return response()->json(['message' => 'Activity updated']);
    }
}