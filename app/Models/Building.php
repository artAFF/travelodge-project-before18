<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['id', 'name'];

    public function tlcmnNets()
    {
        return $this->hasMany(Tlcmn_net::class);
    }

    public function ehcmNets()
    {
        return $this->hasMany(Ehcm_net::class);
    }

    public function uncmNets()
    {
        return $this->hasMany(Uncm_net::class);
    }
}
