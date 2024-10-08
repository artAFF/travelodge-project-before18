<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['id', 'name'];

    public function travelodges()
    {
        return $this->hasMany(Travelodge::class);
    }
}
