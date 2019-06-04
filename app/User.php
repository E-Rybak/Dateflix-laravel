<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function likes () {
        return $this->hasMany('App\Like');
    }

    public function liked_users () {
        $user_ids = $this->likes->map(function ($item, $key) {
            return $item->liked_user_id;
        });

        return User::findMany($user_ids);
    }

    /**
     * Finds and returns all users that are not liked.
     *
     * @return collection
     */
    public function unliked_users () {
        $users = User::get();
        $user_ids = $users->map(function ($item, $key) {
            return $item->id;
        });

        $liked_user_ids = $this->likes->map(function ($item, $key) {
            return $item->liked_user_id;
        });

        $liked_user_ids = $liked_user_ids->toArray();
        $user_ids = $user_ids->toArray();

        $difference = array_diff($user_ids, $liked_user_ids);

        $users = User::findMany($difference);

        return $users;
    }
}
