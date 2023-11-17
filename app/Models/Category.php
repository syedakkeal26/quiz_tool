<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $fillable = [
      'category_name',
      'department_id',
      'parent_id',
     ];

     public function department(){
        return $this->hasOne(Department::class, 'id', 'department_id');
    }

    // public function categoryMain(){
    //     return $this->hasOne(Category::class, 'id', 'parent_id');
    // }

}
