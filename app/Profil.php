<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profil extends Model
{
    
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    
    public function user()
    {
        return $this->belongsTo('App\User');// le major belongsto un service
    }    
}
