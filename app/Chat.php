<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\ChatDeleted;

class Chat extends Model
{
    protected $fillable = ['name'];

    public function messages () {
    	return $this->hasMany('App\Message');
    }

    public function users () {
    	return $this->belongsToMany('App\User');
    }

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
    	'deleting' => ChatDeleted::class,
    ];

    public function addParticipant(int $user_id)
    {
    	$participants = collect([auth()->user(), User::findOrFail($user_id)]);
        foreach ($participants as $participant) {
            $result = $this->users()->save($participant);
        }
        return true;
    }
}
