<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
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
        
        static::creating(function($post){
            $post->slug = str_slug($post->title);
        });
    }
    
    public function category(){
        return $this->belongsTo('App\Models\Category','categoryId');
    }
    
    public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->format('M d, Y');
    }
    
}