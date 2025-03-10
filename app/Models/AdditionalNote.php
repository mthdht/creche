<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Child;
use App\Models\Health;

class AdditionalNote extends Model
{
    /** @use HasFactory<\Database\Factories\AdditionalNotesFactory> */
    use HasFactory;

    protected $fillable = [
        'child_id',
        'note',
        'severity',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
