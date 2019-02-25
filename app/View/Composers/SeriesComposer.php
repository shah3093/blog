<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Post;
use Illuminate\View\View;

class SeriesComposer {
    
    protected $menustr = "";
    
    /**
     *
     *
     * @return void
     */
    public function __construct() {
        // Dependencies automatically resolved by service container...
    }
    
    /**
     * Bind data to the view.
     *
     * @param  View $view
     *
     * @return void
     */
    
    
    public function compose(View $view) {
        $category = $view->getData();
        if($category['category']->series == 1) {
            $this->menustr .= '<div class="bg-light border-right" id="sidebar-wrapper">
                                <div class="sidebar-heading">'.$category['category']->name.'</div>
                                <div class="list-group list-group-flush">';
            $this->menuGenerator($category['category']->id);
            $this->menustr .= "</div></div></div>";
        }
        $view->with('seriesstr', $this->menustr);
    }
    
    public function menuGenerator($parentid) {
        $categories = Category::where("parent_id", $parentid)->get();
        if($categories->count() > 0) {
            foreach($categories as $key => $category) {
                $this->menustr .= '<a data-toggle="collapse" href="#collapse'.$key.'" role="button" aria-expanded="false" aria-controls="#collapse'.$key.'" class="list-group-item list-group-item-action bg-light">'.$category->name.' - </a>';
                $this->menustr .= '<div class="collapse" id="#collapse'.$key.'">
                                        <div class="card card-body">';
                $this->menuGenerator($category->id);
                $this->menustr .= "</div></div>";
                
            }
        }
        $posts = Post::where("categoryId", $parentid)->get();
        foreach($posts as $post) {
            $this->menustr .= '<a href="#" class="list-group-item list-group-item-action bg-light">'.$post->title.'</a>';
        }
    }
}
