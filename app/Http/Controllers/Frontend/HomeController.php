<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Tag;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mpdf\Mpdf;

class HomeController extends Controller {
    public static $tmp;
    
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
        try {
            $data['post'] = Post::with('category')->where("slug", $slug)->first();
            $data['releteadposts'] = Post::with('category')->where('categoryId', $data['post']->categoryId)->limit(3)->inRandomOrder()->get();
            
            return view('frontend.showpost', $data);
        } catch(\Exception $exception) {
            return redirect()->route('frontend.error');
        }
        
    }
    
    public function showcategory($slug) {
        $data = [];
        
        try {
            $data['category'] = Category::where([
                'slug'   => $slug,
                'status' => 1
            ])->first();
            $data['posts'] = Post::where([
                'categoryId' => $data['category']->id,
                'status'     => 1
            ])->paginate(10);
            
            return view('frontend.showcategory', $data);
        } catch(\Exception $exception) {
            return redirect()->route('frontend.error');
        }
        
    }
    
    public function showpage($slug) {
        $data = [];
        
        try {
            $data['page'] = Page::where([
                'slug'   => $slug,
                'status' => 1
            ])->first();
            
            return view('frontend.showpage', $data);
        } catch(\Exception $exception) {
            return redirect()->route('frontend.error');
        }
    }
    
    public function showtag($tag) {
        $data[] = "";
        $tag = $data['tag'] = Tag::with('posts')->where('name', $tag)->first();
        $data['posts'] = Tag::find($tag->id)->posts()->paginate(10);
        try {
            
            return view('frontend.showtag', $data);
        } catch(\Exception $exception) {
            return redirect()->route('frontend.error');
        }
    }
    
    public function contact() {
    
    }
    
    public function generatepdf($type, $slug) {
        $data = [];
        try {
            if($type == "post") {
                $data['post'] = Post::where('slug', $slug)->first();
            }
            
            $mpdf = new Mpdf();
            
            $html = view('frontend.pdf.post', $data)->render();
            $mpdf->setFooter('{PAGENO}');
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } catch(\Exception $exception) {
            return redirect()->route('frontend.error');
        }
    }
}
