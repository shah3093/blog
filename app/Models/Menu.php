<?php

namespace App\Models;

use App\Events\MenuEvent;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = [];
    
    
    public function parent(){
        return $this->belongsTo('App\Models\Menu','parent_id');
    }
    
    public function menu(){
        return $this->hasMany('App\Models\Menu','parent_id');
    }
    
    protected $dispatchesEvents = [
        'saved' => MenuEvent::class,
        'deleted' => MenuEvent::class,
        'updated' => MenuEvent::class
    ];
}
