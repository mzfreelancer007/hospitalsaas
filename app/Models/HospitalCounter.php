<?php

namespace App\Models;

use App\Traits\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;

class HospitalCounter extends Model
{
    use BelongsToHospital;

    protected $fillable = ['hospital_id', 'key', 'current_value'];
}
