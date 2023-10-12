<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalysisOffers extends Model
{
    use HasFactory;

    protected $primaryKey = 'AnalysisOfferId';

    protected $fillable = [
        'offerId',
        'analysisId',
    ];

    protected $hidden = [
        'offerId',
        'analysisId',
    ];
}
