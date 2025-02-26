<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuestas extends Model
{
    use HasFactory;
    protected $table = 'encuesta';
    public $timestamps = false;
    protected $primaryKey = 'idencuesta';
    protected $fillable = ['fechaAplica', 'objetivo', 'estadoActivo', 'fk_idAutor'];

    // Relación con el autor (usuario que creó el cuestionario)
    public function autor()
    {
        return $this->belongsTo(Usuarios::class, 'fk_idAutor', 'idUsuario');
    }

    // Relación con preguntas (un cuestionario tiene muchas preguntas)
    public function preguntas()
    {
        return $this->hasMany(PreguntasEncuestas::class, 'fk_idEncuesta', 'idencuesta');
    }

    // Relación con respuestas (a través de las preguntas)
    public function respuestas()
    {
        return $this->hasManyThrough(RespuestasEncuestas::class, PreguntasEncuestas::class, 'fk_idEncuesta', 'fk_idPreguntaEncuesta', 'idencuesta', 'idPreguntaEncuesta');
    }




    

    // En el modelo Encuestas
    public function alumnos()   
    {
        return $this->hasMany(EncuestasAlumnos::class, 'fk_idEncuestaE', 'idencuesta');
    }

        
    public function nivel(){
        return $this->belongsTo(NivelesSatisfaccion::class, 'idencuesta', 'fk_encuestaContestada');
    }

    public function encuestasAlumnos()
     {
         return $this->hasMany(EncuestasAlumnos::class, 'fk_idAlumnoE', 'idUsuario');
     }


    

}
