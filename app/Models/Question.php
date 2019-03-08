<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];
    
    public function questiontypes(){
        // return $this->morphToMany(QuestionType::class,'questionable');
        return $this->morphedByMany(QuestionType::class,'questionable');
    }
    
    public function visitors(){
        return $this->belongsTo(Visitor::class,'visitor_id');
    }
    
    public function answer(){
        return $this->hasOne(Answer::class,'question_id');
    }
    
    public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->format('M d, Y');
    }
}
