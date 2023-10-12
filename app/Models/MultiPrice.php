<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultiPrice extends Model
{
    protected $primaryKey = 'multipriceId';

    protected $fillable = [
        'firstPrice',
        'secondPrice',

    ];

}
