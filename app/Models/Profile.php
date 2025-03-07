<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Profile extends Model
{
    /** @use HasFactory<\Database\Factories\ProfileFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['first_name', 'phone', 'avatar', 'last_name', 'address', 'role', 'relationship', 'birth_date', 'sexe'];

    // La relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
