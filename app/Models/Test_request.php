<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test_request extends Model
{
    use HasFactory;
 protected $table = "test_request";
    protected $fillable = [
      'user_email',
      'skill_name',
    	'status',
     ];
}
