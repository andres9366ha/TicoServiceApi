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
        'id_user_comment', 'id_collaborator', 'comment',
    ];

    /**
     * Get the user record associated with the comment.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the collaborator record associated with the comment.
     */
    public function collaborator()
    {
        return $this->belongsTo('App\Collaborator');
    }

}
