<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Les informations de profil sont liées ici
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // Lien avec les enfants en tant que tuteur (relation many-to-many)
    public function children()
    {
        return $this->belongsToMany(Child::class, 'child_user');
    }

    // Exemple de fonction pour récupérer le rôle de l'utilisateur (tuteur, professionnel, etc.)
    public function isGuardian()
    {
        return $this->children()->exists();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
