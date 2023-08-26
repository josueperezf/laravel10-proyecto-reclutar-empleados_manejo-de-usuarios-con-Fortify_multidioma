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

    public function candidatos() {
        return $this->hasMany(Candidato::class);
    }

    //*IMPORTANTE:
    /**
     * la siguiente relacion deberia de llamarse usuario, PERO,
     * no se llama asi ya que no tiene sentido semantico, es decir,
     * que es mas complicado de entender si vemos algo como vacante->user,
     * encambio si vemos vacante->reclutador intuimos que esta buscando al usuario de rol reclutador que creo esta vacante.
     *
     * solo por esto se llama reclutador() y no user(). nosotros le podemos colocar el nombre que queramos.
     *
     ** por haber hecho este cambio, debemos colocar el campo que es relacional, para este caso user_id
     */
    public function reclutador() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
