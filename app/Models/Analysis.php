<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    protected $primaryKey = 'analysisId';

    protected $fillable = [
        'labId',
        'lable',
        'price',
        'firstPrice',
        'secondPrice',
        'description'
    ];

}
