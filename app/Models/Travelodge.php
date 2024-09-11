<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travelodge extends Model
{
    protected $fillable = [
        'issue',
        'detail',
        'remarks',
        'department',
        'hotel',
        'status',
        'file_path',
        'assignee_id'
    ];

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }
}
