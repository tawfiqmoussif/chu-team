<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Demande extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function user(){
        //soit traitement soit demande donc soit brancardier soit demandeur
        return $this->belongsTo('App\User');
    }

    public function etats(){
        return $this->belongsToMany('App\Etat');
    }
    public function hospitalisation(){
        return $this->belongsTo('App\Hospitalisation');
    }
}
