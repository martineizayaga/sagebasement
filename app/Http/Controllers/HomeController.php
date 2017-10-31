<?php

namespace App\Http\Controllers;

use Session;
use App\User;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hootlex\Friendships\Traits\Friendable;

class HomeController extends Controller
{
    use Friendable;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checked_in_profiles = Profile::recentvisit()->orderBy('checked_in', 'desc')->get();
        $user = Auth::user();
        $requests_users = [];
        if(!is_null($user)){
            $friend_requests = $user->getFriendRequests();
            foreach ($friend_requests as $friend_request) {
                $user = User::find($friend_request->sender_id);
                array_push($requests_users, $user);
            }
        }
        return view('home')->with('checked_in_profiles', $checked_in_profiles)->with('requests_users', $requests_users);
    }
}
