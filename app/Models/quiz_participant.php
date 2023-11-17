<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quiz_participant extends Model
{
    use HasFactory;
    protected $table = "quiz_participants";
    protected $fillable = [
        'participant_id',
        'question_id',
        'option_id',
        'score',
        'max_score',
        'quiz_main_id',
        'linkgen_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function participator()
    {
        return $this->hasOne(participator::class, 'id', 'participant_id');
    }

    public function quiz_question()
    {
        return $this->hasMany(quiz_questions::class, 'id', 'question_id');
    }
}
