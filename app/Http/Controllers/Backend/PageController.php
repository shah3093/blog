<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller {
    
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
        $data['pages'] = Page::with('parent')->orderBy('id', 'desc')->get();
        
        return view('backend.page.index', $data);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data['pages'] = Page::select('id', 'title')->get();
        
        return view('backend.page.create', $data);
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
            'image'        => 'image',
        ]);
        
        $image = $request->file('image');
        
        if($image->isValid()) {
            try {
                $path = $image->store('page');
                $data2 = [
                    'created'       => \Auth::id(),
                    'featuredImage' => $path
                ];
                $data = $request->input('data');
                $data = array_merge($data, $data2);
                Page::create($data);
                
                return redirect()->route('backend.page.index');
            } catch(\Exception $exception) {
                return redirect()->back()->withErrors([$exception->getMessage()]);
            }
        }
        
        return redirect()->back()->withErrors(["Image is not valid"]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page $page
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page) {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page $page
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data['page'] = Page::find($id);
        $data['pages'] = Page::select('id', 'title')->get();
        
        return view('backend.page.edit', $data);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Page         $page
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'data.title'   => 'required|unique:pages,title,'.$id,
            'data.content' => 'required',
            'image'        => 'image'
        ]);
        
        $page = Page::find($id);
        
        $image = $request->file('image');
        $path = "";
        $data2 = [];
        if($image != null) {
            if(!$image->isValid()) {
                return redirect()->back()->withErrors(["Image is not valid"]);
            } else {
                $path = $image->store('page');
                Storage::delete($page->featuredImage);
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
            Page::where('id', $id)->update($data);
            
            return redirect()->route('backend.page.index');
        } catch(\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page $page
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Page::destroy($id);
    
        return redirect()->route('backend.page.index');
    }
}
