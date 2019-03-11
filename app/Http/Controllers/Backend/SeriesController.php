<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Series;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class SeriesController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['series'] = Series::orderBy('id', 'desc')->get();
        
        return view('backend.series.index', $data);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('backend.series.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validatedData = $request->validate([
            'name'  => 'required|unique:series,name',
            'image' => 'required|image',
        ]);
        
        $image = $request->file('image');
        
        if($image->isValid()) {
            try {
                $path = $image->store('series');
                $series = new Series();
                $series->name = $request->name;
                $series->created = \Auth::user()->id;
                $series->description = $request->description;
                $series->featuredImage = $path;
                $series->homepageTop = $request->homepageTop;
                $series->status = $request->status;
                $series->seo_descriptions = $request->seo_descriptions;
                $series->seo_keywords = $request->seo_keywords;
                $series->save();
                
                return redirect()->route('backend.series.index');
            } catch(\Exception $exception) {
                return redirect()->back()->withErrors([$exception->getMessage()]);
            }
        }
        
        return redirect()->back()->withErrors(["Image is not valid"]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Series $series
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Series $series) {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Series $series
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data['series'] = Series::find($id);
        
        return view('backend.series.edit', $data);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Series       $series
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'name'  => 'required|unique:series,name,'.$id,
            'image' => 'image',
        ]);
        
        $series = Series::find($id);
        
        $image = $request->file('image');
        $path = "";
        if($image != null) {
            if(!$image->isValid()) {
                return redirect()->back()->withErrors(["Image is not valid"]);
            } else {
                $path = $image->store('series');
                Storage::delete($series->featuredImage);
            }
        }
        
        try {
            $series->name = $request->name;
            $series->description = $request->description;
            $series->homepageTop = $request->homepageTop;
            $series->status = $request->status;
            $series->seo_descriptions = $request->seo_descriptions;
            $series->seo_keywords = $request->seo_keywords;
            if($path != "") {
                $series->featuredImage = $path;
            }
            $series->save();
            
            return redirect()->route('backend.series.index');
        } catch(\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Series $series
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $series =Series::with('categories')->find($id);
        $series->categories()->detach();
        Series::destroy($id);
        
        return redirect()->route('backend.series.index');
    }
    
    public function getSeriesList($id) {
        $series = Series::with('categories')->find($id);
        $data['series_name'] = $series->name;
        $data['seriesid'] = $series->id;
        $categories = [];
        
        $data['categories'] = Category::select("id", "name")->where('status', 1)->get();
        
        foreach($series->categories as $key => $se) {
            $categories[$key]['id'] = $se->id;
            $categories[$key]['name'] = $se->name;
            $categories[$key]['sort_order'] = $se->pivot->sort_order;
            $categories[$key]['series_id'] = $series->id;
            $categories[$key]['posts'] = Post::select('id', 'title', 'sort_order')->where('categoryId', $se->id)->orderBy('sort_order', 'asc')->get();
        }
        $data['results'] = array_values(Arr::sort($categories, function($value) {
            return $value['sort_order'];
        }));
        
        return view('backend.series.list', $data);
    }
    
    public function editpostorder(Request $request) {
        try {
            $validatedData = $request->validate([
                'sort_order' => 'required|numeric',
                'postid'     => 'required',
            ]);
            $post = Post::find($request->postid);
            $post->sort_order = $request->sort_order;
            $post->save();
            
            return response()->json(['DONE']);
        } catch(\Exception $exception) {
            return response()->json([$exception->getMessage()]);
        }
    }
    
    public function addCategorySeries(Request $request) {
        try {
            $validatedData = $request->validate([
                'category'   => 'required',
                'series'     => 'required',
                'sort_order' => 'required|numeric',
            ]);
            
            $category = Category::find($request->category);
            $category->series()->attach($request->series, ['sort_order' => $request->sort_order]);
            
            return response()->json(['DONE']);
        } catch(\Exception $exception) {
            return response()->json([$exception->getMessage()]);
        }
    }
    
    public function editcategororder(Request $request) {
        try {
            $validatedData = $request->validate([
                'sort_order' => 'required|numeric',
                'seriesid'   => 'required',
                'categoryid' => 'required'
            ]);
            $series = Series::find($request->seriesid);
            // $series->categories()->sync($request->categoryid);
            $series->categories()->updateExistingPivot($request->categoryid, ['sort_order' => $request->sort_order]);
            
            return response()->json(["DONE"]);
        } catch(\Exception $exception) {
            return response()->json([$exception->getMessage()]);
        }
    }
    
    public function deletecategoryseries($categoryid) {
        try {
            $category = Category::find($categoryid);
            $category->series()->detach();
            
            return redirect()->back();
        } catch(\Exception $exception) {
            return response()->json([$exception->getMessage()]);
        }
    }
}
