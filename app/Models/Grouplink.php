<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grouplink extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_assetmaster_id',
        'group_question_id',
       ];
}
