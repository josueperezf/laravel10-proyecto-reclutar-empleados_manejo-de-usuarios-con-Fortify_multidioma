<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacante extends Model
{
    use HasFactory;

    protected $casts = [ 'ultimo_dia'=>'date']; // esto es para que laravel sepa que cualquier de estos campos puede que yo quiera manejarlos como fecha en algun momento

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

    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }

    public function salario() {
        return $this->belongsTo(Salario::class);
    }
}
