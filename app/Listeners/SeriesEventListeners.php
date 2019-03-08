<?php

namespace App\Listeners;

use App\Events\SeriesEvent;
use App\Models\Post;
use App\Models\Series;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class SeriesEventListeners {
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
     * @param  SeriesEvent $event
     *
     * @return void
     */
    public function handle(SeriesEvent $event) {
        $ca = [];
        $series = $ca['series'] = Series::with('categories')->where('slug', $event->series->slug)->first();
        $categories = [];
        if(isset($series->slug)) {
            foreach($series->categories as $key => $category) {
                $categories[$key]['catid'] = $category->id;
                $categories[$key]['name'] = $category->name;
                $categories[$key]['slug'] = $category->name;
                $categories[$key]['sort_order'] = $category->pivot->sort_order;
                $categories[$key]['series_id'] = $series->id;
                $categories[$key]['posts'] = Post::where('categoryId', $category->id)->orderBy('sort_order', 'asc')->get();
            }
            $ca['results'] = array_values(Arr::sort($categories, function($value) {
                return $value['sort_order'];
            }));
            
            if(Cache::has('series'.$event->series->slug)) {
                Cache::forget('series'.$event->series->slug);
            }
            
            Cache::forever('series'.$event->series->slug, $ca);
        }
    
    
        if(Cache::has('series'.$event->series->slug)) {
            Cache::forget('series'.$event->series->slug);
        }
        
        
    }
}
