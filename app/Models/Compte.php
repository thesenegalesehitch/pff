<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Compte extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'comptes';
    public $username = 'login';
    protected $fillable = [
        'login',
        'motPasse',
        'profile_id',
    ];

    protected $hidden = [
        'motPasse',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->motPasse;
    }

    public function acheteur()
    {
        return $this->hasOne(Acheteur::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
