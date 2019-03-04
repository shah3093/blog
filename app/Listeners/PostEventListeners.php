<?php

namespace App\Listeners;

use App\Events\PostEvent;
use App\Events\SeriesEvent;
use App\Models\Category;
use App\Models\Post;
use App\Models\Series;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class PostEventListeners {
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }
    
    /**
     * Handle the event.
     *
     * @param  PostEvent $event
     *
     * @return void
     */
    public function handle(PostEvent $event) {
        
        if(Cache::has("postTotalPage")) {
            $totalpage = Cache::get("postTotalPage");
            for($i = 0; $i <= $totalpage; $i ++) {
                if(Cache::has('posts'.$i)) {
                    Cache::forget('posts'.$i);
                }
            }
        }
        $post = $event->post;
    
        if(Cache::has($post->categoryId.'categoryTotalPostPage')) {
            $totalpage = Cache::get($post->categoryId.'categoryTotalPostPage');
            for($i = 0; $i <= $totalpage; $i ++) {
                if(Cache::has($post->categoryId.'categoryPost'.$i)) {
                    Cache::forget($post->categoryId.'categoryPost'.$i);
                }
            }
        }
        
    }
}
