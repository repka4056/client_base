<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'nume', 'prenume', 'adresa', 'regiune', 'numar_casa', 'latitudine', 'longitudine',
    ];
}
