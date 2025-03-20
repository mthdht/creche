<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Health;

class Allergy extends Model
{
    /** @use HasFactory<\Database\Factories\AllergyFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'severity', 'child_id'
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
