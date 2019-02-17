<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller {
    public function index() {
        $data['posts'] = Post::with('category')->orderBy('id', 'desc')->paginate(8);
        $data['categoriesTopPage'] = Category::select("slug", "name", "featuredImage")->where([
            "status"      => 1,
            "homepageTop" => 1
        ])->get();
        $data['postsTopPage'] = Post::select("slug", "title", "featuredImage")->where([
            "status"      => 1,
            "homepageTop" => 1
        ])->get();
        
        return view('frontend.home', $data);
    }
    
    public function showpost($slug) {
        $data = [];
        $data['post'] = Post::with('category')->where("slug", $slug)->first();
        $data['releteadposts'] = Post::with('category')->where('categoryId', $data['post']->categoryId)->limit(3)->get();
        
        return view('frontend.showpost', $data);
    }
    
    public function showcategory($slug){
        $data = [];
        $data['category'] = Category::where(['slug'=>$slug,'status'=>1])->first();
        $data['posts'] = Post::where(['categoryId'=>$data['category']->id,'status'=>1])->paginate(10);
        return view('frontend.showcategory', $data);
    }
    
    public function showpage($slug){
        $data = [];
        $data['page'] = Page::where(['slug'=>$slug,'status'=>1])->first();
        return view('frontend.showpage', $data);
    }
    
    public function contact(){
    
    }
}
