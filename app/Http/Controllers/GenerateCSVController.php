<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use League\Csv\Writer;
use Illuminate\Support\Facades\Storage;


class GenerateCSVController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $likes = Post::
        // $post = Post::withCount('likes')->find($id);

        // $posts = Post::withCount('likes')->get();

        // foreach ($posts as $post) {
        //     echo "Post ID: {$post->id}, Likes: {$post->likes_count} \n";
        // }

        // $comments = Post::withCount('comments')->get();

        // foreach ($comments as $comment) {
        //     echo "Post ID: {$comment->id}, Comment: {$comment->comments_count} \n";
        // }


        // $views = Post::withCount('views')->get();

        // foreach ($views as $view) {
        //     echo "Post ID: {$view->id}, View: {$view->views_count} \n";
        // }

        
        // $posts = Post::withCount('likes', 'comments', 'views')->get();

        // $csv = Writer::createFromString('');
        // $csv->insertOne(['Post ID', 'Likes', 'Comments', 'Views']);

        // foreach ($posts as $post) {
        //     $csv->insertOne([$post->id, $post->likes_count, $post->comments_count, $post->views_count]);
        // }

        // $csv->output('usersdata.csv');
        
        // $file = 'usersdata.csv';
        // $csv->store('public/' . $file);





        $posts = Post::withCount('likes', 'comments', 'views')->get();
        $csv = Writer::createFromString('');
        $csv->insertOne(['Post ID', 'Likes', 'Comments', 'Views']);

        foreach ($posts as $post) {
            $csv->insertOne([$post->id, $post->likes_count, $post->comments_count, $post->views_count]);
        }

        $filename = 'usersdata.csv';
        $filepath = 'public/' . $filename;
        Storage::put($filepath, $csv->__toString());



        


        // $posts = Post::select('posts.id', 'likes.likes', 'likes.author_id', 'comments.author_id', 'comments.comment', 'viewnews.views', 'viewnews.author_id')
        //     ->join('likes', 'likes.post_id', '=', 'posts.id')
        //     ->join('comments', 'comments.post_id', '=', 'posts.id')
        //     ->join('viewnews', 'viewnews.post_id', '=', 'posts.id')
        //     ->get();

        // // return $posts;

        // $filename = 'userdata.csv';
        // $file = fopen($filename, 'w');
        // fputcsv($file, ['Post Id', 'Author Id', 'Like', 'Comment', 'View']);

        // foreach ($posts as $post) {
        //     // foreach ($user->orders as $order) {
        //         fputcsv($file, [
        //             $post->id,
        //             $post->author_id,
        //             $post->likes,
        //             $post->comment,
        //             $post->views,
        //             // $order->order_number,
        //             // $order->product_name,
        //         ]);
        //     // }
        // }
        // fclose($file);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
