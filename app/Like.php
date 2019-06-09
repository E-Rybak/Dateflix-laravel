<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //
    protected $fillable = ['liked_user_id'];

    public function user () {
    	return $this->belongsTo('App\User');
    }
}
