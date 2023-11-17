<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quiz_options extends Model
{
    use HasFactory;

    protected $table = "quiz_options";
    protected $fillable = [
      					   'option',
                           'answer',
                           'question_id',
                          ];

        public function quiz_questions(){
        return $this->hasOne(quiz_questions::class, 'id', 'question_id');
    }
}
