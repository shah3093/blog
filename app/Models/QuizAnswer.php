<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    protected $guarded = [];

    public function quiz(){
        return $this->belongsTo(QuizQuestion::class,'question_id');
    }
}
