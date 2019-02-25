<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Series extends Model
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
        
        static::creating(function($series){;
            $name = preg_replace('/([+,:;=$&?@])/','',$series->name);
            $series->slug = strtolower(preg_replace('/\s+/u', '-', trim($name)));
        });
    }
}
