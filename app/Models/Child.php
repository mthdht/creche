<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Health;
use App\Models\Allergy;
use App\Models\Illness;
use App\Models\Medication;
use App\Models\AdditionalNote;

class Child extends Model
{
    /** @use HasFactory<\Database\Factories\ChildFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'first_name', 'last_name', 'birth_date', 'sexe', 'avatar'
    ];

    public function health()
    {
        return $this->hasOne(Health::class);
    }

    public function allergies()
    {
        return $this->hasManyThrough(Allergy::class, Health::class);
    }

    public function illnesses()
    {
        return $this->hasManyThrough(Illness::class, Health::class);
    }

    public function medications()
    {
        return $this->hasManyThrough(Medication::class, Health::class);
    }

    public function additionalNotes()
    {
        return $this->hasManyThrough(AdditionalNote::class, Health::class);
    }
}
