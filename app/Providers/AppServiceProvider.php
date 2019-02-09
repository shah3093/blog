<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $data = [];
        
        view()->composer('frontend.partials.sidebar',function($view){
            $data['popular_posts'] = Post::where(["isPopular"=>1,"status"=>1])->limit(5)->get();
            $data['all_categories'] = Category::with('posts')->where('status',1)->get();
            $data['all_tags'] = Tag::select('name')->get();
            $view->with($data);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
