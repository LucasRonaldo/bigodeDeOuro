<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaDePagamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipos_de_pagamento',
        'status_do_pagamento',
        'taxa'

    ];
}
