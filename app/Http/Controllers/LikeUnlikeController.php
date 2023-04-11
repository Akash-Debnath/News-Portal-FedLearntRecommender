<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Unlike;
use Illuminate\Http\Request;

class LikeUnlikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $request->validate([
            'id'   => 'required'
        ]);
        $like = new Like();
        $like->likes = 1;
        $like->post_id =  $request->get('id');
        $like->author_id = $request->user()->id;
        $like->save();
        return redirect()->back();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LikeUnlike  $likeUnlike
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LikeUnlike  $likeUnlike
     * @return \Illuminate\Http\Response
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LikeUnlike  $likeUnlike
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Like $like)
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function unlikesreaction(Request $request)
    {
        $request->validate([
            'id'   => 'required'
        ]);
        $unlike = new Unlike();
        $unlike->unlikes = 1;
        $unlike->post_id =  $request->get('id');
        $unlike->author_id = $request->user()->id;
        $unlike->save();
        return redirect()->back();
    }
}
