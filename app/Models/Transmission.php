<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Child;

class Transmission extends Model
{
    /** @use HasFactory<\Database\Factories\TransmissionFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['type', 'description', 'severity', 'datetime', 'duration', 'child_id'];


    public function child() {
        return $this->belongTo(Child::class);
    }
}
