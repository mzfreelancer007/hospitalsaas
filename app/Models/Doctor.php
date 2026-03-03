<?php

namespace App\Models;

use App\Traits\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use BelongsToHospital;

    protected $fillable = ['hospital_id', 'user_id', 'department_id', 'name', 'license_no', 'phone', 'fee'];
}
