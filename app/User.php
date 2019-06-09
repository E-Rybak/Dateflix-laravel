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
        'name', 'email', 'password', 'birthday', 'sex',
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

    public function blocks () {
        return $this->hasMany('App\Block');
    }

    public function messages () {
        return $this->hasMany('App\Message');
    }

    public function chats () {
        return $this->belongsToMany('App\Chat');
    }

    /**
     * 
     * 
     * @return collection
     */
    public function liked_users () {
        $user_ids = $this->likes->map(function ($item, $key) {
            return $item->liked_user_id;
        });

        $users = User::findMany($user_ids);
        $filtered_users = $this->filter_blocked_users($users);
        

        return $filtered_users;
    }

    /**
     * Finds and returns all users that are not liked by the user instance.
     *
     * @return collection
     */
    public function unliked_users () {
        $users = User::get();

        $liked_user_ids = $this->likes->map(function ($item, $key) {
            return $item->liked_user_id;
        });

        $difference = $users->whereNotIn('id', $liked_user_ids);
        $without_blocked_users = $this->filter_blocked_users($difference);

        return $without_blocked_users;
    }

    public function blocked_users () {
        $block_ids = $this->blocks->map(function ($item, $key) {
            return $item->blocked_user_id;
        });

        return User::findMany($block_ids);
    }

    private function filter_blocked_users ($users) {
        $block_ids = $this->blocks->map(function ($item, $key) {
            return $item->blocked_user_id;
        });

        return $users->whereNotIn('id', $block_ids);
    }
}
