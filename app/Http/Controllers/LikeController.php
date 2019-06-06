<?php

namespace App\Http\Controllers;

use App\Like;
use App\User;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = auth()->user()->unliked_users();
        return view('index', compact('users'));
    }

    /**
     * Display a listing of the users likes.
     *
     * @return \Illuminate\Http\Response
     */
    public function likes()
    {
        $users = auth()->user()->liked_users();
        return view('liked-users', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $like = new Like();
        $like->liked_user_id = request('liked_user_id');

        $user = auth()->user();
        $user->likes()->save($like);

        return redirect()->action('LikeController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $liked_user_id = request('liked_user_id');
        auth()->user()->likes()->where('liked_user_id', $liked_user_id)->delete();
        return redirect()->action('LikeController@likes');
    }
}
