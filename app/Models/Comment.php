<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    protected $guarded = [];
    
    public function posts(){
        return $this->belongsTo('App\Models\Post','post_id');
    }
    
    public function visitors(){
        return $this->belongsTo('App\Models\Visitor','visitor_id');
    }
}
