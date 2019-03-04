<?php

namespace App\Listeners;

use App\Events\SidebarEvent;
use App\Models\Category;
use App\Models\Post;
use App\Models\Series;
use App\Models\Tag;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class SidebarEventListeners {
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
     * @param  SidebarEvent $event
     *
     * @return void
     */
    public function handle($event) {
        if(Cache::has('sidebar')) {
            Cache::forget('sidebar');
        }
        
        $data['popular_posts'] = Post::where([
            "isPopular" => 1,
            "status"    => 1
        ])->limit(5)->get();
        $data['all_categories'] = Category::with('posts')->where('status', 1)->get();
        $data['all_tags'] = Tag::select('name')->get();
        $data['all_series'] = Series::has('categories')->select('name', 'slug')->get();
        
        Cache::forever('sidebar', $data);
    }
}
