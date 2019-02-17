<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    protected $guarded = [];
    
    protected static function boot() {
        parent::boot(); // TODO: Change the autogenerated stub
        
        static::creating(function($page){
            $page->slug = str_slug($page->title);
        });
    }
    
    public function parent(){
        return $this->belongsTo('App\Models\Page','parent_id');
    }
    
    public function page(){
        return $this->hasMany('App\Models\Page','parent_id');
    }
}
