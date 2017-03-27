<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user_comment', 'id_user_receive', 'comment',
    ];
    /**
     * Get the user record associated with the comment.
     */
    public function user()
    {
        return $this->hasOne('App\User');
    }

}
