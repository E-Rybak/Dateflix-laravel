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

    /**
     * 
     * 
     * @return collection
     */
    public function liked_users () {
        $user_ids = $this->likes->map(function ($item, $key) {
            return $item->liked_user_id;
        });

        return User::findMany($user_ids);
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

        return $difference;
    }
}
