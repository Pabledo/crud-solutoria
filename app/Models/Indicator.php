<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'symbol',
        'currency',
        'value',
        'date',
        'time',
        'source',
    ];

    protected $attributes = [
        'name' => 'UNIDAD DE FOMENTO (UF)',
        'symbol' => 'UF',
        'currency' => 'Pesos',
        'source' => 'mindicador.cl',
    ];
}
