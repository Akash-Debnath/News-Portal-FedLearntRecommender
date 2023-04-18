<?php

use App\Http\Livewire\Categories\Categories;
use App\Http\Livewire\Categories\Categoryposts;
use App\Http\Livewire\Posts\Posts;
use App\Http\Livewire\Posts\Post as p;
use App\Http\Livewire\Tags\Tagposts;
use App\Http\Controllers\Api\CommentApiController;
use App\Http\Controllers\LikeUnlikeController;
use App\Http\Controllers\NewsViewController;
use App\Http\Controllers\GenerateCSVController;
use App\Http\Controllers\PythonModelController;
use App\Http\Livewire\Tags\Tags;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('test', function () {
//     $category = App\Models\Category::find(3);
//     // return $category->posts;

//     $comment = App\Models\Comment::find(152);
//     // return $comment->author;
//     // return $comment->post;

//     $post = App\Models\Post::find(152);
//     // return $post->category;
//     // return $post->author;
//     // return $post->images;
//     // return $post->comments;
//     // return $post->tags;

//     $tag = App\Models\Tag::find(5);
//     // return $tag->posts;

//     $author = App\Models\User::find(88);
//     // return $author->posts;
//     return $author->comments;
// });

Route::get('/', function () {
    return view('welcome');
    // Route::get('dashboard/posts', Posts::class)->name('posts');
    // Route::get('dashboard/posts/{id}', p::class);   
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
    // return view('livewire.posts.posts');
})->name('dashboard');

Route::get('dashboard/categories', Categories::class)->name('categories');
Route::get('dashboard/categories/{id}/posts', Categoryposts::class);

Route::get('dashboard/posts', Posts::class)->name('posts');
Route::match(['get'],'dashboard/posts/{id}', p::class)->name('postview');
// Route::match(['post'],'dashboard/posts/{id}', [NewsViewController::class, 'edit']);
// Route::match(['post'],'dashboard/posts/{id}', function () {
//     return 'Hello World';
// });
// Route::get('dashboard/posts/{id}', p::class);
// Route::post('dashboard/posts/{id}', [NewsViewController::class, 'store']);

Route::get('dashboard/tags', Tags::class)->name('tags');
Route::get('dashboard/tags/{id}/posts', Tagposts::class);

Route::post('comments/posts', [CommentApiController::class, 'store']);
Route::post('likes/posts', [LikeUnlikeController::class, 'store']);
Route::post('unlikes/posts', [LikeUnlikeController::class, 'unlikesreaction']);
Route::post('posts/views', [NewsViewController::class, 'store']);

Route::get('/hey', [GenerateCSVController::class, 'index']);
// Route::get('/dashboard/posts', [PythonModelController::class, 'index']);
// Route::get('/dashboard/py', [PythonModelController::class, 'index']);
