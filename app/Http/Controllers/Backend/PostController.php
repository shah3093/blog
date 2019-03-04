<?php

namespace App\Http\Controllers\Backend;

use App\Events\SeriesEvent;
use App\Models\Category;
use App\Models\Files;
use App\Models\Post;
use App\Models\Series;
use App\Models\Tag;
use DebugBar\DebugBar;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        \Debugbar::disable();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['posts'] = Post::with('category')->orderBy('id', 'desc')->get();
        
        return view('backend.posts.index', $data);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data['categories'] = Category::select('id', 'name')->get();
        $data['tags'] = Tag::select('name')->get();
        $data['series'] = Series::get();
        
        return view('backend.posts.create', $data);
    }
    
    public function storefile(Request $request) {
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('files');
            $full_path = Storage::url($path);
            if(Storage::get($path)) {
                try {
                    $file = new Files();
                    $file->file_name = $path;
                    $file->created = \Auth::id();
                    $file->save();
                    
                    return response()->json($full_path);
                } catch(\Exception $exception) {
                    return response()->json("FILE_NOT_FOUND");
                }
                
            } else {
                return response()->json("FILE_NOT_FOUND");
            }
            
        }
        
        return response()->json("FILE_NOT_FOUND");
    }
    
    public function deletefile(Request $request) {
        $filepath = $request->text;
        $serverpath = url('/')."/uploads/";
        $filename = str_replace($serverpath, "", $filepath);
        
        $file = Files::select('id', 'file_name')->where('file_name', $filename)->first();
        
        if(isset($file->file_name)) {
            if(Storage::delete($file->file_name)) {
                Files::destroy($file->id);
                
                return response()->json($file);
            }
            
        }
        
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
            'data.title'   => 'required|unique:posts,title',
            'data.content' => 'required',
            'image'        => 'required|image',
        ]);
        
        $image = $request->file('image');
        
        if($image->isValid()) {
            try {
                $path = $image->store('post');
                $data2 = [
                    'created'       => \Auth::id(),
                    'featuredImage' => $path
                ];
                $tmpdata = $data = $request->input('data');
                $data = array_merge($data, $data2);
                $post = Post::create($data);
                
                $tags = explode(",", $request->tags);
                
                foreach($tags as $data) {
                    if($data != "") {
                        $tag = Tag::where("name", $data)->first();
                        if(isset($tag->id)) {
                            $post->tags()->attach($tag->id);
                        } else {
                            $tag = new Tag();
                            $tag->name = $data;
                            $post->tags()->save($tag);
                        }
                    }
                }
                
                if(isset($tmpdata['categoryId'])) {
                    $category = Category::find($tmpdata['categoryId']);
                    $series = Series::find($category->series[0]->id);
                    event(new SeriesEvent($series));
                }
                
                return redirect()->route('backend.posts.index');
            } catch(\Exception $exception) {
                return redirect()->back()->withErrors([$exception->getMessage()]);
            }
        }
        
        return redirect()->back()->withErrors(["Image is not valid"]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $post = $data['post'] = Post::with('category')->find($id);
        $data['categories'] = Category::select('id', 'name')->get();
        $data['tags'] = Tag::select('name')->get();
        $data['series'] = Series::get();
        
        $tagstr = "";
        foreach($post->tags as $tag) {
            $tagstr .= $tag->name.",";
        }
        
        $data['tagstr'] = $tagstr;
        
        return view('backend.posts.edit', $data);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'data.title'   => 'required|unique:posts,title,'.$id,
            'data.content' => 'required'
        ]);
        
        $post = $postobj = Post::find($id);
        
        $image = $request->file('image');
        $path = "";
        $data2 = [];
        if($image != null) {
            if(!$image->isValid()) {
                return redirect()->back()->withErrors(["Image is not valid"]);
            } else {
                $path = $image->store('post');
                Storage::delete($post->featuredImage);
                if($path != "") {
                    $data2 = [
                        'featuredImage' => $path
                    ];
                }
            }
        }
        
        try {
            
            $tmpdata = $data = $request->input('data');
            $data = array_merge($data, $data2);
            $post = Post::where('id', $id)->update($data);
            
            $tags = explode(",", $request->tags);
            $tagsid = [];
            
            foreach($tags as $data) {
                if($data != "") {
                    $tag = Tag::where("name", $data)->first();
                    if(isset($tag->id)) {
                        array_push($tagsid, $tag->id);
                    } else {
                        $tag = new Tag();
                        $tag->name = $data;
                        array_push($tagsid, $tag->save());
                    }
                }
            }
            $postobj->tags()->sync($tagsid);
            
            if(isset($tmpdata['categoryId'])) {
                $category = Category::find($tmpdata['categoryId']);
                $series = Series::find($category->series[0]->id);
                event(new SeriesEvent($series));
            }
            
            return redirect()->route('backend.posts.index');
        } catch(\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $post = Post::find($id);
        if(isset($data['categoryId'])) {
            $category = Category::find($post->categoryId);
            $series = Series::find($category->series[0]->id);
            event(new SeriesEvent($series));
        }
        
        Post::destroy($id);
        
        return redirect()->route('backend.posts.index');
    }
}
