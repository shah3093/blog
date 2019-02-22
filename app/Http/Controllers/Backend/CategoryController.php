<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data['categories'] = Category::orderBy('id', 'desc')->get();
        
        return view('backend.categories.index', $data);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('backend.categories.create');
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
            'name'  => 'required|unique:categories,name',
            'image' => 'required|image',
        ]);
        
        $image = $request->file('image');
        
        if($image->isValid()) {
            try {
                $path = $image->store('category');
                $category = new Category();
                $category->name = $request->name;
                $category->created = \Auth::user()->id;
                $category->description = $request->description;
                $category->featuredImage = $path;
                $category->homepageTop = $request->homepageTop;
                $category->status = $request->status;
                $category->save();
                
                return redirect()->route('backend.categories.index');
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
    
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data['category'] = Category::find($id);
        
        return view('backend.categories.edit', $data);
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
            'name'  => 'required|unique:categories,name,'.$id,
            'image' => 'image',
        ]);
    
        $category = Category::find($id);
        
        $image = $request->file('image');
        $path = "";
        if($image != null) {
            if(!$image->isValid()) {
                return redirect()->back()->withErrors(["Image is not valid"]);
            } else {
                $path = $image->store('category');
                Storage::delete($category->featuredImage);
            }
        }
        
        try {
            $category->name = $request->name;
            $category->description = $request->description;
            $category->homepageTop = $request->homepageTop;
            $category->status = $request->status;
            if($path != "") {
                $category->featuredImage = $path;
            }
            $category->save();
            
            return redirect()->route('backend.categories.index');
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
        Category::destroy($id);
        return redirect()->route('backend.categories.index');
    }
}
