<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabLocation extends Model
{
    protected $primaryKey = 'labLocationId';

    protected $fillable = [
        'region',
        'town',
        'country',

    ];


    /**
     * Get all of the labs for the LabLocation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function labs()
    {
        return $this->hasMany(Lab::class, 'labLocationId', 'labLocationId');
    }
}
