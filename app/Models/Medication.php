<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    /** @use HasFactory<\Database\Factories\MedicationFactory> */
    use HasFactory;

    protected $fillable = [
        'health_id',
        'name',
        'dosage',
        'note',
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
