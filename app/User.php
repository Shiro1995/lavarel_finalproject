<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     * You can manually set this using Laravel, just remember to add 'created_at' to your $fillable array
     * and $timestamps = true; work and fill created_at and updated_at
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_verified', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isEmailExisted($email) {
        return DB::table('users')->where('email', '=', $email)->first() != null;
    }

    public function add($data) {
        return DB::table('users')->insert($data);
    }

    public function getByEmail($email) {
        return DB::table('users')->where('email', '=', $email)->first();
    }

    public function getById($id) {
        return DB::table('users')->where('id', '=', $id)->first();
    }

    public function updateItem($data) {
        return DB::table('users')
            ->where('email', $data[0]['email'])
            ->update([
                'id' => $data[0]['id'],
                'name' => $data[0]['name'],
                'email' => $data[0]['email'],
                'password' => $data[0]['password'],
                'date_of_birth' => $data[0]['date_of_birth'],
                'gender' => $data[0]['gender'],
                'avatar' => $data[0]['avatar'],
                'phone_number' => $data[0]['phone_number'],
                'address' => $data[0]['address'],
                'is_verified' => $data[0]['is_verified'],
                'uid' => $data[0]['uid'],
                'remember_token' => $data[0]['remember_token'],
                'created_at' => $data[0]['created_at'],
                'updated_at' => $data[0]['updated_at']
            ]);
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
