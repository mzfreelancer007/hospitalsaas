<?php

namespace App\Models;

use App\Traits\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use BelongsToHospital;

    protected $fillable = ['hospital_id', 'patient_code', 'name', 'dob', 'gender', 'phone', 'address', 'emergency_contact'];
}
