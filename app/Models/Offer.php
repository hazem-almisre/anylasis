<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $primaryKey = 'offerId';

    protected $fillable = [
        'photo',
        'priceBeforOffer',
        'priceAfterOffer',
        'dateEnd',
        'analysisCount',
    ];

    /**
     * Get all of the analysis for the Offer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function analysis()
    {
        return $this->hasManyThrough(Analysis::class, AnalysisOffers::class,'analysisId','analysisId');
    }
}
