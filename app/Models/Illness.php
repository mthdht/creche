<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Illness extends Model
{
    /** @use HasFactory<\Database\Factories\IllnessFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'child_id'
    ];

    public function health()
    {
        return $this->belongsTo(Health::class);
    }

    public function child()
    {
        return $this->hasOneThrough(child::class, Health::class);
    }

    
}
