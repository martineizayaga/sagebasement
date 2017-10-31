<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the profile record associated with the user.
     */
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->profile->nickname . ' ' . $this->last_name;
    }

    public function getFirstAndLastName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function checkhasSentFriendRequestTo($recipient)
    {
        return $this->hasSentFriendRequestTo($recipient);
    }

    public function checkisFriendWith($friend)
    {
        return $this->isFriendWith($friend);
    }

    public function checkHasFriendRequestFrom($sender)
    {
        return $this->hasFriendRequestFrom($sender);
    }

    public function getListFriends()
    {
        return $this->getFriends();
    }
}
