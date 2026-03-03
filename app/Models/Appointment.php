<?php

namespace App\Models;

use App\Traits\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use BelongsToHospital;

    protected $fillable = ['hospital_id', 'patient_id', 'doctor_id', 'appointment_at', 'status', 'notes'];
}
