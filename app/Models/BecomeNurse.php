<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BecomeNurse extends Model
{
    use HasFactory;


    protected $primaryKey = 'becomeNurseId';

    protected $fillable = [
        'name',
        'phone',
        'degree',
        'position',
        'userId'
    ];

    /**
     * Get the user that owns the BecomeNurse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

}
