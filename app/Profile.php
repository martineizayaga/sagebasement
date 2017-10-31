<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname', 'groups', 'points', 'streak', 'checked_in',
    ];

    /**
     * Get the user that owns this profile.
     */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function getFullName()
    {
        return $this->user->getFullName();
    }

    public function getFirstAndLastName()
    {
        return $this->user->getFirstAndLastName();
    }

    /**
     * Scope a query to only include users checked in within
     * the last hour.
     * @param  \Illuminate\Database\Eloquent\Builder $query 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecentvisit($query)
    {
        return $query->whereNotNull('checked_in')
                    ->where('points', '!=', 0)
                    ->where('checked_in', '>=', Carbon::now()->subHour());
    }
    /**
     * Assigns emoji to profile depending on the amount of points
     * it has.
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  App\Profile $profile
     * @return App\Profile
     */
    public function scopeSetUpEmoji($query, Profile $profile)
    {
        $points = $profile->points;
        if($points == 1){
            $profile->emoji = '✨';
        } else if($points >= 2 && $points <= 4){
            $profile->emoji = '👶';
        } else if($points >= 5 && $points <=9) {
            $profile->emoji = '💥';
        } else if($points >= 10 && $points <= 24) {
            $profile->emoji = '🚨';
        } else if($points >= 25 && $points <=99) {
            $profile->emoji = '🏆';
        } else if($points == 100) {
            $profile->emoji = '💯';
        } else if($points > 100) {
            $profile->emoji = '🌵';
        }
        return $profile;
    }
}
