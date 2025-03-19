<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Child;
use App\Models\Allergy;
use App\Models\Illness;
use App\Models\Medication;
use App\Models\AdditionalNote;

class health extends Model
{
    /** @use HasFactory<\Database\Factories\HealthFactory> */
    use HasFactory;

    protected $fillable = [
        'child_id',
        // Allergies, maladies, médicaments et autres informations
    ];
    protected $with= ['illnesses', 'allergies', 'medications'];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function allergies()
    {
        return $this->hasMany(Allergy::class);
    }

    public function illnesses()
    {
        return $this->hasMany(Illness::class);
    }

    public function medications()
    {
        return $this->hasMany(Medication::class);
    }


}
