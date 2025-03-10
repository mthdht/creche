<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Child;

class Daycare extends Model
{
    /** @use HasFactory<\Database\Factories\DaycareFactory> */
    use HasFactory;
    protected $fillable = ['name', 'address', 'phone', 'email', 'user_id'];

    /**
     * Un enfant appartient à une crèche.
     */
    public function children()
    {
        return $this->hasMany(Child::class);
    }

}
