<?php

namespace App\Models;

use function foo\func;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
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
        
        static::creating(function($category){;
            $name = preg_replace('/([+,:;=$&?@])/','',$category->name);
            $category->slug = strtolower(preg_replace('/\s+/u', '-', trim($name)));
        });
    }
    
    public function posts(){
        return $this->hasMany('App\Models\Post','categoryId');
    }
    
    public function parent(){
        return $this->belongsTo('App\Models\Category','parent_id');
    }
    
    public function menu(){
        return $this->hasMany('App\Models\Category','parent_id');
    }
}
