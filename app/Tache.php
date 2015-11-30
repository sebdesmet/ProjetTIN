<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    //
    protected $fillable = ['name_user','name_liste', 'tache' , 'etat_tache' , 'date'];
}
