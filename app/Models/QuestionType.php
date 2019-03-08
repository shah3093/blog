<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    protected $guarded = [];
    
    public function questions(){
        // return $this->morphedByMany(Question::class,'questionable');
        return $this->morphToMany(Question::class,'questionable');
    }
}
