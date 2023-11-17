<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class linkGen extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_mark',
        'status',
        'start_time',
        'end_time',
        'group_id',
        'email'
       ];
    public function quiz_main()
    {
        return $this->belongsTo(quiz_main::class,'dept_id');
    }
    public function participator()
    {
        return $this->belongsTo(participator::class,'participant_id');
    }
    public function title()
    {
        return $this->hasOne(AssetMaster::class, 'id', 'dept_id');
    }


}
