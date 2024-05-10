<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index($id)
    {
        $user = User::find($id);
        // Load the chat page view, passing the user object
        return view('chat', compact('user'));
    }
}