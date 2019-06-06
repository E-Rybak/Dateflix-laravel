<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    //
    protected $fillable = ['user_id', 'blocked_user_id'];

    public function user () {
    	return $this->belongsTo('App\User');
    }
}
