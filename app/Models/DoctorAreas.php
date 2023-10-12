<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorAreas extends Model
{
    protected $primaryKey = 'doctorAreasId';

    protected $fillable = [
        'labLocationId',
        'nurseId',
    ];

}
