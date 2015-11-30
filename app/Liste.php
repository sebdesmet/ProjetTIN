<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liste extends Model
{
    protected $fillable = ['name_user','name_liste', 'description_liste','tache_acc','tache_tot'];
}
