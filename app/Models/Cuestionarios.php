<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuestionarios extends Model
{
    protected $table = 'cuestionario';
    public $timestamps = false;
    protected $primaryKey = 'idCuestionario';
    protected $fillable = ['titulo', 'descripcion', 'fechaRegistro', 'estadoActivo', 'puntajeMaximo', 'fk_Autor'];

    // Relación con el autor (usuario que creó el cuestionario)
    public function autor()
    {
        return $this->belongsTo(Usuarios::class, 'fk_Autor', 'idUsuario');
    }

    // Relación con preguntas (un cuestionario tiene muchas preguntas)
    public function preguntas()
    {
        return $this->hasMany(PreguntasCuestionarios::class, 'fk_idCuestionario', 'idCuestionario');
    }

    // Relación con respuestas (a través de las preguntas)
    public function respuestas()
    {
        return $this->hasManyThrough(RespuestasCuestionarios::class, PreguntasCuestionarios::class, 'fk_idCuestionario', 'fk_idPreguntaCuestionario', 'idCuestionario', 'idPreguntaInstrumento');
    }

    

    // En el modelo Cuestionarios
    public function alumnos()   
    {
        return $this->hasMany(CuestionarioAlumno::class, 'fk_idCuestionario', 'idCuestionario');
    }


    public function evaluacion(){
        return $this->belongsTo(EvaluacionEstres::class, 'idCuestionario', 'fk_idCuestionario');
    }



}
