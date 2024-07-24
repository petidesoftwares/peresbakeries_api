<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\CanResetPassword;
use \Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Staff extends Authenticatable implements JWTSubject, CanResetPassword
{
    use HasFactory, HasUuids, Notifiable, CanResetPasswordTrait, SoftDeletes;

    protected $keyType ="string";
    public $incrementing = false;

    protected $fillable =[
        'firstname',
        'surname',
        'gender',
        'mobile_number',
        'position',
        'address',
        'dob',
        "password"
    ];

    protected $hidden = [
        "password", "deleted_at"
    ];

    public function getJWTIdentifier(){
        return getKey();
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
}
