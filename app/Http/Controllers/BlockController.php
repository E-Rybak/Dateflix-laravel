<?php

namespace App\Http\Controllers;

use App\Block;
use App\User;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = auth()->user()->blocked_users();
        return view('blocks', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $block = new Block();
        $block->blocked_user_id = request('user_id');
        auth()->user()->blocks()->save($block);
        return redirect()->action('LikeController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $blocked_user_id = request('blocked_user_id');
        auth()->user()->blocks()->where('blocked_user_id', $blocked_user_id)->delete();
        return redirect()->action('BlockController@index');
    }
}
