<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Health;
use App\Models\Allergy;
use App\Models\Illness;
use App\Models\Medication;
use App\Models\AdditionalNote;
use App\Models\Daycare;
use App\Models\Transmission;
use App\Models\Message;
use Illuminate\Support\Carbon;

class Child extends Model
{
    /** @use HasFactory<\Database\Factories\ChildFactory> */
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'birth_date', 'sexe', 'avatar','daycare_id'
    ];

    protected $with = ['daycare'];

    /**
     * Un enfant appartient à une crèche.
     */
    public function daycare()
    {
        return $this->belongsTo(Daycare::class);
    }

    // La relation avec les tuteurs (utilisateurs)
    public function guardians()
    {
        return $this->belongsToMany(User::class, 'child_user');
    }

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
        return $this->hasMany(AdditionalNote::class);
    }

    public function transmissions() {
        return $this->hasMany(Transmission::class);
    }

    public function lastFiveDaysTransmissions() {
        return $this->transmissions()
            ->where('datetime', '>=', Carbon::now()->subDays(5))
            ->orderBy('datetime', 'desc');
    }

    public function messages()
    {
        return $this->belongsToMany(Message::class, 'messages_recipients');
    }

    public function allMessages()
    {
        return $this->belongsToMany(Message::class, 'messages_recipients')
            ->where(function ($query) {
                $query->where('child_id', $this->id)
                    ->orWhere('daycare_id', $this->daycare_id);
            })
            ->orWhere('target', 'all')
            ->orderBy('created_at', 'desc');
    }

}
