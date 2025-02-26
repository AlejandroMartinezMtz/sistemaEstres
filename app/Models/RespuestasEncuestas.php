<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestasEncuestas extends Model
{
    use HasFactory;
    protected $table = 'respuestaEncuesta';
    public $timestamps = false;
    protected $primaryKey = 'idRespuestaEncuesta';
    protected $fillable = ['fechaRegistro', 'valor_respuesta','fk_idPreguntaEncuesta', 'fk_idUsuario'];

    // Relación con la pregunta (una respuesta pertenece a una pregunta)
    public function pregunta()
    {
        return $this->belongsTo(PreguntasEncuestas::class, 'fk_idPreguntaEncuesta', 'idPreguntaEncuesta');
    }

    // Relación con el alumno que responde (una respuesta pertenece a un usuario)
    public function alumno()
    {
        return $this->belongsTo(Usuario::class, 'fk_idUsuario', 'idUsuario');
    }

}
