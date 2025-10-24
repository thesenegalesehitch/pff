<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeMateriel extends Model
{
    protected $table = 'types_materiel';
    protected $fillable = ['nom'];
    public function materiels()
    {
        return $this->hasMany(Materiel::class, 'type_materiel_id');
    }
}