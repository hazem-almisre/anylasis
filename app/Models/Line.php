<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $primaryKey = 'lineId';

    protected $fillable = [
        'dateStart',
        'analysis',
        'price',
        'status',
        'orderId'
    ];

}
