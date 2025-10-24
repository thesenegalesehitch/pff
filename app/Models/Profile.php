<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['nom'];

    public function comptes()
    {
        return $this->hasMany(Compte::class);
    }
}
