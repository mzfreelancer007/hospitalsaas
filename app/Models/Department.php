<?php

namespace App\Models;

use App\Traits\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use BelongsToHospital;

    protected $fillable = ['hospital_id', 'name'];
}
