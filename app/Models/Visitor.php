<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Visitor extends Authenticatable
{
    use SoftDeletes,Notifiable;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    protected $guarded = [];
    
    public function comments(){
        return $this->hasMany('App\Models\Comment','visitor_id');
    }
    
    public function questions(){
        return $this->hasMany(Question::class,'visitor_id');
    }
}
