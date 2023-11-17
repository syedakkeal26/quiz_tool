<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class participator extends Model
{
    use HasFactory;
    protected $table = "participators";
    protected $fillable = [
      					   'name',
                             'email',
                             'password',
                             'department_id',
                             'Phone_no',
                             'type',
                             'start_time',
                             'otp',
    ];
    public function quiz_main()
    {
        return $this->hasOne(AssetMaster::class, 'id', 'department_id');
    }
    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }
    public function category()
    {
        return $this->hasOne(Category::class, 'department_id', 'department_id');
    }
    // public function title()
    // {
    //     return $this->hasOne(AssetMaster::class, 'id', 'department_id');
    // }

    // public function link()
    // {
    //     return $this->hasOne(linkGen::class,'participant_id');
    // }
}
