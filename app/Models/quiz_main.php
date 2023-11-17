<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quiz_main extends Model
{
    use HasFactory;

    protected $table = "quiz_mains";
    protected $fillable = [
      					   'department_id',
                           'max_number_questions',
                           'max_score',
                           'category_id',
                           'level',
                           'user_id',
                          ];

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function questions()
    {
        return $this->hasMany(quiz_questions::class,'quiz_id');
    }

    // public function maincategory(){
    //     return $this->hasManyThrough(Category::class,Category::class,'parent_id');
    // }

}
