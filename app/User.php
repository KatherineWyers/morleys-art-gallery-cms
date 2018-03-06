<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * isAdmin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        if ($this->role == 'Admin')
        {
            return true;
        }
        return false;
    }

    /**
     * isManager
     *
     * @return boolean
     */
    public function isManager()
    {
        if ($this->role == 'Manager')
        {
            return true;
        }
        return false;
    }



}
