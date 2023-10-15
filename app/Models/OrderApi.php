<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderApi extends Model
{
    protected $primaryKey = 'orderId';

    protected $fillable = [
        'nurseId',
        'contactId',
        'totalPrice',
        'serviceName',
        'date',
        'labId',
        'userId',
        'isFrequency',
        'instructios'
    ];

    protected $casts = ['isFrequency' => 'boolean'];
    /**
     * Get the nurse that owns the OrderApi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nurse()
    {
        return $this->belongsTo(Nurse::class, 'nurseId', 'nurseId');
    }

    /**
     * Get the lab that owns the OrderApi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lab()
    {
        return $this->belongsTo(Lab::class, 'labId', 'labId');
    }

    /**
     * Get the user that owns the OrderApi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    /**
     * Get the contact that owns the OrderApi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contactId', 'contactId');
    }

    /**
     * Get all of the lines for the OrderApi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lines()
    {
        return $this->hasMany(Line::class, 'orderId', 'orderId');
    }
}
