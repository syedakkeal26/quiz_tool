<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetMaster extends Model
{
    use HasFactory;
    protected $table = "asset_master";
    protected $fillable = [
      'title',
      'total_questions',
      'created_by',
     ];

}
