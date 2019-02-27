<?php

namespace App\Http\Controllers\Frontend;

use App\Http\View\Composers\SeriesComposer;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Series;
use App\Models\Tag;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;

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
        
        $data['category'] = Category::where([
            'slug'   => $slug,
            'status' => 1
        ])->first();
        
        if($data['category']->series == 1) {
            return view('frontend.showseries', $data);
        }
        
        try {
            
            
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
    
    public function showseries($sslug, $catsulg = "", $pslug = "") {
        $data = [];
        $data['tmparray'] = [];
        $data['cattmparray'] = [];
        try {
            $series = $data['series'] = Series::with('categories')->where('slug', $sslug)->first();
            foreach($series->categories as $key => $category) {
                $categories[$key]['catid'] = $category->id;
                $categories[$key]['name'] = $category->name;
                $categories[$key]['slug'] = $category->name;
                $categories[$key]['sort_order'] = $category->pivot->sort_order;
                $categories[$key]['series_id'] = $series->id;
                $categories[$key]['posts'] = Post::where('categoryId', $category->id)->orderBy('sort_order', 'asc')->get();
            }
            $results = $data['results'] = array_values(Arr::sort($categories, function($value) {
                return $value['sort_order'];
            }));
            if($catsulg == "") {
                $data['post'] = $results[0]['posts'][0];
                $data['catid'] = $results[0]['catid'];
            } else {
                foreach($results as $catkey => $result) {
                    if($result['slug'] == $catsulg) {
                        if($pslug != "") {
                            foreach($result['posts'] as $pkey => $post) {
                                if($post->slug == $pslug) {
                                    $data['post'] = $post;
                                    $data['catid'] = $result['catid'];
                                    
                                    break;
                                }
                            }
                        } else {
                            $data['post'] = $result['posts'][0];
                            $data['catid'] = $result['catid'];
                            break;
                        }
                    }
                }
            }
            
            return view('frontend.showseries', $data);
        } catch(\Exception $exception) {
            return redirect()->route('frontend.error');
        }
        
        
    }
}
