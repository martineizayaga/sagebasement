<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function befriend(Request $request)
    {
    	$user = Auth::user();
    	$recipient = User::find($request->id);
    	$user->befriend($recipient);
    	return redirect('/');
    }

    public function acceptFriendRequest(Request $request)
    {
        $user = Auth::user();
        $sender = User::find($request->sender_id);
        $user->acceptFriendRequest($sender);
        return redirect('/');
    }

    public function denyFriendRequest(Request $request)
    {
        $user = Auth::user();
        $sender = User::find($request->sender_id);
        $user->denyFriendRequest($sender);
        return redirect('/');
    }

    public function unfriend(Request $request)
    {
        $user = Auth::user();
        $friend = User::find($request->friend);
        $user->unfriend($friend);
        return redirect('/friends');
    }

    public function indexFriends()
    {
        $user = Auth::user();
    	$friends = $user->getListFriends();
    	return view('friends')->with('friends', $friends);
    }
}
