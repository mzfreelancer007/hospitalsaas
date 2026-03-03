<?php

namespace App\Models;

use App\Traits\BelongsToHospital;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use BelongsToHospital;

    protected $fillable = ['hospital_id', 'name', 'key'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }
}
