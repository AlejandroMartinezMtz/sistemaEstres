<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestasCuestionarios extends Model
{
    use HasFactory;
    protected $table = 'respuestaCuestionario';
    public $timestamps = false;
    protected $primaryKey = 'idRespuestaCuestionario';
    protected $fillable = ['fechaRegistro', 'valor_respuesta', 'fk_idPreguntaCuestionario', 'fk_usuario'];

    // Relación con la pregunta (una respuesta pertenece a una pregunta)
    public function pregunta()
    {
        return $this->belongsTo(PreguntasCuestionarios::class, 'fk_idPreguntaCuestionario', 'idPreguntaInstrumento');
    }

    // Relación con el alumno que responde (una respuesta pertenece a un usuario)
    public function alumno()
    {
        return $this->belongsTo(Usuario::class, 'fk_usuario', 'idUsuario');
    }
}
