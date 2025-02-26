<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncuestasAlumnos extends Model
{
    use HasFactory;
    protected $table = 'encuestaAlumno';
    public $timestamps = false;
    protected $primaryKey = 'idEncuestaAlumno';
    protected $fillable = ['fk_idEncuestaE', 'fk_idAlumnoE', 'fk_idProfeAsignacion','fechaAsignacion','comentario', 'estado'];

    // Relación con el autor (usuario que creó el encuesta)
    public function alumno()
    {
        return $this->belongsTo(Usuarios::class, 'fk_idAlumnoE', 'idUsuario');
    }

    
   
    public function encuesta()
    {
    return $this->belongsTo(Encuestas::class, 'fk_idEncuestaE', 'idencuesta');
    }



}
