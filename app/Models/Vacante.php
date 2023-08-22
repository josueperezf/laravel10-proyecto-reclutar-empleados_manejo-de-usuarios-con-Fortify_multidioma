<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacante extends Model
{
    use HasFactory;
    protected $fillable = [
        'categoria_id',
        'descripcion',
        'empresa',
        'imagen',
        'publicado',
        'salario_id',
        'titulo',
        'ultimo_dia',
        'user_id',
    ];
}
