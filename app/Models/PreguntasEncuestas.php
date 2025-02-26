<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntasEncuestas extends Model
{
    use HasFactory;
    protected $table = 'preguntaEncuesta';
    public $timestamps = false;
    protected $primaryKey = 'idPreguntaEncuesta';
    protected $fillable = ['textoPregunta', 'fk_idEncuesta'];

    // Relación con la Encuesta (una pregunta pertenece a una Encuesta)
    public function encuesta()
    {
        return $this->belongsTo(Encuestas::class, 'fk_idEncuesta', 'idencuesta');
    }

    // Relación con las respuestas (una pregunta tiene muchas respuestas)
    public function respuestas()
    {
        return $this->hasMany(RespuestasEncuestas::class, 'fk_idPreguntaEncuesta', 'idPreguntaEncuesta');
    }
}
