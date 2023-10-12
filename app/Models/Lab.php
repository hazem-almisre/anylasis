<?php

namespace App\Models;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Lab extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $primaryKey = 'labId';

    protected $fillable = [
        'name',
        'ownerName',
        'phone',
        'phoneEnter',
        'password',
        'region',
        'photo',
        'labLocationId',
        'address',
        'isActive',
        'distinct',
        'description'
    ];

    protected $hidden = [
        'password',
        'phoneEnter',
        'labLocationId',
        'isActive',
        'distinct'
    ];

    //---------------Newly_Added_For_JWT------------------------------

     // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get all of the analyses for the Lab
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function analyses()
    {
        return $this->hasMany(Analysis::class, 'labId', 'labId');
    }

}
