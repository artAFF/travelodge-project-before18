<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uncm_net extends Model
{
    use HasFactory;

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
}
