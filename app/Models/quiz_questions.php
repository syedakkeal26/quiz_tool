<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quiz_questions extends Model
{
    use HasFactory;
    protected $table = "quiz_questions";
    protected $fillable = [
      					   'question',
      					   'score',
                           'category_id',
                           'quiz_id',
                          ];
    public function option()
    {
        return $this->belongsTo(quiz_options::class);
    }
    public function quiz_main()
    {
        return $this->hasOne(quiz_main::class, 'id','quiz_id');
    }
    public function options()
    {
        return $this->hasMany(quiz_options::class,'question_id','id');
    }


}
