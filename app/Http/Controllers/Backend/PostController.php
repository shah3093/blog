<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Models\Files;
use App\Models\Post;
use DebugBar\DebugBar;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['posts'] = Post::with('category')->orderBy('id', 'desc')->get();
        
        return view('backend.post.index', $data);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data['categories'] = Category::select('id', 'name')->get();
        
        return view('backend.post.create', $data);
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
            'data.title'      => 'required|unique:posts,title',
            'data.categoryId' => 'required',
            'data.content'    => 'required',
            'image'           => 'required|image',
        ]);
        
        $image = $request->file('image');
        
        if($image->isValid()) {
            try {
                $path = $image->store('post');
                $data2 = [
                    'created'       => \Auth::id(),
                    'featuredImage' => $path
                ];
                $data = $request->input('data');
                $data = array_merge($data, $data2);
                Post::create($data);
                
                return redirect()->route('backend.post.index');
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
        $data['post'] = Post::with('category')->find($id);
        $data['categories'] = Category::select('id', 'name')->get();
        
        return view('backend.post.edit', $data);
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
            'data.title'      => 'required|unique:posts,title,'.$id,
            'data.categoryId' => 'required',
            'data.content'    => 'required'
        ]);
        
        $post = Post::find($id);
        
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
            
            $data = $request->input('data');
            $data = array_merge($data, $data2);
            Post::where('id', $id)->update($data);
            
            return redirect()->route('backend.post.index');
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
        Post::destroy($id);
        
        return redirect()->route('backend.category.index');
    }
}
