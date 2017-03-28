<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 'id_service', 'description', 'availability',
    ];
    /**
     * Get the user record associated with the collaborator.
     */
    public function user()
    {
        return $this->hasOne('App\User');
    }
    /**
     * Get the service record associated with the collaborator.
     */
    public function service()
    {
        return $this->hasOne('App\Service');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }


}
