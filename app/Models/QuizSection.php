<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSection extends Model
{
    use HasFactory;
    protected $table = "quiz_sections";
    protected $fillable = [
      'asset_master_id',
      'quiz_main_id',
      'no_of_questions',
     ];

     public function quiz_main(){
        return $this->hasMany(quiz_main::class,'id', 'quiz_main_id');
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
