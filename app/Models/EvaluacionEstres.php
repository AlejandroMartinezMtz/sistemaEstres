<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluacionEstres extends Model
{
    use HasFactory;
    protected $table = 'evaluacionEstres';
    public $timestamps = false;
    protected $primaryKey = 'idEvaluacionEstres';
    protected $fillable = ['fk_idCuestionario', 'fk_usuario', 'puntajeTotal', 'nivelEstres', 'fechaRegistro'];

    // Relación con el alumno(usuario que respondio el cuestionario)
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'fk_usuario', 'idUsuario');
    }

     // Establecer que cuando se cree un nuevo registro, se asigne la fecha actual a 'fechaRegistro'
     protected static function booted()
     {
         static::creating(function ($evaluacionEstres) {
            $evaluacionEstres->fechaRegistro = now();
         });
     }

    // Relación con el cuestionario
    public function cuestionario()
    {
        return $this->belongsTo(Cuestionarios::class, 'fk_idCuestionario', 'idCuestionario');
    }

    

}
