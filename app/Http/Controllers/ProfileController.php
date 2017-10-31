<?php

namespace App\Http\Controllers;

use DB;
use Image;
use Session;
use App\User;
use App\Profile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = Profile::find($id);
        return view('profile.edit')->with('profile', $profile);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $profile = $user->profile;

        $this->validate($request, array(
            'first_name' => 'required|string|alpha_dash|max:255',
            'nickname' => 'required|string|max:255|regex:"\s*(.*?)\s*"',
            'last_name' => 'required|string|alpha_dash|max:255',
            'groups' => 'required',
            'email' => 'required|string|email|max:255',
        ));

        $user->first_name = $request->first_name;
        $profile->nickname = $request->nickname;
        $profile->nickname = '"' . trim(substr($request->nickname, 1, -1)) . '"';
        $user->last_name = $request->last_name;
        $profile->groups = serialize($request->groups);

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(100, 100)->save($location);
            $profile->image = $filename;
        }

        $user->save();
        $profile->save();

        Session::flash('success', 'This profile was successfully updated.');

        return redirect('/');

    }

    /**
     * Marks user as checked into Sage Basement.
     * @return \Illuminate\Http\Response
     */
    public function checkIn()
    {
        $user = Auth::user();
        $profile = $user->profile;

        //so that users can't checkIn more than once per hour
        $profileCheckIn = Carbon::parse($profile->checked_in);
        if(is_null($profile->checked_in)|| $profileCheckIn->lt(Carbon::now()->subHour()))
        {
            $profilePoints = $profile->points;
            $profile->points = $profilePoints + 1;

            if(!is_null($profile->checked_in))
            {
                if($profileCheckIn->isYesterday())
                {
                    $profile->streak += 1;
                } else if ($profileCheckIn->lt(Carbon::now()->subHour())){
                    $profile->streak = $profile->streak;
                } else {
                    $profile->streak = 0;
                }
            } else {
                $profile->streak = 0;
            }

            $profile->checked_in = Carbon::now();
            $profile = $profile::SetUpEmoji($profile);
            $profile->save();
            Session::flash('success', "You're now at Sage!");
        } else {
            Session::flash('warning', "I'm sorry. You can only check in once every hour.");
        }
        return redirect('/');   
    }

    

    public function leaderboards()
    {
        $profilePoints = Profile::orderBy('points', 'desc')
                                ->orderBy('checked_in', 'desc')
                                ->where('points', '!=', 0)
                                ->take(10)
                                ->get();
        $profileStreaks = Profile::orderBy('streak', 'desc')
                                    ->orderBy('checked_in', 'desc')
                                    ->where('streak', '!=', 0)
                                    ->take(10)
                                    ->get();

        return view('leaderboards')->with('profilePoints', $profilePoints)->with('profileStreaks', $profileStreaks);
    }
}
