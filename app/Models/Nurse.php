<?php

namespace App\Models;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Nurse extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $primaryKey = 'nurseId';

    // query


    protected $fillable = [
        'name',
        'address',
        'phone',
        'ratio',
        // 'password',
        'photo',
        'socId',
        'isActive',
        'notification_token'
    ];

    protected $casts = [
        'isActive' => 'bool',
    ];

    protected $hidden = [
        // 'password',
        'phoneEnter',
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

    public static function selectNurseOrder($region,$labId){
        $query=
        "
         select N.nurseId,N.notification_token,N.isActive
         from nurse_labs NL
         INNER JOIN nurses N on N.nurseId=NL.nurseId
         WHERE NL.labId = '$labId'
         AND EXISTS
         (select N.nurseId from doctor_areas DA
         INNER JOIN lab_locations LL on LL.labLocationId=DA.labLocationId
         INNER JOIN nurses N on N.nurseId=DA.nurseId
         Where LL.region='$region')
        "
         ;
        return DB::select($query);
    }

    /**
     * Get all of the labsLocation for the Nurse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function labsLocation()
    {
        return $this->hasManyThrough(LabLocation::class, DoctorAreas::class,'nurseId','labLocationId','nurseId','labLocationId');
    }

}
