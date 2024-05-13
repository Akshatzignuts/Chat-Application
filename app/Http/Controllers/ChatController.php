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
    
    public function blockUser(Request $request, $userId)
    {
        $user = auth()->user();
        $blockedUser = User::findOrFail($userId);

        // Check if the user is already blocked
        if ($user->blockedUsers()->where('blocked_user_id', $blockedUser->id)->exists()) {
            return redirect()->back();
        }
        // Block the user
        $user->blockedUsers()->attach($blockedUser);
        return redirect()->back();
    }
   
    public function unblock($userId)
    {
        $user = auth()->user();
        $blockedUser = User::findOrFail($userId);
        // Remove the user from the blocked users list
        $user->blockedUsers()->detach($blockedUser);
        return redirect()->back()->with('success', 'User unblocked successfully.');
    }
    
    
}