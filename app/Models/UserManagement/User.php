<?php

namespace App\Models\UserManagement;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

use OwenIt\Auditing\Contracts\Auditable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements Auditable
{
    use Notifiable;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'first_name', 'last_name', 'full_name', 'system_user_type', 'email', 'password', 'created_user_id', 'updated_user_id'
    ];

    protected $hidden = ['password', 'remember_token',];

    protected $casts = ['email_verified_at' => 'datetime',];

    
    /**
     * Tag User as active
     *
     * @param User $user
     * @return void
     */
    public function approvedUser(User $user)
    {
        $user->is_active = true;
        $user->updated_user_id = $this->id;
        $user->save(); 
    }

    

    /**
     * Automatically hash the password
     * 
     * @param string $password
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        if(trim($password) === ''){
            return; 
        }

        $this->attributes['password'] = Hash::make($password);
    }



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

}
