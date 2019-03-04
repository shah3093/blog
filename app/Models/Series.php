<?php

namespace App\Models;

use App\Events\SeriesEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Series extends Model {
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
        
        static::creating(function($series) {
            ;
            $name = preg_replace('/([+,:;=$&?@])/', '', $series->name);
            $series->slug = strtolower(preg_replace('/\s+/u', '-', trim($name)));
        });
    }
    
    protected $dispatchesEvents = [
        'saved'   => SeriesEvent::class,
        'deleted' => SeriesEvent::class,
        'updated' => SeriesEvent::class,
    ];
    
    public function categories() {
        return $this->morphedByMany(Category::class, 'seriesable')->withPivot('sort_order');
    }
}
