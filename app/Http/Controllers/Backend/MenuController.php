<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;

class MenuController extends Controller {
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
        $data['menus'] = Menu::with('parent')->orderBy('sort_order', 'asc')->get();
        
        return view('backend.menu.index', $data);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data['menus'] = Menu::select('id', 'name')->get();
        
        return view('backend.menu.create', $data);
    }
    
    public function getMenyTypes(Request $request) {
        $type = $data['type'] = $request->type;
        
        if($type == "category") {
            $data['categories'] = Category::select("id", "name", "slug")->get();
        } elseif($type == "page") {
            $data['pages'] = Page::select("id", "title", "slug")->get();
        } elseif($type == "post") {
            $data['posts'] = Post::select("id", "title", "slug")->get();
        }
        
        return (string)view('backend.menu.type', $data);
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
            'name'      => 'required|unique:menus,name',
            'menu_type' => 'required',
            'menu_url'  => 'required'
        ]);
        
        try {
            $menu = new Menu();
            $menu->name = $request->name;
            $menu->parent_id = $request->parent_id;
            $menu->menu_url = $request->menu_url;
            $menu->status = $request->status;
            $menu->sort_order = $request->sort_order;
            $menu->menu_type = $request->menu_type;
            $menu->save();
            
            return redirect()->route('backend.menu.index');
        } catch(\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
        
        
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu $menu
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu) {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu $menu
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $menu = $data['menu'] = Menu::find($id);
        $data['menus'] = Menu::select('id', 'name')->get();
        
        if($menu->menu_type == "category") {
            $data['categories'] = Category::select("id", "name", "slug")->get();
        } elseif($menu->menu_type == "page") {
            $data['pages'] = Page::select("id", "title", "slug")->get();
        } elseif($menu->menu_type == "post") {
            $data['posts'] = Post::select("id", "title", "slug")->get();
        }
        
        return view('backend.menu.edit', $data);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Menu         $menu
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'name'      => 'required|unique:menus,name,'.$id,
            'menu_type' => 'required',
            'menu_url'  => 'required'
        ]);
        
        try {
            $menu = Menu::find($id);
            $menu->name = $request->name;
            $menu->parent_id = $request->parent_id;
            $menu->menu_url = $request->menu_url;
            $menu->status = $request->status;
            $menu->sort_order = $request->sort_order;
            $menu->menu_type = $request->menu_type;
            $menu->update();
            
            return redirect()->route('backend.menu.index');
        } catch(\Exception $exception) {
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu $menu
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Menu::destroy($id);
    
        return redirect()->route('backend.menu.index');
    }
}
