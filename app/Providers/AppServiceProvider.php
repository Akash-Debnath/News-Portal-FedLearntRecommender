<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Post;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    public $isOpen = 0;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //JsonResource::withoutWrapping();
        $posts = Post::with(['author', 'category', 'tags', 'images', 'videos', 'comments'])->paginate();
        view()->share('posts', $posts);

        $categories = Category::all();
        view()->share('categories', $categories);

    }
}
