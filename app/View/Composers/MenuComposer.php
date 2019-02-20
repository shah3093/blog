<?php

namespace App\Http\View\Composers;

use App\Models\Menu;
use Illuminate\View\View;

class MenuComposer {
    /**
     * The user repository implementation.
     *
     */
    protected $menustr = "";
    
    /**
     *
     *
     * @return void
     */
    public function __construct() {
        // Dependencies automatically resolved by service container...
        $this->menuGenerator();
    }
    
    public function menuGenerator() {
        $menus = Menu::with('parent')->orderBy('sort_order', 'asc')->get();
        $this->menustr = '<ul class="navbar-nav mx-auto">';
        foreach($menus as $key => $menu) {
            $hassubmenu = $this->submenucheck($menu->id);
            if(($hassubmenu == true) && ($menu->parent_id == null)) {
                $this->menustr .= '<li class="nav-item dropdown custom-dropdown">';
                $this->menustr .= '<a class="nav-link dropdown-toggle" href="#" id="dropdown'.$key.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $this->menustr .= $menu->name."</a>";
                $this->menustr .= '<div class="dropdown-menu custom-dropdown-show" aria-labelledby="dropdown'.$key.'">';
                $this->menustr .= '<div class="row">';
                $this->menustr .= $this->submenugenerator($menu->id);
                $this->menustr .= '</div></div></li>';
                
            } elseif(($hassubmenu == false) && ($menu->parent_id == null)) {
                $this->menustr .= '<li class="nav-item">';
                if($menu->menu_type != "custom") {
                    $this->menustr .= '<a class="nav-link active" href="'.url($menu->menu_url).'">';
                    $this->menustr .= $menu->name;
                    $this->menustr .= '</a>';
                } else {
                    $this->menustr .= '<a class="nav-link active" href="'.$menu->menu_url.'">';
                    $this->menustr .= $menu->name;
                    $this->menustr .= '</a>';
                }
                $this->menustr .= '</li>';
            }
            
        }
        
    }
    
    public function submenucheck($id) {
        $menu = Menu::where("parent_id", $id)->first();
        if(isset($menu->id)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function submenugenerator($parentid) {
        $submenustr = "";
        $menus = Menu::where("parent_id", $parentid)->get();
        foreach($menus as $menu) {
            $url = $menu->menu_type == "cutom" ? $menu->menu_url : url($menu->menu_url);
            $submenustr .= '<div class="col">';
            $submenustr .= '<a class="dropdown-item" href="'.$url.'">'.$menu->name.'</a>';
            $submenustr .= $this->sub_submenugenerator($menu->id);
            $submenustr .= '</div>';
        }
        
        return $submenustr;
    }
    
    public function sub_submenugenerator($parentid) {
        $submenustr = "";
        $menus = Menu::where("parent_id", $parentid)->get();
        $submenustr .= '<div class="child-nav">';
        foreach($menus as $menu) {
            $url = $menu->menu_type == "cutom" ? $menu->menu_url : url($menu->menu_url);
            $submenustr .= '<a class="dropdown-item child-nav" href="'.$url.'">'.$menu->name.'</a>';
            $submenustr .= $this->sub_submenugenerator($menu->id);
        }
        $submenustr .= '</div>';
        
        return $submenustr;
    }
    
    /**
     * Bind data to the view.
     *
     * @param  View $view
     *
     * @return void
     */
    public function compose(View $view) {
        $view->with('header', $this->menustr);
    }
}
